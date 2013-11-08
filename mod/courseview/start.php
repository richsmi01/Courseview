<?php

/**
 * Write something profound here...
 */
elgg_register_event_handler('init', 'system', 'courseviewInit'); //call courseviewinit when the plugin initializes

function courseviewInit()
{
    elgg_extend_view('css/elgg', 'courseview/css', 1000);  //set up our link to css rulesets
    //register menu item to switch to CourseView
    //instead of calling an url and handling in the switch statement, use an action.
    //::MATT:  1.  I can't figure out the action tokens business here...help!
    //::TODO:  Ask Matt about the redirect in togglecourseview.php == until then, keep doing it the old way by passing it to the switch
    $item = new ElggMenuItem('courseview', 'CourseView', 'courseview/main');
    //$item = new ElggMenuItem('courseview', 'CourseView', elgg_add_action_tokens_to_url('actions/toggle')); // then add an action at action/courseview/toggle
    elgg_register_menu_item('site', $item);

    //this allows us to hijack the sidebar.  Each time the sidebar is about to be rendered, this hook fires
    elgg_register_plugin_hook_handler('view', 'page/elements/sidebar', 'cvsidebarintercept');
    //this allows us to intercept each time elgg calls a forward.  We will use this to be able to return to the coursview tool after adding a relationship
    //to added content
    elgg_register_plugin_hook_handler('forward', 'all', 'cvforwardintercept');

    //register page event handler
    elgg_register_page_handler('courseview', 'courseviewPageHandler');
    //elgg_register_event_handler('pagesetup', 'system','interceptpagesetup');  //likely won't need this
    //this is registering an event handler to call my interceptcreate method whenever an object is created.
    elgg_register_event_handler('create', 'object', 'cvinterceptcreate');

    //set up our paths
    $base_path = dirname(__FILE__); //gives a relative path to the directory where this file exists
    //this is where I will put all of the action registrations for the forms
    //::TODO:  Get Matt to better explain how actions/forms work 
    elgg_register_action("createcourse", $base_path . '/actions/courseview/createcourse.php');
    elgg_register_action("cveditacourse", $base_path . '/actions/courseview/cveditacourse.php');
    elgg_register_action("editmenuitem", $base_path . '/actions/courseview/editmenuitem.php');
    elgg_register_action("deleteacohort", $base_path . '/actions/courseview/deleteacohort.php');
    elgg_register_action("addacohort", $base_path . '/actions/courseview/addacohort.php');
    elgg_register_action("deletecourse", $base_path . '/actions/courseview/deletecourse.php');
    elgg_register_action('toggle', $base_path . '/actions/courseview/togglecourseview.php');
    elgg_register_action('addmenuitem', $base_path . '/actions/courseview/addmenuitem.php'); //::TODO: what is this again???
}

//this is the method that gets called when one of the courseview urls is called.  We will use a switch to choose how to respond
function courseviewPageHandler($page, $identifier)
{
    //TODO::add a group gatekeeper function here --find out more about gatekeeper code
    elgg_set_page_owner_guid($page[1]);   //set the page owner to the cohort and then call gatekeeper
    group_gatekeeper();

    ElggSession::offsetSet('cvcohortguid', $page[1]);
    ElggSession::offsetSet('cvmenuguid', $page[2]);
    $base_path = elgg_get_plugins_path() . 'courseview/pages/courseview';

    switch ($page[0])  //switching on the first parameter passed through the RESTful url
    {
        case 'main':
            //::TODO:  This needs to be replaced with an action
            $status = ElggSession::offsetGet('courseview');
            //if the courseview session variable was false, toggle it to true and viceversa
//            if ($status)
//            {
//                ElggSession::offsetSet('courseview', false);
//                forward('http://localhost/elgg/activity');
//            } 
//            else
            {
                ElggSession::offsetSet('courseview', true); //set session variable telling elgg that we are in 'masters' mode
                require "$base_path/courseviewlanding.php"; //load the default courseview welcome page
            }
            break;
        case 'contentpane':    //this is the main course content page
            require "$base_path/contentpane.php";
            break;
        case 'courseview':   //this is the landing page when a user first clicks on coursview
            set_input("object_type", 'all');
            require "$base_path/courseviewlanding.php";
            break;
//        case 'addcourse':
//            require "$base_path/addcourse.php";
//            break;
//        case 'exit':  //I don't think I need this at all...just use the togglecourseview action
//            ElggSession::offsetSet('courseview', false);
//            forward('http://localhost/elgg/activity');
//            break;
        //One of the next two should be deleted --pick one to manage all courses
        case 'managecourseview':
            require "$base_path/managecourseview.php";
            break;
        case 'managecourses':
            set_input("object_type", $page[1]);
            require "$base_path/managecourses.php";
            break;
        case 'testinginit':  //this will go too  -- just used for debugging
            require "$base_path/testinginit.php";
            break;
        default:
            echo "request for " . $page[0];
    }
    return true;
}

function cvsidebarintercept($hook, $entity_type, $returnvalue, $params)
{
    //here we check to see if we are currently in courseview mode.  If we are, we hijack the sidebar for our course 
    if (ElggSession::offsetGet('courseview'))
    {
        $returnvalue = elgg_view('courseview/hijacksidebar');
    } else  //this should be an else if that checks if user is currently enrolled in any cohorts -- need to figure out how to do this
    {
        $returnvalue.= '<br/>add to courseview'; //::TODO:  This is where I need to put the code for Dr Dron's idea
    }
    return $returnvalue;
}

//this method intercepts object creations and adds relationships to menu items when appropriate
function cvinterceptcreate($event, $type, $object)
{
    $cvmenu = ElggSession::offsetGet('cvmenuguid'); //need to get this from the session since I'm no longer on a courseview page
    $cvcohort = ElggSession::offsetGet('cvcohortguid');
    if ($object->getSubtype() != 'cvmenu' && ElggSession::offsetGet('courseview'))//::TODO:need to eventually change this to only add to subtype of approved plugins
    {
        $relationship = 'content' . $cvcohort;
        add_entity_relationship($cvmenu, $relationship, $object->guid);
        $rootdomain = elgg_get_site_url();
        $cvredirect = $rootdomain . 'courseview/contentpane/' . $cvcohort . '/' . $cvmenu;
        ElggSession::offsetSet('cvredirect', $cvredirect);
        //::TODO:  Need to understand the whole forward intercept thing better.
    }
}

function cvforwardintercept($hook, $type, $return, $params)
{
    $cvredirect = ElggSession::offsetGet('cvredirect');
    if (!empty($cvredirect))
    {
        $return = ElggSession::offsetGet('cvredirect');
        ElggSession::offsetUnset('cvredirect');
    }
    return $return;
}

//function cvinterceptpagesetup($event, $type, $object)  //this really isn't need anymore is it?
//{
//    $context = elgg_get_context();
//    //system_message('Context:  '.$context);
//    $temp1 = 'abc' . get_input('cvmenuguid');
//    //system_message ('CVMENUGUID: '.get_input('cvmenuguid'));
//    if ($context == 'group_profile')
//    {
//        //echo elgg_echo ('In Group Page '.var_dump($object));
//    }
//}

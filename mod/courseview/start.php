<?php

/**
 * Write something profound here...
 */
elgg_register_event_handler('init', 'system', 'courseviewInit'); //call courseviewinit when the plugin initializes

function courseviewInit()
{
    //set up our link to css rulesets
    elgg_extend_view('css/elgg', 'courseview/css', 1000);  
    
    //register menu item to switch to CourseView
    $item = new ElggMenuItem('courseview', 'CourseView', elgg_add_action_tokens_to_url('action/toggle')); // then add an action at action/courseview/toggle
    elgg_register_menu_item('site', $item);

    //this allows us to hijack the sidebar.  Each time the sidebar is about to be rendered, this hook fires
    elgg_register_plugin_hook_handler('view', 'page/elements/sidebar', 'cvsidebarintercept');
    
    //this allows us to intercept each time elgg calls a forward.  We will use this to be able to return to the coursview tool after adding a relationship
    //to added content
    elgg_register_plugin_hook_handler('forward', 'all', 'cvforwardintercept');
    
    //this allows us too add a menu choice to add an entity to a cohort
    elgg_register_plugin_hook_handler ('register','menu:entity','cventitymenu');
    
    //registering my ajax-based tree control for adding content from the wild to a cohort
    elgg_register_ajax_view('ajaxaddtocohort');
    
    //register page event handler
    elgg_register_page_handler('courseview', 'courseviewPageHandler');
    //elgg_register_event_handler('pagesetup', 'system','interceptpagesetup');  //likely won't need this
    //this is registering an event handler to call my interceptcreate method whenever an object is created.
    elgg_register_event_handler('create', 'object', 'cvinterceptcreate');

    elgg_register_library('elgg:courseview', elgg_get_plugins_path() . 'courseview/lib/courseview.php');
    
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
        $temp = $returnvalue;
        $returnvalue = elgg_view('courseview/hijacksidebar').$temp;
    } else  //this should be an else if that checks if user is currently enrolled in any cohorts -- need to figure out how to do this
    {
        $returnvalue.= '<br/>add to courseview'; //::TODO:  This is where I need to put the code for Dr Dron's idea
    }
    return $returnvalue;
}

//this method intercepts object creations and adds relationships to menu items when appropriate
function cvinterceptcreate($event, $type, $object)
{
    $cvmenuguid = ElggSession::offsetGet('cvmenuguid'); //need to get this from the session since I'm no longer on a courseview page
    $cvcohortguid = ElggSession::offsetGet('cvcohortguid');
    $validplugins= unserialize(elgg_get_plugin_setting('availableplugins', 'courseview')); 
    //check if the courseview flag is on and the object is one of the selected plugins available to courseview from the settings page.
    if (ElggSession::offsetGet('courseview') && is_valid_plugin($object->getSubtype()))
    { 
        $relationship = 'content' ;
        
        if (get_entity($cvmenuguid)->menutype !='professor') {
            $relationship.= $cvcohortguid;
        }
//        echo 'cvmenuguid:  '.$cvmenuguid.'<br>';
//        echo 'relationship:  '.$relationship.'<br>';
//        echo 'new object guid:  '.$object->guid.'<br>';
      
        add_entity_relationship($cvmenuguid, $relationship, $object->guid);
        $rootdomain = elgg_get_site_url();
        $cvredirect = $rootdomain . 'courseview/contentpane/' . $cvcohortguid . '/' . $cvmenu;
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

function cventitymenu ($hook, $type, $return, $params)
{
//    var_dump ($return);
//    var_dump ($params);
//    exit;
    //$validplugins= unserialize(elgg_get_plugin_setting('availableplugins', 'courseview')); 
    if (is_valid_plugin($params['entity']->getSubtype()))
    {
        $item = new ElggMenuItem('cvpin','add to Cohort', '#');
        $return [] = $item;
    }
     return $return;
}

function is_valid_plugin( $arg1)
{
    $validplugins= unserialize(elgg_get_plugin_setting('availableplugins', 'courseview')); 
    return (array_key_exists($arg1,$validplugins));  
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

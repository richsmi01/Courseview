<?php

/**
 * Write something profound here...
 */
elgg_register_event_handler('init', 'system', 'courseviewInit');

function courseviewInit()
{
    //elgg_extend_view('css/elgg','customize_css/css', 1000);
    elgg_extend_view('css/elgg','courseview/css', 1000);


//register menu item to switch to CourseView
    //instead of calling an url and handling in the switch statement, use an action.
    //$item = new ElggMenuItem('courseview', 'CourseView', elgg_add_action_tokens_to_url('action/courseview/toggle'); -- then add an action at action/courseview/toggle
    //check this out elgg_add_action_tokens_to_url($url)
    $item = new ElggMenuItem('courseview', 'CourseView', 'courseview/main');
    elgg_register_menu_item('site', $item);

    //::TODO:  ok, so what do I do with this now?
    add_group_tool_option("courseview", "Use this group as a CourseView cohort", FALSE);

    //include the courseview.php class library -- can replace this with a simple include.
    //include dirname(__FILE__) . '/lib/functions.php';
    elgg_register_library('elgg:courseview', elgg_get_plugins_path() . 'courseview/lib/courseview.php');
    elgg_load_library('elgg:courseview');

    //this allows us to hijack the sidebar.  Each time the sidebar is about to be rendered, this hook fires
    elgg_register_plugin_hook_handler('view', 'page/elements/sidebar', 'sidebar_intercept');

    //register page event handler
    elgg_register_page_handler('courseview', 'courseviewPageHandler');
    elgg_register_event_handler('pagesetup', 'system','interceptpagesetup');
    
    //this is registering an event handler to call my interceptcreate method whenever an object is created.
    elgg_register_event_handler('create', 'object','interceptcreate');

    //set up our paths
    $plugin_path = elgg_get_plugins_path();
    $base_path = $plugin_path . 'courseview';

    //this is where I will put all of the action registrations for the forms
    //::TODO:  Get Matt to better explain how actions/forms work 
    elgg_register_action("createcourse", $base_path . '/actions/courseview/createcourse.php');
    //echo $CONFIG->actions;
}
//testing git...delete this

//this is the method that gets called when one of the courseview urls is called.  We will use a switch to choose how to respond
function courseviewPageHandler($page, $identifier)
{
    //TODO::add a group gatekeeper function here
    elgg_set_page_owner_guid($page[1]);   //set the page owner to the cohort and then call gatekeeper
    group_gatekeeper();
    
    $plugin_path = elgg_get_plugins_path();
    $base_path = $plugin_path . 'courseview/pages/courseview';

    set_input('rich', $page);

    switch ($page[0])  //switching on the first parameter passed through the RESTful url
    {
        case 'main':
           
            $status = ElggSession::offsetGet('courseview');
   //          echo '$$$'.$status;
            //if the courseview session variable was false, toggle it to true and viceversa
//            if ($status)
//            {
//                //put these back in order to exit courseview
//                //ElggSession::offsetSet ('courseview', false);
//               // forward('http://localhost/elgg/activity');
//            }
//            else
            {
   
                ElggSession::offsetSet('courseview', true); //set session variable telling elgg that we are in 'masters' mode
 
                require "$base_path/courseview.php"; //load the default courseview welcome page
            }
            break;
        case 'contentpane':    //this is the main page 
            echo elgg_echo ('Menu item guid:  '.$page[1]);
            //need to pass this $page[1] to the content page
            //ElggSession::offsetSet('object_type', $page[1]);
            //ElggSession::offsetSet('coursetreeindex', $page[2]);
           require "$base_path/contentpane.php";
            break;
        case 'courseview':
            set_input("object_type", 'all');
            require "$base_path/courseview.php";
            break;
        case 'managecourseview':
            require "$base_path/managecourseview.php";
            break;
        case 'addcourse':
            require "$base_path/addcourse.php";
            break;
        case 'exit':
            ElggSession::offsetSet('courseview', false);
            forward('http://localhost/elgg/activity');
            break;
        case 'managecourses':
            set_input("object_type", $page[1]);
            require "$base_path/managecourses.php";
            break;
        case 'testinginit':
            require "$base_path/testinginit.php";
            break;
        default:
            echo "request for " . $page[0];
    }
    return true;
}

function sidebar_intercept($hook, $entity_type, $returnvalue, $params)
{
    //here we check to see if we are currently in courseview mode.  If we are, we hijack the sidebar for our course 
    if (ElggSession::offsetGet('courseview'))
    {
        $returnvalue = elgg_view('courseview/hijacksidebar');
    }
   
    return $returnvalue;
}

//this method will eventually be used to intercept  object creations and add the appropriate tags.
function interceptcreate ($event, $type, $object)
{
    system_message("Rich's object creation event hander was just triggered...");
    system_message('Type: '.$type.'  Event: '.$event);
    echo elgg_echo('interceptcreate is running:  The object just created was of type: '.$type.' GUID:  '.$object->guid.' and subtype: '.$object->subtype.'<br/>');
}

function interceptpagesetup ($event, $type, $object)
{
    $context = elgg_get_context();
    system_message('Context:  '.$context);
    if ($context=='group_profile')
    {
       //echo elgg_echo ('In Group Page '.var_dump($object));
    }
}

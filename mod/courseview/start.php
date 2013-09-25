<?php

/**
 * Write something profound here...
 */
elgg_register_event_handler('init', 'system', 'courseviewInit');

function courseviewInit()
{
    //register menu item to switch to CourseView
    $item = new ElggMenuItem('courseview', 'CourseView', 'courseview/main'); 
    elgg_register_menu_item('site', $item);
    
    //include the courseview.php class library
    elgg_register_library('elgg:courseview', elgg_get_plugins_path() . 'courseview/lib/courseview.php');
    elgg_load_library('elgg:courseview');
    
    //this allows us to hijack the sidebar.  Each time the sidebar is about to be rendered, this hook fires
    elgg_register_plugin_hook_handler('view', 'page/elements/sidebar', 'sidebar_intercept');
       
    //register page event handler
    elgg_register_page_handler('courseview', 'courseviewPageHandler');
    
    //set up our paths
    $plugin_path = elgg_get_plugins_path();
    $base_path = $plugin_path . 'courseview';
    
    //this is where I will put all of the action registrations for the forms
    elgg_register_action ("createcourse", $base_path.'/actions/courseview/createcourse.php');
    echo $CONFIG->actions;
}

//this is the method that gets called when one of the courseview urls is called.  We will use a switch to choose how to respond
function courseviewPageHandler($page, $identifier)
{
    $plugin_path = elgg_get_plugins_path();
    $base_path = $plugin_path . 'courseview/pages/courseview';
   
    set_input('rich', $page);

    switch ($page[0])  //switching on the first parameter passed through the RESTful url
    {
        case 'main':
            $status = ElggSession::offsetGet ('courseview');
            //if the courseview session variable was false, toggle it to true and viceversa
            if ($status)
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
        case 'listview':
            ElggSession::offsetSet('object_type', $page[1]);
            ElggSession::offsetSet('coursetreeindex',$page[2]);
            require "$base_path/listview.php";
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
            echo "request for ". $page[0];
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





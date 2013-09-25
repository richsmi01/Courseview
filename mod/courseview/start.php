<?php

/**
 * Think about changing this from masters to courseview or something like that
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
    
    //just to add a course to work with for testing
    //masters_create_course(); 
    
    
    
    //register page event handler
    elgg_register_page_handler('courseview', 'courseviewPageHandler');
    
    $plugin_path = elgg_get_plugins_path();
    $base_path = $plugin_path . 'courseview';
    elgg_register_action ("createcourse", $base_path.'/actions/courseview/createcourse.php');
    echo $CONFIG->actions;
}

function courseviewPageHandler($page, $identifier)
{
    $plugin_path = elgg_get_plugins_path();
    $base_path = $plugin_path . 'courseview/pages/courseview';
    //echo 'richs guid '.uniqid();
    set_input('rich', $page);

    switch ($page[0])  //switching on the first parameter passed through the RESTful url
    {
        case 'main':
            $status = ElggSession::offsetGet ('courseview');
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
            //echo '@@@'.$page[1];
            ElggSession::offsetSet('object_type', $page[1]);
            ElggSession::offsetSet('coursetreeindex',$page[2]);
           // echo '###'.$page[1];
            require "$base_path/listview.php";
            break;
        case 'courseview':
            set_input("object_type", 'all');
            require "$base_path/courseview.php";
            break;
         case 'managecourseview':
            //set_input("object_type", 'all');
            require "$base_path/managecourseview.php";
            break;
         case 'addcourse':
            require "$base_path/addcourse.php";
            break;
        case 'exit':
            ElggSession::offsetSet('courseview', false);
            forward('http://localhost/elgg/activity');
            break;
//         case 'list':
//            set_input("object_type", $page[1]);
//            require "$base_path/view2.php";
//            break;
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



//just some cool snippets of code that I've discovered...add these to my onenote pages
//$view = $params['view'];
//    $testview = elgg_extract('view', $params);
//    echo 'Rich was here!';
//
//    if ($params[vars][full_view] == 1)
//    {
//        $temp1 = elgg_get_context();
//        //echo 'viewing:  '.$view;
//        // elgg_extend_view($returnvalue, 'greetings');
//        $returnview = elgg_view('blog/view') . elgg_view('masters/view2');
//        // elgg_extend_view($returnvalue, 'greetings');
//        // $vars = array('content' => $content,);
//        // $sidebar = "";
//// layout the page
////$body = elgg_view_layout('one_sidebar', array(
//        //'content' => $content,
//        //'sidebar' => $sidebar
////));
//        //elgg_extend_view('page/elements/sidebar', 'masters/hijacksidebar');-----
//        //
//        //
//        //       elgg_extend_view('page/elements/sidebar', 'masters/greetings'); 
////        $entity = $params[vars][entity];
////        $content = elgg_view_entity($entity);
////        $sidebar =  elgg_echo(  "Hi Rich");
////        $canvas_area = elgg_view_layout('one_sidebar', array('content' => $content, 'sidebar' => $sidebar));
////        $returnvalue= $canvas_area;

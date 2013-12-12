<?php

/**
 * Write something profound here...
 */
elgg_register_event_handler('init', 'system', 'courseviewInit'); //call courseviewinit when the plugin initializes

function courseviewInit()
{
    //register libraries:
    elgg_register_library('elgg:courseview', elgg_get_plugins_path() . 'courseview/lib/courseview.php');
    elgg_register_library('elgg:cv_debug', elgg_get_plugins_path() . 'courseview/lib/cv_debug.php');
    elgg_load_library('elgg:courseview');  //need to load this library in order to determine whether user belongs to any cohorts
    
    //if the user is not a member of any cohorts, then don't bother running anything.
    if (!cv_is_courseview_user())
    {
        return;
    }

    //set up our link to css rulesets
    elgg_extend_view('css/elgg', 'courseview/css', 1000);

    //register menu item to switch to CourseView
    $status = ElggSession::offsetGet('courseview');
    if ($status)
    {
        $menutext = "Exit CourseView";
    }
    else
    {
        $menutext = "CourseView";
    }

    //add CourseView menu item
    $item = new ElggMenuItem('courseview', $menutext, elgg_add_action_tokens_to_url('action/toggle'));
    elgg_register_menu_item('site', $item);

    // allows us to hijack the sidebar.  Each time the sidebar is about to be rendered, this hook fires so that we can add our menu
    elgg_register_plugin_hook_handler('view', 'page/elements/sidebar', 'cvsidebarintercept');

    /* allows us to intercept each time elgg calls a forward.  We will use this to be able to return to the coursview 
     * tool after adding a relationshipto added content
     */
    elgg_register_plugin_hook_handler('forward', 'all', 'cvforwardintercept');

    //::TODO:  Matt - can you go over this again?  I don't think I'm using this now that I've chosen not to use ajax
    // allows us to add a menu choice to add an entity to a cohort
//    elgg_register_plugin_hook_handler('register', 'menu:entity', 'cventitymenu');
    //registering my ajax-based tree control for adding content from the wild to a cohort
//    elgg_register_ajax_view('ajaxaddtocohort');

    /*this view gets added to the bottom of each page.  The addcontenttocohort view has code in it to simply return
     * without doing anything unless the user belongs to at least one cohort and the current view is creating or updating
     * an approved object such as a blog, bookmark etc as chosen in the settings page.
     */
    elgg_extend_view('input/form', 'courseview/addcontenttocohort', 250);

    //register page event handler
    elgg_register_page_handler('courseview', 'courseviewPageHandler');

    /*both creating and updating content results in us calling the cvinterceptupdate to make or remove any
     * relationships between the content and any menuitems deemed neccesary.
     */
    elgg_register_event_handler('create', 'object', 'cvinterceptupdate');
    elgg_register_event_handler('update', 'object', 'cvinterceptupdate');


    //set up our paths and various actions 
    $base_path = dirname(__FILE__); //gives a relative path to the directory where this file exists
  
    elgg_register_action("createcourse", $base_path . '/actions/courseview/createcourse.php');
    elgg_register_action("cvaddtocohorttreeview", $base_path . '/actions/courseview/cvaddtocohorts.php');
    elgg_register_action("cveditacourse", $base_path . '/actions/courseview/cveditacourse.php');
    elgg_register_action("editmenuitem", $base_path . '/actions/courseview/editmenuitem.php');
    elgg_register_action("deleteacohort", $base_path . '/actions/courseview/deleteacohort.php');
    elgg_register_action("addacohort", $base_path . '/actions/courseview/addacohort.php');
    elgg_register_action("deletecourse", $base_path . '/actions/courseview/deletecourse.php');
    elgg_register_action('toggle', $base_path . '/actions/courseview/togglecourseview.php');
    elgg_register_action('addmenuitem', $base_path . '/actions/courseview/addmenuitem.php'); //::TODO: what is this again???
    elgg_register_action('editacohort', $base_path . '/actions/courseview/editacohort.php');
}

//the method that gets called when one of the courseview urls is called.  
function courseviewPageHandler($page, $identifier)
{
    //TODO:: Matt, do I need to be more worried about gatekeeper functions etc?
    elgg_set_page_owner_guid($page[1]);   //set the page owner to the cohort and then call gatekeeper
    group_gatekeeper();

    /*Since it is possible to require the current cohort and menuitem while on a non-courseview page, we push
     * this information into the session
     */
    ElggSession::offsetSet('cvcohortguid', $page[1]);  
    ElggSession::offsetSet('cvmenuguid', $page[2]);
    
    $base_path = elgg_get_plugins_path() . 'courseview/pages/courseview';

    switch ($page[0])  //switching on the first parameter passed through the RESTful url
    {
        case 'contentpane':    //this is the main course content page
            require "$base_path/contentpane.php";
            break;
        case 'courseview':   //this is the landing page when a user first clicks on coursview
            set_input("object_type", 'all');
//            require "$base_path/courseviewlanding.php";
            require "$base_path/contentpane.php";
            break;
//        case 'addcourse':
//            require "$base_path/addcourse.php";
//            break;
//        case 'exit':  //I don't think I need this at all...just use the togglecourseview action
//            ElggSession::offsetSet('courseview', false);
//            forward('http://localhost/elgg/activity');
//            break;
            //One of the next two should be deleted --pick one to manage all courses
//        case 'managecourseview':
//            require "$base_path/managecourseview.php";
//            break;
//        case 'managecourses':
//            set_input("object_type", $page[1]);
//            require "$base_path/managecourses.php";
//            break;
//        case 'testinginit':  //this will go too  -- just used for debugging
//            require "$base_path/testinginit.php";
//            break;
//        default:
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
        $returnvalue = elgg_view('courseview/hijacksidebar') . $temp;
    }
    return $returnvalue;
}

//this method intercepts object creations and adds relationships to menu items when appropriate
//function cvinterceptcreate($event, $type, $object)
//{
//    $cvmenuguid = ElggSession::offsetGet('cvmenuguid'); //need to get this from the session since I'm no longer on a courseview page
//    $cvcohortguid = ElggSession::offsetGet('cvcohortguid');
//    $validplugins = unserialize(elgg_get_plugin_setting('availableplugins', 'courseview'));
//    //check if the courseview flag is on and the object is one of the selected plugins available to courseview from the settings page.
//    if (ElggSession::offsetGet('courseview') && is_valid_plugin($object->getSubtype()))
//    {
//        $relationship = 'content';
//
//        if (get_entity($cvmenuguid)->menutype != 'professor')
//        {
//            $relationship.= $cvcohortguid;
//        }
////        echo 'cvmenuguid:  '.$cvmenuguid.'<br>';
////        echo 'relationship:  '.$relationship.'<br>';
////        echo 'new object guid:  '.$object->guid.'<br>';
//
//        add_entity_relationship($cvmenuguid, $relationship, $object->guid);
//        $rootdomain = elgg_get_site_url();
//        $cvredirect = $rootdomain . 'courseview/contentpane/' . $cvcohortguid . '/' . $cvmenu;
//        ElggSession::offsetSet('cvredirect', $cvredirect);
//        //::TODO:  Need to understand the whole forward intercept thing better.
//    }
// }

function cvinterceptupdate($event, $type, $object)
{
    $cvmenuguid = ElggSession::offsetGet('cvmenuguid'); //need to get this from the session since I'm no longer on a courseview page
    $cvcohortguid = ElggSession::offsetGet('cvcohortguid');
    $validplugins = unserialize(elgg_get_plugin_setting('availableplugins', 'courseview'));

    $menu_items = get_input('menuitems');
    foreach ($menu_items as $menu_item)
    {
        /* Note that $menu_items is an array of Strings passed from cvaddtocohorttree where each element contains three pieces 
         * of information in the format Xmenuitemguid|cohortguid where X is a + if a new relationship should be created.
         * menuitemguid is stripped out into $menu_item and cohortguid is stripped out into $cohort_guid
         */
        $cohort_guid = substr(strstr($menu_item, '|'), 1);
        $menu_item_guid = substr(strstr($menu_item, '|', true), 1);
        $guid_one = $menu_item_guid;

        //need to check if this is a non-professor type content and change relationship accordingly...
        $relationship = 'content';
        //however, if the $menuitem is not of type 'professor' (ie, of type 'student'), then we need to append the particulart  cohort to 'content'
        if (get_entity($menu_item_guid)->menutype != 'professor')
        {
            $relationship.= $cohort_guid;
        }

        $guid_two = $object->guid;
        if (strrchr('+', $menu_item))  //if the module was checked, then add relationship
        {
            add_entity_relationship($guid_one, $relationship, $guid_two);
        } 
        else
        {
            $rel_to_delete = check_entity_relationship($guid_one, $relationship, $guid_two);
            if ($rel_to_delete)  //if the module was unchecked and there was a relationship, we need to remove the relationship
            {
                delete_relationship($rel_to_delete->id);
            } 
        }
    }

    $rootdomain = elgg_get_site_url();
    $cvredirect = $rootdomain . 'courseview/contentpane/' . $cvcohortguid . '/' . $cvmenuguid;
    ElggSession::offsetSet('cvredirect', $cvredirect);
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

function cventitymenu($hook, $type, $return, $params)
{
    if (is_valid_plugin($params['entity']->getSubtype()))
    {
        $item = new ElggMenuItem('cvpin', 'add to Cohort', '#');
        $return [] = $item;
    }
    return $return;
}

function is_valid_plugin($arg1)
{
    $validplugins = unserialize(elgg_get_plugin_setting('availableplugins', 'courseview'));
    return (array_key_exists($arg1, $validplugins));
}


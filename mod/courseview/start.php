<?php

/**
 * Write something profound here...
 */
elgg_register_event_handler('init', 'system', 'courseviewInit'); //call courseviewinit when the plugin initializes

function courseviewInit()
{
    elgg_extend_view('css/elgg','courseview/css', 1000);  //set up our link to css rulesets


//register menu item to switch to CourseView
    //instead of calling an url and handling in the switch statement, use an action.
  //$item = new ElggMenuItem('courseview', 'CourseView', elgg_add_action_tokens_to_url('action/toggle')); // then add an action at action/courseview/toggle
  //::TODO:  Ask Matt about the redirect in togglecourseview.php == until then, keep doing it the old way by passing it to the switch
    $item = new ElggMenuItem('courseview', 'CourseView', 'courseview/main');
    elgg_register_menu_item('site', $item);

    //::TODO:  ok, so what do I do with this now?  Probably don't need this anymore...
    add_group_tool_option("courseview", "Use this group as a CourseView cohort", FALSE);

    //include the courseview.php  library 
    include dirname(__FILE__) . '/lib/courseview.php';
    
  //::TODO:delete these lines below
   //elgg_register_library('elgg:courseview', elgg_get_plugins_path() . 'courseview/lib/courseview.php');
   // elgg_load_library('elgg:courseview');

    //this allows us to hijack the sidebar.  Each time the sidebar is about to be rendered, this hook fires
    elgg_register_plugin_hook_handler('view', 'page/elements/sidebar', 'sidebar_intercept');
    //this allows us to intercept each time elgg calls a forward.  We will use this to be able to return to the coursview tool after adding a relationship
    //to added content
    elgg_register_plugin_hook_handler ('forward', 'all', 'cvforwardintercept');
    
    //register page event handler
    elgg_register_page_handler('courseview', 'courseviewPageHandler');
    //elgg_register_event_handler('pagesetup', 'system','interceptpagesetup');  //likely won't need this
    //this is registering an event handler to call my interceptcreate method whenever an object is created.
    elgg_register_event_handler('create', 'object','interceptcreate');

    //set up our paths
    //$plugin_path = elgg_get_plugins_path();
   
    $base_path=dirname(__FILE__); //gives a relative path to the directory where this file exists

    //this is where I will put all of the action registrations for the forms
    //::TODO:  Get Matt to better explain how actions/forms work 
    elgg_register_action("createcourse", $base_path . '/actions/courseview/createcourse.php');
    elgg_register_action('toggle',$base_path.'/actions/courseview/togglecourseview.php');
    elgg_register_action ('addmenuitem', $base_path.'/actions/courseview/addmenuitem.php');
    
    //echo $CONFIG->actions; -- what does this do?
}

//this is the method that gets called when one of the courseview urls is called.  We will use a switch to choose how to respond
function courseviewPageHandler($page, $identifier)
{
    //TODO::add a group gatekeeper function here --find out more about gatekeeper code
    elgg_set_page_owner_guid($page[1]);   //set the page owner to the cohort and then call gatekeeper
    group_gatekeeper();
    
    $base_path = elgg_get_plugins_path(). 'courseview/pages/courseview';

    
    //set_input ('cvcohortguid', $page[1]);
    //set_input ('cvmenuguid', $page[2]);
   ElggSession::offsetSet('cvcohortguid',$page[1]);
   ElggSession::offsetSet('cvmenuguid',$page[2]);

    switch ($page[0])  //switching on the first parameter passed through the RESTful url
    {
        case 'main':
           
            $status = ElggSession::offsetGet('courseview');
   //          echo '$$$'.$status;
            //if the courseview session variable was false, toggle it to true and viceversa
            if ($status)
            {
                //put these back in order to exit courseview
                ElggSession::offsetSet ('courseview', false);
                forward('http://localhost/elgg/activity');
            }
            else
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
    //system_message("Rich's object creation event hander was just triggered...");
    //system_message("object created:  ".$object->guid);
  
     $cvmenu = ElggSession::offsetGet('cvmenu'); //need to put this into the session since I'm no longer on a courseview page
     $cvcohort = ElggSession::offsetGet('cvcohort');
    //system_message ('CVMENUGUID: '.$temp2);
    // system_message ('object subtype: '.$object->getSubtype());
     
    if ($object->getSubtype() !='cvmenu' && ElggSession::offsetGet('courseview'))//::TODO:need to eventually change this to only add to subtype of approved plugins
    {
         $relationship = 'content' . $cvcohort;
        add_entity_relationship($cvmenu, $relationship, $object->guid); 
        $rootdomain = elgg_get_site_url();
    $cvredirect =$rootdomain.'courseview/contentpane/'.$cvcohort.'/'.$cvmenu;
    ElggSession::offsetSet ('cvredirect', $cvredirect);
        // system_message ('Added a relationship!'.$cvmenu.'->'.$relationship.'->'.$object.guid);
    }
    
    //echo elgg_echo('interceptcreate is running:  The object just created was of type: '.$type.' GUID:  '.$object->guid.' and subtype: '.$object->subtype.'<br/>');
    

    
    
    
    //$plugin_path = elgg_get_plugins_path();
    //$content_path = $plugin_path . 'courseview/pages/contentpane';
    
   //forward ('http://localhost/elgg/courseview/contentpane/'.$cvcohort.'/'.$cvmenu);
}
//::TODO:  All of my methods need to be namespaced with cv

function cvforwardintercept ($hook, $type, $return, $params)
{
   $cvredirect =ElggSession::offsetGet('cvredirect');
    if (!empty($cvredirect))
    {
        $return = ElggSession::offsetGet('cvredirect');
        ElggSession::offsetUnset ('cvredirect');
    }
    return $return;
   
//    var_dump($params);
//    exit;
}

function interceptpagesetup ($event, $type, $object)
{
    $context = elgg_get_context();
    //system_message('Context:  '.$context);
    $temp1 = 'abc'.get_input('cvmenuguid');
    //system_message ('CVMENUGUID: '.get_input('cvmenuguid'));
    if ($context=='group_profile')
    {
       //echo elgg_echo ('In Group Page '.var_dump($object));
    }
}

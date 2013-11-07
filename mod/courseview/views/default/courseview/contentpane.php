<?php

/*
 * Rich Test stuff
 */
// ::TODO:  I need to start packaging all output into an elgg view and then calling the view properly instead of just using elgg_echo
//echo elgg_view('output/url', array("text" => "Manage Courses", "href" => "courseview/thiswillmanagecourses", 'class' => 'elgg-button elgg-button-action'));

//build variables list
$user = elgg_get_logged_in_user_entity();
$cvcohortguid=ElggSession::offsetGet('cvcohortguid');
$cvmenuguid = ElggSession::offsetGet('cvmenuguid');
$menuitem = get_entity($cvmenuguid);  //get the menuitem object
$menutype = $menuitem->menutype;  //there are three types of menu items:  folder, bundle, and student
$base_path=dirname(__FILE__); //gives a relative path to the directory where this file exists
//echo 'MENU ITEM: '.$menuitem->name;
require (elgg_get_plugins_path() . 'courseview/lib/courseview.php'); //various methods 
//::TODO:  Is it better to require this or use somthing like this
    //elgg_register_library('elgg:courseview', elgg_get_plugins_path() . 'courseview/lib/courseview.php');
    // elgg_load_library('elgg:courseview');


//if the user is a prof, include the ability to edit the course
if ((cv_isprof($user)))
{
    require "$base_path/profeditcontentview.php";
}
//depending on what type of module is selected, load the correct view for folder, bundle or student
switch ($menutype)
{
    case "folder":
        echo elgg_echo("<br><p id = 'cvfolderdescription'>" . $menuitem->name."</p>");
        echo elgg_echo("<br>Description: " . $menuitem->description);
        break;

    case "bundle":
       require "$base_path/bundlecontentview.php"; 
        break;

    case "student":  //::TODO:  Same thing...move refactor all of this into constituent methods for code clarity...
         require "$base_path/studentcontentview.php";
        break;
    
    default:
        echo elgg_echo("<BR><BR>WELCOME TO COURSEVIEW");
        break;
}
 
 
 
 

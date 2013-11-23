<?php
//$validplugins= unserialize(elgg_get_plugin_setting('availableplugins', 'courseview')); 
//if (array_key_exists("blog",$validplugins))
//{
//    echo 'yep';
//} 
//else
//{
//    echo 'nope';
//}
//var_dump ($validplugins);
//echo cv_is_valid_plugin ('blog');
//exit;
/*
 * Rich Test stuff
 */
// ::TODO:  I need to start packaging all output into an elgg view and then calling the view properly instead of just using elgg_echo
//echo elgg_view('output/url', array("text" => "Manage Courses", "href" => "courseview/thiswillmanagecourses", 'class' => 'elgg-button elgg-button-action'));

  elgg_load_library('elgg:courseview');
  
//  echo elgg_view('courseview/testing'); 
//  exit;
$user = elgg_get_logged_in_user_entity();
$cvmenuguid = ElggSession::offsetGet('cvmenuguid');
$menuitem = get_entity($cvmenuguid);  //get the menuitem object
$menutype = $menuitem->menutype;  //there are three types of menu items:  folder, professor, and student
$base_path=dirname(__FILE__); //gives a relative path to the directory where this file exists
//echo 'MENU ITEM: '.$menuitem->name;
//require (elgg_get_plugins_path() . 'courseview/lib/courseview.php'); //various methods 
//::TODO:  Is it better to require this or use somthing like this
 
echo '<h1>'.$menuitem->name.'</h1><br>';
//if the user is a prof, include the ability to edit the course
if ((cv_isprof($user)))
{
    echo elgg_view('courseview/profeditcontentview');  //don't use require when  a view will do...
}
//depending on what type of module is selected, load the correct view for folder, professor or student
switch ($menutype)
{
    case "folder":
        echo elgg_echo("<br><p id = 'cvfolderdescription'>" . $menuitem->name."</p>");
        echo elgg_echo("<br>Description: " . $menuitem->description);
        break;
//::TODO:  CHANGE THESE REQUIRES INTO ELGG_VIEW
    case "professor":
         case "bundle":    //delete this down the road
       echo elgg_view('courseview/professorcontentview'); 
        break;

    case "student": 
         echo elgg_view('courseview/studentcontentview');
        break;
    
    default:
        echo elgg_echo("<BR><BR>WELCOME TO COURSEVIEW");
        break;
   
}
 
echo "<p id = 'debug'></p>";
 
 
 

<?php

/*
 * This action will create a course using information provided by the createcourse form
 */

//I need to place the code to build the course object here and then redirect some sort of course editing page...
//I should check to make sure that the user is a professor.
//echo'createcourse action called';
//exit;
$cvcoursename = get_input('cvcoursename');  //this pulls the text from the title textbox in the form...
//echo $cvcoursename;
$cvcoursedescription = get_input('cvcoursedescription');
//echo $cvcoursedescription;

$cvcourse = new ElggObject();
$cvcourse->title = $cvcoursename;
$cvcourse->access_id = ACCESS_PUBLIC;
$cvcourse->owner_guid = elgg_get_logged_in_user_guid();
$cvcourse->container_guid = elgg_get_logged_in_user_guid();
$cvcourse->save();
$cvcourse->cvcourse = true;
$cvcourse->description = $cvcoursedescription;
$cvcourse->save();
//echo elgg_echo("Course Created! ");

$cvmenu = new ElggObject();
    $cvmenu->subtype = 'cvmenu';
    $cvmenu->name = $cvcoursename;
    $cvmenu->owner_guid = $user->guid;
    $cvmenu->container_guid = $cvcourse->guid;
    $cvmenu->access_id = ACCESS_PUBLIC;
    $cvmenu->save();
    $cvmenu->menutype = "folder";
    $cvmenu->meta1 = "closed";
    $cvmenu->menuorder = 0;
    $cvmenu->indent="0";
    $cvmenu->save();
//now, connect it to the course
    //echo "Adding first menu item relationship: $cvcourse->guid menu $cvmenu->guid";
    add_entity_relationship($cvcourse->guid, "menu", $cvmenu->guid);


?>

<?php

/*
 * This action will create a course using information provided by the createcourse form
 */

//I need to place the code to build the course object here and then redirect some sort of course editing page...
//I should check to make sure that the user is a professor.

$cvcoursename = get_input('cvcoursename');  //this pulls the text from the title textbox in the form...
echo $cvcoursename;
$cvcoursedescription = get_input('cvcoursedescription');
echo $cvcoursedescription;

exit;
$cvcourse = new ElggObject();
$cvcourse->title = $cvcoursename;
$cvcourse->access_id = ACCESS_PUBLIC;
$cvcourse->owner_guid = elgg_get_logged_in_user_guid();
$cvcourse->container_guid = elgg_get_logged_in_user_guid();
$cvcourse->save();
$cvcourse->cvcourse = true;
$cvcourse->description = $cvcoursedescription;
$cvcourse->save();
echo elgg_echo("Course Created! ");
exit;
?>

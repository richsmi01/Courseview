<?php

//TODO need to eventually fix this up to present the user with options depending on whether they are student, prof, or admin


//get the CourseView object.  This object contains all of the stuff we need to run CourseView.
//If the courseview object doesn't exist, courseview_initialize () will assume that this is the first time that
//courseview has run on this installation and will create a new one
$courseview_guid = courseview_initialize();
//this puts the courseview object into the session
ElggSession::offsetSet('courseviewobject', courseview_initialize());
//build and call greetings view
$user = elgg_get_logged_in_user_entity();
$params = array('name' => $user->name);
$content = elgg_view('courseview/homeview', $params);

//display the content in a one_sidebar layout
$vars = array('content' => $content,);
$body = elgg_view_layout('two_column_left_sidebar', $vars, $vars);
echo elgg_view_page($title, $body);
?>
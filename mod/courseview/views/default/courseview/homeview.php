<?php

//this will eventually have to get more sophisticated to present the user with options depending on who they are: student, prof or admin
//if they are a student, we will present them with a list of cohorts that they belong to and allow them to choose one.
echo elgg_echo ('courseview:greetings', array ($vars ['name']));

if (elgg_is_admin_logged_in())
{
    echo elgg_echo ("ADMIN CHOICES <br/>");
    echo elgg_echo ('courseview:adminstatus');
    
    echo elgg_view('output/url', array("text" => "Manage CourseView", "href" => "courseview/managecourseview", 'class' => 'elgg-button elgg-button-action'));
}

$myuser = elgg_get_logged_in_user_entity();


//if (courseview_get_profsgroup()->isMember ($myuser))
//{
   echo '<br>'.$myuser->name .' is in the profs group';
   echo elgg_view('output/url', array("text" => "Manage Courses", "href" => "courseview/managecourses", 'class' => 'elgg-button elgg-button-action'));
   
//}

?>

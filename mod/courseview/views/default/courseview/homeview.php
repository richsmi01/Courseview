<?php


echo elgg_echo ('courseview:greetings', array ($vars ['name']));

if (elgg_is_admin_logged_in())
{
    echo elgg_echo ("ADMIN CHOICES <br/>");
    echo elgg_echo ('courseview:adminstatus');
    
    echo elgg_view('output/url', array("text" => "Manage CourseView", "href" => "courseview/managecourseview", 'class' => 'elgg-button elgg-button-action'));
}

$myuser = elgg_get_logged_in_user_entity();


if (courseview_get_profsgroup()->isMember ($myuser))
{
   echo '<br>'.$myuser->name .' is in the profs group';
   echo elgg_view('output/url', array("text" => "Manage Courses", "href" => "courseview/managecourses", 'class' => 'elgg-button elgg-button-action'));
   
}


//$profgroup = elgg_get_entities(array(
//    'type' => 'group',
//    'joins' => array("JOIN {$db_prefix}groups_entity ge on ge.guid = e.guid"),
//    'wheres' => array("ge.name = '$name'"),
//));

//if ($profgroup.isMemeber ($myuser->guid))
//{
//    
//}

?>

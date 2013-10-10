<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

echo 'Course created!!!';
    $coursegroup= new ElggGroup();
    $coursegroup->subtype = 'group';
    $coursegroup ->title ='comp697';
    $coursegroup ->name ='comp697';
    $coursegroup ->save();
    $coursegroup -> testAttribute = "Hi Rich";
    $coursegroup ->save();

    $user = elgg_get_logged_in_user_entity();
    $groups = $user->getGroups();
    
    foreach ($groups as $group)
{
    echo elgg_echo ("GROUP: ".$group->title.$group->testAttribute);
}

?>

<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


echo elgg_echo('Manage CourseView');
echo elgg_echo('<br>This page is only accessable to administrators and will do the following:<br>');
echo elgg_echo('Add a professor to courseview<br>');
echo elgg_echo('Remove a professor from courseview<br>');
echo elgg_echo('Add a cohort to courseview<br>');
echo elgg_echo('Remove a cohort from courseview<br>');
echo elgg_echo('Add a plugin type to courseview<br>');
echo elgg_echo('remove a plugin type from courseview<br>');
echo elgg_echo('return to home page<br>');

echo elgg_view('output/url', array("text" => "Add a Professor", "href" => "courseview/addProfessor", 'class' => 'elgg-button elgg-button-action'));

echo elgg_echo (courseview_listplugins());
//echo elgg_view(courseview_listplugins()); 
  //include the form that allows the admin to add or remove plugins from CourseView's pervue
echo elgg_view_form('adddeleteelggplugin');
  
  
  
  ?>

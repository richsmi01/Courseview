<?php

/*
 * 
 */

echo 'adding course';


$course_content = array();
$course_content [0][0]='Module 1';
$course_content[0][1] = 'blog';
$course_content[0][2] = 'file';
$course_content[1][0] = 'Module 2';
$course_content[1][1] = 'blog';
$course_content[1][2] = 'file';
$course_content[1][3] = 'bookmarks';

echo elgg_view_form('createcourse');
echo elgg_echo("Testing");
//$group = elgg_get_entities_from_metadata(array(guid=>51));
//$group = elgg_get_entities_from_metadata(array(type=>'group', name=>'RichGroup1'));
//$group = elgg_get_entities_from_annotations(array(type=>'group', annotation_name_value_pairs=>array('name','RichGroup1')));
//echo elgg_echo ('group:  '.var_dump($group[1]->getGUID()));
//echo elgg_echo (elgg_list_entities(array('type' => 'group', 'title'=>'RichGroup1')));
echo elgg_echo (var_dump(get_entity(51)));
$group = get_entity(51);
$user = elgg_get_logged_in_user_entity( ) ;	

echo elgg_echo ('Is Member? '.$group->isMember($user));

$course_title = 'Course 1';


?>

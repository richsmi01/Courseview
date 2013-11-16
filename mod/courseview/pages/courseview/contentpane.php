<?php

$content = elgg_view('courseview/contentpane');
//$content .= elgg_view('courseview/debug');
$content .= elgg_view('courseview/treeview');
 
$vars = array('content' => $content,);
$body = elgg_view_layout('one_sidebar', $vars);
echo elgg_view_page('CourseView', $body);




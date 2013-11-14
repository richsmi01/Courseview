<?php

$content = elgg_view('courseview/contentpane');
$content .= elgg_view('courseview/debug');
$vars = array('content' => $content,);
$body = elgg_view_layout('one_sidebar', $vars);
echo elgg_view_page($title, $body);




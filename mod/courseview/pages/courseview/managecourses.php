<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

echo 'Manage Courses<br>';

 $rs_type = ElggSession::offsetSet('object_type', 'course');
  //require "$base_path/contentpane.php";

  
 //$content = elgg_view ('courseview/contentpane').'<br>';
 
  $content .= elgg_view('output/url', array("text" => "Set Initial Testing Conditions", "href" => "courseview/testinginit", 'class' => 'elgg-button elgg-button-action'));
 $content .= elgg_view('output/url', array("text" => "Add a course", "href" => "courseview/addcourse", 'class' => 'elgg-button elgg-button-action'));
 $vars = array('content' => $content,);
 $body = elgg_view_layout('one_sidebar', $vars);
 echo elgg_view_page($title, $body);
  
  




//
//$course_content = array();
//$course_content [0][0]='Module 1';
//$course_content[0][1] = 'blog';
//$course_content[0][2] = 'file';
//$course_content[1][0] = 'Module 2';
//$course_content[1][1] = 'blog';
//$course_content[1][2] = 'file';
//$course_content[1][3] = 'bookmarks';
//
//echo '
//    <style>
//   /* ##### Top level items #####*/
//
//#acdnmenu 
//{
//    /* Note about height: 
//    Set "height:auto;" if flexible height is required. 
//    A fixed height is prefered as content below the menu wont be pulled down/up when the menu is expanding/collapsing. */
//    height: 300px;
//    width: 240px;
//}
//
//
//#acdnmenu ul.top
//{
//	padding-left:0;
//    background:#CDE3F7;
//    border:1px solid #4B8CCD;
//    padding-bottom:1px;
//}
//
//#acdnmenu div.heading, #acdnmenu a.link
//{
//    padding:8px; padding-left:24px;
//    text-align:left;
//    font:normal 12px Verdana;
//    color:#FFF; 
//    background:#4B8CCD;
//    text-decoration:none;
//    border:1px solid #97C8F7;
//    border-bottom:none;
//    outline:none;
//}
//
//#acdnmenu div.current, #acdnmenu div:hover, #acdnmenu a.link:hover, #acdnmenu div.current a.link
//{
//    color:#FFF;
//    font-weight:normal;
//    text-decoration:none;  
//    background:#377EC6;
//}
//
///*Top level link without children*/
//#acdnmenu a.current, #acdnmenu a.current:hover
//{
//    color:#FFF;
//    text-decoration:underline;   
//}
//
///* arrow image for the top headings */
//#acdnmenu div.arrowImage {
//    width:12px;
//    height:12px;
//    top:9px;
//    left:4px; /* Changing it to "right:4px;" will position the arrow image to the right */
//    background-image:url(arrows.gif);
//    background-position:0 0;
//}
//
//#acdnmenu div.current div.arrowImage {
//    background-position:0 -12px;
//}
//
//#acdnmenu li.separator
//{
//    border-top:none;
//    border-bottom:none; 
//}
//
//
///* ##### Sub level items #####*/
//#acdnmenu ul.sub
//{
//	padding-left:14px; /*This determines the hierarchical offset*/ 
//}
//
//#acdnmenu ul.sub div.heading
//{
//    text-align:left;
//    font:normal 12px Arial;
//    padding:5px; padding-left:20px;
//    color:#000;
//    background:none; 
//    border:none;
//}
//#acdnmenu ul.sub div.heading a
//{
//    color:#000;
//}
//
//#acdnmenu ul.sub div.current
//{
//    color:#000;
//    background:none; 
//}
//
//#acdnmenu ul.sub a.link
//{
//    font:normal 11px Arial;
//    color:#000;
//    padding:5px; padding-left:20px;
//    text-decoration:none;
//    background:none; 
//    border:none;
//}
//
//#acdnmenu ul.sub a.link:hover, #acdnmenu ul.sub a.current, #acdnmenu ul.sub div.heading a:hover, #acdnmenu ul.sub div.heading a.current
//{
//    color:#000;
//    text-decoration:underline;
//    background:none; 
//}
//
//
//#acdnmenu ul.sub div.arrowImage {
//    width:12px;
//    height:12px;
//    top:6px;
//    left:4px;
//    background-image:url(arrows.gif);
//    background-position:0 -24px;
//}
//#acdnmenu ul.sub div.current div.arrowImage {
//    background-position:0 -36px;
//}
//
//
//
///* ##### Followings usually dont need modification ###### */
///*Hack the font-size:0 bug for IE6 */
//#acdnmenu,  #acdnmenu ul
//{
//    display:block;
//    font-size:0px;
//    line-height:0px;
//}
//#acdnmenu li {font-size:12px; line-height:16px;}
//#acdnmenu:after {content:'.';height:0;clear:both;display:block;visibility:hidden;} 
//
///*Hack for IE6-7*/
//#acdnmenu ul, #acdnmenu li, #acdnmenu div.heading, #acdnmenu a.smLink, #acdnmenu div.description {*zoom:1;}
//#acdnmenu li {*float:left;*width:100%;}
//
//#acdnmenu ul
//{
//	position:relative;/*!*/
//	overflow:hidden;
//	padding:0;margin:0;list-style-type: none;padding-left:10px;
//}
//#acdnmenu>ul{visibility: hidden;}
//#acdnmenu li {padding:0;margin:0;}
//
//#acdnmenu div.heading, #acdnmenu div.current
//{
//	position:relative;
//    cursor: pointer;
//}
//#acdnmenu div.arrowImage {position:absolute; overflow:hidden;}
//
//</style>
//
//
// <div id="hmn0" style="margin-top:50px;">
//    <nav>
//        <div id="acdnmenu" style="width:208px;height:390px;">
//              <ul>
//              <li style="display:none;"><a href="/">Home</a></li>
//        ';
//
//
//for ($row = 0; $row<  sizeof($course_content); $row++)
//{
//   echo elgg_echo ('<li >'.$course_content [$row][0].'<ul>');
//    
//    for ($column =1; $column< sizeof($course_content[$row]); $column++)
//    {
//        echo '<li><a href ="'.$course_content [$row][$column].'">---'.$course_content [$row][$column].' </a></li>';
//        //echo '<br>----'.$course_content[$row][$column];
//    }
//    
//}
//
//echo '</ul></li></li></div>
//';

?>

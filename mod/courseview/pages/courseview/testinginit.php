<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


echo elgg_echo ("Made it to the initializing testing page!");

//first, remove all courseviewcourse objects

$courses = elgg_get_entities(array(type=>'object', subtype=>'courseviewcourse'));
  echo elgg_echo (var_dump ($courses));


    foreach ($courses as $temp) {
        echo elgg_echo ('~~~ '.$temp->subtype);
        echo elgg_echo ($temp->coursename);
        $temp->delete ();
  }
  
  //next, make a couple courses
  

  
    $courseviewcourse = new ElggObject();
    $courseviewcourse->type='object';
    $courseviewcourse->subtype = "courseviewcourse";
    $courseviewcourse->access_id = 2;
    $courseviewcourse->save();
    $courseviewcourse ->coursename = 'COMP 697';
    $courseviewcourse ->courseid = 697;
    $courseviewcourse ->cohortid = 23;
    $courseviewcourse ->coursetree =array();
        $coursetree[0] = array (
            label=>'Module 1',
            contenttype =>'moduleOpen',
            subtype =>'mod1guid',
            filter=>'',
            indent=>'0',
            );
            $coursetree[1] = array (
            label=>'Professors Rants',
            contenttype =>'bundle',
            subtype =>'bundleguid1',
                 indent=>'+',
            filter=>''
            );
            $coursetree[2] = array (
            label=>'More Comments',
            contenttype =>'guid99999',
            subtype =>'',
                 indent=>'0',
            filter=>''
            );
            $coursetree[3] = array (
            label=>'Module 2',
            contenttype =>'moduleOpen',
            subtype =>'mod2guid',
            indent=>'-',
            filter=>''
            );
             $coursetree[4] = array (
            label=>'Blogs 1',
            contenttype =>'guid99999',
            subtype =>'blog',
                 indent=>'+',
            filter=>array ('tag1','blog1')
            );
              $coursetree[5] = array (
            label=>'Blogs 2',
            contenttype =>'guid99999',
            subtype =>'blog',
                 indent=>'0',
            filter=>array ('tag1')
            );
              $coursetree[6] = array (
            label=>'Files',
            content =>'guid99999',
            subtype =>'file',
                 indent=>'0',
            filter=>array ('tag1')
            );
                 $coursetree[7] = array (
            label=>'The Wire',
            contenttype =>'guid99999',
            subtype =>'thewire',
                 indent=>'-',
            filter=>'tag1'
            );
                  $coursetree[8] = array (
            label=>'Bookmarks',
            content =>'guid99999',
            subtype =>'bookmarks',
                 indent=>'-',
            filter=>array('blog1')
            );
    //ElggSession::offsetSet('currentcourse', $coursetree);
    $courseviewcourse->save();

    
    //course number 2
     $courseviewcourse = new ElggObject();
    $courseviewcourse->subtype = "courseviewcourse";
    $courseviewcourse->access_id = 2;
    $courseviewcourse->save();
    $courseviewcourse ->coursename = 'Sailing';
    $courseviewcourse ->courseid = 987;
    $courseviewcourse ->cohortid = 22;
    $courseviewcourse ->coursetree =array();
        $coursetree[0] = array (
            label=>'Module 1',
            contenttype =>'moduleOpen',
            subtype =>'mod1guid',
            filter=>'',
            indent=>'0',
            );
            $coursetree[1] = array (
            label=>'Professors Rants',
            contenttype =>'bundle',
            subtype =>'bundleguid1',
                 indent=>'+',
            filter=>''
            );
            $coursetree[2] = array (
            label=>'More Comments',
            contenttype =>'guid99999',
            subtype =>'',
                 indent=>'0',
            filter=>''
            );
            $coursetree[3] = array (
            label=>'Module 2',
            contenttype =>'moduleOpen',
            subtype =>'mod2guid',
            indent=>'-',
            filter=>''
            );
             $coursetree[4] = array (
            label=>'Blogs 1',
            contenttype =>'guid99999',
            subtype =>'blog',
                 indent=>'+',
            filter=>array ('tag1','blog1')
            );
              $coursetree[5] = array (
            label=>'Blogs 2',
            contenttype =>'guid99999',
            subtype =>'blog',
                 indent=>'0',
            filter=>array ('tag1')
            );
              $coursetree[6] = array (
            label=>'Files',
            content =>'guid99999',
            subtype =>'file',
                 indent=>'0',
            filter=>array ('tag1')
            );
                 $coursetree[7] = array (
            label=>'The Wire',
            contenttype =>'guid99999',
            subtype =>'thewire',
                 indent=>'-',
            filter=>'tag1'
            );
                  $coursetree[8] = array (
            label=>'Bookmarks',
            content =>'guid99999',
            subtype =>'bookmarks',
                 indent=>'-',
            filter=>array('blog1')
            );
    //ElggSession::offsetSet('currentcourse', $coursetree);
    $courseviewcourse->save();
    
     foreach ($courses as $temp) {
        echo elgg_echo ('###'.var_dump($temp->subtype));       
      
  }
?>

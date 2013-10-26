<?php
//this method grabs the courseview object and returns the profsgroup attribute which contains the guid of the profsgroup
function cv_get_profsgroup () 
{
    $cvcourseview = elgg_get_entities(array('type'=>'object','subtype'=>'courseview'));
    return $cvcourseview[0]->profsgroup;
}

function cv_isprof ($user)
{
    $profsgroup = get_entity(elgg_get_plugin_setting('profsgroup','courseview'));
    echo $profsgroup->guid;

    if ($profsgroup->guid=='')
    {
        return false;
    }
    else
    {
        return true;
    }
    
//    echo elgg_entity_exists(elgg_get_plugin_setting('profsgroup','courseview'));
//    //echo get_entity($profsgroup)->isMember($user);
//    if(get_entity($profsgroup)->isMember($user))
//    {
//        return true;
//    }
//    else 
//        {
//        return false;
//        }
    
//   $profs =cv_get_profsgroup();
//    
//   if   (get_entity(cv_get_profsgroup())->isMember ($user))
//    {
//        return true;
//    }
}
/*
 * 
 */
function courseview_initialize ()
{
    //just some learning stuff
    $courseview_object = elgg_get_entities(array('type' => 'object', 'subtype' => 'courseview'))[0];
    
    //echo elgg_echo ('coursetreexxx'.var_dump($courseview_object->coursetree));
    ElggSession::offsetSet('currentcourse',$courseview_object->coursetree);
    
    
    //echo 'courseview_object guid:  ' . $courseview_object->guid;
    $courseview_object->plugins = array ('Hi Rich...It works!', 'blog', 'bookmark');
    $courseview_object->save;
    
   // echo '######'.$courseview_object->plugins[0];
    //if a CourseView Object doesn't exist, this must be the first time the plugin has run.  In that case,
    //we build a CourseView Object to track various things that our plugin needs.
if (!$courseview_object)
{
     //Since this is the first time that CourseView has run, we need to create a professor group
    $courseview_profsgroup = new ElggGroup();
    $courseview_profsgroup->subtype = 'group';
    $courseview_profsgroup ->title ='profsgroup';
    $courseview_profsgroup ->name ='profsgroup';//just added this...should it be name or title?
    $courseview_profsgroup ->save();
    
    $courseview_object = new ElggObject();
    $courseview_object->subtype = "courseview";
    $courseview_object->access_id = 2;
    $courseview_object->save();
    $courseview_object ->plugins = array('blog','bookmark');
    $courseview_object->profsgroup = $courseview_profsgroup->guid; //add the profsgroup guid to our courseview object.
    $courseview_object->save();
  //  echo 'This is the first time that CourseView has run...new CourseView object created';
    
   
    
  //  echo 'profsgroup created:  '.$courseview_profsgroup->guid;    
}


//::TODO:  delete this stuff after I get my create course code all worked out

//$coursetree = array();
//$coursetree[0] = array (
//    label=>'Module 1',
//    contenttype =>'moduleOpen',
//    subtype =>'mod1guid',
//    filter=>'',
//    indent=>'0',
//    );
//    $coursetree[1] = array (
//    label=>'Professors Rants',
//    contenttype =>'bundle',
//    subtype =>'bundleguid1',
//         indent=>'+',
//    filter=>''
//    );
//    $coursetree[2] = array (
//    label=>'More Comments',
//    contenttype =>'guid99999',
//    subtype =>'',
//         indent=>'0',
//    filter=>''
//    );
//    $coursetree[3] = array (
//    label=>'Module 2',
//    contenttype =>'moduleOpen',
//    subtype =>'mod2guid',
//    indent=>'-',
//    filter=>''
//    );
//     $coursetree[4] = array (
//    label=>'Blogs 1',
//    contenttype =>'guid99999',
//    subtype =>'blog',
//         indent=>'+',
//    filter=>array ('tag1','blog1')
//    );
//      $coursetree[5] = array (
//    label=>'Blogs 2',
//    contenttype =>'guid99999',
//    subtype =>'blog',
//         indent=>'0',
//    filter=>array ('tag1')
//    );
//      $coursetree[6] = array (
//    label=>'Files',
//    content =>'guid99999',
//    subtype =>'file',
//         indent=>'0',
//    filter=>array ('tag1')
//    );
//         $coursetree[7] = array (
//    label=>'The Wire',
//    contenttype =>'guid99999',
//    subtype =>'thewire',
//         indent=>'-',
//    filter=>'tag1'
//    );
//          $coursetree[8] = array (
//    label=>'Bookmarks',
//    content =>'guid99999',
//    subtype =>'bookmarks',
//         indent=>'-',
//    filter=>array('blog1')
//    );
    //ElggSession::offsetSet('currentcourse', $coursetree);

return $courseview_object->guid;
}



function courseview_create_course ()
{
  //  echo elgg_echo('in courseview_create_course method!');
//    echo  count (elgg_get_entities(array('type' => 'object', 'subtype' => 'blog' )));
//    $abc = elgg_get_entities(array('type' => 'object', 'subtype' => 'blog' ));
//    $postings = elgg_get_entities(array('type' => 'object', 'subtype' => 'blog' ));
//    foreach ($postings as $temp) {
//                echo $temp->title;
//    }
    
    $abc = count(elgg_get_entities(array('type' => 'object', 'subtype' => 'course' )));
    
    if (abc==0)
    {
        $course = new ElggCourse ();
        $course->subtype = "course";
        $course->title = "COMP 697";
        $course->access_id = 2;
        $course->save();
        $course->test = "It works!";
        $course->save();
        echo 'inside if';
    }
   // echo  count (elgg_get_entities(array('type' => 'object', 'subtype' => 'course' )));
    $postings = elgg_get_entities(array('type' => 'object', 'subtype' => 'course' ));
    foreach ($postings as $temp) {
      //          echo $temp->title;
      //          echo $temp -> id;
      //          echo $temp -> test;
               // $temp->delete ();
    }
}
    
function courseview_listplugins()
    {
        echo 'Got here!!!';
        $cvobject = ElggSession::offsetGet('courseviewobject');
        $returnvalue ='Currently Registered Plugins:  '. $cvobject->plugins[0];
        //echo $returnvalue;
        return $returnvalue;
    }
    


?>

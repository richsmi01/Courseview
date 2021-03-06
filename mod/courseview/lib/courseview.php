<?php

//this method grabs the courseview object and returns the profsgroup attribute which contains the guid of the profsgroup
//function cv_get_profsgroup()
//{
//    $cvcourseview = elgg_get_entities(array('type' => 'object', 'subtype' => 'courseview'));
//    return $cvcourseview[0]->profsgroup;
//}

function cv_get_menu_items_for_cohort($cvcohortguid)
{
    //echo "<br>Getting menu items from relationship:".get_entity($cvcohortguid)->container_guid.'-- menu --';
    $menu = elgg_get_entities_from_relationship(array
        ('relationship_guid' => get_entity($cvcohortguid)->container_guid,
        'relationship' => 'menu',
        'type' => 'object',
        'subtype' => 'cvmenu',
        'order_by_metadata' => array('name' => 'menuorder', 'direction' => 'ASC', 'as' => 'integer'),
        'limit' => 1000,
            )
    );
    //echo'<br>menu items returned '.  sizeof($menu);
    //var_dump($menu);
    return $menu;
}

function is_valid_plugin($arg1)
{
    $validplugins = unserialize(elgg_get_plugin_setting('availableplugins', 'courseview'));
    return (array_key_exists($arg1, $validplugins));
}

function cv_get_student_menu_items_by_cohort($cvcohortguid)
{
    $menu = elgg_get_entities_from_relationship(array
        ('relationship_guid' => get_entity($cvcohortguid)->container_guid,
        'relationship' => 'menu',
        'type' => 'object',
        'subtype' => 'cvmenu',
        'order_by_metadata' => array('name' => 'menuorder', 'direction' => 'ASC', 'as' => 'integer'),
        'limit' => 1000,
        'metadata_names' => array('menutype'),
        'metadata_values' => array('student'),
            )
    );
    return $menu;
}

function cv_is_courseview_user ()
{
     $cohorts = cv_get_users_cohorts();
    return sizeof($cohorts);
}



function cv_get_users_cohorts()
{
    $userguid = elgg_get_logged_in_user_guid();
    $searchcriteria = array
        ('type' => 'group',
        'metadata_names' => array('cvcohort'),
        'metadata_values' => array(1),
        'limit' => false,
        'relationship' => 'member',
        'relationship_guid' => $userguid,
    );
    $groupsmember = elgg_get_entities_from_relationship($searchcriteria);
    // var_dump ($groupsmember);
    return $groupsmember;
}

function cv_isprof($user)
{
    //echo "Entering cv_isprof<br>";
    // echo "<br>User: ".($user->name)."--".$user->guid;
    $profgroupguid = elgg_get_plugin_setting('profsgroup', 'courseview');
    //echo "<br>Prof group guid: ". $profgroupguid;
    $profsgroup = get_entity(elgg_get_plugin_setting('profsgroup', 'courseview'));

    // echo "Profsgroup GUID: ". $profsgroup->guid;
    //echo "Is memeber? "+$profsgroup->isMember($user);
    if ($profsgroup == false)
    {
        return false;
    } else
    {
        return $profsgroup->isMember($user);
    }
}

function cv_get_cohorts_by_courseguid($courseguid)
{

    $options = array
        ('type' => 'group',
        'metadata_names' => array('cvcohort'),
        'metadata_values' => array(1),
        'limit' => false,
        'container_guid' => $courseguid,
    );

    $value = elgg_get_entities_from_metadata($options);
    return $value;
}

function cv_is_valid_plugin($arg1)
{
    $validplugins = unserialize(elgg_get_plugin_setting('availableplugins', 'courseview'));
   
    return (array_key_exists($arg1, $validplugins));
}

//function cv_debug_to_console($data)
//{
//
//    if (is_array($data))
//        $output = "<script>console.log( 'Debug Objects: " . implode(',', $data) . "' );</script>";
//    else
//        $output = "<script>console.log( 'Debug Objects: " . $data . "' );</script>";
//
//    echo $output;
//}

//function cv_calc_relationship_string($menuitem)
//{
//
//    //if the $menuitem is of type 'professor', the relationship string is simple 'content'
//    $relationship = 'content';
//    //however, if the $menuitem is not of type 'professor' (ie, of type 'student'), then we need to append the particulart  cohort to 'content'
//    if (get_entity($menu_item_guid)->menutype != 'professor')
//    {
//        $relationship.= $cohort_guid;
//    }
//    return $relationship;
//}

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

function cv_get_content_by_menu_item($filter, $cvmenuguid, $relationship)
{
    $options = array
        ('relationship_guid' => $cvmenuguid,
        'relationship' => $relationship,
        'type' => 'object',
        'subtype' => $filter,
    );
    if ($filter == 'all')
    {
        unset($options['subtype']);
    }

    $content = elgg_get_entities_from_relationship($options);
    return $content;
}

//function courseview_initialize()
//{
//just some learning stuff
//  $courseview_object = elgg_get_entities(array('type' => 'object', 'subtype' => 'courseview'))[0];
//echo elgg_echo ('coursetreexxx'.var_dump($courseview_object->coursetree));
//   ElggSession::offsetSet('currentcourse', $courseview_object->coursetree);
//echo 'courseview_object guid:  ' . $courseview_object->guid;
//   $courseview_object->plugins = array('Hi Rich...It works!', 'blog', 'bookmark');
//   $courseview_object->save;
// echo '######'.$courseview_object->plugins[0];
//if a CourseView Object doesn't exist, this must be the first time the plugin has run.  In that case,
//we build a CourseView Object to track various things that our plugin needs.
//    if (!$courseview_object)
//    {
//Since this is the first time that CourseView has run, we need to create a professor group
//        $courseview_profsgroup = new ElggGroup();
//        $courseview_profsgroup->subtype = 'group';
//        $courseview_profsgroup->title = 'profsgroup';
//        $courseview_profsgroup->name = 'profsgroup'; //just added this...should it be name or title?
//        $courseview_profsgroup->save();
//
//        $courseview_object = new ElggObject();
//        $courseview_object->subtype = "courseview";
//        $courseview_object->access_id = 2;
//        $courseview_object->save();
//        $courseview_object->plugins = array('blog', 'bookmark');
//        $courseview_object->profsgroup = $courseview_profsgroup->guid; //add the profsgroup guid to our courseview object.
//        $courseview_object->save();
//    }
//    return $courseview_object->guid;
//}

function courseview_create_course()
{
//  echo elgg_echo('in courseview_create_course method!');
//    echo  count (elgg_get_entities(array('type' => 'object', 'subtype' => 'blog' )));
//    $abc = elgg_get_entities(array('type' => 'object', 'subtype' => 'blog' ));
//    $postings = elgg_get_entities(array('type' => 'object', 'subtype' => 'blog' ));
//    foreach ($postings as $temp) {
//                echo $temp->title;
//    }

    $abc = count(elgg_get_entities(array('type' => 'object', 'subtype' => 'course')));

    if (abc == 0)
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
    $postings = elgg_get_entities(array('type' => 'object', 'subtype' => 'course'));
    foreach ($postings as $temp)
    {
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
    $returnvalue = 'Currently Registered Plugins:  ' . $cvobject->plugins[0];
//echo $returnvalue;
    return $returnvalue;
}

?>

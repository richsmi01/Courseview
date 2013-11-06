<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$cvcohortname = get_input('cvcohortname');
$cvcourseguid = get_input('cvcourse');  
$cvcourse = get_entity($cvcourseguid);
echo $cohortname;
echo '<br>'.$course->title;

 $cvcohort = new ElggGroup ();
    $cvcohort->title = $cvcohortname;  //use titles only for elgg groups
    $cvcohort->access_id = ACCESS_PUBLIC;
    $cvcohort->owner_guid = elgg_get_logged_in_user_guid();
    $cvcohort->container_guid = $cvcourseguid;
    $cvcohort->save();
    $cvcohort->cvcohort = true;
      echo elgg_echo ("Cohort Created:  ".$cvcohort->guid);
      $cvcohort->save();
?>

<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$userguid =  elgg_get_logged_in_user_guid();
 $cvcohorts = elgg_get_entities_from_metadata(array
        ('type' => 'group',
        'metadata_names' => array('cvcohort'),
        'metadata_values' => array(true),
        'limit' => false,
        'owner_guid' => $userguid,
            )
    );

    foreach ($cvcohorts as $cvcohort)
    {
        $radioname =$cvcohort->title.' - '.$cvcohort->description;
        echo elgg_view ('input/radio',array('internalid' => $cvcohort->guid,'name' => 'cvcohort', 'options'=>array($radioname=> $cvcohort->guid)));
        //echo elgg_echo("<br/>GROUP: " . $group->guid . ', ' . $group->title . ', ' . $group->testAttribute);
    }
?>

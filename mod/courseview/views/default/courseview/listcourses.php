<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$userguid = elgg_get_logged_in_user_guid();

    $cvcourses = elgg_get_entities_from_relationship(array
        ('type' => 'object',
        'metadata_names' => array('cvcourse'), 
        'metadata_values' => array(true),  
        'limit' => false,
        'owner' => $userguid,
            )
    );
    
     foreach ($cvcourses as $cvcourse)
{
    //echo '!!!'.$cvcourse->title.'<br/>';
    $radioname =$cvcourse->title.' - '.$cvcourse->description;
    echo elgg_view ('input/radio',array('internalid' => $cvcourse->guid,'name' => 'cvcourse', 'options'=>array($radioname=> $cvcourse->guid)));
}
?>

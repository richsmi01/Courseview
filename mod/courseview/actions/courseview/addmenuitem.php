<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


$user = elgg_get_logged_in_user_entity();
$modulename = get_input('newmodulename');
$moduletype = get_input('newmoduletype');
$moduleindent = get_input('newmoduleindent');
$moduleorder = get_input('newmoduleorder');
$cvcohortguid =ElggSession::offsetGet('cvcohortguid');
$cvcourseguid = get_entity($cvcohortguid)->container_guid;



//echo $user.'<br/>';
//echo $modulename.'<br/>';
//echo $moduletype.'<br/>';
//echo $moduleindent.'<br/>';
//echo $moduleorder.'<br/>';
//echo $cvcohort.'<br/>';
//echo $cvcourse.'<br/>';
//echo get_entity($cvcohort)->title.'<br/>';
//echo get_entity($cvcourse)->title;

//exit;
$cvmenu = new ElggObject();
$cvmenu->subtype = 'cvmenu';
$cvmenu->name = $modulename;
$cvmenu->owner_guid = $user->guid;
$cvmenu->container_guid = $cvcourse;
$cvmenu->access_id = ACCESS_PUBLIC;
$cvmenu->save();
$cvmenu->menutype = $moduletype;
$cvmenu->meta1 = "closed";
$cvmenu->menuorder = $moduleorder;
$cvmenu->indent = $moduleindent;
var_dump($cvmenu);
//now, connect it to the course

add_entity_relationship($cvcourseguid, 'menu', $cvmenu->guid);
echo 'cvcourse = '.get_entity($cvcourseguid)->title;
echo 'cvmenu = '.$cvmenu->name;

$menu = elgg_get_entities_from_relationship(array
        ( 'relationship_guid' => $cvcourseguid,   
            'relationship' => 'menu',
            'type'=>'object',  
            'subtype' =>'cvmenu',
            'order_by_metadata' =>array ('name'=>'menuorder', 'direction'=>'ASC', 'as'=>'integer'),
            'limit'=>1000,
        )
     );

//$temp = $menu = elgg_get_entities_from_relationship(array
//        ( 'relationship_guid' => $cvcourse,
//            'relationship' => 'menu',
//            'type'=>'object',  
//            'subtype' =>'cvmenu',
//            'order_by_metadata' =>array ('name'=>'menuorder', 'direction'=>'ASC', 'as'=>'integer')
//        )
//     );
//echo 'Menu: '.$temp[7]->name;
//var_dump($temp);
//exit;
?>

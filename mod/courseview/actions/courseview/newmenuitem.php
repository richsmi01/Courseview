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
$cvcourse = get_entity(get_input('cvcohort'))->owner_guid;

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
//now, connect it to the course
add_entity_relationship($cvcourse, "menu", $cvmenu->guid);
?>

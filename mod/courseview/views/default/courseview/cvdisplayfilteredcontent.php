<?php

//echo 'cvdisplayfilteredcontent<br>';
$filter = get_input('filter', 'all'); //the currently selected dropdown list  item  
$cvmenuguid = ElggSession::offsetGet('cvmenuguid');
$cvcohortguid = ElggSession::offsetGet('cvcohortguid');

$relationship = 'content' . $cvcohortguid;
//echo elgg_echo("Relationship name:  " . $relationship);
//echo elgg_echo("Relationship GUID:  " . $cvmenuguid);
//
$content = cv_get_content_by_menu_item($filter, $cvmenuguid, $relationship);
foreach ($content as $menuitem)
{
//::TODO:  Think about replacing the whole "professor" with "professor"  That way, we have three module types:  Folder, Professor, and Student
    echo elgg_echo(elgg_view_entity($menuitem, array(full_view => false)));
}
?>

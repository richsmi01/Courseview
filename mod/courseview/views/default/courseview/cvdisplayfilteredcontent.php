<?php


$filter = get_input('filter', 'all'); //the currently selected dropdown list  item  
$cvmenuguid = ElggSession::offsetGet('cvmenuguid');
$cvcohortguid = ElggSession::offsetGet('cvcohortguid');
$cohortguid=get_input ('cohortfilter',$cvcohortguid);
//echo '<br>in cvdisplayfilteredcontent <br>cohort filter:  '.$cohortguid.'<br>';
$cohortname = get_entity($cohortguid)->title;
//echo "dropdown info: ".$cohortname;


//$relationship = 'content' . $cvcohortguid;
$relationship = 'content' . $cohortguid;

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

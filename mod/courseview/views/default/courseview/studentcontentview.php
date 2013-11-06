<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$filter = get_input('filter', 'all'); //the currently selected dropdown list  item  
//
//pull down the create strings for the various plugins from the settings page:
$createString = unserialize(elgg_get_plugin_setting('plugincreatestring', 'courseview'));

//build the string used for the create content button...need to substitute real value for the placeholders in the setup page
$createbutton = $createString[$filter];      //elgg_get_plugin_setting('blogadd', 'courseview');
$createbutton = str_replace('{url}', elgg_get_site_url(), $createbutton);
$createbutton = str_replace('{user_guid}', elgg_get_logged_in_user_guid(), $createbutton);

//create and populate a pulldown menu using the list of authorized plugins from the setup screen   
$availableplugins = unserialize(elgg_get_plugin_setting('availableplugins', 'courseview'));  //pull down list of authorized plugin types
$availableplugins['all'] = 'All';  //add the ability for the student to select all content

//this is just hardcoded for now but will eventually pull all cohorts that this user belongs to.
$availablecohorts =array();
$availablecohorts ['test'] = 'Test Cohort 001';
$availablecohorts ['test2'] = 'Test Cohort 002';

echo '<form method="get" action="' . current_page_url() . '">List content in: ';
echo elgg_view('input/dropdown', array(
    'name' => 'filter',
    'value' => $filter,
    'options_values' => $availablecohorts));
echo  ' and filter by:  ';
echo elgg_view('input/dropdown', array(
    'name' => 'filter',
    'value' => $filter,
    'options_values' => $availableplugins));
echo elgg_view('input/submit', array(
    'value' => elgg_echo('Go!')));
if ($createbutton != '')  //if there is a currently filtered plugin type, give the user the option to create content
{
    echo elgg_view('output/url', array(
        'text' => 'Create a ' . $filter . ' posting',
        'href' => $createbutton));
}
echo '</form><br/>';

$relationship = 'content' . $cvcohortguid;
//echo elgg_echo("Relationship name:  " . $relationship);
//echo elgg_echo("Relationship GUID:  " . $cvmenuguid);
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

foreach ($content as $temp)
{

//::TODO:  Think about replacing the whole "bundle" with "professor"  That way, we have three module types:  Folder, Professor, and Student
    echo elgg_echo(elgg_view_entity($temp, array(full_view => false)));
}
?>

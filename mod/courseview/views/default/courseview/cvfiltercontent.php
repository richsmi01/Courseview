<?php

/*
 * This file builds the dropdown filter used to filter content by cohort and content type
 */
//echo 'cvcoursecontent<br>';
$courseguid= ElggSession::offsetGet('cvcourseguid');
$menuguid= ElggSession::offsetGet('cvmenuguid');
$filter = get_input('filter', 'all'); //the currently selected dropdown list  item  
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

$availablecohorts = cv_get_cohorts_by_courseguid($courseguid);

$dropdownlist= array();
foreach ($availablecohorts as $availablecohort)
{
    $dropdownlist [$availablecohort->guid] = $availablecohort->title;
}

echo '<form method="get" action="' . current_page_url() . '">';
if (get_entity($menuguid)->menutype=='student')
{
    echo' List content in: ';
    echo elgg_view('input/dropdown', array(
    'name' => 'filter',
    'value' => $filter,
    'options_values' => $dropdownlist));
}
echo ' filter by:  ';
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
?>

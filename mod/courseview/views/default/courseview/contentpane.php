<?php

/*
 * Rich Test stuff
 */
// ::TODO:  I need to start packaging all output into an elgg view and then calling the view properly instead of just using elgg_echo
//echo elgg_view('output/url', array("text" => "Manage Courses", "href" => "courseview/thiswillmanagecourses", 'class' => 'elgg-button elgg-button-action'));
//add button to create a new object of correct subtype:
//list all objects that meet subtype and tag criteria


$coursetreeindex = ElggSession::offsetGet('coursetreeindex'); //could just pull this from the url...is this easier?
$currentcourse = ElggSession::offsetGet('currentcourse'); //get current course
$currentmenuitem = $currentcourse[$coursetreeindex]; //get current menu item
$filter = ElggSession::offsetGet('currentcourse')[$coursetreeindex][filter]; //pull the filter tags out of the current menu item and assign to $filter

//Here, I'm figuring out what the parent module is for the currently selected tree element--don't really need to do this yet, I'm just trying stuff
for ($count = $coursetreeindex; $count >= 0; $count--)
{
    if ($currentcourse[$count]['content'] === 'module' || $currentcourse[$count]['content'] === 'moduleOpen')
    {
        echo elgg_echo('Parent Module:  ' . $currentcourse[$count]['label']);
        break;
    }
}

//If the contenttype attribute of the curentmenuitem is set to bundle, we need get a list of all types on entities that contain the
//specified by the tags that match the subtype attribute (which will actually contain a guid) of the $currentmenuitem
if ($currentmenuitem['contenttype'] === 'bundle')
{
    $searchcriteria = array(
        type => 'object', 
        metadata_name_value_pairs => array('name' => 'tags', 'value' => $currentmenuitem['subtype']),
    );
}
//else, we are dealing with a standard elgg plugin type and we set the search criteria by subtype
else
{
    $subtype = $currentmenuitem['subtype'];
    $searchcriteria = array(
        'type' => 'object',
        'subtype' => $subtype
            //metadata_name_value_pairs =>array('name'=>'tags', 'value'=>'cohort guid', 
    );
}
$entities = elgg_get_entities_from_metadata($searchcriteria);

//now we search through all returned entities, finding the ones that satisfy all of our tag criteria..
//::TODO: 'm sure there must be a more efficient way to do this -- Ask Matt about it.
for ($numentities = 0; $numentities < sizeof($entities); $numentities++)
{
    $match = TRUE;  //we assume that this entity is a good one to display until it proves otherwise

    for ($count = 0; $count < sizeof($filter); $count++)
    {
        if ($filter[count] === '')
        {
            continue;
        }
        $tags = $entities[$numentities]->tags;
        if (!(in_array($filter[$count], $tags) || $tags === $filter[$count]))
        {
            $match = FALSE;  //Oops, one of the required tags was not present in this element so we fail it and do not display
            break;
        }
    }
    if ($match)  //if the entity survived our inspection of tags, go ahead and display it
    {
        echo elgg_echo(elgg_view_entity($entities[$numentities], array(full_view => false)));
    } 
}

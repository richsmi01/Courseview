<?php

/*
 * Rich Test stuff
 */
//TODO : I need to start packaging all output into an elgg view and then calling the view properly instead of just using elgg_echo
//echo elgg_view('output/url', array("text" => "Manage Courses", "href" => "courseview/thiswillmanagecourses", 'class' => 'elgg-button elgg-button-action'));
//add button to create a new object of correct subtype:
//list all objects that meet subtype and tag criteria


$coursetreeindex = ElggSession::offsetGet('coursetreeindex'); //could just pull this from the url...is this easier?
$currentcourse = ElggSession::offsetGet('currentcourse'); //get current course
$currentmenuitem = $currentcourse[$coursetreeindex]; //get current menu item
$filter = ElggSession::offsetGet('currentcourse')[$coursetreeindex][filter]; //pull the filter tags out of the current menu item and assign to $filter
//Here, I'm figuring out what the parent module is for the currently selected tree element
for ($count = $coursetreeindex; $count >= 0; $count--)
{
    if ($currentcourse[$count]['content'] === 'module' || $currentcourse[$count]['content'] === 'moduleOpen')
    {
        echo elgg_echo('Parent Module:  ' . $currentcourse[$count]['label']);
        break;
    }
}

//If the contenttype attribute of the curentmenuitem is set to bundle, we need get a list of all types on entities that contaion the
//specified by the tags that match the subtype attribute (which will actually contain a guid) of the $currentmenuitem
if ($currentmenuitem['contenttype'] === 'bundle')
{

    $searchcriteria = array(
        type => 'object', //I just removed the quotes around type...I think this ok
        metadata_name_value_pairs => array('name' => 'tags', 'value' => $currentmenuitem['subtype']),
    );
}
//else, we are dealing with a standar elgg plugin type and we set the search criteria by subtype
else
{
    $type = $currentmenuitem['subtype'];
    echo elgg_echo('subtype' . $type);
    $searchcriteria = array(
        'type' => 'object',
        'subtype' => $type
            //metadata_name_value_pairs =>array('name'=>'tags', 'value'=>'cohort guid', 
    );
}
$entities = elgg_get_entities_from_metadata($searchcriteria);

for ($numentities = 0; $numentities < sizeof($entities); $numentities++)
{
    $match = TRUE;

    //echo elgg_echo(elgg_view_entity($entities[$numentities], array(full_view => false)));
    for ($count = 0; $count < sizeof($filter); $count++)
    {
        if ($filter[count] === '')
        {
            continue;
        }
        $tags = $entities[$numentities]->tags;
        // echo elgg_echo('comparing '.$filter[$count]);
        if (!(in_array($filter[$count], $tags) || $tags === $filter[$count]))
        {
            //echo elgg_echo('bad</br>');
            $match = FALSE;
            break;
        }
    }
    if ($match)
    {
        echo elgg_echo(elgg_view_entity($entities[$numentities], array(full_view => false)));
        // echo elgg_echo ('accepted<br>');
    } else
    {
        //echo elgg_echo ('rejected<br>');
    }
}

<?php

/*
 * Rich Test stuff
 */
// ::TODO:  I need to start packaging all output into an elgg view and then calling the view properly instead of just using elgg_echo
//echo elgg_view('output/url', array("text" => "Manage Courses", "href" => "courseview/thiswillmanagecourses", 'class' => 'elgg-button elgg-button-action'));
//add button to create a new object of correct subtype:
//list all objects that meet subtype and tag criteria
//How do I best pass the cohort and menu item between pages?
$user = elgg_get_logged_in_user_entity();
if ((cv_isprof($user)))
{
    echo elgg_echo('
    <div id ="editbox"> aaa           
           <input type ="checkbox" id = "editcoursecheckbox"/><label>Edit Course?</label></br></br>
            <div  id ="editcourse">
                    Edit stuff will go in here
                   <br/>
                    <br/>
                    <select>
                            <option value="Add a folder">addFolder</option>
                            <option value="Add a student Module">addStudent</option>
                            <option value="Add Professor Module">addProfessor</option>
                     </select>
               </div>
    </div>');
}

set_input("rich1","rich1");
$cvmenuguid = get_input('cvmenuguid');
$cvcohortguid = get_input('cvcohortguid');
$menuitem = get_entity($cvmenuguid);
$menutype = $menuitem->menutype;
echo '#####'.get_input('createdobject');
echo ('CVMENUGUID:  '.$cvmenuguid);
//just some stuff for changing the objects for debugging...
//add_entity_relationship($cvmenuguid, 'content608', 54); 
//$menuitem->description = "Module 1 information is placed in this description field";
//$menuitem->save();
//get the type of menuitem (folder, bundle, student) and display the content accordingly
switch ($menutype)
{
    case "folder":
        echo elgg_echo("FOLDER");
        echo elgg_echo("<br>" . $menuitem->name);
        echo elgg_echo("<br>Description: " . $menuitem->description);        
        break;
    
   

    case "bundle":
        echo elgg_echo("BUNDLE");  //::TODO:  Move all of this stuff into methods to clean up the code
        $content = elgg_get_entities_from_relationship(array
            ('relationship_guid' => $cvmenuguid,
            'relationship' => 'content',
                )
        );
        foreach ($content as $temp)
        {
            //echo elgg_echo('<br/>Content:  '.$temp->title);
            if (cv_isprof($user))
            {
                echo elgg_echo('<div class="editcourse"><a class ="uparrowcontainer" href="http://sheridancollege.ca"><div class="uparrow" ></div></a>');
                echo elgg_echo('<a class ="downarrowcontainer" href="http://sheridancollege.ca"><div class="downarrow"></div></a>');
                echo elgg_echo('</div>');
            }
            echo elgg_echo(elgg_view_entity($temp, array(full_view => false)));
        }
        break;


    case "student":  //::TODO:  Same thing...move refactor all of this into constituent methods for code clarity...
      
        $createbutton = elgg_get_plugin_setting('blogadd', 'courseview');
        echo '@@@'.elgg_get_plugin_setting('testpluginsetting','courseview');
        
        $filter = get_input('filter');
        
        echo '<form method="get" action="'.current_page_url().'">';
        echo elgg_view('input/dropdown', array(
            'name' => 'filter',
            'value' => $filter,  //could add second paramater with default --> maybe all
            'options_values' => array(
                'all'=>'All',
                'blog' => 'Blog',
                'bookmark' => 'Bookmark',
                'file' => 'File')
                )
        );
        echo elgg_view('input/submit', array (
            'value'=>elgg_echo('submit')
        ));
        $url = 'http://localhost/elgg/blog/add/'.elgg_get_logged_in_user_entity()->guid;
         echo elgg_view('output/url', array (
            'text'=>'Create a '.$filter,
             'href'=>$createbutton
        ));
        echo '</form>';
        
//        echo elgg_echo("STUDENT");//this is building a little dropdown menu based on the plugins pulled from the cvcourseview object
//        echo elgg_echo('<br/>FILTER BY:  <select>');
//        foreach ($plugins as $plugin)
//        {
//            echo elgg_echo('<option value = "' . $plugin . '">' . $plugin . "</option>");
//        }
//        echo elgg_echo('</select>  ');
//        echo elgg_view('output/url', array("text" => "Go!", "href" => "/0", 'class' => 'elgg-button elgg-button-action'));
//        echo elgg_echo('-------Add a: ');
//        echo elgg_view('output/url', array("text" => "blog", "href" => "/0", 'class' => 'elgg-button elgg-button-action'));
//        echo elgg_echo("<br/><br/>");

        $relationship = 'content' . $cvcohortguid;
        echo elgg_echo ("Relationship name:  ".$relationship);
        echo elgg_echo ("Relationship GUID:  ".$cvmenuguid);
        $options =array
            ('relationship_guid' => $cvmenuguid,
            'relationship' => $relationship,
            'type'=>'object',
            'subtype' => $filter,
                );
                if ($filter=='all')
                {
                    unset($options['subtype']);
                }
        $content = elgg_get_entities_from_relationship($options);

        foreach ($content as $temp)
        {
//This code will presumabley only need to run when in bundle mode...think this one through some more.
//::TODO:  Think about replacing the whole "bundle" with "professor"  That way, we have three module types:  Folder, Professor, and Student
//            if (cv_isprof($user))
//            {
//                echo elgg_echo('<div class="editcourse"><a class ="uparrowcontainer" href="http://sheridancollege.ca"><div class="uparrow" ></div></a>');
//                echo elgg_echo('<a class ="downarrowcontainer" href="http://sheridancollege.ca"><div class="downarrow"></div></a>');
//                echo elgg_echo('</div>');
//            }
            echo elgg_echo(elgg_view_entity($temp, array(full_view => false)));
        }
        break;
    default:
        echo elgg_echo("WELCME TO");
        break;
}
 
 
 
 //$cvmenuguid = $page[2];
 //echo elgg_echo ("<br/>cvmenuguid:  ".$cvmenuguid.'</br>');
 //find all cvmenu items with a menu relationship with $comp697
    
    
    
    //echo elgg_echo(var_dump ($menu));
   

//$coursetreeindex = ElggSession::offsetGet('coursetreeindex'); //could just pull this from the url...is this easier?
//$currentcourse = ElggSession::offsetGet('currentcourse'); //get current course
//$currentmenuitem = $currentcourse[$coursetreeindex]; //get current menu item
//$filter = ElggSession::offsetGet('currentcourse')[$coursetreeindex][filter]; //pull the filter tags out of the current menu item and assign to $filter

////Here, I'm figuring out what the parent module is for the currently selected tree element--don't really need to do this yet, I'm just trying stuff
//for ($count = $coursetreeindex; $count >= 0; $count--)
//{
//    if ($currentcourse[$count]['content'] === 'module' || $currentcourse[$count]['content'] === 'moduleOpen')
//    {
//        echo elgg_echo('Parent Module:  ' . $currentcourse[$count]['label']);
//        break;
//    }
//}

//If the contenttype attribute of the curentmenuitem is set to bundle, we need get a list of all types on entities that contain the
//specified by the tags that match the subtype attribute (which will actually contain a guid) of the $currentmenuitem
//if ($currentmenuitem['contenttype'] === 'bundle')
//{
//    $searchcriteria = array(
//        type => 'object', 
//        metadata_name_value_pairs => array('name' => 'tags', 'value' => $currentmenuitem['subtype']),
//    );
//}
////else, we are dealing with a standard elgg plugin type and we set the search criteria by subtype
//else
//{
//    $subtype = $currentmenuitem['subtype'];
//    $searchcriteria = array(
//        'type' => 'object',
//        'subtype' => $subtype
//            //metadata_name_value_pairs =>array('name'=>'tags', 'value'=>'cohort guid', 
//    );
//}
//$entities = elgg_get_entities_from_metadata($searchcriteria);
//
////now we search through all returned entities, finding the ones that satisfy all of our tag criteria..
////::TODO: 'm sure there must be a more efficient way to do this -- Ask Matt about it.
//for ($numentities = 0; $numentities < sizeof($entities); $numentities++)
//{
//    $match = TRUE;  //we assume that this entity is a good one to display until it proves otherwise
//
//    for ($count = 0; $count < sizeof($filter); $count++)
//    {
//        if ($filter[count] === '')
//        {
//            continue;
//        }
//        $tags = $entities[$numentities]->tags;
//        if (!(in_array($filter[$count], $tags) || $tags === $filter[$count]))
//        {
//            $match = FALSE;  //Oops, one of the required tags was not present in this element so we fail it and do not display
//            break;
//        }
//    }
//    if ($match)  //if the entity survived our inspection of tags, go ahead and display it
//    {
//        echo elgg_echo(elgg_view_entity($entities[$numentities], array(full_view => false)));
//    } 
//}

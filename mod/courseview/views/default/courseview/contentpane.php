<?php

/*
 * Rich Test stuff
 */
// ::TODO:  I need to start packaging all output into an elgg view and then calling the view properly instead of just using elgg_echo
//echo elgg_view('output/url', array("text" => "Manage Courses", "href" => "courseview/thiswillmanagecourses", 'class' => 'elgg-button elgg-button-action'));

$user = elgg_get_logged_in_user_entity();
echo 'User: '.$user->name.'<br/>';

$cvcohortguid=ElggSession::offsetGet('cvcohortguid');
$cvmenuguid = ElggSession::offsetGet('cvmenuguid');
//$cvmenuguid = get_input('cvmenuguid');  //the guid of the currently selected menu item
$menuitem = get_entity($cvmenuguid);  //get the menuitem object
//$cvcohortguid = get_input('cvcohortguid');  //the guid of the current cohort
$menutype = $menuitem->menutype;  //there are three types of menu items:  folder, bundle, and student

if ((cv_isprof($user)))
{
    $moduletitle = $menuitem->name;
    echo ' <div id ="editbox"> aaa           
            <input type ="checkbox" id = "editcoursecheckbox"/><label>Edit Course?</label></br></br>';
             echo '<div  id ="editcourse">';
//              echo elgg_view('input/text', array(
//                    'name' => 'params[modulename]',
//                     'value'=>$moduletitle));
//                    echo elgg_view('input/submit', array(
//                    'value' => elgg_echo('Update')));
                    
             echo elgg_view_form('addmenuitem');
            echo'</div>';
    echo '</div>';
}


switch ($menutype)
{
    case "folder":
        echo elgg_echo("FOLDER");
        echo elgg_echo("<br>" . $menuitem->name);
        echo elgg_echo("<br>Description: " . $menuitem->description);
        break;

    case "bundle":
       // echo elgg_echo("BUNDLE");  //::TODO:  Move all of this stuff into methods to clean up the code
            //add_entity_relationship($cvmenuguid, "content", 690);
            //add_entity_relationship($cvmenuguid, "content", 689);
        $content = elgg_get_entities_from_relationship(array(
            'relationship_guid' => $cvmenuguid,
            'relationship' => 'content'));
        foreach ($content as $temp)
        {
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
        $filter = get_input('filter','all'); //the currently selected dropdown list    
        //pull down the create strings for the various plugins from the settings page:
        $createString = unserialize(elgg_get_plugin_setting('plugincreatestring', 'courseview'));
        //build the string used for the create content button...need to substitute real value for the placeholders in the setup page
        $createbutton = $createString[$filter];      //elgg_get_plugin_setting('blogadd', 'courseview');
        $createbutton = str_replace('{url}', elgg_get_site_url(), $createbutton);
        $createbutton = str_replace('{user_guid}', elgg_get_logged_in_user_guid(), $createbutton);
        //echo 'Create Button: '.$createbutton.'<br/>';
        //create and populate a pulldown menu using the list of authorized plugins from the setup screen   
        $availableplugins = unserialize(elgg_get_plugin_setting('availableplugins', 'courseview'));  //pull down list of authorized plugin types
        $availableplugins['all'] = 'All';  //add the ability for the student to select all content
        echo '<form method="get" action="' . current_page_url() . '">Filter by:';
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
        break;
    default:
        echo elgg_echo("WELCME TO");
        break;
}
 
 
 
 

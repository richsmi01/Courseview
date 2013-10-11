<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


echo elgg_echo("Returning Test Suite to Zero Point<br/>");

//get the currently logged in user entity
$user = elgg_get_logged_in_user_entity();
$aiko = get_user_by_username("Aiko");
$lori = get_user_by_username("Lori");
$rich = get_user_by_username("Rich");
//
//$menuitems = elgg_get_entities(array
//        ('type' => 'object',
//        'subtype' => 'cvmenu',
//        'limit' => false,
//        'owner_guid'=> $user->guid
//            )
//     );
//    //echo elgg_echo (var_dump($menuitems));
//    echo elgg_echo ("<br/>Deleting all cvmenu items<br/>");
//    foreach ($menuitems as $temp)
//    {
//        echo elgg_echo('Deleting  cvmenu item: ' . $temp->name .'SUBTYPE: '.$temp->subtype. ' GUID: '.$temp->guid . '<br/>');
//      $temp->delete();
//    }
//
////first, remove all cvcohort objects so that we can start again
//$cvcohort = elgg_get_entities_from_metadata(array
//    ('type' => 'group',
//    'metadata_names' => array('testAttribute'),
//    'metadata_values' => array('123'),
//    'limit' => false,
//    'owner_guid' => $user->guid
//        )
//);
//
//foreach ($cvcohort as $temp)
//{
//    echo elgg_echo('Deleting  CourseName: ' . $temp->name . 'Title: ' . $temp->title . 'GUID: ' . $temp->guid . '<br/>');
//    $temp->delete();
//}
    
//First, we create a cvcourse:
//course 1 - COMP697
    $comp697 = new ElggObject();
    $comp697->title = 'Comp 697';
    $comp697->access_id = ACCESS_PUBLIC;
    $comp697->owner_guid = elgg_get_logged_in_user_guid();
    $comp697->container_guid = elgg_get_logged_in_user_guid();
    $comp697->save();
    $comp697->cvcourse = true;
    echo elgg_echo ("Comp697 cvcourse GUID:  ".$comp697->guid);
    
   //Next, we'll create a cvcohort that is owned by the professor but has a container of the cvcourse (in this case COMP 697)
    
    $cvcohort697 = new ElggGroup ();
    $cvcohort697->title = 'Comp 697 Cohort 1';
    $cvcohort697->access_id = ACCESS_PUBLIC;
    $cvcohort697->owner_guid = elgg_get_logged_in_user_guid();
    $cvcohort697->container_guid = $comp697->guid;
    $cvcohort697->save();
    $cvcohort697->cvcohort = true;
      echo elgg_echo ("Comp 697 Cohort 1 GUID:  ".$cvcohort697->guid);

    
//now we're adding some members to the cvcohort
    $cvcohort697->join($user);
    $cvcohort697->join($aiko);
    $cvcohort697->join($lori);
    
    
//    ElggSession::offsetSet('currentcourse', $comp697->guid);
//     echo elgg_echo('<br/>currently selected course is '.ElggSession::offsetGet('currentcourse').'<br/>');
 
   
//create the cvmenu objects that will make up the menu for this course
    $cvmenu = new ElggObject();
    $cvmenu->subtype = 'cvmenu';
    $cvmenu->name = 'Module 1';
    $cvmenu->owner_guid = $user->guid;
    $cvmenu->container_guid = $comp697->guid;
    $cvmenu->access_id = ACCESS_PUBLIC;
    $cvmenu->save();
    $cvmenu->menutype = "folder";
    $cvmenu->meta1 = "closed";
    $cvmenu->menuorder = 1;
    $cvmenu->indent="";
//now, connect it to the course
    add_entity_relationship($comp697->guid, "menu", $cvmenu->guid);


    $cvmenu2 = new ElggObject();
    $cvmenu2->subtype = "cvmenu";
    $cvmenu2->name = "Professor Rant";
    $cvmenu2->owner_guid = $user->guid;
    $cvmenu2->container_guid = $comp697->guid;
    $cvmenu2->access_id = ACCESS_PUBLIC;
    $cvmenu2->save();
    $cvmenu2->menutype = "bundle";
    $cvmenu2->meta1 = "";
    $cvmenu2->menuorder = 2;
    $cvmenu2->indent="+";
    add_entity_relationship($comp697->guid, "menu", $cvmenu2->guid);
 
     //add a couple of blog postings through a relationship to the above cvmenu
    add_entity_relationship($cvmenu2->guid, "content", 164);  //added a blog post to this menu item
    add_entity_relationship($cvmenu2->guid, "content", 64);  //added a blog post to this menu item
    

    $cvmenu3 = new ElggObject();
    $cvmenu3->subtype = "cvmenu";
    $cvmenu3->name = "Student Content";
    $cvmenu3->owner_guid = $user->guid;
    $cvmenu3->container_guid = $comp697->guid;
    $cvmenu3->access_id = ACCESS_PUBLIC;
    $cvmenu3->save();
    $cvmenu3->menutype = "student";
    $cvmenu3->meta1 = "";
    $cvmenu3->menuorder = 3;
    $cvmenu3->indent="";
    add_entity_relationship($comp697->guid, 'menu', $cvmenu3->guid);
    
     $cvmenu4 = new ElggObject();
    $cvmenu4->subtype = "cvmenu";
    $cvmenu4->name = "Student Content";
    $cvmenu4->owner_guid = $user->guid;
    $cvmenu4->container_guid = $comp697->guid;
    $cvmenu4->access_id = ACCESS_PUBLIC;
    $cvmenu4->save();
    $cvmenu4->menutype = "folder";
    $cvmenu4->meta1 = "";
    $cvmenu4->menuorder = 4;
    $cvmenu4->indent="-";
    add_entity_relationship($comp697->guid, 'menu', $cvmenu4->guid);
    
     $cvmenu5 = new ElggObject();
    $cvmenu5->subtype = "cvmenu";
    $cvmenu5->name = "Student Content";
    $cvmenu5->owner_guid = $user->guid;
    $cvmenu5->container_guid = $comp697->guid;
    $cvmenu5->access_id = ACCESS_PUBLIC;
    $cvmenu5->save();
    $cvmenu5->menutype = "student";
    $cvmenu5->meta1 = "";
    $cvmenu5->menuorder = 5;
    $cvmenu5->indent="+";
    add_entity_relationship($comp697->guid, 'menu', $cvmenu5->guid);


//    //find all cvmenu items with a menu relationship with $comp697
//    $menu = elgg_get_entities_from_relationship(array
//        ( 'relationship_guid' => $comp697->guid,
//            'relationship' => 'menu',
//        )
//     );
//    
//    //how can I sort these by menuorder???????
//    
//    //echo elgg_echo(var_dump ($menu));
//    foreach ($menu as $temp)
//{
//    echo elgg_echo('<br/>Getting menu item:  '.$temp->name);
//}
    
//course 2 - COMP698
//    $comp698 = new ElggGroup();
//    $comp698->title = 'comp698';
//    $comp698->access_id = ACCESS_PUBLIC;
//    $comp698->owner_guid = elgg_get_logged_in_user_guid();
//    $comp698->container_guid = elgg_get_logged_in_user_guid();
//    $comp698->save();
//    $comp698->testAttribute = "123";
//    $coursegroup->cvcourse = true;
////now we're having the currently logged user join the group
//    $comp698->join($user);
//    $comp698->join($aiko);
//
////course 3 - COMP699
//    $comp699 = new ElggGroup();
//    $comp699->title = 'comp699';
//    $comp699->access_id = ACCESS_PUBLIC;
//    $comp699->owner_guid = elgg_get_logged_in_user_guid();
//    $comp699->container_guid = elgg_get_logged_in_user_guid();
//    $comp699->save();
//    $comp699->testAttribute = "123";
//    $comp699->cvcourse = true;
////now we're having the currently logged user join the group
//    $comp699->join($user);
//    $comp699->join($lori);
//
//
////Here we are listing all groups that are owned by the currently logged in user that have the testAttribute=123 set
//
//    $groupsowned = elgg_get_entities_from_metadata(array
//        ('type' => 'group',
//        'metadata_names' => array('testAttribute'),
//        'metadata_values' => array('123'),
//        'limit' => false,
//        'owner_guid' => $user->guid
//            )
//    );
//    echo elgg_echo('<br/>Groups owned by Professor: <br/>');
//    foreach ($groupsowned as $group)
//    {
//        echo elgg_echo("<br/>GROUP: " . $group->guid . ', ' . $group->title . ', ' . $group->testAttribute);
//    }
////And here we are listing all groups that the currently logged in user belongs to.
//    $groupsmember = elgg_get_entities_from_relationship(array
//        ('type' => 'group',
//        'metadata_names' => array('testAttribute'),
//        'metadata_values' => array('123'),
//        'limit' => false,
//        'relationship' => 'member',
//        'relationship_guid' => $user->guid
//            )
//    );
//    
//    echo elgg_echo('<br/><br/>Groups owned that professor belongs to: <br/>');
//    $somegroup = new ElggGroup;
//    foreach ($groupsmember as $group)
//    {
//        echo elgg_echo("<br/>GROUP: " . $group->guid . ', ' . $group->title . ', ' . $group->testAttribute);
//        $somegroup = $group;
//    }


//Here, I'd like to create an entity of subtype cvtreeitem
//$cvtreeitem = new ElggObject();
//$cvtreeitem ->type ='object';
//$cvtreeitem ->title ='comp697';
//$cvtreeitem->subtype='cvtreeitem';
//$cvtreeitem ->name ='comp697';
//$cvtreeitem ->access_id = ACCESS_PUBLIC;
//$cvtreeitem->owner_guid = elgg_get_logged_in_user_guid();
//$cvtreeitem->container_guid = $somegroup->guid;
//$cvtreeitem->save();
//$cvtreeitem->testAttribute = "123"; 
//list all cvtreeitems that belong to somegroup and meet the testAttribute criteria
//    $treeitems = elgg_get_entities_from_metadata(array
//        ('type' => 'object',
//        'subtype' => 'cvtreeitem',
//        'contaier_guid' => $somegroup,
//        'limit' => false,
//            //some sort of ordering here
//            ));
//
//    echo elgg_echo("<br/>Testing pulling out all of the tree entities...<br/>");
//    foreach ($treeitems as $treeitem)
//    {
//        echo elgg_echo("<br/>cvtreeitem:  " . $treeitem->guid . $treeitem->name . $treeitem->title . $treeitem->testAttribute);
//        $somegroup = $group;
//    }
//
////add_entity_relationship(268, "testrelationshiptype", 267);
//
//    $relationshipTest = elgg_get_entities_from_relationship(array('relationship' => 'testrelationshiptype', 'relationship_guid' => '268'));
//
//    foreach ($relationshipTest as $relationship)
//    {
//        echo elgg_echo('<br/>A relationship exists between guid 268 and ' . $relationship->guid);
//    }
?>
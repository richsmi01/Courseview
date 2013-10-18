<?php

$page = get_input('rich');
//echo elgg_echo (var_dump($page));
//$cvcohort=$page[1];
$cvcohort=ElggSession::offsetget('cohort');
echo elgg_echo ("Cohort: "+$cvcohort);
//This pulls all menu entitities that have a relationship with this course...
$menu = elgg_get_entities_from_relationship(array
        ( 'relationship_guid' => get_entity(599)->guid,
            'relationship' => 'menu',
            'type'=>'object',  
            'subtype' =>'cvmenu',
            'order_by_metadata' =>array ('name'=>'menuorder', 'direction'=>'ASC', 'as'=>'integer')
        )
     );
//Next, I have to sort the entities by the menuorder attribute so that I can display the course links in the correct order
//TODO::Have no idea why this works!  Ask Matt what I've done
//$menu = array();
//foreach ($unsortedmenu as $key =>$row)
//{
//    $menu[$key]=$row['menuorder'];
//}
//array_multisort($menu, SORT_ASC, $unsortedmenu);
//$menu=$unsortedmenu;

//Here I am building the html of the treeview control and adding the correct css classes so that my css
//can turn it into a tree that can be manipulated by the user 
echo elgg_echo ('<div class ="css-treeview">');
  foreach ($menu as $temp)
{
    //If this menu item should be indented from the previous one, add a <ul> tag to start a new unordered list
    if ($temp->indent==='+')
    {
        echo elgg_echo('
            <ul>
            ');
    }
    //if this menu item should be outdented, close off our unordered list and list item
    if ($temp->indent==='-')
    {
        echo elgg_echo('
            </ul>
            </li>
            ');
    }
    //if the menu item is a folder type, add a checkbox which the css will massage into the collapsing tree
    if ($temp->menutype=="folder")
    {
         echo elgg_echo("<ul>
           <li><input type ='checkbox'/><label><a href='".elgg_get_site_url()."courseview/contentpane/".$cvcohort."/".$temp->guid."'> ".$temp->name.$temp->menuorder."!!!</a></label>");
    }
    //otherwise, let's just create a link to the contentpane and pass the guid of the menu object...the css class indent is also added here
 else
    {
        echo elgg_echo("<li><a class = 'indent' href ='".  elgg_get_site_url()."courseview/contentpane/".$cvcohort."/".$temp->guid."' >".$temp->name.$temp->menuorder."</a></li>");
    }
}     
echo elgg_echo ('</div>')  ;  
 
?>

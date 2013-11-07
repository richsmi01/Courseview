<?php

//$page = get_input('rich');
$cvcohortguid=ElggSession::offsetGet('cvcohortguid');
$cvmenuguid = ElggSession::offsetGet('cvmenuguid');

if (isset($cvcohortguid))  //if the courseview doesn't yet have a cohort, then don't display the menu...this should change if I move to the multiple cohort treeview
{

//This pulls all menu entitities that have a relationship with this course...
$menu = elgg_get_entities_from_relationship(array
        ( 'relationship_guid' => get_entity($cvcohortguid)->container_guid,   
            'relationship' => 'menu',
            'type'=>'object',  
            'subtype' =>'cvmenu',
            'order_by_metadata' =>array ('name'=>'menuorder', 'direction'=>'ASC', 'as'=>'integer'),
            'limit'=>1000,
        )
     );

//Here we are building the html of the treeview control and adding the correct css classes so that my css
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
    $name = '';
    if ($temp->guid==$cvmenuguid)
    {
        $name="* ";  //currently I'm just adding a * to the active module but eventually I should use it to force the active module folder to default to open
    }
   $name = $name.$temp->name;
    $name .= '--'.$temp->menuorder;
    if ($temp->menutype=="folder")
    {
         echo elgg_echo("<ul>
           <li><input type ='checkbox'/><label><a href='".elgg_get_site_url()."courseview/contentpane/".$cvcohortguid."/".$temp->guid."'> ".$name."</a></label>");
    }
    //otherwise, let's just create a link to the contentpane and pass the guid of the menu object...the css class indent is also added here
 else
    {
        echo elgg_echo("<li><a class = 'indent' href ='".  elgg_get_site_url()."courseview/contentpane/".$cvcohortguid."/".$temp->guid."' >".$name."</a></li>");
    }
}     
echo elgg_echo ('</div>')  ;  
}
?>

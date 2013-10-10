<?php

/*
 *   ::TODO:  This is a sucky way to do the CSS-- work through Matt's css tutorial plugin and fix this
 */





//$coursetree = ElggSession::offsetGet('currentcourse');
//echo elgg_echo('<br/>currently selected course is '. get_entity(599)->title.'<br/>');

//echo elgg_echo("Current Course Guid:  ".$coursetree);
$unsortedmenu = elgg_get_entities_from_relationship(array
        ( 'relationship_guid' => get_entity(599)->guid,
            'relationship' => 'menu',
        )
     );
//echo elgg_echo (var_dump($unsortedmenu));
$menu = array();
foreach ($unsortedmenu as $key =>$row)
{
    $menu[$key]=$row['menuorder'];
}
array_multisort($menu, SORT_ASC, $unsortedmenu);
//echo elgg_echo (var_dump($menu));

//$inventory = array(
//
//   array("type"=>"fruit", "price"=>3.50),
//   array("type"=>"milk", "price"=>2.90),
//   array("type"=>"pork", "price"=>5.43),
//
//);
//
//$price = array();
//foreach ($inventory as $key => $row)
//{
//    $price[$key] = $row['price'];
//}
//array_multisort($price, SORT_DESC, $inventory);
//echo elgg_echo (var_dump($price));

//echo elgg_echo (var_dump($menu));
//echo 'CourseTree'.var_dump($coursetree);
//echo 'Courseview object guid'.var_dump(ElggSession::offsetGet('courseviewobject'));
//echo elgg_echo(ElggSession::offsetGet('cvcourse'));

//$menu= get_entity (ElggSession::offsetGet('courseviewobject'));
//echo elgg_echo ('course info:  '.var_dump($course));
//echo elgg_echo ('course tree'.var_dump ($course->coursetree));

//Need to build the coursetree html with the appropriate class attributes so that the CSS can target it correctly and display
//it in a tree.

// ::TODO: the css needs to be fixed so that the open and close icons show up next to the folders and modules
$menu=$unsortedmenu;
echo elgg_echo ('<div class ="css-treeview">');
  foreach ($menu as $temp)
{
    //echo elgg_echo('<br/>Getting menu item:  '.$temp->name);
    if ($temp->indent==='+')
    {
        echo elgg_echo('
            <ul>
            ');
    }
    if ($temp->indent==='-')
    {
        echo elgg_echo('
            </ul>
            </li>
            ');
    }
    //echo elgg_echo ('###'.$temp->menutype);
    if ($temp->menutype=="folder")
    {
         echo elgg_echo('<ul>
           <li><input type ="checkbox"/><label><a> '.$temp->name.$temp->menuorder.'!!!</a></label>');
    }
 else
    {
        echo elgg_echo("<li><a class = 'indent' href ='".  elgg_get_site_url()."courseview/contentpane/".$temp->guid."' >".$temp->name.$temp->menuorder."</a></li>");
    }
}     
//for ($row=0; $row <sizeof ($coursetree); $row++)
//{
//    if ($coursetree[$row][indent ]== '+')
//    {
//        echo elgg_echo('
//            <ul>
//            ');
//    }
//   if ($coursetree[$row][indent ]== '-')
//    {
//        echo elgg_echo('
//            </ul>
//            </li>
//            ');
//    }
//    if ($coursetree[$row][contenttype ]== 'folder'||$coursetree[$row][contenttype ]== 'module')
//    {
//        echo elgg_echo('<ul>
//            <li><input type ="checkbox"/><label><a> '.$coursetree[$row][label].'</a></label>');
//    }
//    else if ($coursetree[$row][contenttype ]== 'folderOpen'||$coursetree[$row][contenttype ]== 'moduleOpen')
//    {
//        echo elgg_echo('<ul>
//            <li><input type ="checkbox" checked ="checked"/><label><a> '.$coursetree[$row][label].'</a></label>');
//    }
// else 
//    {
//        echo elgg_echo('<li><a class = "indent" href = /elgg/courseview/contentpane/'.$coursetree [$row][subtype].'/'.$row.'>'.$coursetree[$row][label].'</a></li>');
//    }
//   
//}
echo elgg_echo ('</div>')  ;  
 
?>

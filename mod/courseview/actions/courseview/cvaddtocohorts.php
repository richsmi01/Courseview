<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

elgg_load_library('elgg:courseview');

 $cvcohortguid = ElggSession::offsetGet('cvcohortguid');
echo get_input('objectguid');
echo '###'.get_input('rs1');
echo '<br>###'.get_input('rs2');
echo 'Cool!<br>';

$invite = $_POST['check'];
echo '.......'.$invite;
echo '+++++'.get_input ('check [ ]');
$cvobject = get_entity(get_input(objectguid));
$menuitems = cv_get_student_menu_items_by_cohort ($cvobject->container_guid);
$count =0;
foreach ($menuitems as $item )
{
    //echo 'menu item: '.$item->guid." -- ". $item->name."- "."rs".$count.'--'.get_input('rs'.$count)   .  "<br>";
    $test = get_input('rs'.$item->guid);
    
    echo "<br>$item->guid--- $test <br>";
     $relationship = 'content'.$cvcohortguid;

//        echo 'cvmenuguid:  '.$cvmenuguid.'<br>';
//        echo 'relationship:  '.$relationship.'<br>';
//        echo 'new object guid:  '.$object->guid.'<br>';
    if (get_input($item->guid))
    {
        
      $one=$item->guid;
      $two=$relationship;
      $three= $cvobject->guid;
      echo'<br>$$$$$$$$$$$$$$$$$$$$$$$$$$$$$<br>';
      echo '<br>'.$one.'--'.$two.'--'.$three.'<br>';
   
//        add_entity_relationship($one, $two, $three);
    }
    $count++;
}
exit;
?>

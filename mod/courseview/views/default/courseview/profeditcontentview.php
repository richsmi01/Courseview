<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
echo 'Hello'.$cvmenuguid;
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
?>

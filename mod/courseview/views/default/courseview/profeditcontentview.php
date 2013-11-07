<?php

 $moduletitle = $menuitem->name;
    echo ' <div id ="editbox">          
           <input type ="checkbox" id = "editcoursecheckbox"/><label>Edit Course?</label> -- need to elggify this and connect to cveditcourse action</br></br>';
             echo '<div  id ="editcourse">';
            echo elgg_view_form ('editmenuitem');
             echo elgg_view_form('addmenuitem');
            echo'</div>';
    echo '</div>';
?>

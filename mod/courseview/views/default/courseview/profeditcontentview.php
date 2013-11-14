<?php

//echo 'profeditcontentview<br>';

//    echo ' <div id ="editbox">    
echo ' <ul>';
    echo '<li>';
     echo "<input type='checkbox' name='a' id='cp-2'>CourseView administration";
             echo' <div>';
echo ' <ul>';
    echo '<li>';
        echo "<input type='checkbox' name='a' id='cp-2'>Edit The current module";
        echo' <div>';
            echo elgg_view_form('editmenuitem');
        echo' </div>';
    echo '<li>';

    echo '<li>';
        echo "<input type='checkbox' >Add menu item below current node";
        echo "<div > ";
            echo elgg_view_form('addmenuitem');
        echo'</div>';
    echo '<li>';
    echo '<li>';
    echo "<input type='checkbox' >Other stuff";
    echo '<div>';
        echo elgg_view_form('createcourse');
        echo elgg_view_form('cveditacourse');
        echo elgg_view_form ('deletecourse');
        echo elgg_view_form('addacohort');
        echo elgg_view_form('deleteacohort');
    echo '</div>';
    echo '</li>';
echo '</ul>';
    echo '</div>';
  echo '</li>';
echo '</ul>';
echo '</br>';

//if (cv_isprof(elgg_get_logged_in_user_entity()))
//{
//    echo ' Prof area to add content<br>';
//   
//}
?>

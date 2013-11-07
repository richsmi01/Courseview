<?php

//::MATT:  2.  So, this form will ultimately lead to the cveditcourse view...show I go to an action and have it load the view or should I just redirect through the switch statement in start

$userguid = elgg_get_logged_in_user_guid();


echo "<div class='cvminiview'>";
echo '<em>EDIT A COURSE:</em><br/><br/>';
echo ('Please choose course name to edit: ');

$base_path = elgg_get_plugins_path() . 'courseview/views/default/courseview';
require ($base_path . '/listcourses.php');
echo elgg_view('input/submit');
echo "</div>";
// var_dump ($cvcourses);
//  exit;
?>

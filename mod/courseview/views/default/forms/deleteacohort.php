<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$userguid = elgg_get_logged_in_user_guid();


echo "<div class='cvminiview'>";
echo '<em>DELETE A COHORT:</em><br/><br/>';
echo ('Please choose cohort  to delete: ');

$base_path = elgg_get_plugins_path() . 'courseview/views/default/courseview';
require ($base_path . '/listcohorts.php');
echo elgg_view('input/submit');
echo "</div>";
?>

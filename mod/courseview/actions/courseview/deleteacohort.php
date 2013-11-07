<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

echo 'cool!<br/>';
$cvcohortguid = get_input('cvcohort'); 
echo $cvcohortguid."!!!";
$cvcohort = get_entity($cvcohortguid);
echo $cvcohort->title;






echo 'Course:  '.$cvcohort->title.' has been deleted';
$cvcohort->delete();
exit;


?>

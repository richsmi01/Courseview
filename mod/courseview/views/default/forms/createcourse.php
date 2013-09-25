<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
echo elgg_echo ('Course name: ');
echo elgg_view('input/text', array('name' => 'coursename'));
echo elgg_view('input/submit');

?>

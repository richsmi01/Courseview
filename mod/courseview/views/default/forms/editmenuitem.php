<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$cvmenuguid = ElggSession::offsetGet('cvmenuguid');
$cvmenu = get_entity($cvmenuguid);

echo "<div class='cvminiview'>";
echo '<em>Edit the current module</em>';
echo '<br/>Enter name of new module';
echo elgg_view('input/text', array(
    'name' => 'cvmodulename',
    'value' => $cvmenu->name));
echo elgg_view('input/submit', array(
    'value' => 'Change Name'));
echo elgg_view('input/submit', array(
    'value' => 'Indent'));
echo elgg_view('input/submit', array(
    'value' => 'Outdent'));
echo elgg_view('input/submit', array(
    'value' => 'Move up'));
echo elgg_view('input/submit', array(
    'value' => 'Move down'));
echo '<br/>';
echo elgg_view('input/submit', array(
    'value' => 'Delete Menu Item'));
echo '<input type ="checkbox" id = "editcoursecheckbox"/>Confirm Delete --(need to Elggify this)';
echo '</div>';
?>

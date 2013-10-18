<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

var_dump(get_registered_entity_types());
echo elgg_view ('input/text', array (
    'name'=> 'params[blogadd]',
     'value'=>$vars['entity']->blogadd   ));

echo elgg_view('input/text', array( 
'internalname' => 'params[message]', 
'value' => $vars['entity']->message,
'class' => 'cssclassname' ) ); 

echo elgg_view('input/text', array( 
'name2' => 'params[test]', 
'value' => "hello",
'class' => 'cssclassname',
 'disabled'=>true) ); 


elgg_set_plugin_setting('testpluginsetting','Did this work???','courseview');
	

?>

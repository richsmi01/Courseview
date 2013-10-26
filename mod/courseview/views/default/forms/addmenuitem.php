<?php



//::TODO: will need to figure out about whether to do folder descriptions

echo 'Module Name: ';
                    
                    echo '<br/>Create a new menu item:';
                    echo '<br/>Enter name of new module';
                    echo elgg_view('input/text', array(
                    'name' => 'newmodulename',
                     'value'=>"")); 
                     echo '<br/>Enter type of new module';
                     echo elgg_view('input/text', array(
                    'name' => 'newmoduletype',
                     'value'=>""));
                      echo '<br/>Enter indent of new module';
                     echo elgg_view('input/text', array(
                    'name' => 'newmoduleindent',
                     'value'=>""));
                      echo '<br/>Enter order of new module';
                      echo elgg_view('input/text', array(
                    'name' => 'newmoduleorder',
                     'value'=>""));
                    echo elgg_view('input/submit', array(
                    'value' => elgg_echo('Create')));
                    
?>

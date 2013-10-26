<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
echo 'Profs Group:<br/>';
echo elgg_view('input/text', array(
    'name' => 'params[profsgroup]',
    'value' => $vars['entity']->profsgroup,
    'disabled' => true));

echo 'Plugins to be reconginized by Courseview';
$plugins = get_registered_entity_types()['object'];

$shortname= array();
$pluginaddurl=array();
$approvedlist =array();


foreach ($plugins as $plugin)
{
    $temp = 'check' . $plugin;
    echo '<div class=cvsettingsplugins>';
    $checkoptions =array('name' => "params[$temp]", 'value' => 1);  //sends a 0 if the checkbox isn't checked
    if ($vars['entity']->$temp ==1)
    {
        $checkoptions['checked'] = true;
    }
    echo elgg_view('input/checkbox', $checkoptions);
    echo $plugin;
    $pluginname = "createstring" . $plugin;
    $friendly = "friendly".$plugin;
   
    echo elgg_view('input/text', array(
    'name' => 'params['.$friendly.']',
    'value' => $vars['entity']->$friendly));
    //'class' => 'cssclassname'));  //::TODO: this doesn't work -- Check with Matt

    echo elgg_view('input/text', array(
        'name' => 'params[' . $pluginname . ']',
        'value' => $vars['entity']->$pluginname));
    echo'</div>';
    if ($vars['entity']->$temp ==1)  //this should be changed to use the checkbox when I get that working...
    {
       // $shortname[]=$vars['entity']->$friendly;
        $pluginaddurl[$plugin]= $vars['entity']->$pluginname;
        $approvedlist [$plugin]=$vars['entity']->$friendly;
    }
}

//var_dump($pluginaddurl);
elgg_set_plugin_setting('availableplugins', serialize($approvedlist), 'courseview');  //need to serialize arrays before putting in settings
elgg_set_plugin_setting('plugincreatestring', serialize($pluginaddurl), 'courseview');  //need to serialize arrays before putting in settings

//echo elgg_view('input/text', array(
//    'name2' => 'params[test]',
//    'value' => "hello",
//    'class' => 'cssclassname',
//    'disabled' => true));


//elgg_set_plugin_setting('testpluginsetting', 'Did this work???', 'courseview');
//echo elgg_get_plugin_setting('testpluginsetting','courseview');
//var_dump(get_registered_entity_types());
?>

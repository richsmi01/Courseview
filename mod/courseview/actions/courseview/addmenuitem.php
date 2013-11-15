<?php

$currentcvmenuguid = ElggSession::offsetGet('cvmenuguid');
$currentcvmenu= get_entity($currentcvmenuguid);
$indent=0;
switch (get_input('buttonchoice'))
{
    case 'Indent':
        $indent = $currentcvmenu->indent +1;
        break;
    case "Outdent":
        $indent = $currentcvmenu->indent - 1;
        break;
    case "Same Level":
        $indent =$currentcvmenu->indent ;
        break;
}

$user = elgg_get_logged_in_user_entity();
$modulename = get_input('newmodulename');
$moduletype = get_input('newmoduletype');
$moduleindent = get_input('newmoduleindent');

$cvcohortguid = ElggSession::offsetGet('cvcohortguid');
$cvcourseguid = get_entity($cvcohortguid)->container_guid;

$moduleorder = $currentcvmenu->menuorder + 1;
echo "order num:  " . $moduleorder . '###';

$menu = elgg_get_entities_from_relationship(array
    ('relationship_guid' => $cvcourseguid,
    'relationship' => 'menu',
    'type' => 'object',
    'subtype' => 'cvmenu',
    'order_by_metadata' => array('name' => 'menuorder', 'direction' => 'ASC', 'as' => 'integer'),
    'limit' => 1000,
        )
);
//var_dump($menu);
echo 'Number to change' . sizeof($menu) . '###';
for ($a = $moduleorder; $a < sizeof($menu); $a++)
{
    echo'!!!!<br>';
    $currentsort = $menu[$a]->menuorder;
    $newsort = $currentsort + 1;
    echo'<br/>changing ' . $menu[$a]->name . ' from ' . $currentsort . ' to ' . $newsort;
    $menu[$a]->menuorder = $newsort;
    $menu[$a]->save();
}

$cvmenu = new ElggObject();
$cvmenu->subtype = 'cvmenu';
$cvmenu->name = $modulename;
$cvmenu->owner_guid = $user->guid;
$cvmenu->container_guid = $cvcourseguid;
$cvmenu->access_id = ACCESS_PUBLIC;
$cvmenu->save();
$cvmenu->menutype = $moduletype;
$cvmenu->meta1 = "closed";
$cvmenu->menuorder = $moduleorder;
$cvmenu->indent = $indent;

//now, connect it to the course

add_entity_relationship($cvcourseguid, 'menu', $cvmenu->guid);
echo 'cvcourse = ' . get_entity($cvcourseguid)->title;
echo 'cvmenu = ' . $cvmenu->name;
echo 'indent: '.$indent;
//exit;
?>

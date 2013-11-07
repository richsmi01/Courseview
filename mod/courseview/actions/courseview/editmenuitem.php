<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$cvmenuitemname= get_input('cvmodulename');
echo $cvmenuitemname;
$cvmenuitem = get_entity(ElggSession::offsetGet('cvmenuguid'));
echo $cvmenuitem->name =$cvmenuitemname;
$cvmenuitem->save();
exit;



//when indenting we go from - to . to +  or back again.

?>

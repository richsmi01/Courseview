<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$cvmenuitemname = get_input('cvmodulename');
$cvmenuitem = get_entity(ElggSession::offsetGet('cvmenuguid'));
 echo "menu item indent ".$cvmenuitem->indent;
echo "TEST:" . get_input('buttonchoice');
 echo "menu item indent ".$cvmenuitem->indent;

switch (get_input('buttonchoice'))
{
    case 'Indent':
        echo 'indent has been selected';
       
     
        $cvmenuitem->indent=$cvmenuitem->indent+1;
//        if ($cvmenuitem->indent == '-')
//        {
//            $cvmenuitem->indent = '.';
//        } elseif ($cvmenuitem->indent == '.')
//        {
//            $cvmenuitem->indent = '+';
//        }
        break;
    case 'Outdent':
        echo 'outdent has been selected';
         $cvmenuitem->indent=$cvmenuitem->indent-1;
//        if ($cvmenuitem->indent == '+')
//        {
//            $cvmenuitem->indent = '.';
//        } elseif ($cvmenuitem->indent == '.')
//        {
//            $cvmenuitem->indent = '-';
//        }
        break;

    case 'Move Up':
        echo 'move up selected';
        break;    
     case 'Move Down':
         echo 'move down selected';
         break;

    case 'Change Name':
        echo 'Change Name has been selected';
        $cvmenuitem->name = $cvmenuitemname;
        break;
}

$cvmenuitem->save();
//echo $cvmenuitemname;

exit;




//when indenting we go from - to . to +  or back again.
?>

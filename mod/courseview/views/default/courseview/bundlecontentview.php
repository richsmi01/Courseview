<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$content = elgg_get_entities_from_relationship(array(
            'relationship_guid' => $cvmenuguid,
            'relationship' => 'content'));
        foreach ($content as $temp)
        {
            if (cv_isprof($user))
            {
                echo elgg_echo('<div class="editcourse"><a class ="uparrowcontainer" href="http://sheridancollege.ca"><div class="uparrow" ></div></a>');
                echo elgg_echo('<a class ="downarrowcontainer" href="http://sheridancollege.ca"><div class="downarrow"></div></a>');
                echo elgg_echo('</div>');
            }
            echo elgg_echo(elgg_view_entity($temp, array(full_view => false)));
        }
?>

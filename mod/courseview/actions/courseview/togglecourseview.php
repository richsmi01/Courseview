<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
//forward('courseview/contentpane');
           
            $status = ElggSession::offsetGet('courseview');
            echo '$$$'.$status;
//if the courseview session variable was false, toggle it to true and viceversa
            if ($status)
            {
                //put these back in order to exit courseview
                ElggSession::offsetSet ('courseview', false);
                forward('http://localhost/elgg/activity');
            }
            else
            {
   
                ElggSession::offsetSet('courseview', true); //set session variable telling elgg that we are in 'masters' mode
                //$base_path=dirname(__FILE__); //gives a relative path to the directory where this file exists
                $plugin_path = elgg_get_plugins_path().'courseview/pages/courseview';
                
//               stuff to change the menu to say Exit Courseview when in courseview
//                elgg_unregister_menu_item('site', 'courseview');
//                $item = new ElggMenuItem('courseview', 'Exit CourseView', elgg_add_action_tokens_to_url('action/toggle'));
//                elgg_register_menu_item('site', $item);
                
                forward("courseview/courseview"); //load the default courseview welcome page
           }

?>

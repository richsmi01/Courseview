<?php

$user = elgg_get_logged_in_user_entity();
//check to see if the user is an admin and provide appropriate admin button
if (elgg_is_admin_logged_in())
{
    echo "<div class='cvminiview'>";
    echo elgg_echo ('courseview:adminstatus');   
    echo '<br>';
    echo elgg_view('output/url', array("text" => "Manage CourseView", "href" => "courseview/managecourseview", 'class' => 'elgg-button elgg-button-action'));
    echo '</div>';
    
}
//check to see if the user is a professor and add appropriate content based on this
require (elgg_get_plugins_path() . 'courseview/lib/courseview.php');
if (cv_isprof($user))
{
    echo "<div class='cvminiview'>";
   echo '<br>'.$user->name .' is in the profs group<br/>';
   echo elgg_view('output/url', array("text" => "Debug Stuff", "href" => "courseview/managecourses", 'class' => 'elgg-button elgg-button-action'));
   echo '</div>';
}

  //List all cohorts that this user is a member of
    $cvcohorts = elgg_get_entities_from_relationship(array
        ('type' => 'group',
       'metadata_names' => array('cvcohort'), 
        'metadata_values' => array(true),  
        'limit' => false,
        'relationship' => 'member',
        'relationship_guid' => $user->guid
            )
    );
    
    echo "<div class='cvminiview'>";
    echo elgg_echo('<br/><em>Please choose a cohort: </em><br/>');
    //$somegroup = new ElggGroup;
    
    foreach ($cvcohorts as $cvcohort)
    {
        //echo elgg_echo ("<br/>~~~".get_entity($cvcohort->container_guid)->title);
        echo ('<br/>');
        echo elgg_view('output/url', array("text" => $cvcohort->title, "href" => "courseview/contentpane/".$cvcohort->guid."/0", 'class' => 'elgg-button elgg-button-action'));
        //echo elgg_echo("<br/>Cohort: <em>".$cvcohort->title .'</em>...GUID: '.  $cvcohort->guid);
    }
    echo '</div>';
?>

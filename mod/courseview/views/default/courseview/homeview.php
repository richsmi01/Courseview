<?php

//this will eventually have to get more sophisticated to present the user with options depending on who they are: student, prof or admin
//if they are a student, we will present them with a list of cohorts that they belong to and allow them to choose one.

$user = elgg_get_logged_in_user_entity();
//check to see if the user is an admin and provide appropriate admin button
if (elgg_is_admin_logged_in())
{
    echo elgg_echo ("ADMIN CHOICES <br/>");
    echo elgg_echo ('courseview:adminstatus');   
    echo elgg_view('output/url', array("text" => "Manage CourseView", "href" => "courseview/managecourseview", 'class' => 'elgg-button elgg-button-action'));
}
//check to see if the user is a professor and add appropriate content based on this


if (cv_isprof($user))
{
   echo '<br>'.$user->name .' is in the profs group<br/>';
   echo elgg_view('output/url', array("text" => "Manage Courses", "href" => "courseview/managecourses", 'class' => 'elgg-button elgg-button-action'));
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
    
    echo elgg_echo('<br/><br/>Please choose a cohort: <br/>');
    //$somegroup = new ElggGroup;
    foreach ($cvcohorts as $cvcohort)
    {
        echo elgg_echo ("<br/>");
        echo elgg_view('output/url', array("text" => $cvcohort->title, "href" => "courseview/contentpane/".$cvcohort->guid."/0", 'class' => 'elgg-button elgg-button-action'));
        //echo elgg_echo("<br/>Cohort: <em>".$cvcohort->title .'</em>...GUID: '.  $cvcohort->guid);
    }
?>

<?php

//this will eventually have to get more sophisticated to present the user with options depending on who they are: student, prof or admin
//if they are a student, we will present them with a list of cohorts that they belong to and allow them to choose one.
echo elgg_echo ('courseview:greetings', array ($vars ['name']));

if (elgg_is_admin_logged_in())
{
    echo elgg_echo ("ADMIN CHOICES <br/>");
    echo elgg_echo ('courseview:adminstatus');
    
    echo elgg_view('output/url', array("text" => "Manage CourseView", "href" => "courseview/managecourseview", 'class' => 'elgg-button elgg-button-action'));
}

$user = elgg_get_logged_in_user_entity();


//if (courseview_get_profsgroup()->isMember ($myuser))
//{
   echo '<br>'.$user->name .' is in the profs group';
   echo elgg_view('output/url', array("text" => "Manage Courses", "href" => "courseview/managecourses", 'class' => 'elgg-button elgg-button-action'));
   
//}

  //List all cohorts that this user is a member of
    $cvcohort = elgg_get_entities_from_relationship(array
        ('type' => 'group',
         //TODO::change this to look for an attribute called cvcohort set to true instead of testAttribute and 123
        'metadata_names' => array('cvcohort'), 
        'metadata_values' => array(true),  
        'limit' => false,
        'relationship' => 'member',
        'relationship_guid' => $user->guid
            )
    );
    
    echo elgg_echo('<br/><br/>Please choose a cohort: <br/>');
    //$somegroup = new ElggGroup;
    foreach ($cvcohort as $group)
    {
        echo elgg_echo("<br/>Cohort: <em>".$group->title .'</em>...GUID: '.  $group->guid);
    }
   
      echo elgg_echo('<br/><br/>We are assuming that the user chose the first cohort listed<br/>');
      echo elgg_view('output/url', array("text" => "User chooses first cohort", "href" => "courseview/contentpane/".$cvcohort[0]->guid."/1", 'class' => 'elgg-button elgg-button-action'));
   
?>

<?php

/*
 * Rich Test stuff
 */
//I need to start packaging all output into an elgg view and then calling the view properly instead of just using elgg_echo
//echo elgg_view('output/url', array("text" => "Manage Courses", "href" => "courseview/thiswillmanagecourses", 'class' => 'elgg-button elgg-button-action'));
//add button to create a new object of correct subtype:
//list all objects that meet subtype and tag criteria


$coursetreeindex = ElggSession::offsetGet('coursetreeindex');//could just pull this from the url...is this easier?
$currentcourse = ElggSession::offsetGet('currentcourse');//get current course
$currentmenuitem = $currentcourse[$coursetreeindex]; //get current menu item
$filter = ElggSession::offsetGet('currentcourse')[$coursetreeindex][filter]; //pull the filter tags out of the current menu item and assign to $filter




for ($count=$coursetreeindex; $count>=0; $count--)
{
   
    if ($currentcourse[$count]['content' ]=== 'module' || $currentcourse[$count]['content']==='moduleOpen' )
    {
         echo elgg_echo ('Parent Module:  '.$currentcourse[$count]['label']);
         break;
    }
}
//echo elgg_echo ('currentmenuitem!!!!'.var_dump($currentmenuitem));
// elgg_echo ('currentmenuitem subtype!!!!'.var_dump($currentmenuitem['subtype']));
if ($currentmenuitem['contenttype']==='bundle')
{
    //echo elgg_echo ('currentmenuitem subtype'.$currentmenuitem['subtype']);
    //echo elgg_echo (var_dump($currentmenuitem));
    $searchcriteria = array (
    type=>'object',//I just removed the quotes around type...I think this ok
    //'metadata_name'=>grou_category
    //'subtype' => $type,
    //limit => $limit,
    metadata_name_value_pairs =>array('name'=>'tags', 'value'=> $currentmenuitem['subtype']), 
    );
    
}
else
{
   
    $type = $currentmenuitem['subtype'];
     echo elgg_echo ('subtype'.$type);
$searchcriteria = array (
    'type'=>'object',
    //'metadata_name'=>grou_category
    'subtype' =>  $type 
    //limit => $limit,
    //metadata_name_value_pairs =>array('name'=>'tags', 'value'=>'cohort guid', 
    );
}
$entities = elgg_get_entities_from_metadata($searchcriteria);
//echo elgg_echo ('searchcriteria....'.var_dump ($searchcriteria));
//echo elgg_echo ("returned entities".var_dump ($entities));
//echo elgg_echo ('searching for '.$type);
//echo elgg_echo ('filters:  '.var_dump ($filter));
//echo elgg_echo (var_dump ($entities));

for ($numentities = 0;$numentities<sizeof($entities); $numentities++)
{
  $match = TRUE;
  
  //echo elgg_echo(elgg_view_entity($entities[$numentities], array(full_view => false)));
    for ($count = 0; $count < sizeof($filter); $count++)
    {
        if ($filter[count]==='')
        {
            continue;
        }
        $tags = $entities[$numentities]->tags;
       // echo elgg_echo('comparing '.$filter[$count]);
        if (!(in_array($filter[$count], $tags) || $tags === $filter[$count]))
        
        {
            //echo elgg_echo('bad</br>');
            $match = FALSE;
            break;
        }
    }
    if ($match)
{
    echo elgg_echo(elgg_view_entity($entities[$numentities], array(full_view => false)));
     // echo elgg_echo ('accepted<br>');
}
else
{
   //echo elgg_echo ('rejected<br>');
}
}


// echo elgg_echo (var_dump ($test));
//  echo elgg_echo(elgg_view_entity($test[0], array(full_view=>false)));
//echo elgg_echo(elgg_view_entity($test[0], array(full_view=>true)));
// echo elgg_echo (var_dump ($entities[0]));
// echo elgg_echo ('=============================================~');
// echo elgg_echo (var_dump($entities[0]->tags));
//  echo elgg_echo ('=============================================~');
// echo elgg_echo (var_dump ($entities));
//$tags_value = $test[0]->tags;
//echo elgg_echo ("tags:  ".var_dump($tags_value));
//
//
//masters_display_matching_entities('blog');
//masters_display_matching_entities('bookmarks');
//masters_display_matching_entities('file');
//masters_display_matching_entities('page_top');
//masters_display_matching_entities('page');
//masters_display_matching_entities('group');
//elgg_extend_view('masters/testview', 'masters/greetings');
//echo elgg_echo('<br>Blog Entries!<br>');
//echo elgg_list_entities(array(
//    'type' => 'object',
//    'subtype' => 'blog',
//));
//
//$params = blog_get_page_content_list();
//$body = elgg_view_layout('content', $params);
//echo elgg_view_page('Hi Rich', $body);

//$filters="'metadata_name_value_pairs' => array('name' => 'tags'";
//for ($row=0; $row<sizeof($filter); $row++)
//{
//    $filters.=", 'value' =>'".$filter[$row]."'";
//    
//}
//$filters.='),';
//$filters= array(
//    'name' => 'tags'
//);
//for ($row=0; $row<sizeof($filter); $row++)
//{
//    //$filters.=", 'value' =>'".$filter[$row]."'";
//    $filters ['value']= $filter[$row];
//}
//$temp = array('name' => 'tags', 'value' => 'blog1', 'value'=>'tag1');
//echo elgg_echo (var_dump ($temp));
//echo elgg_echo (var_dump ($filters));
// = ElggSession::offsetGet('currentcourse');
//     $content = elgg_list_entities_from_metadata(array(
//			'type' => 'object',
//			//'metadata_name' => 'group_category',
//			//'metadata_value' => 'language',
//                                                                  'subtype' => $type,
//			//'limit' => $limit,
//                                                         /*         'metadata_name_value_pairs' => array('name' => 'tags', 'value' => 'blog1','tag1'),*/
//                                                                   
//			'full_view' => false
//    ));
//    echo elgg_echo ($content);
//if(elgg_is_logged_in()){
//    echo elgg_view('output/url', array("text" => "View Blogs", "href" => "courseview/list/blog",'class' => 'elgg-button elgg-button-action'));
//    }
//if(elgg_is_logged_in()){
//    echo elgg_view('output/url', array("text" => "Add Blog", "href" => "blog/add/".  elgg_get_logged_in_user_guid(), 'class' => 'elgg-button elgg-button-action'));
//    }
//     if(elgg_is_logged_in()){
//    echo elgg_view('output/url', array("text" => "Check view2 page", "href" => "courseview/view2", 'class' => 'elgg-button elgg-button-action'));
//    }
//    
//     if(elgg_is_logged_in()){
//    echo elgg_view('output/url', array("text" => "Check masters page", "href" => "courseview/masters", 'class' => 'elgg-button elgg-button-action'));
//    }
//    
//    if(elgg_is_logged_in()){
//    echo elgg_view('output/url', array("text" => "Add Bookmark", "href" => "bookmarks/add/".  elgg_get_logged_in_user_guid(), 'class' => 'elgg-button elgg-button-action'));
//    }
//    
//    if(elgg_is_logged_in()){
//    echo elgg_view('output/url', array("text" => "Add Page", "href" => "pages/add/".  elgg_get_logged_in_user_guid(), 'class' => 'elgg-button elgg-button-action'));
//    }
//echo '!!!'.get_input('object_type');
//
?>

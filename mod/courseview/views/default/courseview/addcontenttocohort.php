<?php
//Check to see if the action string contains any of our approved plugins...If it does, and the user is in a cohort, display the page.
 

elgg_load_library('elgg:courseview');
elgg_load_library('elgg:cv_debug');
 //first, we should check to see if the user has any cohorts...if they don't return without doing anything else
if ( !cv_is_courseview_user())
{
    return;
}

//var_dump($vars['action']);
$entity = ($vars['entity']);
//echo "...".$entity->guid;
//var_dump($vars);
$action = $vars['action'];
$validplugins = unserialize(elgg_get_plugin_setting('availableplugins', 'courseview'));
$validkeys = array_keys($validplugins);
$donotdisplay = true;
//echo "Action: ".$vars['action'];
foreach ($validkeys as $plugin)
{
  //  echo "Plugin :".$plugin.'<br>';
    if (strpos($action, $plugin)!==false)
    {
        $donotdisplay=false;
    }
}
cv_debug("Decided not to display", "",5);
//if (array_key_exists("blog", $validplugins))
//exit;
    if ($donotdisplay)
    {
       return true;
    }
?>
<script>
    /**
     * Comment
     */
    function showCVAdd() {
       
        myDiv = document.querySelector("#addToCohort");
        //alert (myDiv.style.visibility);
        if (myDiv.style.visibility=="visible") {
            myDiv.style.visibility='hidden';
            myDiv.style.height='0px';
                 
        }
        else
        {
            myDiv.style.visibility='visible';
            myDiv.style.height='auto';
                 
        } 
    }
</script>


<div id='add_entity_to_cohort_menus'>
    <input onclick = "showCVAdd ()" id ="showtree" type ='checkbox' style='display:inline' />
    <label  for ="showtree" style="display:inline">Add this content to a CourseView module </label><br><br>
    <div id ='addToCohort'>
    <?php
     //echo elgg_view('courseview/debug');
        echo elgg_view('courseview/cvaddtocohorttreeview',$vars);  //what $vars???
        echo '</div>';
        echo '</div>';
    ?>

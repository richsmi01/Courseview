
<!--move our link to just above the save button-->
<script>
    $(document).ready (function () {
        $(".elgg-form input[type='submit']:last-of-type").before($("#add_entity_to_cohort_menus"));
    });
</script>


<?php
//var_dump($vars['action']);
$entity = ($vars['entity']);
//echo "...".$entity->guid;
//pull in any needed vars
$cvcohortguid = ElggSession::offsetGet('cvcohortguid');
$cvmenuguid = ElggSession::offsetGet('cvmenuguid');
$userguid = elgg_get_logged_in_user_guid();

//we'll need some of the library methods here
elgg_load_library('elgg:courseview');

//get  a list of the cohorts that the logged in user belongs to
$groupsmember = cv_get_users_cohorts();


echo ('<div class ="cvtreeaddtocohort">');
echo '<br>';
$count = 0;
$rscount = 0;
//::TODO:  for now, I'm just asking for the object guid...I need to get it from the context of the transaction
//echo 'object guid';
//echo "<input type ='input'  name='objectguid'   />";
//loop through each cohort and build the tree menu
foreach ($groupsmember as $cohort)
{
    $cvcohortguid = $cohort->guid;
    $menuitems = cv_get_menu_items_for_cohort($cvcohortguid);

    //$checkedmodules =array();
    //Here we are building the html of the treeview control and adding the correct css classes so that my css
    //can turn it into a tree that can be manipulated by the user 
    echo ('<div class ="css-treeview">');
    $indentlevel = 0;

    //now, loop through each menu item (by menusort order)
    foreach ($menuitems as $menuitem)
    {

        $rel = 'content' . $cvcohortguid;
        $checkoptions = false;
        if (check_entity_relationship($menuitem->guid, $rel, $entity->guid)->guid_one > 0)
        {
            $checkoptions = true;
        }
        if ($cvmenuguid ==$menuitem->guid)
        {
            $checkoptions =true;
        }

        //If this menu item should be indented from the previous one, add a <ul> tag to start a new unordered list
        if ($menuitem->indent > $indentlevel)
        {
            echo('<ul>');
        }
        //if this menu item should be outdented, close off our list item and unorderedlist item
        else if ($menuitem->indent < $indentlevel)
        {
            echo ('</li> </ul>');
        }
        //now we set indent level to the current menu item indent level so that we can check against it on the next iteration
        $indentlevel = $menuitem->indent;

        //setting up attributes to insert into the html tags
        $name = $menuitem->name;
        $id1 = $count; //$menuitem->menuorder;
        $count++;
        $indent = $menuitem->indent;

        $class2 = "cvinsert";

        if ($menuitem->menutype == "folder")
        {
            echo "<li>";
            echo "<input type ='checkbox'  name='$indent' class ='cvmenuitem'   />";
            echo "<label>";
            echo "<a href='" . elgg_get_site_url() . "courseview/contentpane/" . $cvcohortguid . "/" . $menuitem->guid . "'> " . $name . "</a>";
            echo "</label>";
        }
        //otherwise, let's just create a link to the contentpane and pass the guid of the menu object...the css class indent is also added here
        elseif ($menuitem->menutype == 'professor')
        {
            echo "<span class ='indent'>$name.</span>";
        } else
        {
            $value = $menuitem->guid;
            echo ("<li>");
            echo elgg_view('input/checkbox', array('name' => 'modules[]', 'value' => '+' . $value, 'class' => 'cvinsert', 'checked' => $checkoptions, 'default' => '-' . $value));
            echo "<a  name='$indent' class = 'cvmenuitem $class2  indent' href ='" . elgg_get_site_url() . "courseview/contentpane/" . $cvcohortguid . "/" . $menuitem->guid . "' >" . $name . "</a></li>";
        }
    }
    echo ('</div>');
}
echo '<br>';
echo '</div>';

?>

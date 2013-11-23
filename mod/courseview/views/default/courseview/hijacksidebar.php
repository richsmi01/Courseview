<script>  //quick and dirty script to persist the tree menu between page refreshes...should probably think about a better way to do this...maybe through ajax
    window.onload=function(){
        var treemenu = document.getElementsByClassName("cvmenuitem");
        var current=document.getElementsByClassName("cvcurrent")[0];
        
        var currentposition = current.id;
        var currentindent = current.name;
       // var stuff="length of treemenu: "+treemenu.length+"\ncurrent: "+current+"<br>";
        for (i = currentposition; i >=0; i--) 
        {
            //stuff+=treemenu[i].name+" - "+treemenu[i].id+"<br>";
            //treemenu[i].innerHTML += "**"+treemenu[i].id;
//            treemenu[i].checked=true;
            if (treemenu[i].checked==false&& treemenu[i].name<currentindent) 
            {
                treemenu[i].checked=true;
                currentindent--;
            }
           
            if (currentindent==0) 
            {
                break;
            }
        }
    current.checked=true;
//var debug = document.getElementById("debug");
        //debug.innerHTML += ' Debug Stuff<br>' + stuff;
        }
</script>

<?php
//pull in any needed vars
$cvcohortguid = ElggSession::offsetGet('cvcohortguid');
$cvmenuguid = ElggSession::offsetGet('cvmenuguid');
$userguid = elgg_get_logged_in_user_guid();

//we'll need some of the library methods here
elgg_load_library('elgg:courseview');

//get  a list of the cohorts that the logged in user belongs to
$groupsmember = cv_get_users_cohorts();

echo '<h3>CourseView</h3><br>';
$count=0;
//loop through each cohort and build the tree menu
foreach ($groupsmember as $cohort)
{
    $cvcohortguid = $cohort->guid;
    $menuitems = cv_get_menu_items_for_cohort($cvcohortguid);

    //Here we are building the html of the treeview control and adding the correct css classes so that my css
    //can turn it into a tree that can be manipulated by the user 
    echo elgg_echo('<div class ="css-treeview">');
    $indentlevel = 0;

    //now, loop through each menu item (by menusort order)
    foreach ($menuitems as $menuitem)
    {
        //If this menu item should be indented from the previous one, add a <ul> tag to start a new unordered list
        if ($menuitem->indent > $indentlevel)
        {
            echo elgg_echo('<ul>');
        }
        //if this menu item should be outdented, close off our list item and unorderedlist item
        else if ($menuitem->indent < $indentlevel)
        {
            echo elgg_echo('</li> </ul>');
        }
        //now we set indent level to the current menu item indent level so that we can check against it on the next iteration
        $indentlevel = $menuitem->indent;

        //setting up attributes to insert into the html tags
        $name = $menuitem->name.'--'.$menuitem->guid;
        $id1 = $count; //$menuitem->menuorder;
        $count++;
        $class2 = "";
        $indent = $menuitem->indent;
        if ($menuitem->guid == $cvmenuguid)
        {
            $class2 = " cvcurrent";  //setting the current menu item
        }
        if ($menuitem->menutype == "folder")
        {
            echo "<li>";
                echo "<input type ='checkbox' abc ='m' name='$indent' class ='cvmenuitem $class2' id ='$id1' />";
                    echo "<label>";
                        echo "<a href='" . elgg_get_site_url() . "courseview/contentpane/" . $cvcohortguid . "/" . $menuitem->guid . "'> " . $name . "</a>";
                    echo "</label>";
        }
        //otherwise, let's just create a link to the contentpane and pass the guid of the menu object...the css class indent is also added here
        else
        {
            echo elgg_echo("<li><a abc ='m' name='$indent' class = 'cvmenuitem $class2 indent' id ='$id1' href ='" . elgg_get_site_url() . "courseview/contentpane/" . $cvcohortguid . "/" . $menuitem->guid . "' >" . $name . "</a></li>");
        }
    }
    // echo '<br>' . $abc;
    echo elgg_echo('</div>');
}
echo '<br>';
?>

<script>
    
    window.onload=function(){
        var treemenu = document.getElementsByClassName("cvmenuitem");
        var current=document.getElementsByClassName("cvcurrent")[0];
        var currentposition = current.id;
        var currentindent = current.name;
        var stuff="length of treemenu: "+treemenu.length+"\ncurrent: "+current;
        for (i = currentposition; i >=0; i--) 
        {
            if (treemenu[i].checked==false&& treemenu[i].name<currentindent) {
                stuff+=" opening because current item indent is "+treemenu[i].name+"and current is: "+currentindent+"n";
                treemenu[i].checked=true;
                currentindent--;
            }
            else
                {
                     treemenu[i].checked=false;
                     stuff+=" closing\n ";
                }
                 // stuff+=" tree item:  "+ treemenu[i].name+"tree indent  "+treemenu[i].id;
        }
       //alert (stuff);
    }


    function handleClick(cb) {
        //       message ="";
        //       for (i = 0; i < cb.checkbox.length; i++)
        //      if (cb[i].checked){
        //         message = message + frm.checkbox[i].value + "#";
        //      }
        //      alert("Tree menu changed! ");
        //      
        //      
//        var treemenu = document.getElementsByClassName("cvmenuitem");
//        //treemenu[0].checked=true;
//        alert(treemenu.length);
        //  
  
        //alert ("Clicked, new value = " + cb.className);
    }
</script>

<?php
//$page = get_input('rich');
$cvcohortguid = ElggSession::offsetGet('cvcohortguid');
$cvmenuguid = ElggSession::offsetGet('cvmenuguid');

$userguid = elgg_get_logged_in_user_guid();
$abc = "";
elgg_load_library('elgg:courseview');

$groupsmember = cv_get_users_cohorts();  //get  a list of the cohorts that the logged in user belongs to
foreach ($groupsmember as $cohort)
{
    $cvcohortguid = $cohort->guid;
    $menu = cv_get_menu_items_for_cohort($cvcohortguid);

//Here we are building the html of the treeview control and adding the correct css classes so that my css
//can turn it into a tree that can be manipulated by the user 
    echo elgg_echo('<div class ="css-treeview">');
    $indentlevel = 0;
    foreach ($menu as $temp)
    {
        //If this menu item should be indented from the previous one, add a <ul> tag to start a new unordered list
        if ($temp->indent > $indentlevel)
        {
            $abc.='@' . $temp->menuorder;
            echo elgg_echo('
            <ul>
            ');
        }
        //if this menu item should be outdented, close off our unordered list and list item
        else if ($temp->indent < $indentlevel)
        {
            echo elgg_echo('</li>
            </ul>
            
            ');
        }
        $indentlevel = $temp->indent;
        //delete this
//         if ($temp->indent == '')
//        {
//          echo'!!!!!';
//          $temp->indent='.';
//          $temp->save();
//        }
        //if the menu item is a folder type, add a checkbox which the css will massage into the collapsing tree
        $name = '';

        
        $name .=  $temp->name;
        $id1 =  $temp->menuorder;
        $class2 = "";
        $indent=$temp->indent;
        if ($temp->guid == $cvmenuguid)
        {
            $class2 = " cvcurrent";  //setting the current menu item
 
        }
        if ($temp->menutype == "folder")
        {
            echo elgg_echo("
           <li><input type ='checkbox' abc ='m' name='$indent' class ='cvmenuitem $class2' id ='$id1' /><label><a href='" . elgg_get_site_url() . "courseview/contentpane/" . $cvcohortguid . "/" . $temp->guid . "'> " . $name . "</a></label>");
        }
        //otherwise, let's just create a link to the contentpane and pass the guid of the menu object...the css class indent is also added here
        else
        {
            echo elgg_echo("<li><a abc ='m' name='$indent' class = 'cvmenuitem $class2 indent' id ='$id1' href ='" . elgg_get_site_url() . "courseview/contentpane/" . $cvcohortguid . "/" . $temp->guid . "' >" . $name . "</a></li>");
        }
    }
    echo '<br>' . $abc;
    echo elgg_echo('</div>');
}
?>

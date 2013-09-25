<?php

/*
 * 
 */

echo '
   <style>
            .css-treeview ul,
            .css-treeview li
            {
                padding: 0;
                margin: 0;
                list-style: none;
            }

            .css-treeview input
            {
                position: absolute;
                opacity: 0;
            }

            .css-treeview
            {
                font: normal 11px "Segoe UI", Arial, Sans-serif;
                -moz-user-select: none;
                -webkit-user-select: none;
                user-select: none;
            }

            .css-treeview a
            {
                color: #00f;
                text-decoration: none;
            }
            /*I added this to make branch nodes push in a little bit--Rich.*/
            .css-treeview  .indent {
                margin-left: 40px;
            }

            .css-treeview a:hover
            {
                text-decoration: underline;
            }

            .css-treeview input + label + ul
            {
                margin: 0 0 0 22px;
            }

            .css-treeview input ~ ul
            {
                display: none;
            }

            .css-treeview label,
            .css-treeview label::before
            {
                cursor: pointer;
            }

            .css-treeview input:disabled + label
            {
                cursor: default;
                opacity: .6;
               
            }

            .css-treeview input:checked:not(:disabled) ~ ul
            {
                display: block;
            }

            .css-treeview label,
            .css-treeview label::before
            {
               /* background: url("localhost/elgg/courseview/imgs/icons.png") no-repeat;*/
              /*background: url("../../imgs/icons.png") no-repeat;*/
             /*   background: url("/imgs/icons.png") no-repeat; */
             /* background: url("icons.png") no-repeat;*/
           
           /*       background: url ("'.  elgg_get_site_url().'mod/courseview/_graphics/icons.png") no-repeat;*/
               background: url("../../../../icons.png");
            }

            .css-treeview label,
            .css-treeview a,
            .css-treeview label::before
            {
                display: inline-block;
                height: 16px;
                line-height: 16px;
                vertical-align: middle;
            }

            .css-treeview label
            {
                background-position: 18px 0;
            }

            .css-treeview label::before
            {
                content: "";
                width: 16px;
                margin: 0 22px 0 0;
                vertical-align: middle;
                background-position: 0 -32px;
            }

            .css-treeview input:checked + label::before
            {
                background-position: 0 -16px;
            }

            /* webkit adjacent element selector bugfix */
            @media screen and (-webkit-min-device-pixel-ratio:0)
            {
                .css-treeview 
                {
                    -webkit-animation: webkit-adjacent-element-selector-bugfix infinite 1s;
                }

                @-webkit-keyframes webkit-adjacent-element-selector-bugfix 
                {
                    from 
                    { 
                    padding: 0;
                } 
                to 
                { 
                    padding: 0;
                }
            }
            }
        </style>
';

//echo elgg_echo ('hello:greetings', array ($vars ['name']));

//if the user is an admin, then display a link to managing courses.  Students will not see this link
//if (elgg_is_admin_logged_in())
//{
//    echo elgg_view('output/url', array("text" => "Manage Courses", "href" => "courseview/thiswillmanagecourses", 'class' => 'elgg-button elgg-button-action'));
//}
//
////need to loop through and display various modules here.
//
// echo elgg_view('output/url', array("text" => "View Blogs", "href" => "courseview/listview", 'class' => 'elgg-button elgg-button-action'));
// echo elgg_view('output/url', array("text" => "Exit Course Tool", "href" => "courseview/exit", 'class' => 'elgg-button elgg-button-action'));
 
 /*******************************************************************************
  * NOTE!!!
  * 
  * Need to be able to create a 'mixed' sub-module that displays multiple things that the professor wants to include like
  * a pdf file, a video, a feedback page, a wiki-page etc that could all be grouped as "Professor's Comments" or
  * something like that...for this, we would just get all entities regardless of subtype that matched a tag such as
  * @#$Multi-Module 1$#@
  * 
  * or just one thing per sub-module like professor-video and then another submodule called - assignment etc.
  */
 


$coursetree = ElggSession::offsetGet('currentcourse');
    
echo elgg_echo ('<div class="css-treeview">')  ;  
for ($row=0; $row <sizeof ($coursetree); $row++)
{
    if ($coursetree[$row][indent ]== '+')
    {
        echo elgg_echo('
            <ul>
            ');
    }
   if ($coursetree[$row][indent ]== '-')
    {
        echo elgg_echo('
            </ul>
            </li>
            ');
    }
    if ($coursetree[$row][contenttype ]== 'folder'||$coursetree[$row][contenttype ]== 'module')
    {
        echo elgg_echo('<ul>
            <li><input type ="checkbox"/><label><a> '.$coursetree[$row][label].'</a></label>');
    }
    else if ($coursetree[$row][contenttype ]== 'folderOpen'||$coursetree[$row][contenttype ]== 'moduleOpen')
    {
        echo elgg_echo('<ul>
            <li><input type ="checkbox" checked ="checked"/><label><a> '.$coursetree[$row][label].'</a></label>');
    }
 else 
    {
        echo elgg_echo('<li><a class = "indent" href = /elgg/courseview/listview/'.$coursetree [$row][subtype].'/'.$row.'>'.$coursetree[$row][label].'</a></li>');
    }
   
}
echo elgg_echo ('</div>')  ;  
 //$plugin_path = elgg_get_plugins_path();
 //echo $plugin_path;
 
 //echo '$$$'.$_SERVER['DOCUMENT_ROOT'];
// for ($row = 0; $row<  sizeof($course_content); $row++)
//{
//   echo elgg_echo ('<li >'.$course_content [$row][0].'<ul>');
//   
//    
//    for ($column =1; $column< sizeof($course_content[$row]); $column++)
//    {
//        echo elgg_echo ('<li><a href = /elgg/courseview/listview/'.$course_content [$row][$column].'/'.$row.'>---'.$course_content [$row][$column].' </a></li>');
//        //echo '<br>----'.$course_content[$row][$column];
//    }
//    
//}

 //echo elgg_echo (elgg_get_plugins_path().'courseview/imgs');
    //echo elgg_echo (getcwd());
// echo elgg_echo ('


// 
// 
// 
//     <div class="css-treeview">
//            <ul>
//                <li><input type="checkbox"  /><label >Module 1 - Closed!!!</label>
//                    <ul>
//                        <li><input type="checkbox" id="item-0-0" /><label for="item-0-0">Professors Notes</label>
//                            <ul>
//                                <li><a href="./">Item 1</a></li>
//                                <li><a href="./">Item 2</a></li>
//                                <li><a href="./">Item 3</a></li>
//                            </ul>
//                        </li>
//                        
//                                <li><a href="./">blog1 entries</a></li>
//                                <li><a href="./">bookmarks</a></li>
//                                <li><a href="./">discussions</a></li>
//                       
//                    </ul>
//               </ul>
//       </div>               
//         ');

?>

<?php

/*
 *   TODO :Note, this is a sucky way to do the CSS-- work through Matt's css tutorial plugin and fix this
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




$coursetree = ElggSession::offsetGet('currentcourse');
    
//Need to build the coursetree html with the appropriate class attributes so that the CSS can target it correctly and display
//it in a tree.

echo '<div class ="css-treeview">';
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
        echo elgg_echo('<li><a class = "indent" href = /elgg/courseview/contentpane/'.$coursetree [$row][subtype].'/'.$row.'>'.$coursetree[$row][label].'</a></li>');
    }
   
}
echo elgg_echo ('</div>')  ;  
 
?>

<?php
/**
 * Page Layout
 ************Changed for EasyTheme (line 25)****************
 * Contains CSS for the page shell and page layout
 *
 * Default layout: 990px wide, centered. Used in default page shell
 *
 */
?>


.elgg-page-default .elgg-page-header > .elgg-inner {
	
      // background-color: red;
	
}
.elgg-page-default {
	//min-width: 850px;
}


.elgg-sidebar {
 //background-color:yellow;
 //float:left;
 //box-shadow:2px 2px 2px black;
 }
 
 .elgg-sidebar {
	
}

.elgg-main {

//background-color:green;

}
//.elgg-menu-item-module2 {
//font-weight:bold;
//margin-left:8px;
}

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
                margin-left: 25px;
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
   
      background: url(<?php echo elgg_get_site_url(); ?>mod/courseview/icons.png) no-repeat;
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
            
            #editbox {
                border: solid 1px black;
                padding:10px;
                box-shadow:black 2px 2px 2px;
                margin:3px;
            }
            
            /* This will hide the edit course material unless the prof has checked the edit course checkbox.*/
            
            #editcourse {
                visibility:hidden;
                height:0px;
            }
            #editcoursecheckbox~label{
            color:red;
            }

            #editcoursecheckbox:checked ~#editcourse {
                visibility:visible;
                height:auto;
                color:blue;
  
            }
            
             .editcourse {
             float:left;
             width:30px;
             height:30px;
             
            }
            .uparrowcontainer, downarrowcontainer {
            display:block;
            }
            
            .uparrow {
                height:15px;
                width: 15px;
                background-color:blue;
                border: solid black;
                margin:3px;
                
            }
            .downarrow {
                height:15px;
                width: 15px;
                background-color:red;
                border: solid black;
                margin:3px;
            }
  
            #cvfolderdescription {
            font-size: 400%;
            text-align:center;
            }
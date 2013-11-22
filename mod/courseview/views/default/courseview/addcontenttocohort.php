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
    <?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
     echo '<br><br><h3 onclick = "showCVAdd ()" >Add this content to a CourseView module </h3><br>';
  echo "<div id ='addToCohort'>";
  
echo elgg_view_form('cvaddtocohorttreeview');
echo '</div>';
?>

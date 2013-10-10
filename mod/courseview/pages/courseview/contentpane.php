<!--<!DOCTYPE html>-->
<!--<html>
      <head>
            <title>HTML</title>
            <meta name="author" content="Rich Smith" />
           
      </head>
      <body>-->
            <?php
            
             echo elgg_echo ('In the content page---Menu item guid:  '.$page[1]);
//            $title = "View 2";
//            $user = elgg_get_logged_in_user_entity();
//        
//            $options = array(
//                'type' => 'object',
//                'subtype' => 'blog',
//                'owner_guid' => $user->guid,
//                'count' => true,
//            );
//         
             //how do I pass the object guid to the view?
             
            $content = elgg_view ('courseview/contentpane');
            //$content += 'I am in the contentpane page...';
            $vars = array('content' => $content,);

            $body = elgg_view_layout('one_sidebar', $vars);
            
         
            
            echo elgg_view_page($title, $body);
            
            
//            $testrs= get_input('rich');
//            echo $testrs[1].'...'.$testrs[2];
//            
          //   echo (elgg_view('blog/all'));
            ?>
<!--      </body>
</html> -->


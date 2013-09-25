<!DOCTYPE html>
<html>
      <head>
            <title>HTML</title>
            <meta name="author" content="Rich Smith" />
            <link rel="stylesheet" href="css/view2.css"/>
      </head>
      <body>
            <?php
            $title = "View 2";
            $user = elgg_get_logged_in_user_entity();
        
            $options = array(
                'type' => 'object',
                'subtype' => 'blog',
                'owner_guid' => $user->guid,
                'count' => true,
            );
         
            $content = elgg_view ('courseview/listview');
            //$content += 'I am in the listview page...';
            $vars = array('content' => $content,);

            $body = elgg_view_layout('one_sidebar', $vars);
            
         
            
            echo elgg_view_page($title, $body);
            echo 'I AM IN LISTVIEW page....why???';
            
            $testrs= get_input('rich');
            echo $testrs[1].'...'.$testrs[2];
            
             echo (elgg_view('blog/all'));
            ?>
      </body>
</html> 


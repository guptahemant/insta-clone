<?php

namespace Drupal\profile_block\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use \Drupal\node\Entity\Node; 

/** 
 *
 * @Block(
 *   id = "user_profile_block",
 *   admin_label = @Translation("user profile block"),
 *   category = @Translation("custom World"),
 * )
 */
class user_profile_block extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $db = \Drupal::database(); 

      //for username
      $user = \Drupal::routeMatch()->getParameter('user');
      $uid = $user->id();
 
      $query1 = $db->select('users_field_data', 'e');
      $query1->condition('e.uid', $uid );
      $query1->fields('e'); 
      $usrn = $query1->execute()->fetchAll(); 

      foreach($usrn as $row){
        $uname = $row->name;
      }

      //for post count
      $post_count = 0;

      $query2 = $db->select('node_field_data', 'n');
      $query2->condition('n.uid', $uid );
      $query2->condition('n.status', 1 );
      $query2->fields('n'); 
      $posts = $query2->execute()->fetchAll();

      foreach($posts as $row){
        $post_count++;
      } 

      //for followers count
      $query3 = $db->select('flag_counts', 'f');
      $query3->condition('f.entity_id', $uid );
      $query3->fields('f'); 
      $followers = $query3->execute()->fetchAll();

      $followers_count = 0;
      foreach($followers as $row){
        $followers_count = $row->count;
      }  

      //for following count
      $following_count = 0;

      $query4 = $db->select('flagging', 'fl');
      $query4->condition('fl.uid', $uid );
      $query4->condition('fl.flag_id', 'following' );
      $query4->fields('fl'); 
      $following = $query4->execute()->fetchAll();

      foreach($following as $row){
        $following_count++;
      } 

      //for bio
      $query5 = $db->select('user__field_bio', 'b');
      $query5->condition('b.entity_id', $uid );
      $query5->fields('b'); 
      $result5 = $query5->execute()->fetchAll(); 

      foreach($result5 as $row){
        $bio = $row->field_bio_value;  
      } 

      //for full name
      $query6 = $db->select('user__field_full_name', 'fn');
      $query6->condition('fn.entity_id', $uid );
      $query6->fields('fn'); 
      $result6 = $query6->execute()->fetchAll(); 

      foreach($result6 as $row){
        $name = $row->field_full_name_value;  
      }

      
      $profile_top[] = [ 
        t("<a class='uname'><h4>$uname</h4></a>
        <div class='set_tab'><a href='edit' class='edit_profile'>Edit Profile</a> 
        <a href='settings' class='settings'>Settings</a></div>"), 
      ]; 
      
      $profile_flag[] = [   
        t("<span>$post_count<a> posts</a></span>
        <span>$followers_count <a class='use-ajax' data-dialog-options='{&quot;width&quot;:400,
         &quot;title&quot;:&quot;Followers&quot;}'
         data-dialog-type='modal' href='../user/$uid/followers'> followers</a> </span>  
        <span>$following_count <a class='use-ajax' data-dialog-options='{&quot;width&quot;:400,
         &quot;title&quot;:&quot;Following&quot;}'
         data-dialog-type='modal' href='../user/$uid/following'> following</a></span>"), 
    ];
      
      $profile_bottom[] = [ 
        t("<p class='name'>$name</p>
        <p class='bio'>$bio</p>"),
      ];
          

    return [
      '#theme' => 'user-profile-block',
      '#profile_top' => $profile_top,
      '#profile_flag' => $profile_flag,
      '#profile_bottom' => $profile_bottom, 
    ];
  }
  
  public function getCacheMaxAge() {
    return 0;
  }

}
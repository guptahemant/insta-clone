<?php

namespace Drupal\profile_block\Controller;
 
use Drupal\Core\Url;
use Drupal\Core\Link;
use Drupal\Component\Serialization\Json;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Connection;
use Symfony\Component\DependencyInjection\ContainerInterface;

class controller extends ControllerBase
{
  /**
   * @var \Drupal\Core\Database\Connection
   */
  private $connection;
  public function __construct(Connection $connection) 
  {
    $this->connection = $connection;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) 
  {
    return new static(
      $container->get('database')
    );
  }

  public function followers_modal()
  { 
    $user = \Drupal::routeMatch()->getParameter('user_id');
    $uid = $user->id();
    $query = $this->connection->select('flagging', 'f');
    $query->condition('f.entity_id', $uid);
    $query->condition('f.flag_id', 'following');
    $query->condition('f.entity_type', 'user');
    $query->fields('f');
    $fuid = $query->execute()->fetchAll();
    $userrec = [];  
    
    foreach ($fuid as $row) 
    {
      $fid = $row->uid;
      $query0 = $this->connection->select('user__user_picture', 'i');
      $query0->condition('i.entity_id', $fid); 
      $query0->fields('i');
      $result_img_id = $query0->execute()->fetchAll();

      foreach ($result_img_id as $row) 
      {
        $picture_id = $row->user_picture_target_id;          
        $query1 = $this->connection->select('file_managed', 'fm');
        $query1->condition('fm.fid', $picture_id); 
        $query1->fields('fm');
        $result_img_id2 = $query1->execute()->fetchAll();

        foreach ($result_img_id2 as $row) 
        {
          $uri = file_create_url($row->uri);
        }
      }

      $post_count = 0;
      $query2 = $this->connection->select('node_field_data', 'n');
      $query2->condition('n.uid', $fid );
      $query2->condition('n.status', 1 );
      $query2->fields('n'); 
      $posts = $query2->execute()->fetchAll();

      foreach($posts as $row){
        $post_count++;
      } 

      $query3 = $this->connection->select('flagging', 'f');
      $query3->condition('f.entity_id', $fid );
      $query3->condition('f.flag_id', 'following' );
      $query3->fields('f'); 
      $followers = $query3->execute()->fetchAll();
      $followers_count = 0;
      
      foreach($followers as $row)
      {
        $followers_count++;
      }  

      $following_count = 0;
      $query4 = $this->connection->select('flagging', 'fl');
      $query4->condition('fl.uid', $fid );
      $query4->condition('fl.flag_id', 'following' );
      $query4->fields('fl'); 
      $following = $query4->execute()->fetchAll();

      foreach($following as $row)
      {
        $following_count++;
      } 

      $uname = \Drupal::entityTypeManager()->getStorage('user')->load($fid)->get('name')->value;
      $query6 = $this->connection->select('user__field_full_name', 'fn');
      $query6->condition('fn.entity_id', $fid );
      $query6->fields('fn'); 
      $result6 = $query6->execute()->fetchAll(); 

      foreach($result6 as $row)
      {
        $name = $row->field_full_name_value;  
      }
  
      $query7 = $this->connection->select('node_field_data', 'nd');
      $query7->condition('nd.uid', $fid); 
      $query7->condition('nd.status', 1); 
      $query7->condition('nd.type', 'article'); 
      $query7->fields('nd');
      $result7 = $query7->execute()->fetchAll();
      $post_uri_all ='';
  
      foreach ($result7 as $row) 
      {
        $img_nid = $row->nid;    
        $query8 = $this->connection->select('node__field_image', 'ni');
        $query8->condition('ni.entity_id', $img_nid); 
        $query8->fields('ni');
        $result8 = $query8->execute()->fetchAll();

        foreach ($result8 as $row) 
        {
          $img_target_id = $row->field_image_target_id;
          $query9 = $this->connection->select('file_managed', 'fm');
          $query9->condition('fm.fid', $img_target_id); 
          $query9->condition('fm.uid', $fid); 
          $query9->fields('fm');
          $result9 = $query9->execute()->fetchAll(); 

          foreach ($result9 as $row)
          {
            $post_uri = file_create_url($row->uri);
            $post_uri_all = t("<a href='../node/$img_nid' class='posts_img'><img src='$post_uri'></a>") . ' ' . $post_uri_all;        
          }
        }
      } 

      $flag_txt = 'Instagram wont tell ' . $uname . ' they were removed from your followers'; 
      $remove_link = Url::fromRoute('profile_block.remove_follower',['user_id' => $fid]);
      $remove_link->setOptions([
        'attributes' => [
          'class' => ['use-ajax', 'button', 'button--small'],
          'data-dialog-type' => 'modal',
          'data-dialog-options' => Json::encode(['width' => 400, 'title'=> 'Followers']),
        ]
      ]);

      $record=[
        '#theme' => 'flag-modal',  
        '#uname' => $uname, 
        '#uri' => $uri, 
        '#name' => $name,  
        '#post_count' => $post_count, 
        '#followers_count' => $followers_count, 
        '#following_count' => $following_count, 
        '#post_uri_all' => $post_uri_all, 
        '#link' => 'Remove', 
        '#flag_txt' => t("<h2>Remove Follower?</h2><p class='remove_txt'>$flag_txt</p>"),
        '#flag_link' => Link::fromTextAndUrl(t('Remove'), $remove_link)->toString(),
      ];
      $userrec = [$userrec , $record] ;   
    }
    return $userrec;
  }

  public function remove_follower()
  {
    $user = \Drupal::routeMatch()->getParameter('user_id');
    $uid = $user->id();
    $current_user = \Drupal\user\Entity\User::load(\Drupal::currentUser()->id());
    $current_user_uid = $current_user->get('uid')->value;
    $query10 = $this->connection->delete('flagging');
    $query10->condition('uid', $uid); 
    $query10->condition('entity_id', $current_user_uid);  
    $query10->execute(); 
  }
}

<?php

namespace Drupal\profile_block\Service;

use Drupal\Core\Entity\EntityTypeManager;
use Drupal\Core\Database\Connection;

/**
 * The UserInfo service to get user data.
 */
class UserInfo {

  /**
   * A variable to create a connection.
   *
   * @var \Drupal\Core\Database\Connection
   */
  private $connection;

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManager
   */
  protected $entityTypeManager;

  /**
   * To initiate the database.
   *
   * @param \Drupal\Core\Database\Connection $connection
   *   The database connection to be used.
   * @param \Drupal\Core\Entity\EntityTypeManager $entityTypeManager
   *   The entity type manager.
   */
  public function __construct(Connection $connection, EntityTypeManager $entityTypeManager) {
    $this->connection = $connection;
    $this->entityTypeManager = $entityTypeManager;
  }

  /**
   * Function that returns the user id.
   */
  public function userid($fid) {
    $query = $this->connection->select('flagging', 'f');
    $query->condition('f.uid', $fid);
    $query->condition('f.flag_id', 'following');
    $query->fields('f');
    $fuid = $query->execute()->fetchAll();

    return $fuid;
  }

  /**
   * Function that returns the user picture url.
   */
  public function userpicture($fid) {
    $query0 = $this->connection->select('user__user_picture', 'i');
    $query0->condition('i.entity_id', $fid);
    $query0->fields('i');
    $result_img_id = $query0->execute()->fetchAll();

    foreach ($result_img_id as $row) {
      $picture_id = $row->user_picture_target_id;
      $query1 = $this->connection->select('file_managed', 'fm');
      $query1->condition('fm.fid', $picture_id);
      $query1->fields('fm');
      $result_img_id2 = $query1->execute()->fetchAll();

      foreach ($result_img_id2 as $row) {
        $uri = file_create_url($row->uri);
      }
    }
    return $uri;
  }

  /**
   * Function that returns user's post count.
   */
  public function postcount($fid) {
    $post_count = 0;
    $query2 = $this->connection->select('node_field_data', 'n');
    $query2->condition('n.uid', $fid);
    $query2->condition('n.type', 'article');
    $query2->fields('n');
    $post_count = $query2->countQuery()->execute()->fetchField();
    return $post_count;
  }

  /**
   * Function that returns user's followers count.
   */
  public function followerscount($fid) {
    $followers_count = $this->entityTypeManager
      ->getStorage('flagging')
      ->getQuery()
      ->condition('entity_id', $fid)
      ->condition('flag_id', 'following')
      ->count()->execute();
    return $followers_count;
  }

  /**
   * Function that returns user's following count.
   */
  public function followingcount($fid) {
    $following_count = $this->entityTypeManager
      ->getStorage('flagging')
      ->getQuery()
      ->condition('uid', $fid)
      ->condition('flag_id', 'following')
      ->count()->execute();
    return $following_count;
  }

  /**
   * Function that returns user's username.
   */
  public function username($fid) {
    $uname = $this->entityTypeManager->getStorage('user')->load($fid)->get('name')->value;
    return $uname;
  }

  /**
   * Function that returns user's full name.
   */
  public function fullname($fid) {
    $query6 = $this->connection->select('user__field_full_name', 'fn');
    $query6->condition('fn.entity_id', $fid);
    $query6->fields('fn');
    $result6 = $query6->execute()->fetchAll();

    foreach ($result6 as $row) {
      $name = $row->field_full_name_value;
    }
    return $name;
  }

  /**
   * Function that returns user posts (images).
   */
  public function userposts($fid) {
    $query7 = $this->connection->select('node_field_data', 'nd');
    $query7->condition('nd.uid', $fid);
    $query7->condition('nd.status', 1);
    $query7->condition('nd.type', 'article');
    $query7->fields('nd');
    $result7 = $query7->execute()->fetchAll();

    $post_uri_all = '';
    foreach ($result7 as $row) {
      $img_nid = $row->nid;

      $query8 = $this->connection->select('node__field_image', 'ni');
      $query8->condition('ni.entity_id', $img_nid);
      $query8->fields('ni');
      $result8 = $query8->execute()->fetchAll();

      foreach ($result8 as $row) {
        $img_target_id = $row->field_image_target_id;

        $query9 = $this->connection->select('file_managed', 'fm');
        $query9->condition('fm.fid', $img_target_id);
        $query9->condition('fm.uid', $fid);
        $query9->fields('fm');
        $result9 = $query9->execute()->fetchAll();

        foreach ($result9 as $row) {
          $post_uri = file_create_url($row->uri);
          $str = "<a href='../node/" . $img_nid . "' class='posts_img'><img src='" . $post_uri . "'></a>";
          $post_uri_all = $str . ' ' . $post_uri_all;
        }
      }
    }
    return $post_uri_all;
  }

}

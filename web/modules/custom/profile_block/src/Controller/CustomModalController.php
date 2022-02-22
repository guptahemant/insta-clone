<?php

namespace Drupal\profile_block\Controller;

use Drupal\Core\Url;
use Drupal\Core\Link;
use Drupal\Component\Serialization\Json;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Connection;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Entity\EntityTypeManager;
use Drupal\Core\Routing\CurrentRouteMatch;
use Drupal\profile_block\Service\UserInfo;

/**
 * A controller Class for the Follwing Modal.
 */
class CustomModalController extends ControllerBase {

  /**
   * A variable to create a connection.
   *
   * @var \Drupal\Core\Database\Connection
   */
  private $connection;

  /**
   * The current route match.
   *
   * @var \Drupal\Core\Routing\CurrentRouteMatch
   */
  protected $currentRouteMatch;

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManager
   */
  protected $entityTypeManager;

  /**
   * Provides user data.
   *
   * @var \Drupal\profile_block\Service\UserInfo
   */
  private $userInfo;

  /**
   * To initiate the database.
   *
   * @param \Drupal\Core\Database\Connection $connection
   *   The database connection to be used.
   * @param \Drupal\Core\Routing\CurrentRouteMatch $currentRouteMatch
   *   The current route match.
   * @param \Drupal\Core\Entity\EntityTypeManager $entityTypeManager
   *   The entity type manager.
   * @param \Drupal\profile_block\Service\UserInfo $userInfo
   *   Provides user data.
   */
  public function __construct(Connection $connection, CurrentRouteMatch $currentRouteMatch, EntityTypeManager $entityTypeManager, UserInfo $userInfo) {
    $this->connection = $connection;
    $this->currentRouteMatch = $currentRouteMatch;
    $this->entityTypeManager = $entityTypeManager;
    $this->userInfo = $userInfo;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('database'),
      $container->get('current_route_match'),
      $container->get('entity_type.manager'),
      $container->get('user_info')
    );
  }

  /**
   * To open the modal of the following userspage.
   */
  public function followingmodal() {
    $user = $this->currentRouteMatch->getParameter('user_id');
    $uid = $user->id();
    $fuid = $this->userInfo->userid($uid);

    $userrec = [];
    foreach ($fuid as $row) {
      $fid = $row->entity_id;

      $uri = $this->userInfo->userpicture($fid);
      $post_count = $this->userInfo->postcount($fid);
      $followers_count = $this->userInfo->followerscount($fid);
      $following_count = $this->userInfo->followingcount($fid);
      $uname = $this->userInfo->username($fid);
      $name = $this->userInfo->fullname($fid);
      $post_uri_all = $this->userInfo->userposts($fid);

      $unfollow_link = Url::fromRoute('profile_block.unfollow', ['user_id' => $fid]);
      $unfollow_link->setOptions([
        'attributes' => [
          'class' => ['use-ajax', 'button', 'button--small'],
          'data-dialog-type' => 'modal',
          'data-dialog-options' => Json::encode([
            'width' => 400,
            'title' => 'Unfollow',
          ]),
        ],
      ]);

      $record = [
        '#theme' => 'flag-modal',
        '#uri' => $uri,
        '#uname' => $uname,
        '#name' => $name,
        '#post_count' => $post_count,
        '#followers_count' => $followers_count,
        '#following_count' => $following_count,
        '#post_uri_all' => $post_uri_all,
        '#link' => $this->t('Following'),
        '#flag_txt_unfollow' => $this->t("If you change your mind, you'll have to request to follow @@uname again.", ['@uname' => $uname]),
        '#flag_link' => Link::fromTextAndUrl($this->t('Unfollow'), $unfollow_link)->toString(),
      ];
      $userrec = [$userrec , $record];
    }
    return $userrec;
  }

  /**
   * To initiate the unfollow flag.
   */
  public function unfollow() {
    $user = $this->currentRouteMatch->getParameter('user_id');
    $uid = $user->id();
    $current_user = $this->entityTypeManager->getStorage('user')->load($this->currentUser()->id());
    $current_user_uid = $current_user->get('uid')->value;
    $query10 = $this->connection->delete('flagging');
    $query10->condition('uid', $current_user_uid);
    $query10->condition('entity_id', $uid);
    $query10->execute();
  }

}

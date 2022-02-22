<?php

namespace Drupal\profile_block\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Url;
use Drupal\Core\Link;
use Drupal\Component\Serialization\Json;
use Drupal\Core\Database\Connection;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Routing\CurrentRouteMatch;
use Drupal\user\UserStorageInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\profile_block\Service\UserInfo;

/**
 * A block that holds the id and admin label for the logged in user.
 *
 * @Block(
 *   id = "user_profile_block",
 *   admin_label = @Translation("user profile block"),
 *   category = @Translation("custom World"),
 * )
 */
class UserProfileBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * A connection class with database.
   *
   * @var \Drupal\Core\Database\Connection
   */
  protected $connection = NULL;

  /**
   * The current route match.
   *
   * @var \Drupal\Core\Routing\CurrentRouteMatch
   */
  protected $currentRouteMatch;

  /**
   * The current account stored.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $account;

  /**
   * For user entity storage classes.
   *
   * @var \Drupal\user\UserStorageInterface
   */
  protected $userStorage;

  /**
   * Provides user data.
   *
   * @var \Drupal\profile_block\Service\UserInfo
   */
  private $userInfo;

  /**
   * The database connection to be used.
   *
   * @param \Drupal\Core\Database\Connection $connection
   *   The database connection to be used.
   * @param \Drupal\Core\Routing\CurrentRouteMatch $currentRouteMatch
   *   The current route match.
   * @param \Drupal\Core\Session\AccountProxyInterface $account
   *   The current account stored.
   * @param \Drupal\user\UserStorageInterface $userStorage
   *   For user entity storage classes.
   * @param \Drupal\profile_block\Service\UserInfo $userInfo
   *   Provides user data.
   */

  /**
   * Constructor that's expecting the object provided by create().
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, Connection $connection, CurrentRouteMatch $currentRouteMatch, AccountProxyInterface $account, UserStorageInterface $userStorage, UserInfo $userInfo) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->connection = $connection;
    $this->currentRouteMatch = $currentRouteMatch;
    $this->account = $account;
    $this->userStorage = $userStorage;
    $this->userInfo = $userInfo;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('database'),
      $container->get('current_route_match'),
      $container->get('current_user'),
      $container->get('entity_type.manager')->getStorage('user'),
      $container->get('user_info')
    );
  }

  /**
   * To display user profile data.
   */
  public function build() {

    $user = $this->currentRouteMatch->getParameter('user');
    $uid = $user->id();

    $post_count = $this->userInfo->postcount($uid);
    $followers_count = $this->userInfo->followerscount($uid);
    $following_count = $this->userInfo->followingcount($uid);
    $uname = $this->userInfo->username($uid);
    $name = $this->userInfo->fullname($uid);

    $query5 = $this->connection->select('user__field_bio', 'b');
    $query5->condition('b.entity_id', $uid);
    $query5->fields('b');
    $result5 = $query5->execute()->fetchAll();

    foreach ($result5 as $row) {
      $bio = $row->field_bio_value;
    }

    $following_link_url = Url::fromRoute('profile_block.following_modal', ['user_id' => $uid]);
    $following_link_url->setOptions([
      'attributes' => [
        'class' => ['use-ajax', 'button', 'button--small'],
        'data-dialog-type' => 'modal',
        'data-dialog-options' => Json::encode([
          'width' => 400,
          'title' => 'Following',
        ]),
      ],
    ]);

    $followers_link_url = Url::fromRoute('profile_block.followers_modal', ['user_id' => $uid]);
    $followers_link_url->setOptions([
      'attributes' => [
        'class' => ['use-ajax', 'button', 'button--small'],
        'data-dialog-type' => 'modal',
        'data-dialog-options' => Json::encode([
          'width' => 400,
          'title' => 'Followers',
        ]),
      ],
    ]);

    $current_user = $this->userStorage->load($this->account->id());
    $current_user_uid = $current_user->get('uid')->value;

    if ($uid == $current_user_uid) {
      $display_other = 'display-none';
      $display_current = 'flex';
    }
    else {
      $display_other = 'display-flex';
      $display_current = 'none';
    }

    return [
      '#theme' => 'user-profile-block',
      '#uname' => $uname,
      '#display_current' => $display_current,
      '#display_other' => $display_other,
      '#post_count' => $post_count,
      '#followers_count' => $followers_count,
      '#following_count' => $following_count,
      '#name' => $name,
      '#bio' => $bio,
      '#following_link' => Link::fromTextAndUrl($this->t('following'), $following_link_url)->toString(),
      '#followers_link' => Link::fromTextAndUrl($this->t('followers'), $followers_link_url)->toString(),
      '#attached' => ['library' => ['core/drupal.dialog.ajax']],
      '#cache' => [
        'max-age' => 0,
        'contexts' => [],
      ],
    ];
  }

}

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
   * The database connection to be used.
   *
   * @param \Drupal\Core\Database\Connection $connection
   *   The database connection to be used.
   * @param \Drupal\Core\Routing\CurrentRouteMatch $currentRouteMatch
   *   The current route match.
   */

  /**
   * Constructor that's expecting the object provided by create().
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, Connection $connection, CurrentRouteMatch $currentRouteMatch) {
    // Instantiate the BlockBase parent first.
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    // Then save the store service passed to this constructor
    // via dependency injection.
    $this->connection = $connection;
    $this->currentRouteMatch = $currentRouteMatch;
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
      $container->get('current_route_match')
    );
  }

  /**
   * To display user profile data.
   */
  public function build() {

    // For username.
    $user = $this->currentRouteMatch->getParameter('user');
    $uid = $user->id();

    $query1 = $this->connection->select('users_field_data', 'e');
    $query1->condition('e.uid', $uid);
    $query1->fields('e');
    $usrn = $query1->execute()->fetchAll();

    foreach ($usrn as $row) {
      $uname = $row->name;
    }

    // For post count.
    $post_count = 0;

    $query2 = $this->connection->select('node_field_data', 'n');
    $query2->condition('n.uid', $uid);
    $query2->condition('n.status', 1);
    $query2->fields('n');
    $posts = $query2->execute()->fetchAll();

    foreach ($posts as $row) {
      $post_count++;
    }

    $query3 = $this->connection->select('flagging', 'f');
    $query3->condition('f.entity_id', $uid);
    $query3->condition('f.flag_id', 'following');
    $query3->fields('f');
    $followers = $query3->execute()->fetchAll();

    $followers_count = 0;
    foreach ($followers as $row) {
      $followers_count++;
    }

    // For following count.
    $following_count = 0;

    $query4 = $this->connection->select('flagging', 'fl');
    $query4->condition('fl.uid', $uid);
    $query4->condition('fl.flag_id', 'following');
    $query4->fields('fl');
    $following = $query4->execute()->fetchAll();

    foreach ($following as $row) {
      $following_count++;
    }

    // For bio.
    $query5 = $this->connection->select('user__field_bio', 'b');
    $query5->condition('b.entity_id', $uid);
    $query5->fields('b');
    $result5 = $query5->execute()->fetchAll();

    foreach ($result5 as $row) {
      $bio = $row->field_bio_value;
    }

    // For full name.
    $query6 = $this->connection->select('user__field_full_name', 'fn');
    $query6->condition('fn.entity_id', $uid);
    $query6->fields('fn');
    $result6 = $query6->execute()->fetchAll();

    foreach ($result6 as $row) {
      $name = $row->field_full_name_value;
    }

    $link_url1 = Url::fromRoute('profile_block.following_modal', [
      'user_id' => $uid,
    ]);
    $link_url1->setOptions([
      'attributes' => [
        'class' => ['use-ajax', 'button', 'button--small'],
        'data-dialog-type' => 'modal',
        'data-dialog-options' => Json::encode([
          'width' => 400,
          'title' => 'Following',
        ]),
      ],
    ]);

    $link_url2 = Url::fromRoute('profile_block.followers_modal', [
      'user_id' => $uid,
    ]);
    $link_url2->setOptions([
      'attributes' => [
        'class' => ['use-ajax', 'button', 'button--small'],
        'data-dialog-type' => 'modal',
        'data-dialog-options' => Json::encode([
          'width' => 400,
          'title' => 'Followers',
        ]),
      ],
    ]);

    return [
      '#theme' => 'user-profile-block',
      '#uname' => $uname,
      '#post_count' => $post_count,
      '#followers_count' => $followers_count,
      '#following_count' => $following_count,
      '#name' => $name,
      '#bio' => $bio,

      '#markup1' => Link::fromTextAndUrl(
              $this->t('following'),
              $link_url1
      )->toString(),
      '#markup2' => Link::fromTextAndUrl(
              $this->t('followers'),
              $link_url2
      )->toString(),
      '#attached' => ['library' => ['core/drupal.dialog.ajax']],
    ];
  }

  /**
   * A function to get max age.
   */
  public function getCacheMaxAge() {
    return 0;
  }

}

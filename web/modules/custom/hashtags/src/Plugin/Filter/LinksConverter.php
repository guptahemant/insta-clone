<?php

namespace Drupal\hashtags\Plugin\Filter;

use Drupal\Core\Link;
use Drupal\Core\Url;

/**
 * Helper class to parameters to callback function within preg_replace_callback.
 */
class LinksConverter {
  /**
   * Hashtag Ids property.
   *
   * @var array
   */
  private $hashtagsTids;

  /**
   * {@inheritdoc}
   */
  public function __construct($hashtagsTids) {
    $this->hashtagsTids = $hashtagsTids;
  }

  /**
   * {@inheritdoc}
   */
  public function replace($matches) {
    if (isset($this->hashtagsTids)) {
      $hashtagsTids = $this->hashtagsTids;
    }
    $first_delimeter = $matches[1] ?? '';
    $hashtag_name = $matches[3] ?? '';
    $hashtag_tid = $this->hashtagsTids[strtolower($hashtag_name)] ?? '';
    $hashtag_name = '#' . $hashtag_name;
    // Hashtag is not exists - show without link.
    if (empty($hashtag_tid)) {
      return $first_delimeter . $hashtag_name;
    }
    // Fatal error: [] operator not supported for strings in
    // /includes/common.inc on line 2442
    // Issue comes up when we try to bind attribute to link which has path
    // parameter of the current page............
    /*if ($_GET['q'] == 'taxonomy/term/'.$hashtag_tid) {
    $hashtag_link = l($hashtag_name, 'taxonomy/term/'.$hashtag_tid);
    } else {
    $hashtag_link = l($hashtag_name, 'taxonomy/term/'.$hashtag_tid,
    array('attributes' => array('class' => 'hashtag')));
    }*/
    $hashtag_link = Link::fromTextAndUrl($hashtag_name,
          Url::fromRoute('entity.taxonomy_term.canonical', ['taxonomy_term' => $hashtag_tid],
              ['attributes' => ['class' => 'hashtag']]))->toString();

    return $first_delimeter . $hashtag_link;
  }

}

<?php

namespace Drupal\link_icons\Entity;

use Drupal\Core\Config\Entity\ConfigEntityInterface;

/**
 * Provides an interface for defining a link icon service.
 */
interface LinkIconServiceInterface extends ConfigEntityInterface {

  /*
   * The settings for the service.
   *
   * @return array
   *   An array with the following keys:
   *     - "hostnames" - an array of the end of the hostname in the URL of the
   *        link, ex. 'google.com'
   *     - "class" - the HTML class to use in the generated link icon
   *     - "icon" - the ID of the main Font Awesome icon to use, ex. 'google'
   *     - "icon_style" - the style of the main Font Awesome icon to use, ex.
   *        'brand' or 'solid'
   *     - "icon_square" - the ID of the square version of the Font Awesome
   *         icon to use, ex. 'google-plus-square'
   *     - "icon_circle" - the ID of the circular version of the Font Awesome
   *         icon to use, ex. 'google-plus-circle'
   *     - "color" - the CSS color string to use for the icon, ex. 'black' or
   *         '#000000'
   */

}

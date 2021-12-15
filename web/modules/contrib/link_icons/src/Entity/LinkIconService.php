<?php

namespace Drupal\link_icons\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;

/**
 * Defines the link icon service entity.
 *
 * @ConfigEntityType(
 *   id = "link_icon_service",
 *   label = @Translation("Link icon service"),
 *   handlers = {
 *     "list_builder" = "Drupal\link_icons\Config\Entity\LinkIconServiceListBuilder",
 *     "form" = {
 *       "add" = "Drupal\link_icons\Form\LinkIconServiceForm",
 *       "edit" = "Drupal\link_icons\Form\LinkIconServiceForm",
 *       "delete" = "Drupal\link_icons\Form\LinkIconServiceFormDelete"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "link_icon_service",
 *   admin_permission = "administer site configuration",
 *   list_cache_tags = { "rendered" },
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/config/search/link_icon_services/{link_icon_service}",
 *     "add-form" = "/admin/config/search/link_icon_services/add",
 *     "edit-form" = "/admin/config/search/link_icon_services/{link_icon_service}/edit",
 *     "delete-form" = "/admin/config/search/link_icon_services/{link_icon_service}/delete",
 *     "collection" = "/admin/config/search/link_icon_services"
 *   },
 *   config_export = {
 *     "id",
 *     "label",
 *     "hostnames",
 *     "class",
 *     "icon",
 *     "icon_style",
 *     "icon_square",
 *     "icon_circle",
 *     "color"
 *   }
 * )
 */
class LinkIconService extends ConfigEntityBase implements LinkIconServiceInterface {

  /**
   * The link icon service ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The link icon service label.
   *
   * @var string
   */
  protected $label;

  /**
   * {@inheritdoc}
   */
  public function getCacheTagsToInvalidate() {
    return ['rendered'];
  }

}

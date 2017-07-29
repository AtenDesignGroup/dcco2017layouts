<?php

namespace Drupal\layout_entity\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the Layout Entity type entity.
 *
 * @ConfigEntityType(
 *   id = "layout_entity_type",
 *   label = @Translation("Layout Entity type"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\layout_entity\LayoutEntityTypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\layout_entity\Form\LayoutEntityTypeForm",
 *       "edit" = "Drupal\layout_entity\Form\LayoutEntityTypeForm",
 *       "delete" = "Drupal\layout_entity\Form\LayoutEntityTypeDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\layout_entity\LayoutEntityTypeHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "layout_entity_type",
 *   admin_permission = "administer site configuration",
 *   bundle_of = "layout_entity",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/layout_entity_type/{layout_entity_type}",
 *     "add-form" = "/admin/structure/layout_entity_type/add",
 *     "edit-form" = "/admin/structure/layout_entity_type/{layout_entity_type}/edit",
 *     "delete-form" = "/admin/structure/layout_entity_type/{layout_entity_type}/delete",
 *     "collection" = "/admin/structure/layout_entity_type"
 *   }
 * )
 */
class LayoutEntityType extends ConfigEntityBundleBase implements LayoutEntityTypeInterface {

  /**
   * The Layout Entity type ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Layout Entity type label.
   *
   * @var string
   */
  protected $label;

}

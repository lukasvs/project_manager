<?php

namespace Drupal\pm_project\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;
use Drupal\Core\Config\Entity\ConfigEntityInterface;

/**
 * Defines the PM project type entity.
 *
 * @ConfigEntityType(
 *   id = "pm_project_type",
 *   label = @Translation("PM project type"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\project_manager\PmTypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\pm_project\Form\PmProjectTypeEntityForm",
 *       "edit" = "Drupal\project_manager\Form\PmTypeEntityForm",
 *       "delete" = "Drupal\project_manager\Form\PmTypeDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "pm_project_type",
 *   admin_permission = "administer site configuration",
 *   bundle_of = "pm_project",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/project_manager/config/pm_project_type/{pm_project_type}",
 *     "add-form" = "/admin/project_manager/config/pm_project_type/add",
 *     "edit-form" = "/admin/project_manager/config/pm_project_type/{pm_project_type}/edit",
 *     "delete-form" = "/admin/project_manager/config/pm_project_type/{pm_project_type}/delete",
 *     "collection" = "/admin/project_manager/config/pm_project_type"
 *   }
 * )
 */
class PmProjectType extends ConfigEntityBundleBase implements ConfigEntityInterface {

  /**
   * The PM project type ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The PM project type label.
   *
   * @var string
   */
  protected $label;

}

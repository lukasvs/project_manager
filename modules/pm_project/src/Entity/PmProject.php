<?php

namespace Drupal\pm_project\Entity;

use Drupal\project_manager\Entity\PmContentEntityBase;
use Drupal\project_manager\Entity\PmContentEntityBaseInterface;

/**
 * Defines the PM project entity.
 *
 * @ingroup project_manager
 *
 * @ContentEntityType(
 *   id = "pm_project",
 *   label = @Translation("PM project"),
 *   bundle_label = @Translation("PM project type"),
 *   show_revision_ui = TRUE,
 *   handlers = {
 *     "storage" = "Drupal\project_manager\PmStorage",
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\project_manager\PmContentListBuilder",
 *     "views_data" = "Drupal\views\EntityViewsData",
 *     "translation" = "Drupal\content_translation\ContentTranslationHandler",
 *     "form" = {
 *       "default" = "Drupal\project_manager\Form\PmContentEntityForm",
 *       "add" = "Drupal\project_manager\Form\PmContentEntityForm",
 *       "edit" = "Drupal\project_manager\Form\PmContentEntityForm",
 *       "delete" = "Drupal\Core\Entity\ContentEntityDeleteForm",
 *     },
 *     "access" = "Drupal\project_manager\PmAccessControlHandler",
 *     "route_provider" = {
 *       "html" = "Drupal\pm_project\PmProjectHtmlRouteProvider",
 *     },
 *   },
 *   base_table = "pm_project",
 *   data_table = "pm_project_field_data",
 *   revision_table = "pm_project_revision",
 *   revision_data_table = "pm_project_field_revision",
 *   translatable = TRUE,
 *   admin_permission = "administer pm_project entities",
 *   entity_keys = {
 *     "id" = "id",
 *     "revision" = "vid",
 *     "bundle" = "type",
 *     "label" = "name",
 *     "uuid" = "uuid",
 *     "uid" = "user_id",
 *     "langcode" = "langcode",
 *     "published" = "status",
 *   },
 *   revision_metadata_keys = {
 *     "revision_user" = "revision_user",
 *     "revision_created" = "revision_created",
 *     "revision_log_message" = "revision_log_message",
 *   },
 *   links = {
 *     "canonical" = "/project_manager/pm_project/{pm_project}",
 *     "add-page" = "/project_manager/pm_project/add",
 *     "add-form" = "/project_manager/pm_project/add/{pm_project_type}",
 *     "edit-form" = "/project_manager/pm_project/{pm_project}/edit",
 *     "delete-form" = "/project_manager/pm_project/{pm_project}/delete",
 *     "version-history" = "/project_manager/pm_project/{pm_project}/revisions",
 *     "revision" = "/project_manager/pm_project/{pm_project}/revisions/{revision}/view",
 *     "revision_revert" = "/project_manager/pm_project/{pm_project}/revisions/{revision}/revert",
 *     "revision_delete" = "/project_manager/pm_project/{pm_project}/revisions/{revision}/delete",
 *     "translation_revert" = "/project_manager/pm_project/{pm_project}/revisions/{revision}/revert/{langcode}",
 *     "collection" = "/project_manager/pm_project",
 *   },
 *   bundle_entity_type = "pm_project_type",
 *   field_ui_base_route = "entity.pm_project_type.edit_form"
 * )
 */
class PmProject extends PmContentEntityBase implements PmContentEntityBaseInterface {

}

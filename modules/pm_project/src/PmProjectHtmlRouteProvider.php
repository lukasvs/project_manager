<?php

namespace Drupal\pm_project;

use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\Routing\AdminHtmlRouteProvider;
use Drupal\project_manager\PmHtmlRouteProvider;
use Symfony\Component\Routing\Route;

/**
 * Provides routes for PM project entities.
 *
 * @see \Drupal\project_manager\PmHtmlRouteProvider
 * @see \Drupal\Core\Entity\Routing\DefaultHtmlRouteProvider
 */
class PmProjectHtmlRouteProvider extends PmHtmlRouteProvider {

  /**
   * {@inheritdoc}
   */
  public function getRoutes(EntityTypeInterface $entity_type) {
    $collection = parent::getRoutes($entity_type);

    $entity_type_id = $entity_type->id();

    // Collection route for PM entity need see in the admin interface.
    $collection
      ->get("entity.{$entity_type_id}.canonical")
       ->setOption('_admin_route', TRUE);

    $collection
      ->get("entity.{$entity_type_id}.collection")
       ->setOption('_admin_route', TRUE);

    return $collection;
  }

  /**
   * Gets the version history route.
   *
   * @param \Drupal\Core\Entity\EntityTypeInterface $entity_type
   *   The entity type.
   *
   * @return \Symfony\Component\Routing\Route|null
   *   The generated route, if available.
   */
  protected function getHistoryRoute(EntityTypeInterface $entity_type) {
    if ($entity_type->hasLinkTemplate('version-history')) {      
      $route = new Route($entity_type->getLinkTemplate('version-history'));
      $route
        ->setDefaults([
          '_title' => "{$entity_type->getLabel()} revisions",
          '_controller' => '\Drupal\pm_project\Controller\PmProjectController::revisionOverview',
        ])
        ->setRequirement('_permission', 'access ' . $entity_type->id() . ' revisions')
        ->setOption('_admin_route', TRUE);

      return $route;
    }
  }

  /**
   * Gets the revision route.
   *
   * @param \Drupal\Core\Entity\EntityTypeInterface $entity_type
   *   The entity type.
   *
   * @return \Symfony\Component\Routing\Route|null
   *   The generated route, if available.
   */
  protected function getRevisionRoute(EntityTypeInterface $entity_type) {
    if ($entity_type->hasLinkTemplate('revision')) {
      $route = new Route($entity_type->getLinkTemplate('revision'));
      $route
        ->setDefaults([
          '_controller' => '\Drupal\pm_project\Controller\PmProjectController::revisionShow',
          '_title_callback' => '\Drupal\pm_project\Controller\PmProjectController::revisionPageTitle',
        ])
        ->setRequirement('_permission', 'access ' . $entity_type->id() . ' revisions')
        ->setOption('_admin_route', TRUE);

      return $route;
    }
  }

}

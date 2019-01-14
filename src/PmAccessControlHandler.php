<?php

namespace Drupal\project_manager;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the an entity.
 *
 * @see \Drupal\project_manager\Entity\PmProject.
 */
class PmAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\project_manager\Entity\PmContentEntityBaseInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished ' . $entity->getEntityTypeId() . ' entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published ' . $entity->getEntityTypeId() . ' entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit ' . $entity->getEntityTypeId() . ' entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete ' . $entity->getEntityTypeId() . ' entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add ' . $this->entityTypeId . ' entities');
  }

}

<?php

namespace Drupal\project_manager;

use Drupal\Core\Entity\Sql\SqlContentEntityStorage;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\project_manager\Entity\PmContentEntityBaseInterface;

/**
 * Defines the storage handler class for an entities.
 *
 * This extends the base storage class, adding required special handling for
 * An entities.
 *
 * @ingroup project_manager
 */
class PmStorage extends SqlContentEntityStorage implements PmStorageInterface {

  /**
   * {@inheritdoc}
   */
  public function revisionIds(PmContentEntityBaseInterface $entity) {
    return $this->database->query(
      'SELECT vid FROM ' . $entity->getEntityTypeId() . '{_revision} WHERE id=:id ORDER BY vid',
      [':id' => $entity->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function userRevisionIds(AccountInterface $account) {
    return $this->database->query(
      'SELECT vid FROM ' . $entity->getEntityTypeId() . '{_field_revision} WHERE uid = :uid ORDER BY vid',
      [':uid' => $account->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function countDefaultLanguageRevisions(PmContentEntityBaseInterface $entity) {
    return $this->database->query('SELECT COUNT(*) FROM ' . $entity->getEntityTypeId() . '{_field_revision} WHERE id = :id AND default_langcode = 1', [':id' => $entity->id()])
      ->fetchField();
  }

  /**
   * {@inheritdoc}
   */
  public function clearRevisionsLanguage(LanguageInterface $language) {
    return $this->database->update($this->getRevisionTable())
      ->fields(['langcode' => LanguageInterface::LANGCODE_NOT_SPECIFIED])
      ->condition('langcode', $language->getId())
      ->execute();
  }

}

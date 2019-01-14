<?php

namespace Drupal\project_manager;

use Drupal\Core\Entity\ContentEntityStorageInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\project_manager\Entity\PmContentEntityBaseInterface;

/**
 * Defines the storage handler class for an entities.
 *
 * This extends the base storage class, adding required special handling for
 * an entities.
 *
 * @ingroup project_manager
 */
interface PmStorageInterface extends ContentEntityStorageInterface {

  /**
   * Gets a list of an entity revision IDs for a specific entity.
   *
   * @param \Drupal\project_manager\Entity\PmContentEntityBaseInterface $entity
   *   The an entity.
   *
   * @return int[]
   *   An entity revision IDs (in ascending order).
   */
  public function revisionIds(PmContentEntityBaseInterface $entity);

  /**
   * Gets a list of revision IDs having a given user as an entity author.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The user entity.
   *
   * @return int[]
   *   An entity revision IDs (in ascending order).
   */
  public function userRevisionIds(AccountInterface $account);

  /**
   * Counts the number of revisions in the default language.
   *
   * @param \Drupal\project_manager\Entity\PmContentEntityBaseInterface $entity
   *   The PM project entity.
   *
   * @return int
   *   The number of revisions in the default language.
   */
  public function countDefaultLanguageRevisions(PmContentEntityBaseInterface $entity);

  /**
   * Unsets the language for all an entities with the given language.
   *
   * @param \Drupal\Core\Language\LanguageInterface $language
   *   The language object.
   */
  public function clearRevisionsLanguage(LanguageInterface $language);

}

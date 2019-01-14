<?php

namespace Drupal\project_manager\Entity;

use Drupal\Core\Config\Entity\ConfigEntityInterface;
use Drupal\Core\Entity\EntityDescriptionInterface;

/**
 * Provides the interface for PM bundle entities.
 */
interface PmBundleEntityBaseInterface extends ConfigEntityInterface, EntityDescriptionInterface {

  /**
   * Gets whether the bundle is locked.
   *
   * Locked bundles cannot be deleted.
   *
   * @return bool
   *   TRUE if the bundle is locked, FALSE otherwise.
   */
  public function isLocked();

  /**
   * Locks the bundle.
   *
   * @return $this
   */
  public function lock();

  /**
   * Unlocks the bundle.
   *
   * @return $this
   */
  public function unlock();
}

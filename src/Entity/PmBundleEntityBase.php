<?php

namespace Drupal\project_manager\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Provides the base class for PM bundle entities.
 */
class PmBundleEntityBase extends ConfigEntityBundleBase implements PmBundleEntityBaseInterface {

  /**
   * The bundle ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The bundle label.
   *
   * @var string
   */
  protected $label;

  /**
   * The entity type description.
   *
   * @var string
   */
  protected $description;

  /**
   * Whether the bundle is locked, indicating that it cannot be deleted.
   *
   * @var bool
   */
  protected $locked = FALSE;

  /**
   * {@inheritdoc}
   */
  public function getDescription() {
    return $this->description;
  }

  /**
   * {@inheritdoc}
   */
  public function setDescription($description) {
    $this->description = $description;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function isLocked() {
    return (bool) $this->locked;
  }

  /**
   * {@inheritdoc}
   */
  public function lock() {
    $this->locked = TRUE;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function unlock() {
    $this->locked = FALSE;
    return $this;
  }

}

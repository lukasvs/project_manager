<?php

namespace Drupal\project_manager\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\RevisionLogInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\Core\Entity\EntityPublishedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides the interface for PM content entities.
 */
interface PmContentEntityBaseInterface extends ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface, RevisionLogInterface, EntityPublishedInterface {

  /**
   * Gets the entity name.
   *
   * @return string
   *   Name of the entity.
   */
  public function getName();

  /**
   * Sets the entity name.
   *
   * @param string $name
   *   The entity name.
   *
   * @return \Drupal\Core\Entity\ContentEntityInterface|null
   *   The called entity.
   */
  public function setName($name);

  /**
   * Gets the entity creation timestamp.
   *
   * @return int
   *   Creation timestamp of the entity.
   */
  public function getCreatedTime();

  /**
   * Sets the entity creation timestamp.
   *
   * @param int $timestamp
   *   The entity creation timestamp.
   *
   * @return \Drupal\Core\Entity\ContentEntityInterface|null
   *   The called entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Gets the entity revision creation timestamp.
   *
   * @return int
   *   The UNIX timestamp of when this revision was created.
   */
  public function getRevisionCreationTime();

  /**
   * Sets the entity revision creation timestamp.
   *
   * @param int $timestamp
   *   The UNIX timestamp of when this revision was created.
   *
   * @return \Drupal\Core\Entity\ContentEntityInterface|null
   *   The called entity.
   */
  public function setRevisionCreationTime($timestamp);

  /**
   * Gets the entity revision author.
   *
   * @return
   *   The user entity for the revision author.
   */
  public function getRevisionUser();

  /**
   * Sets the entity revision author.
   *
   * @param int $uid
   *   The user ID of the revision author.
   *
   * @return \Drupal\Core\Entity\ContentEntityInterface|null
   *   The called entity.
   */
  public function setRevisionUserId($uid);

}

<?php

namespace Drupal\layout_entity\Entity;

use Drupal\Core\Entity\RevisionLogInterface;
use Drupal\Core\Entity\RevisionableInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Layout Entity entities.
 *
 * @ingroup layout_entity
 */
interface LayoutEntityInterface extends RevisionableInterface, RevisionLogInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Layout Entity name.
   *
   * @return string
   *   Name of the Layout Entity.
   */
  public function getName();

  /**
   * Sets the Layout Entity name.
   *
   * @param string $name
   *   The Layout Entity name.
   *
   * @return \Drupal\layout_entity\Entity\LayoutEntityInterface
   *   The called Layout Entity entity.
   */
  public function setName($name);

  /**
   * Gets the Layout Entity creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Layout Entity.
   */
  public function getCreatedTime();

  /**
   * Sets the Layout Entity creation timestamp.
   *
   * @param int $timestamp
   *   The Layout Entity creation timestamp.
   *
   * @return \Drupal\layout_entity\Entity\LayoutEntityInterface
   *   The called Layout Entity entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Layout Entity published status indicator.
   *
   * Unpublished Layout Entity are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Layout Entity is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Layout Entity.
   *
   * @param bool $published
   *   TRUE to set this Layout Entity to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\layout_entity\Entity\LayoutEntityInterface
   *   The called Layout Entity entity.
   */
  public function setPublished($published);

  /**
   * Gets the Layout Entity revision creation timestamp.
   *
   * @return int
   *   The UNIX timestamp of when this revision was created.
   */
  public function getRevisionCreationTime();

  /**
   * Sets the Layout Entity revision creation timestamp.
   *
   * @param int $timestamp
   *   The UNIX timestamp of when this revision was created.
   *
   * @return \Drupal\layout_entity\Entity\LayoutEntityInterface
   *   The called Layout Entity entity.
   */
  public function setRevisionCreationTime($timestamp);

  /**
   * Gets the Layout Entity revision author.
   *
   * @return \Drupal\user\UserInterface
   *   The user entity for the revision author.
   */
  public function getRevisionUser();

  /**
   * Sets the Layout Entity revision author.
   *
   * @param int $uid
   *   The user ID of the revision author.
   *
   * @return \Drupal\layout_entity\Entity\LayoutEntityInterface
   *   The called Layout Entity entity.
   */
  public function setRevisionUserId($uid);

}

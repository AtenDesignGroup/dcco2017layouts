<?php

namespace Drupal\layout_entity;

use Drupal\Core\Entity\ContentEntityStorageInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\layout_entity\Entity\LayoutEntityInterface;

/**
 * Defines the storage handler class for Layout Entity entities.
 *
 * This extends the base storage class, adding required special handling for
 * Layout Entity entities.
 *
 * @ingroup layout_entity
 */
interface LayoutEntityStorageInterface extends ContentEntityStorageInterface {

  /**
   * Gets a list of Layout Entity revision IDs for a specific Layout Entity.
   *
   * @param \Drupal\layout_entity\Entity\LayoutEntityInterface $entity
   *   The Layout Entity entity.
   *
   * @return int[]
   *   Layout Entity revision IDs (in ascending order).
   */
  public function revisionIds(LayoutEntityInterface $entity);

  /**
   * Gets a list of revision IDs having a given user as Layout Entity author.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The user entity.
   *
   * @return int[]
   *   Layout Entity revision IDs (in ascending order).
   */
  public function userRevisionIds(AccountInterface $account);

  /**
   * Counts the number of revisions in the default language.
   *
   * @param \Drupal\layout_entity\Entity\LayoutEntityInterface $entity
   *   The Layout Entity entity.
   *
   * @return int
   *   The number of revisions in the default language.
   */
  public function countDefaultLanguageRevisions(LayoutEntityInterface $entity);

  /**
   * Unsets the language for all Layout Entity with the given language.
   *
   * @param \Drupal\Core\Language\LanguageInterface $language
   *   The language object.
   */
  public function clearRevisionsLanguage(LanguageInterface $language);

}

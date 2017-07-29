<?php

namespace Drupal\layout_entity;

use Drupal\Core\Entity\Sql\SqlContentEntityStorage;
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
class LayoutEntityStorage extends SqlContentEntityStorage implements LayoutEntityStorageInterface {

  /**
   * {@inheritdoc}
   */
  public function revisionIds(LayoutEntityInterface $entity) {
    return $this->database->query(
      'SELECT vid FROM {layout_entity_revision} WHERE id=:id ORDER BY vid',
      [':id' => $entity->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function userRevisionIds(AccountInterface $account) {
    return $this->database->query(
      'SELECT vid FROM {layout_entity_field_revision} WHERE uid = :uid ORDER BY vid',
      [':uid' => $account->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function countDefaultLanguageRevisions(LayoutEntityInterface $entity) {
    return $this->database->query('SELECT COUNT(*) FROM {layout_entity_field_revision} WHERE id = :id AND default_langcode = 1', [':id' => $entity->id()])
      ->fetchField();
  }

  /**
   * {@inheritdoc}
   */
  public function clearRevisionsLanguage(LanguageInterface $language) {
    return $this->database->update('layout_entity_revision')
      ->fields(['langcode' => LanguageInterface::LANGCODE_NOT_SPECIFIED])
      ->condition('langcode', $language->getId())
      ->execute();
  }

}

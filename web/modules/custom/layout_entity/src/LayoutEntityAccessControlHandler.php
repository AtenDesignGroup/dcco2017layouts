<?php

namespace Drupal\layout_entity;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Layout Entity entity.
 *
 * @see \Drupal\layout_entity\Entity\LayoutEntity.
 */
class LayoutEntityAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\layout_entity\Entity\LayoutEntityInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished layout entity entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published layout entity entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit layout entity entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete layout entity entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add layout entity entities');
  }

}

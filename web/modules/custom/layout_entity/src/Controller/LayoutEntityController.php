<?php

namespace Drupal\layout_entity\Controller;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Url;
use Drupal\layout_entity\Entity\LayoutEntityInterface;

/**
 * Class LayoutEntityController.
 *
 *  Returns responses for Layout Entity routes.
 */
class LayoutEntityController extends ControllerBase implements ContainerInjectionInterface {

  /**
   * Displays a Layout Entity  revision.
   *
   * @param int $layout_entity_revision
   *   The Layout Entity  revision ID.
   *
   * @return array
   *   An array suitable for drupal_render().
   */
  public function revisionShow($layout_entity_revision) {
    $layout_entity = $this->entityManager()->getStorage('layout_entity')->loadRevision($layout_entity_revision);
    $view_builder = $this->entityManager()->getViewBuilder('layout_entity');

    return $view_builder->view($layout_entity);
  }

  /**
   * Page title callback for a Layout Entity  revision.
   *
   * @param int $layout_entity_revision
   *   The Layout Entity  revision ID.
   *
   * @return string
   *   The page title.
   */
  public function revisionPageTitle($layout_entity_revision) {
    $layout_entity = $this->entityManager()->getStorage('layout_entity')->loadRevision($layout_entity_revision);
    return $this->t('Revision of %title from %date', ['%title' => $layout_entity->label(), '%date' => format_date($layout_entity->getRevisionCreationTime())]);
  }

  /**
   * Generates an overview table of older revisions of a Layout Entity .
   *
   * @param \Drupal\layout_entity\Entity\LayoutEntityInterface $layout_entity
   *   A Layout Entity  object.
   *
   * @return array
   *   An array as expected by drupal_render().
   */
  public function revisionOverview(LayoutEntityInterface $layout_entity) {
    $account = $this->currentUser();
    $langcode = $layout_entity->language()->getId();
    $langname = $layout_entity->language()->getName();
    $languages = $layout_entity->getTranslationLanguages();
    $has_translations = (count($languages) > 1);
    $layout_entity_storage = $this->entityManager()->getStorage('layout_entity');

    $build['#title'] = $has_translations ? $this->t('@langname revisions for %title', ['@langname' => $langname, '%title' => $layout_entity->label()]) : $this->t('Revisions for %title', ['%title' => $layout_entity->label()]);
    $header = [$this->t('Revision'), $this->t('Operations')];

    $revert_permission = (($account->hasPermission("revert all layout entity revisions") || $account->hasPermission('administer layout entity entities')));
    $delete_permission = (($account->hasPermission("delete all layout entity revisions") || $account->hasPermission('administer layout entity entities')));

    $rows = [];

    $vids = $layout_entity_storage->revisionIds($layout_entity);

    $latest_revision = TRUE;

    foreach (array_reverse($vids) as $vid) {
      /** @var \Drupal\layout_entity\LayoutEntityInterface $revision */
      $revision = $layout_entity_storage->loadRevision($vid);
      // Only show revisions that are affected by the language that is being
      // displayed.
      if ($revision->hasTranslation($langcode) && $revision->getTranslation($langcode)->isRevisionTranslationAffected()) {
        $username = [
          '#theme' => 'username',
          '#account' => $revision->getRevisionUser(),
        ];

        // Use revision link to link to revisions that are not active.
        $date = \Drupal::service('date.formatter')->format($revision->getRevisionCreationTime(), 'short');
        if ($vid != $layout_entity->getRevisionId()) {
          $link = $this->l($date, new Url('entity.layout_entity.revision', ['layout_entity' => $layout_entity->id(), 'layout_entity_revision' => $vid]));
        }
        else {
          $link = $layout_entity->link($date);
        }

        $row = [];
        $column = [
          'data' => [
            '#type' => 'inline_template',
            '#template' => '{% trans %}{{ date }} by {{ username }}{% endtrans %}{% if message %}<p class="revision-log">{{ message }}</p>{% endif %}',
            '#context' => [
              'date' => $link,
              'username' => \Drupal::service('renderer')->renderPlain($username),
              'message' => ['#markup' => $revision->getRevisionLogMessage(), '#allowed_tags' => Xss::getHtmlTagList()],
            ],
          ],
        ];
        $row[] = $column;

        if ($latest_revision) {
          $row[] = [
            'data' => [
              '#prefix' => '<em>',
              '#markup' => $this->t('Current revision'),
              '#suffix' => '</em>',
            ],
          ];
          foreach ($row as &$current) {
            $current['class'] = ['revision-current'];
          }
          $latest_revision = FALSE;
        }
        else {
          $links = [];
          if ($revert_permission) {
            $links['revert'] = [
              'title' => $this->t('Revert'),
              'url' => $has_translations ?
              Url::fromRoute('entity.layout_entity.translation_revert', ['layout_entity' => $layout_entity->id(), 'layout_entity_revision' => $vid, 'langcode' => $langcode]) :
              Url::fromRoute('entity.layout_entity.revision_revert', ['layout_entity' => $layout_entity->id(), 'layout_entity_revision' => $vid]),
            ];
          }

          if ($delete_permission) {
            $links['delete'] = [
              'title' => $this->t('Delete'),
              'url' => Url::fromRoute('entity.layout_entity.revision_delete', ['layout_entity' => $layout_entity->id(), 'layout_entity_revision' => $vid]),
            ];
          }

          $row[] = [
            'data' => [
              '#type' => 'operations',
              '#links' => $links,
            ],
          ];
        }

        $rows[] = $row;
      }
    }

    $build['layout_entity_revisions_table'] = [
      '#theme' => 'table',
      '#rows' => $rows,
      '#header' => $header,
    ];

    return $build;
  }

}

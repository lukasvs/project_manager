<?php

namespace Drupal\project_manager\Controller;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Drupal\project_manager\Entity\PmContentEntityBaseInterface;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Url;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class PmController.
 *
 *  Returns responses for entity routes.
 */
class PmController extends ControllerBase implements ContainerInjectionInterface {

  /**
   * The entity machine name.
   *
   * @var string $entityId
   */
  protected $entityId;

  /**
   * Constructs a new PmController.
   *
   * @param \Drupal\Core\Entity\EntityStorageInterface $entity_storage
   *   The entity storage.
   * @param \Drupal\Core\Database\Connection $connection
   *   The database connection.
   */
  public function __construct($entity_id) {
    $this->entityId = $entity_id;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    $entity_type = $container->get('current_route_match')->getParameters()
      ->keys()[0];
    return new static(
      $entity_type
    );
  }

  /**
   * Displays a entity  revision.
   *
   * @param int $revision
   *   The entity  revision ID.
   *
   * @return array
   *   An array suitable for drupal_render().
   */
  public function revisionShow($revision) {
    $entity = $this->entityManager()->getStorage($this->entityId)->loadRevision($revision);
    $view_builder = $this->entityManager()->getViewBuilder($this->entityId);

    return $view_builder->view($entity);
  }

  /**
   * Page title callback for a entity  revision.
   *
   * @param int $revision
   *   The entity  revision ID.
   *
   * @return string
   *   The page title.
   */
  public function revisionPageTitle($revision) {
    $entity = $this->entityManager()->getStorage($this->entityId)->loadRevision($revision);
    return $this->t('Revision of %title from %date', ['%title' => $entity->label(), '%date' => format_date($entity->getRevisionCreationTime())]);
  }

  protected function tableRevisions(PmContentEntityBaseInterface $entity) {
    $account = $this->currentUser();
    $langcode = $entity->language()->getId();
    $langname = $entity->language()->getName();
    $languages = $entity->getTranslationLanguages();
    $has_translations = (count($languages) > 1);
    $entity_storage = $this->entityManager()->getStorage($this->entityId);

    $build['#title'] = $has_translations ? $this->t('@langname revisions for %title', ['@langname' => $langname, '%title' => $entity->label()]) : $this->t('Revisions for %title', ['%title' => $entity->label()]);
    $header = [$this->t('Revision'), $this->t('Operations')];

    $revert_permission = (($account->hasPermission("revert all " . $this->entityId . " revisions") || $account->hasPermission('administer ' . $this->entityId . ' entities')));
    $delete_permission = (($account->hasPermission("delete all " . $this->entityId . " revisions") || $account->hasPermission('administer ' . $this->entityId . ' entities')));

    $rows = [];

    $vids = $entity_storage->revisionIds($entity);

    $latest_revision = TRUE;

    foreach (array_reverse($vids) as $vid) {
      $revision = $entity_storage->loadRevision($vid);
      // Only show revisions that are affected by the language that is being
      // displayed.
      if ($revision->hasTranslation($langcode) && $revision->getTranslation($langcode)->isRevisionTranslationAffected()) {
        $username = [
          '#theme' => 'username',
          '#account' => $revision->getRevisionUser(),
        ];

        // Use revision link to link to revisions that are not active.
        $date = \Drupal::service('date.formatter')->format($revision->getRevisionCreationTime(), 'short');
        if ($vid != $entity->getRevisionId()) {
          $link = $this->l($date, new Url('entity.' . $this->entityId . '.revision', [$this->entityId => $entity->id(), 'revision' => $vid]));
        }
        else {
          $link = $entity->link($date);
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
              Url::fromRoute('entity.' . $this->entityId . '.translation_revert', [$this->entityId => $entity->id(), 'revision' => $vid, 'langcode' => $langcode]) :
              Url::fromRoute('entity.' . $this->entityId . '.revision_revert', [$this->entityId => $entity->id(), 'revision' => $vid]),
            ];
          }

          if ($delete_permission) {
            $links['delete'] = [
              'title' => $this->t('Delete'),
              'url' => Url::fromRoute('entity.' . $this->entityId . '.revision_delete', [$this->entityId => $entity->id(), 'revision' => $vid]),
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

    $build['revisions_table'] = [
      '#theme' => 'table',
      '#rows' => $rows,
      '#header' => $header,
    ];

    return $build;
  }

}

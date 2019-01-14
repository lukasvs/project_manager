<?php

namespace Drupal\project_manager\Form;

use Drupal\Core\Database\Connection;
use Drupal\Core\Form\ConfirmFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Url;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a form for deleting a entity revision.
 *
 * @ingroup project_manager
 */
class PmRevisionDeleteForm extends ConfirmFormBase {

  /**
   * The entity machine name.
   *
   * @var string $entityId
   */
  protected $entityId;


  /**
   * The entity revision.
   *
   * @var \Drupal\project_manager\Entity\PmContentEntityBaseInterface
   */
  protected $revision;

  /**
   * The entity storage.
   *
   * @var \Drupal\Core\Entity\EntityStorageInterface
   */
  protected $entityStorage;

  /**
   * The database connection.
   *
   * @var \Drupal\Core\Database\Connection
   */
  protected $connection;

  /**
   * Constructs a new PmRevisionDeleteForm.
   *
   * @param \Drupal\Core\Entity\EntityStorageInterface $entity_storage
   *   The entity storage.
   * @param \Drupal\Core\Database\Connection $connection
   *   The database connection.
   */
  public function __construct(EntityStorageInterface $entity_storage, Connection $connection) {
    $this->entityStorage = $entity_storage;
    $this->connection = $connection;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    $entity_manager = $container->get('entity_type.manager');
    $entity_type = $container->get('current_route_match')->getParameters()
      ->keys()[0];
    return new static(
      $entity_manager->getStorage($entity_type),
      $container->get('database')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return $this->entityId . '_revision_delete_confirm';
  }

  /**
   * {@inheritdoc}
   */
  public function getQuestion() {
    return t('Are you sure you want to delete the revision from %revision-date?', ['%revision-date' => format_date($this->revision->getRevisionCreationTime())]);
  }

  /**
   * {@inheritdoc}
   */
  public function getCancelUrl() {
    return new Url('entity.' . $this->entityId . '.version_history', [$this->entityId => $this->revision->id()]);
  }

  /**
   * {@inheritdoc}
   */
  public function getConfirmText() {
    return t('Delete');
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, $revision = NULL) {
    $this->revision = $this->entityStorage->loadRevision($revision);
    $this->entityId = $this->revision->getEntityTypeId();
    $form = parent::buildForm($form, $form_state);
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->entityStorage->deleteRevision($this->revision->getRevisionId());

    $label_type = $this->revision->getEntityType()->getLabel();
    $this->logger('content')->notice('%label_type: deleted %title revision %revision.', ['%title' => $this->revision->label(), '%revision' => $this->revision->getRevisionId(), '%label_type' => $label_type]);
    drupal_set_message(t('Revision from %revision-date of %label_type %title has been deleted.', ['%revision-date' => format_date($this->revision->getRevisionCreationTime()), '%title' => $this->revision->label(), '%label_type' => $label_type]));
    $form_state->setRedirect(
      'entity.' . $this->entityId . '.canonical',
       [$this->entityId => $this->revision->id()]
    );
    if ($this->connection->query('SELECT COUNT(DISTINCT vid) FROM {' . $this->entityId . '_field_revision} WHERE id = :id', [':id' => $this->revision->id()])->fetchField() > 1) {
      $form_state->setRedirect(
        'entity.' . $this->entityId . '.version_history',
         [$this->entityId => $this->revision->id()]
      );
    }
  }

}

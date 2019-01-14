<?php

namespace Drupal\pm_project\Form;

use Drupal\project_manager\Form\PmTypeEntityForm;
use Drupal\Core\Form\FormStateInterface;

class PmProjectTypeEntityForm extends PmTypeEntityForm {

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $status = parent::save($form, $form_state);
    $entity_type = $this->entity;

    // Create the needed fields.
    project_manager_add_description_field($entity_type);
    project_manager_add_reference_field($entity_type, 'Owner', 'owner', FALSE, 'user', NULL, 1, TRUE);
    project_manager_add_reference_field($entity_type, 'Responsible', 'responsible',  FALSE, 'user', NULL, -1, TRUE);
    project_manager_add_reference_field($entity_type, 'Project stage', 'project_stage',  FALSE, 'taxonomy_term', ['project_stage'], 1, TRUE);

    $this->messenger()->addMessage($this->t('The entity type %label has been successfully saved.', ['%label' => $entity_type->label()]));
    $form_state->setRedirectUrl($this->entity->toUrl('collection'));
  }

}

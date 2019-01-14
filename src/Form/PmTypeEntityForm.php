<?php

namespace Drupal\project_manager\Form;

use Drupal\Core\Entity\BundleEntityFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\language\Entity\ContentLanguageSettings;

class PmTypeEntityForm extends BundleEntityFormBase {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $entity_type = $this->entity;

    $form = parent::form($form, $form_state);
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $entity_type->label(),
      '#required' => TRUE,
    ];
    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $entity_type->id(),
      '#machine_name' => [
        'exists' => $entity_type->getEntityType()->getOriginalClass() . '::load',
      ],
      '#maxlength' => EntityTypeInterface::BUNDLE_MAX_LENGTH,
    ];

    if ($this->moduleHandler->moduleExists('language')) {
      $form['language'] = [
        '#type' => 'details',
        '#title' => $this->t('Language settings'),
        '#group' => 'additional_settings',
      ];
      $form['language']['language_configuration'] = [
        '#type' => 'language_configuration',
        '#entity_information' => [
          'entity_type' => $entity_type->getEntityTypeId(),
          'bundle' => $entity_type->id(),
        ],
        '#default_value' => ContentLanguageSettings::loadByEntityTypeBundle($entity_type->getEntityTypeId(), $entity_type->id()),
      ];
      $form['#submit'][] = 'language_configuration_element_submit';
    }

    return $this->protectBundleIdElement($form);
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $status = parent::save($form, $form_state);
    $entity_type = $this->entity;

    $this->messenger()->addMessage($this->t('The entity type %label has been successfully saved.', ['%label' => $entity_type->label()]));
    $form_state->setRedirectUrl($this->entity->toUrl('collection'));
  }

}
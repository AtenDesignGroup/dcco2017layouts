<?php

namespace Drupal\layout_entity\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class LayoutEntityTypeForm.
 */
class LayoutEntityTypeForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $layout_entity_type = $this->entity;
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $layout_entity_type->label(),
      '#description' => $this->t("Label for the Layout Entity type."),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $layout_entity_type->id(),
      '#machine_name' => [
        'exists' => '\Drupal\layout_entity\Entity\LayoutEntityType::load',
      ],
      '#disabled' => !$layout_entity_type->isNew(),
    ];

    /* You will need additional form elements for your custom properties. */

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $layout_entity_type = $this->entity;
    $status = $layout_entity_type->save();

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Layout Entity type.', [
          '%label' => $layout_entity_type->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Layout Entity type.', [
          '%label' => $layout_entity_type->label(),
        ]));
    }
    $form_state->setRedirectUrl($layout_entity_type->toUrl('collection'));
  }

}

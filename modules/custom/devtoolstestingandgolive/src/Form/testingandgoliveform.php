<?php

namespace Drupal\devtoolstestingandgolive\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;


class testingandgoliveform extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'devtoolstestingandgoliveform';
  }

   /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    // Form constructor.
    $form = parent::buildForm($form, $form_state);
    // Default settings.
    $config = $this->config('testingandgoliveform.settings');

    
    $form['get_started_1'] = [
      '#type' => 'textfield',
      '#title' => $this->t('haroon started link '),
      '#maxlength' => 64,
      '#size' => 64,
      '#default_value' => $config->get('get_started_1'),
    ];
    $form['video_link_1'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Video Link'),
      '#maxlength' => 64,
      '#size' => 64,
      '#default_value' => $config->get('video_link_1'),
    ];

     /*  $form['banner_image'] = [
      '#type' => 'managed_file',
      '#title' => 'my file',
      '#name' => 'my_custom_file',
      '#description' => $this->t('my file description'),
      '#default_value' => [$config->get('banner_image')],
      '#upload_location' => 'public://'
    ];
     */

      return $form;
  }
  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {

}

/**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config('testingandgoliveform.settings');


   // $config->set('testingandgoliveform.banner_image', $form_state->getValue('banner_image'));
    $config->set('testingandgoliveform.get_started_1', $form_state->getValue('get_started_1'));
    $config->set('testingandgoliveform.video_link_1', $form_state->getValue('video_link_1'));

    $config->save();
    return parent::submitForm($form, $form_state);
  }

   /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'testingandgoliveform.settings',
    ];
  }
}
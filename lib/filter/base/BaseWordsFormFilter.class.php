<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * Words filter form base class.
 *
 * @package    hangman
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormFilterGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseWordsFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'word' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'word' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('words_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Words';
  }

  public function getFields()
  {
    return array(
      'id'   => 'Number',
      'word' => 'Text',
    );
  }
}

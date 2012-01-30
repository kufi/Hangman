<?php

/**
 * Games form base class.
 *
 * @package    hangman
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseGamesForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'player1_id'       => new sfWidgetFormPropelChoice(array('model' => 'Player', 'add_empty' => false)),
      'player2_id'       => new sfWidgetFormPropelChoice(array('model' => 'Player', 'add_empty' => true)),
      'word_id'          => new sfWidgetFormPropelChoice(array('model' => 'Words', 'add_empty' => false)),
      'player_turn'      => new sfWidgetFormInput(),
      'player1_faults'   => new sfWidgetFormInput(),
      'player2_faults'   => new sfWidgetFormInput(),
      'used_letters'     => new sfWidgetFormInput(),
      'new_game_player1' => new sfWidgetFormInputCheckbox(),
      'new_game_player2' => new sfWidgetFormInputCheckbox(),
      'new_game_started' => new sfWidgetFormInputCheckbox(),
      'created_at'       => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorPropelChoice(array('model' => 'Games', 'column' => 'id', 'required' => false)),
      'player1_id'       => new sfValidatorPropelChoice(array('model' => 'Player', 'column' => 'id')),
      'player2_id'       => new sfValidatorPropelChoice(array('model' => 'Player', 'column' => 'id', 'required' => false)),
      'word_id'          => new sfValidatorPropelChoice(array('model' => 'Words', 'column' => 'id')),
      'player_turn'      => new sfValidatorInteger(),
      'player1_faults'   => new sfValidatorInteger(array('required' => false)),
      'player2_faults'   => new sfValidatorInteger(array('required' => false)),
      'used_letters'     => new sfValidatorString(array('max_length' => 500, 'required' => false)),
      'new_game_player1' => new sfValidatorBoolean(array('required' => false)),
      'new_game_player2' => new sfValidatorBoolean(array('required' => false)),
      'new_game_started' => new sfValidatorBoolean(array('required' => false)),
      'created_at'       => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('games[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Games';
  }


}

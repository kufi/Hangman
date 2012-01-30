<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * Games filter form base class.
 *
 * @package    hangman
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormFilterGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseGamesFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'player1_id'       => new sfWidgetFormPropelChoice(array('model' => 'Player', 'add_empty' => true)),
      'player2_id'       => new sfWidgetFormPropelChoice(array('model' => 'Player', 'add_empty' => true)),
      'word_id'          => new sfWidgetFormPropelChoice(array('model' => 'Words', 'add_empty' => true)),
      'player_turn'      => new sfWidgetFormFilterInput(),
      'player1_faults'   => new sfWidgetFormFilterInput(),
      'player2_faults'   => new sfWidgetFormFilterInput(),
      'used_letters'     => new sfWidgetFormFilterInput(),
      'new_game_player1' => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'new_game_player2' => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'new_game_started' => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'created_at'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
    ));

    $this->setValidators(array(
      'player1_id'       => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Player', 'column' => 'id')),
      'player2_id'       => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Player', 'column' => 'id')),
      'word_id'          => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Words', 'column' => 'id')),
      'player_turn'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'player1_faults'   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'player2_faults'   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'used_letters'     => new sfValidatorPass(array('required' => false)),
      'new_game_player1' => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'new_game_player2' => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'new_game_started' => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'created_at'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('games_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Games';
  }

  public function getFields()
  {
    return array(
      'id'               => 'Number',
      'player1_id'       => 'ForeignKey',
      'player2_id'       => 'ForeignKey',
      'word_id'          => 'ForeignKey',
      'player_turn'      => 'Number',
      'player1_faults'   => 'Number',
      'player2_faults'   => 'Number',
      'used_letters'     => 'Text',
      'new_game_player1' => 'Boolean',
      'new_game_player2' => 'Boolean',
      'new_game_started' => 'Boolean',
      'created_at'       => 'Date',
    );
  }
}

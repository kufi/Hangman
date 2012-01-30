<?php

/**
 * Words form.
 *
 * @package    hangman
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class WordsForm extends BaseWordsForm {
  public function configure() {
  	$this->validatorSchema['word'] = new sfValidatorAnd(array(
  	 $this->validatorSchema['word'],
  	 new sfValidatorRegex(array('pattern' => '/^[a-zA-Z]*$/'), array('invalid' => "Das Wort darf nur aus den Buchstaben A-Z und a-z bestehen"))
  	));
  }
}

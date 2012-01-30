<?php

class myUser extends sfBasicSecurityUser {
	
	/**
	 * adds a single Letter which was used from the user to the Session
	 * 
	 * @param $letter
	 */
	public function addUsedLetter($letter) {
		$usedLetters = $this->getAttribute('usedLetters');
		$usedLetters[] = $letter;
		$this->setAttribute('usedLetters', $usedLetters);
		return $this->getUsedLetters();
	}
	
	/**
	 * returns all used letters of the user
	 *
	 * @return Array of used Letters
	 */
	public function getUsedLetters() {
		return $this->getAttribute('usedLetters');
	}
	
	/**
	 * sets a new word for the user
	 * 
	 * @param $word
	 */
	public function setWord($word) {
		$this->setAttribute('word', $word);
	}
	
	/**
	 * returns the word which the user has to guess
	 * @return unknown_type
	 */
	public function getWord() {
		return $this->getAttribute('word');
	}
	
	/**
	 * resets all values to the default values
	 *
	 * @return unknown_type
	 */
	public function resetValues() {
		$this->setAttribute('errors', 0);
		$this->setAttribute('usedLetters', array()); 
	}
	
	/**
	 * set the errors which the user has made
	 * @return unknown_type
	 */
	public function madeError() {
		$this->setAttribute('errors', $this->getAttribute('errors') + 1);
	}
	
	/**
	 * returns the number of errors
	 * @return unknown_type
	 */
	public function getErrors() {
		return $this->getAttribute('errors');
	}
	
	/**
	 * sets the player ID
	 * 
	 * @param $playerID
	 * @return unknown_type
	 */
	public function setPlayerId($playerID) {
	 $this->setAttribute('playerId', $playerID);
	}
	
	/**
	 * returns the current player ID
	 * 
	 * @return unknown_type
	 */
	public function getPlayerId() {
		return $this->getAttribute('playerId');
	}
	
	public function setGameId($gameId) {
	 $this->setAttribute('gameId', $gameId);
	}
	
	public function getGameId() {
		return $this->getAttribute('gameId');
	}
}

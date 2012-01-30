<?php

class Games extends BaseGames {
  /**
   * adds a letter to a game
   * 
	 * @param $letter
	 * @return unknown_type
   */
	public function addLetter($letter) {
    $usedLetters = unserialize($this->getUsedLetters());
    $usedLetters[] = $letter;
    $this->setUsedLetters(serialize($usedLetters));
    $this->save();
    
    return $usedLetters;
  }
  
  /**
   * adds an error to the given player in a game
   * 
   * @param $player
   * @return unknown_type
   */
  public function addError($player) {
  	if($this->getPlayer1Id() == $player->getId()) {
  		$this->setPlayer1Faults($this->getPlayer1Faults() + 1);
  	} else {
  		$this->setPlayer2Faults($this->getPlayer2Faults() + 1);
  	}
  	$this->save();
  }
  
  /**
   * returns the errors of a given player
   * 
   * @param $player
   * @return unknown_type
   */
  public function getErrors($player) {
    if($this->getPlayer1Id() == $player->getId()) {
      return $this->getPlayer1Faults();
    } else {
      return $this->getPlayer2Faults();
    }
  }
  
  /**
   * returns the errors of the other player in the game
   * 
   * @param $player
   * @return unknown_type
   */
  public function getEnemyErrors($player) {
    if($this->getPlayer1Id() == $player->getId()) {
      return $this->getPlayer2Faults();
    } else {
      return $this->getPlayer1Faults();
    }
  }
  
  /**
   * alternates the turn between player 1 and player 2
   * 
   * @return unknown_type
   */
  public function changeTurn() {
  	if($this->getPlayerTurn() == 1) {
  		$this->setPlayerTurn(2);
  	} else {
  		$this->setPlayerTurn(1);
  	}
  	$this->save();
  }
  
  /**
   * checks if it's the players turn
   * 
   * @param $player
   * @return unknown_type
   */
  public function isPlayerTurn(Player $player) {
    $returnValue = false;
  	if($this->getPlayer1Id() == $player->getId() && $this->getPlayerTurn() == 1) {
      $returnValue = true;
    }
    
    if($this->getPlayer2Id() == $player->getId() && $this->getPlayerTurn() == 2) {
      $returnValue = true;
    }
    
    return $returnValue;
  }
  
  /**
   * sets the flag for the given player, that he wants to make a new game
   * 
   * @param $player
   * @return unknown_type
   */
  public function setNewGame($player) {
    if($this->getPlayer1Id() == $player->getId()) {
      $this->setNewGamePlayer1(true);
    } else {
      $this->setNewGamePlayer2(true);
    }
    $this->save();
  }
  
  
  /**
   * returns the errors of a player
   * 
   * @param $game
   * @param $player
   * @return unknown_type
   */
  public function getErrorsOfPlayer(Player $player) {
  	if($this->getPlayer1Id() == $player->getId()) {
      return $this->getPlayer1Faults();
    } else {
      return $this->getPlayer2Faults();
    }
  }
  
  /**
   * returns the errors of the other player
   * 
   * @param $player
   * @return unknown_type
   */
  public function getErrorsOfEnemyPlayer(Player $player) {
    if($this->getPlayer1Id() == $player->getId()) {
      return $this->getPlayer2Faults();
    } else {
      return $this->getPlayer1Faults();
    }
  }
}

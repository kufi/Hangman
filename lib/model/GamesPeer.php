<?php

class GamesPeer extends BaseGamesPeer {
	
	/**
	 * returns all open games
	 * 
	 * @return unknown_type
	 */
	static public function getAllOpenGames() {
		$c = new Criteria();
		$c->add(GamesPeer::PLAYER2_ID, null);
		return GamesPeer::doSelect($c);
	}
	
	/**
	 * creates a new game
	 * 
	 * @param $player
	 * @param $word
	 * @return unknown_type
	 */
	static public function createGame(Player $player, Words $word) {
		//create game
		$game = new Games();
		$game->setPlayerRelatedByPlayer1Id($player);
		$game->setWords($word);
		$game->save();
		
		//remove player from lobby
		$player->setInLobby(false);
		$player->save();
	}
	
	/**
	 * gets the game of the given player
	 * 
	 * @param $player
	 * @return unknown_type
	 */
	static public function getGameOfPlayer(Player $player) {
		$c = new Criteria();
		
		$cri = $c->getNewCriterion(GamesPeer::PLAYER1_ID, $player->getId());
    $cri->addOr($c->getNewCriterion(GamesPeer::PLAYER2_ID, $player->getId()));
    $c->add($cri);
		
		return GamesPeer::doSelectOne($c);
	}
	
	/**
	 * returns wether the given player has already started a game or not
	 * @param $player
	 * @return unknown_type
	 */
	static public function gameStarted(Player $player) {
		$c = new Criteria();
    
		$cri = $c->getNewCriterion(GamesPeer::PLAYER1_ID, $player->getId());
    $cri->addOr($c->getNewCriterion(GamesPeer::PLAYER2_ID, $player->getId()));
    $c->add($cri);
    
    $game = GamesPeer::doSelectOne($c);
    
    if($game->getPlayer2Id() != null) {
    	return true;
    } else {
    	return false;
    }
	}
}

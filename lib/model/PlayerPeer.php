<?php

class PlayerPeer extends BasePlayerPeer {
	/**
   * adds the player to the lobby and
   * 
   * @return returns the new player
	 */
	static public function addPlayerToLobby($name) {
		$player = new Player();
		$player->setName($name);
		$player->setLastUpdate(time());
		$player->setInLobby(true);
		$player->save();
		return $player;
	}
	
	/**
   * returns all players in the lobby
	 */
	static public function getPlayersInLobby() {
		$c = new Criteria();
		
		$c->add(PlayerPeer::IN_LOBBY, true);
		return PlayerPeer::doSelect($c);
	}
	
	/**
	 * checks if the player already exists
	 * 
	 * @param $playerID
	 * @return unknown_type
	 */
	static public function playerExists($playerID) {
		$c = new Criteria();
		
		$c->add(PlayerPeer::ID, $playerID);
		$count = PlayerPeer::doCount($c);
		if($count > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * removes all users (and their games) which where more than 10 Minutes inactive
	 * @return unknown_type
	 */
	static public function removeInactiveUsers() {
	 $c = new Criteria();
	 $c->add(self::LAST_UPDATE, time() - 600, Criteria::LESS_THAN);
	 
	 return self::doDelete($c);
	}
}

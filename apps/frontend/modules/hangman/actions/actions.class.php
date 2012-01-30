<?php

/**
 * hangman actions.
 *
 * @package    hangman
 * @subpackage hangman
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class hangmanActions extends sfActions {
  private $allLetters = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
	
	public function executeIndex(sfWebRequest $request) {
  }
  
  /**
   * get a new word and reset the sessionparameters
   * 
   * @param $request
   */
  public function executeSingleplayer(sfWebRequest $request) {
    $randomWord = WordsPeer::getRandomWord();
  	
    $displayWord = "";
    
    for($i=0;$i<$randomWord->getWordLength();$i++) {
  		$displayWord .= "_";
  	}
    
  	$this->getUser()->setWord($randomWord);
    $this->getUser()->resetValues();
    
    $this->word = $displayWord;
    $this->letters = $this->allLetters;
  }
  
  /**
   * happens when the user clicks on an letter
   * 
   * @param $request
   * @return unknown_type
   */
  public function executeLetter(sfWebRequest $request) {
  	if($this->getUser()->getErrors() >= sfConfig::get('app_max_errors_singleplayer')) {
    	$this->forward('hangman', 'singleplayer');
  	}
  	
  	$request->setRequestFormat('json');
    $this->setLayout(false);
    $this->getResponse()->setContentType('text/json');
    $this->getResponse()->addCacheControlHttpHeader('no-cache');
  	
  	$clickedLetter = strtoupper($request->getParameter('letter'));
  	
  	//get all used letters
  	$usedLetters = $this->getUser()->getUsedLetters();
  	
  	//get the word out of the session (the object not the actual word)
    $actualWord = $this->getUser()->getWord();
    //get the actual word out of the object
    $usedWord = $actualWord->getWord();
  	
  	//check if the sent letter is a correct letter and hasn't already been clicked
  	if(in_array($clickedLetter, $this->allLetters) && in_array($clickedLetter, $usedLetters) == false)  {
    	//add the new letter
    	$usedLetters = $this->getUser()->addUsedLetter($clickedLetter);
    	//get all used letters
  	
	  	//check wether the new letter is in the word, if not add an error
	  	if(stristr($usedWord, $clickedLetter) == false) {
	  		$this->getUser()->madeError();
	  	}
  	}
  	
    $lost = false;
    //check wether the user has made too many errors
    if($this->getUser()->getErrors() >= sfConfig::get('app_max_errors_singleplayer')) {
      $lost = true;
    }
  	
  	$displayWord = "";
  	
  	//give back the new word
  	for($i=0;$i<$actualWord->getWordLength();$i++) {
  		$letterInWord = $usedWord[$i];
  		if(in_array(strtoupper($letterInWord), $usedLetters)) {
  			$displayWord .= $usedWord[$i];
  		} else {
  			$displayWord .= "_";
  		}
  	}
  	
  	$won = false;
  	//check wether the user has won
  	if(stristr($displayWord, "_") == false) {
  		$won = true;
  	}
  	
  	if($won == false && $lost == false) {
  		//set used word to nothing, so you can't see it in the json file if you call it manually
      $usedWord = "";
  	}
  	
  	$this->word = $displayWord;
  	$this->lost = $lost;
  	$this->won = $won;
  	$this->searchedWord = $usedWord;
  	$this->errors = $this->getUser()->getErrors();
  	$this->letters = $this->allLetters;
  	$this->usedLetters = $usedLetters;
  }
  
  /**
   * displays the lobby with all players and all open games
   * 
   * @return unknown_type
   */
  public function executeLobby(sfWebRequest $request) {
  	//check wether we already got an ID
  	$playerId = $this->getUser()->getPlayerId();
  	
  	$player = PlayerPeer::retrieveByPK($playerId);
  	
  	if($player == null) {
  		//add the player to the active players
	  	$player = PlayerPeer::addPlayerToLobby('player_'.rand(0, 10000));
	  	$this->getUser()->setPlayerId($player->getId());
  	} else {
  		//check if we are still in the database
  		if(PlayerPeer::playerExists($player->getId()) == false) {
  			//add the player to the active players
        $player = PlayerPeer::addPlayerToLobby('player_'.rand(0, 10000));
        $this->getUser()->setPlayerId($player->getId());
  		} else {
  			//if coming from a game
  			//just update the last access time, and set in Lobby = true
  			$player->setLastUpdate(time());
  			$player->setInLobby(true);
  			$player->save();
  			
  			//remove the games the player was playing
  			$game = GamesPeer::getGameOfPlayer($player);
  			if($game != null) {
  			 $game->delete();
  			}
  		}
  	}
  	
  	//get all players in lobby
  	$this->players = PlayerPeer::getPlayersInLobby();
  	//get all open games
  	$this->games = GamesPeer::getAllOpenGames();
  }
  
  /**
   * logout for a user in the multiplayer mode
   * @param $request
   * @return unknown_type
   */
  public function executeLogout(sfWebRequest $request) {
  	$this->setTemplate('index', 'hangman');
  	
  	//delete from database (if still exists)
  	$player = PlayerPeer::retrieveByPK($this->getUser()->getPlayerId());
  	
  	if($player != null) {
      $player->delete();
  	}
  	
  	$this->getUser()->setPlayerId(null);
  }
  
  /**
   * creates a new Multiplayer game
   * @return unknown_type
   */
  public function executeMultiplayer(sfWebRequest $request) {
    $player = PlayerPeer::retrieveByPK($this->getUser()->getPlayerId());
    
    //create a new game only if the player comes from the lobby
    if($player->getInLobby()) {
	    $randomWord = WordsPeer::getRandomWord();
	    GamesPeer::createGame($player, $randomWord);
    } else {
    	$randomWord = GamesPeer::getGameOfPlayer($player)->getWords();
    }
    
    $game = GamesPeer::getGameOfPlayer($player);
    
    $player->setLastUpdate(time());
    $player->save();
    
    $displayWord = "";
    for($i=0;$i<$randomWord->getWordLength();$i++) {
      $displayWord .= "_";
    }
    
    $this->word = $displayWord;
    $this->myErrors = $game->getErrors($player);
    $this->enemyErrors = $game->getEnemyErrors($player);
    $this->letters = $this->allLetters;
  }
  
  /**
   * checks if a second player has joined the game
   *
   * @param $request
   * @return unknown_type
   */
  public function executeGameStarted(sfWebRequest $request) {
  	$request->setRequestFormat('json');
  	$this->setLayout(false);
    $this->getResponse()->setContentType('text/json');
    $this->getResponse()->addCacheControlHttpHeader('no-cache');
    
    $this->started = GamesPeer::gameStarted(PlayerPeer::retrieveByPK($this->getUser()->getPlayerId()));
  }
  
  /**
   * join an existing game
   * 
   * @param $request
   * @return unknown_type
   */
  public function executeJoin(sfWebRequest $request) {
  	$this->setTemplate('multiplayer', 'hangman');
  	
  	$player = PlayerPeer::retrieveByPK($this->getUser()->getPlayerId());
  	
  	$gameId = $request->getParameter('id');
  	
  	$game = GamesPeer::retrieveByPK($gameId);
  	
  	//only add the player to the game if there isn't already a second player
  	//(prevents "hacking" into a game where already 2 players are in)
  	if(is_numeric($game->getPlayer2Id()) == false || $game->getPlayer2Id() == $player->getId()) {
	  	$word = $game->getWords();
	  	
	  	//add the player to the game
	  	$game->setPlayerRelatedByPlayer2Id($player);
	  	$game->save();
	  	
	  	//remove the player from the lobby
	  	$user = PlayerPeer::retrieveByPK($this->getUser()->getPlayerId());
	  	$user->setInLobby(false);
	  	$user->save();
	  	
	    $displayWord = "";
	    for($i=0;$i<$word->getWordLength();$i++) {
	      $displayWord .= "_";
	    }
	    
	  	$this->word = $displayWord;
	  	$this->myErrors = $game->getErrorsOfPlayer($player);
	  	$this->enemyErrors = $game->getErrorsOfEnemyPlayer($player);
	  	$this->letters = $this->allLetters;
  	} else {
  		$this->forward('hangman', 'lobby');
  	}
  }
  
  /**
   * gets called by a multiplayer player
   * looks up if the player if it's the players turn and sets the needed values
   * 
   * @param $request
   * @return unknown_type
   */
  public function executeCheckUpdate(sfWebRequest $request) {
  	$request->setRequestFormat('json');
    $this->setLayout(false);
    $this->getResponse()->setContentType('text/json');
    $this->getResponse()->addCacheControlHttpHeader('no-cache');
  	
  	$player = PlayerPeer::retrieveByPK($this->getUser()->getPlayerId());
  	$game = GamesPeer::getGameOfPlayer($player);
  	//if the game was deleted (other player left the game) don't go any further
  	if($game == null) {
  		$this->deleted = true;
  		return;
  	}
  	
  	$usedLetters = unserialize($game->getUsedLetters());
  	
  	$actualWord = $game->getWords();
  	$usedWord = $actualWord->getWord();
  	
    $displayWord = "";
    
    //give back the new word
    for($i=0;$i<$actualWord->getWordLength();$i++) {
      $letterInWord = $usedWord[$i];
      if(in_array(strtoupper($letterInWord), $usedLetters)) {
        $displayWord .= $usedWord[$i];
      } else {
        $displayWord .= "_";
      }
    }
    
    //check if won or not
    $myErrors = $game->getErrorsOfPlayer($player);
    $enemyErrors = $game->getErrorsOfEnemyPlayer($player);
    
    //I have lost, when the enemy has solved the word or I have over 3 errors
    $lost = "false";
    //check wether the user has lost
    if(stristr($displayWord, "_") == false || $myErrors >= sfConfig::get('app_max_errors_multiplayer')) {
      $lost = "true";
    }
    
    //I have won, when the enemy has over 3 errors
    $won = "false";
    if($enemyErrors >= sfConfig::get('app_max_errors_multiplayer')) {
    	$won = "true";
    }
    
  	$this->turn = $game->isPlayerTurn($player);
  	$this->word = $displayWord;
  	$this->your_errors = $myErrors;
  	$this->enemy_errors = $enemyErrors;
  	$this->searchedWord = $usedWord;
  	$this->won = $won;
  	$this->lost = $lost;
  	$this->usedLetters = unserialize($game->getUsedLetters());
  }
  
  /**
   * gets called when a player clicks a letter in a multiplayer game
   * 
   * @param $request
   * @return unknown_type
   */
  public function executeLetterMultiplayer(sfWebRequest $request) {
    $request->setRequestFormat('json');
    $this->setLayout(false);
    $this->getResponse()->setContentType('text/json');  
    $this->getResponse()->addCacheControlHttpHeader('no-cache');
    
    $player = PlayerPeer::retrieveByPK($this->getUser()->getPlayerId());
    
    //update last access time
    $player->setLastUpdate(time());
    $player->save();
    
    $game = GamesPeer::getGameOfPlayer($player);
    
    //get the clicked letter
    $clickedLetter = strtoupper($request->getParameter('letter'));
    
    //just do it when its actually the players turn
    //when the the sent letter is valid and when the letter hasn't already been clicked
    if($game->isPlayerTurn($player) && in_array($clickedLetter, $this->allLetters) && in_array($clickedLetter, $game->getUsedLetters()) == false) {
	    
	    //add the new letter
	    $usedLetters = $game->addLetter($clickedLetter);
	    
	    //get the word out of the session (the object not the actual word)
	    $actualWord = $game->getWords();
	    
	    //get the actual word out of the object
	    $usedWord = $actualWord->getWord();
	    
	    //check wether the new letter is in the word, if not add an error
	    //if he didn't make an error, don't change the Turn
	    $madeError = "false";
	    if(stristr($usedWord, $clickedLetter) == false) {
	      $game->addError(PlayerPeer::retrieveByPK($this->getUser()->getPlayerId()));
	      //set the turn for the other player
	      $game->changeTurn();
	      $madeError = "true";
	    }
    }
    
    $lost = false;
    //check wether the user has made too many errors
    if($game->getErrors($player) >= sfConfig::get('app_max_errors_multiplayer')) {
      $lost = true;
    }
    
    $displayWord = "";
    
    //give back the new word
    for($i=0;$i<$actualWord->getWordLength();$i++) {
      $letterInWord = $usedWord[$i];
      if(in_array(strtoupper($letterInWord), $usedLetters)) {
        $displayWord .= $usedWord[$i];
      } else {
        $displayWord .= "_";
      }
    }
    
    $won = false;
    //check wether the user has won
    if(stristr($displayWord, "_") == false) {
      $won = true;
    }
    
    $this->word = $displayWord;
    $this->lost = $lost;
    $this->won = $won;
    $this->searchedWord = $usedWord;
    $this->my_errors = $game->getErrors($player);
    $this->madeError = $madeError;
    $this->letters = $this->allLetters;
    $this->usedLetters = $usedLetters;
  }
  
  /**
   * gives back all open games and all players in the lobby
   * 
   * @param $request
   * @return unknown_type
   */
  public function executeCheckLobby(sfWebRequest $request) {
  	$request->setRequestFormat('json');
    $this->setLayout(false);
    $this->getResponse()->setContentType('text/json');  
    $this->getResponse()->addCacheControlHttpHeader('no-cache');
    
    $this->games = GamesPeer::getAllOpenGames();
    $this->users = PlayerPeer::getPlayersInLobby();
  }
  
  /**
   * a player agrees to make a new game
   * 
   * @param $request
   * @return unknown_type
   */
  public function executeNewWord(sfWebRequest $request) {
  	$request->setRequestFormat('json');
    $this->setLayout(false);
    $this->getResponse()->setContentType('text/json');  
    $this->getResponse()->addCacheControlHttpHeader('no-cache');
  	
  	$player = PlayerPeer::retrieveByPK($this->getUser()->getPlayerId());
  	
  	$game = GamesPeer::getGameOfPlayer($player);
  	
  	//set the player newGame flag to true for this player
  	$game->setNewGame($player);
  	
  	$newWord = "false";
  	
  	if($game->getNewGameStarted()) {
  		$game->setNewGameStarted(false);
  		$newWord = "true";
  	}
  	
  	//if both players agreed to a new game, reset the values
  	if($game->getNewGamePlayer1() && $game->getNewGamePlayer2()) {
  		$game->setNewGamePlayer1(false);
  		$game->setNewGamePlayer2(false);
  		
  		$game->setNewGameStarted(true);
  		
  		$game->setWordId($randomWord = WordsPeer::getRandomWord()->getId());
  		$game->setPlayer1Faults(0);
  		$game->setPlayer2Faults(0);
  		$game->setUsedLetters(serialize(array()));
  		$game->save();
  		
  		$newWord = "true";
  	}
  	
  	$this->newWord = $newWord;
  }
  
  /**
   * returns wether the other player also has agreed to start a new game or not
   * 
   * @param $request
   * @return unknown_type
   */
  public function executeOtherPlayerStarted(sfWebRequest $request) {
    $request->setRequestFormat('json');
    $this->setLayout(false);
    $this->getResponse()->setContentType('text/json');  
    $this->getResponse()->addCacheControlHttpHeader('no-cache');
    $this->setTemplate('newWord', 'hangman');
    
    $newWord = "false";
    if($game->getNewGamePlayer1() == false && $game->getNewGamePlayer2() == false) {
      $newWord = "true";
    }
    $this->newWord = $newWord;
  }
}

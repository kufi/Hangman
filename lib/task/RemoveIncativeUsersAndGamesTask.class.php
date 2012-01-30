<?php
class RemoveIncativeUsersAndGames extends sfBaseTask {
  
	protected function configure() {
		$this->namespace = 'hangman';
	  $this->name = 'cleanup';
	  $this->briefDescription = 'Remove incative Users and Games from the database';
	}
  
  protected function execute($arguments = array(), $options = array()) {
  	$databaseManager = new sfDatabaseManager($this->configuration);
  	
  	$nb = PlayerPeer::removeInactiveUsers();
  	
  	$this->logSection('propel', sprintf('Removed %d inactive users and their games', $nb));
  }
}
?>
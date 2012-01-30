<?php

class WordsPeer extends BaseWordsPeer {
	
	/**
	 * returns a random word
	 * 
	 * @return unknown_type
	 */
	static public function getRandomWord() {
		$c = new Criteria();
		$c->addAscendingOrderByColumn('rand()');
		return WordsPeer::doSelectOne($c);
	}
}

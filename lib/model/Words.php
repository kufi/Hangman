<?php

class Words extends BaseWords {
	
	/**
	 * returns the word
	 * 
	 * @return unknown_type
	 */
	public function __toString() {
		return $this->getWord();
	}
	
	/**
	 * returns the length of the word
	 * @return unknown_type
	 */
	public function getWordLength() {
		return strlen($this->getWord());
	}
	
	/**
	 * returns wether a given letter is in the word or not
	 * 
	 * @param $letter
	 * @return unknown_type
	 */
	public function isLetterInWord($letter) {
		return stristr($this->getWord(), $letter);
	}
}
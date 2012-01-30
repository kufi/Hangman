$(document).ready(function() {
	//don't show the letters, because we have to wait on a second player
	$('#letters').hide();
	
	//check if 2. player present
	gameStarted();
	
	$('.newWord').click(function() {
		$.getJSON("/multiplayer/newWord", function(data) {
			//reset all letters
			$('.used').addClass('letter');
			$('.used').removeClass('used');
			
			//hide the panels
			$('#lost').hide();
			$('#won').hide();
			
			$('#your_errors').html('0');
			$('#enemy_errors').html('0');
			
			if(data.newWord) {
				checkForUpdate();
			} else {
				$('#waitForSecondPlayer').show();
				waitForOtherPlayer();
			}
		});
	});
	
	//click function for the buttons
	$('.letter').click(function () {
		clickedItem = $(this);
		
		if(clickedItem.hasClass('used')) {
			return;
		}
		
		//load JSON from server
		$.getJSON("/multiplayer/letter/" + clickedItem.html(),
        function(data){
			dataWord = data.word;
			
			strWord = dataWord.charAt(0);
			for(i=1;i<dataWord.length;i++) {
				strWord = strWord + " " + dataWord.charAt(i);
			}
			
			$('#word').html(strWord);
			
			//update errors
			errors = data.your_errors;
			$('#your_errors').html(errors);
			
			//if the player has made an error, update the picture and hide the input panel
			if(data.made_error) {
				$('#letters').hide();
				$('#hangman_picture').attr({src: "/images/hangman_error_" + errors + ".jpg"});
			}
			
			//check if won or not
			bLost = data.lost;
			bWon = data.won;
			
			//check if the player has lost
			if(bLost) {
				$('#letters').hide();
				$('#searchedWord').html(data.searchedWord);
				$('#lost').show();
			}
			//check if the player has won
			if(bWon) {
				$('#letters').hide();
				$('#won').show();
			}
			
			//change the classes
			clickedItem.removeClass('letter');
			clickedItem.addClass('used');
			
			//if neither won nor lost, begin to check for Updates
			if(bWon == false && bLost == false) {
				checkForUpdate();
			}
        });
	});
});

function gameStarted() {
	$.getJSON("/multiplayer/gameStarted", function(data) {
		if(data.started) {
			$('#waitOnSecondPlayer').hide();
			checkForUpdate();
		} else {
			//wait for 2 seconds and then check again
			setTimeout('gameStarted()', 2000);
		}
	});
}

function checkForUpdate() {
	$.getJSON("/multiplayer/checkUpdate", function(data) {
		//check first if the game is still existent
		if(data.game_deleted) {
			$('#game_ended').show();
			return;
		} else {
			if(data.turn) {
				//disable all used letters
				arrUsedLetters = data.usedLetters;
				for(i=0;i<arrUsedLetters.length;i++) {
					$('#letter_' + arrUsedLetters[i]).removeClass('letter');
					$('#letter_' + arrUsedLetters[i]).addClass('used');
				}
				
				$('#letters').show();
				//write new word
				dataWord = data.word;
				
				strWord = dataWord.charAt(0);
				
				for(i=1;i<dataWord.length;i++) {
					strWord = strWord + " " + dataWord.charAt(i);
				}
				
				$('#word').html(strWord);
				
				$('#enemy_errors').html(data.enemy_errors);
				
				//check if won or not
				bLost = data.lost;
				bWon = data.won;
				
				//check if the player has lost
				if(bLost) {
					$('#letters').hide();
					$('#searchedWord').html(data.searchedWord);
					$('#lost').show();
				}
				
				//check if the player has won
				if(bWon) {
					$('#letters').hide();
					$('#won').show();
				}
			} else {
				dataWord = data.word;
				
				strWord = dataWord.charAt(0);
				for(i=1;i<dataWord.length;i++) {
					strWord = strWord + " " + dataWord.charAt(i);
				}
				
				//check if won or not
				bLost = data.lost;
				bWon = data.won;
				
				//check if the player has lost
				if(bLost) {
					$('#letters').hide();
					$('#searchedWord').html(data.searchedWord);
					$('#lost').show();
				}
				
				//check if the player has won
				if(bWon) {
					$('#letters').hide();
					$('#won').show();
				}
				
				$('#word').html(strWord);
				
				setTimeout('checkForUpdate()', 2000);
			}
		}
	});
}

function waitForOtherPlayer() {
	$.getJSON("/multiplayer/newWord", function(data) {
		if(data.newWord) {
			$('#waitForSecondPlayer').hide();
			checkForUpdate();
		} else {
			setTimeout("waitForOtherPlayer()", 2000);
		}
	});
}
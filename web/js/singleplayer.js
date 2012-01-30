$(document).ready(function() {
	
	$('.letter').click(function () {
		clickedItem = $(this);
		
		if(clickedItem.hasClass('used')) {
			return;
		}
		
		//load JSON from server
		$.getJSON("/singleplayer/" + $(this).html(), function(data){
			dataWord = data.word;
			
			word = dataWord.charAt(0);
			for(i=1;i<dataWord.length;i++) {
				word = word + " " + dataWord.charAt(i);
			}
			
			$('#word').html(word);
			
			//update errors
			errors = data.errors;
			
			//if the player has made an error, update the picture
			if(errors > $('#errors').html()) {
				$('#hangman_picture').attr({src: "/images/hangman_error_" + errors + ".jpg"});
			}
			
			$('#errors').html(errors);
			
			//check if won or not
			lost = data.lost;
			won = data.won;
			
			//check if the player has lost
			if(lost) {
				$('#letters').hide();
				$('#searchedWord').html(data.searchedWord);
				$('#lost').show();
			}
			//check if the player has won
			if(won) {
				$('#letters').hide();
				$('#won').show();
			}
			
			//change the classes
			clickedItem.removeClass('letter');
			clickedItem.addClass('used');
        });
	});
});
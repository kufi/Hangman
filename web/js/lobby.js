$(document).ready(function() {
	checkLobby();
	//setTimeout("checkLobby()", 10000);
});

function checkLobby() {
	$.getJSON("/multiplayer/checkLobby", function(data) {
		//length -1 because the last entry in the json is a placeholderentry
		
		//delete all rows in the gamestable
		$('#tableGames tbody tr').remove();
		for(i=0;i<data.games.length-1;i++) {
			gameId = data.games[i].id;
			player1Name = data.games[i].player1;
			//add row
			rowString = '';
			rowString += '<tr><td id="game_'+gameId+'"><a href="/multiplayer/join/'+gameId+'">game_'+gameId+'</a></td>';
			rowString += '<td>'+player1Name+'</td></tr>';
			$(rowString).appendTo('#tableGames tbody');
		}
		
		$('#tablePlayers tbody tr').remove();
		for(i=0;i<data.users.length-1;i++) {
			playerName = data.users[i].name;
			//add row
			$('<tr><td>'+playerName+'</td></tr>').appendTo('#tablePlayers tbody');
		}
	});
	
	setTimeout("checkLobby()", 2000);
}
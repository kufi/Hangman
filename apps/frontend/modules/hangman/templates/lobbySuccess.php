<?php use_javascript('jquery.js')?>
<?php use_javascript('lobby.js')?>

<div id="games">
<table id="tableGames">
  <thead>
    <tr>
      <th>
        Spielname
      </th>
      <th>
        Spielername
      </th>
    </tr>
  </thead>
  <tbody>
<?php
foreach($games as $game): ?>
	 <tr id="<?="game_".$game->getId();?>">
	   <td>
	     <a href="<?=url_for('multiplayer_join', $game)?>"><?="game_".$game->getId();?></a>
	   </td>
	   <td>
	     <?=$game->getPlayerRelatedByPlayer1Id()->getName()?>
	   </td>
	 </tr>
<?php endforeach; ?>
  </tbody>
</table>
</div>

<div id="players">
<table id="tablePlayers">
  <thead>
  <tr>
    <th>
      Spieler
    </th>
  </tr>
  </thead>
  <tbody>
	<?php foreach($players as $player) :?>
		<tr>
	    <td id="<?=$player->getName();?>">
	      <?=$player->getName();?>
	    </td>
	  <tr>
	<?php endforeach; ?>
  </tbody>
</table>
</div>
<br>
<div style="clear:both;" />
<a href="<?=url_for('@logout')?>"><img id="toMenu" src="/images/toMenu.jpg" /></a>
<a href="<?=url_for('@multiplayer')?>"><img id="newGame" src="/images/neues_spiel.jpg" /></a>
<div style="clear:both;" />
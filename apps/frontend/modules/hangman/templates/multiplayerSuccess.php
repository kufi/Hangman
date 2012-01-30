<?php use_javascript('jquery.js')?>
<?php use_javascript('multiplayer.js')?>
<div>
  deine Fehler: <b><span id="your_errors"><?=$myErrors?></span>/<?=sfConfig::get('app_max_errors_multiplayer')?></b>
</div>
<div>
  gegnerische Fehler: <b><span id="enemy_errors"><?=$enemyErrors?></span>/<?=sfConfig::get('app_max_errors_multiplayer')?></b>
</div>
<div id="waitOnSecondPlayer">
  Es wird auf einen 2. Spieler gewartet
  <img src="/images/wait.gif" alt="warten..." />
</div>
<div id="waitForSecondPlayer">
  Es wird auf den 2. Spieler gewartet
  <img src="/images/wait.gif" alt="warten..." />
</div>
<div id="lost">
  Du hast verloren<br />
  Das gesuchte Wort war "<span id="searchedWord"></span>"<br />
  <div class="newWord">neues Spiel</div>
</div>
<div id="won">
  Du hast gewonnen!<br />
  <div class="newWord">neues Spiel</div>
</div>
<div id="game_ended">
  Das Spiel wurde vom anderen Spieler beendet
  <a href="<?=url_for('@lobby')?>">zur Lobby</a>
</div>
<?php include_partial('hangman', array("word" => $word, "letters" => $letters))?>
<a href="<?=url_for('@logout')?>"><img id="toMenu" src="/images/toMenu.jpg" alt="Menu"></a>
<a href="<?=url_for('@lobby')?>"><img id="toLobby" src="/images/toLobby.jpg" alt="zu Lobby"></a>
<div style="clear:both" />
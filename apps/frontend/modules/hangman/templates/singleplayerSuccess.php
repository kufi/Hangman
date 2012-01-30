<?php use_javascript('jquery.js')?>
<?php use_javascript('singleplayer.js')?>
<div>
  Fehler: <b><span id="errors">0</span>/<?=sfConfig::get('app_max_errors_singleplayer')?></b>
</div>
<div id="lost">
  Du hast verloren<br />
  Das gesuchte Wort war "<span id="searchedWord"></span>"<br />
  <a href="<?=url_for('@singleplayer')?>">neues Spiel</a>
</div>
<div id="won">
  Du hast gewonnen!<br />
  <a href="<?=url_for('@singleplayer')?>">neues Spiel</a>
</div>
<?php include_partial('hangman', array("word" => $word, "letters" => $letters))?>
<a href="<?=url_for('@homepage')?>"><img id="toMenu" src="/images/toMenu.jpg" alt="Menu"></a>
<a href="<?=url_for('@singleplayer')?>"><img id="newGame" src="/images/neues_spiel.jpg" alt="neues Spiel"></a>
<div style="clear:both"></div>
<?php if($deleted): ?>
{
  "game_deleted" : true
}
<?php else:?>
{
  "game_deleted" : false,
  "turn"  : <?=($turn) ? "true" : "false"?>,
  "word"  : "<?=$word?>",
  "your_errors" : <?=$your_errors?>,
  "enemy_errors" : <?=$enemy_errors?>,
  "searchedWord" : "<?=$searchedWord?>",
  "won" : <?=$won?>,
  "lost"  : <?=$lost?>,
  "usedLetters" : [<?php $first = true; foreach($usedLetters as $letter) { if($first){$first = false;}else{echo ",";} echo '"'.$letter.'"';}?>]
}
<?php endif;?>
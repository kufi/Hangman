<div id="image">
  <img id="hangman_picture" src="/images/hangman_error_0.jpg" alt="Hangman Error <?=$errors?>" />
</div>
<div id="word">
<?php for($i = 0;$i<strlen($word);$i++): ?>
  <?=$word[$i]?>
<?php endfor; ?>
</div>
<div id="letters">
    <?php $counter = 0;
    foreach($letters as $letter): 
      $counter++;
      ?>
      <div class="letter" id="letter_<?=$letter?>"><?=$letter?></div>
      
      <?php if($counter == 13) : ?>
        <div style="clear:both;float:left;"></div>
      <?php endif;?>
  <?php endforeach; ?>
</div>
<div style="clear:both"></div>
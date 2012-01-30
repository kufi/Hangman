{
  "games":[
  <?php foreach($games as $game):?>
    {
    "id" : <?=$game->getId()?>,
    "player1" : "<?=$game->getPlayerRelatedByPlayer1Id()->getName()?>"
    },
  <?php endforeach;?>
    {"empty" : "empty"}
  ],
  "users":[
  <?php foreach($users as $user):?>
    {
    "name" : "<?=$user->getName()?>"
    },
  <?php endforeach;?>
    {"empty" : "empty"}
  ]
}
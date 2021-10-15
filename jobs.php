<?php

session_start();
include 'functions.php';
setSession();
$finalOdds = getSpread();
$schedule = setSchedule($finalOdds);
scheduleToDB($schedule);

//createLeaderboard();

?>

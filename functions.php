<?php

function calculateScores(){
  include 'db.php';
  $picks = mysqli_query($conn, "SELECT picks.userid, picks.week, picks.matchid, matches.spread FROM picks JOIN matches ON picks.matchid = matches.sportRadarId WHERE matchid IN (SELECT sportRadarId FROM matches WHERE result = 'upset')");
  $users = mysqli_query($conn, "SELECT id FROM users");
  $userIds = array();
  foreach($users as $u){
    array_push($userIds, $u['id']);
  }

  $scores = array();
  foreach($userIds as $u){
    $totalScore = 0;
    $weekScore = 0;
    $count = 0;
    for ($w = 1; $w <= 14; $w++){
      foreach($picks as $p){
        if($p['week'] == $w AND $p['userid'] == $u){
          $weekScore += $p['spread'];
          $count++;
        }
      }
      if($count == 3){
        $weekScore = $weekScore * 2;
      }
      $totalScore += $weekScore;
      $weekScore = 0;
      $count = 0;
    }
    $scores[$u] = $totalScore;
  }
  mysqli_close($conn);
  return $scores;
}

function updateLeaderboard($scores){
  include 'db.php';
  mysqli_query($conn, "DELETE FROM leaderboard");
  arsort($scores);
  $leaderboard = 'INSERT INTO `leaderboard` (`id`, `rank`, `points`) VALUES (?, ?, ?)';
  $leaderboard = $conn->prepare($leaderboard);
  $leaderboard -> bind_param("iid", $userid, $rank, $points);
  $highScore = 0;
  $position = 1;
  $currentScore = 0;
  foreach($scores as $id => $s){
    if($s > $highScore){
      $userid = $id;
      $rank = $position;
      $points = $s;
      $leaderboard -> execute();
      $highScore = $s;
      $currentScore = $s;
    }
    elseif($s == $currentScore){
      $userid = $id;
      $rank = $position;
      $points = $s;
      $leaderboard -> execute();
    }
    elseif($s < $currentScore){
      $currentScore = $s;
      $position += $position;
      $userid = $id;
      $rank = $position;
      $points = $s;
      $leaderboard -> execute();
    }
  }
  mysqli_close($conn);
}

function createLeaderboard(){
  $scores = calculateScores();
  updateLeaderboard($scores);
}



function getLeaderboard(){
  include 'db.php';
  $standingsQuery = mysqli_query($conn, "SELECT users.name, leaderboard.id, leaderboard.points, leaderboard.rank FROM users JOIN leaderboard ON users.id = leaderboard.id ORDER BY leaderboard.rank ASC");
  $standings = array();
  foreach($standingsQuery as $s){
    if($s['id'] == $_SESSION['id']){
      $_SESSION['rank'] = $s['rank'];
      $_SESSION['points'] = $s['points'];
    }
    array_push($standings, $s);
  }
  return $standings;
  mysqli_close($conn);
}

function retrievePicks(){
  include 'db.php';
  $userid = $_SESSION['id'];
  $week = $_SESSION['gameWeek'];
  $picksQuery = mysqli_query($conn, "SELECT picks.userid, picks.week, picks.matchid, matches.underdog FROM picks JOIN matches ON picks.matchid = matches.sportRadarId WHERE picks.userid = $userid AND picks.week = $week");
  $picks = array();
  foreach($picksQuery as $p){
    array_push($picks, $p);
  }
  return $picks;
  mysqli_close($conn);
}

function calculateRemainingPicks($picks){
  if(empty($picks)){
    return 3;
  }
  elseif(count($picks) == 3){
    return 0;
  }
  elseif(count($picks) == 2){
    return 1;
  }
  elseif(count($picks) == 1){
    return 2;
  }
}

function markSelections($matches, $picks){
  foreach($picks as $p){
    foreach($matches as &$m){
      if($p['underdog'] == $m['underdog']){
        $m['picked'] = "y";
      }
    }
  }
  return $matches;
}

function getSpread(){
  $curl = curl_init();
  //Making the Request to get the Odds for this weeks Schedule
  curl_setopt_array($curl, [
    CURLOPT_URL => "https://odds.p.rapidapi.com/v1/odds?sport=americanfootball_nfl&region=uk&mkt=spreads&dateFormat=iso&oddsFormat=american",
    CURLOPT_RETURNTRANSFER => true, CURLOPT_FOLLOWLOCATION => true, CURLOPT_ENCODING => "", CURLOPT_MAXREDIRS => 10, CURLOPT_TIMEOUT => 30, CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1, CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => [
      "x-rapidapi-host: odds.p.rapidapi.com",
      "x-rapidapi-key: 3382d93e96msh78b283214d19daap17b003jsn5f595efd0059"
    ],
  ]);
  $result = curl_exec($curl);
  $result_decoded = json_decode($result, true);
  $matches = $result_decoded['data'];
  curl_close($curl);

  //Parsing the relevant data and getting the Underdog
  $finalOdds = array();
  foreach($matches as $m){
    $x = array();
    $x['team1'] = $m['teams'][0];
    $x['team2'] = $m['teams'][1];
    $x['home_team'] = $m['home_team'];
    if($x['home_team'] == $x['team1']){
      $x['away_team'] = $x['team2'];
    }
    else{
      $x['away_team'] = $x['team1'];
    }

    if($m['sites'][0]['odds']['spreads']['points'][0] > $m['sites'][0]['odds']['spreads']['points'][1]){
      $x['underdog'] = $m['teams'][0];
      $x['spread'] = $m['sites'][0]['odds']['spreads']['points'][0];
    }
    else{
      $x['underdog'] = $m['teams'][1];
      $x['spread'] = $m['sites'][0]['odds']['spreads']['points'][1];
    }
    $x['time'] = $m['commence_time'];
    array_push($finalOdds, $x);
  }
  return $finalOdds;
}

function setSchedule($finalOdds){
  $week = $_SESSION['gameWeek'];
  $gameSeason = $_SESSION['gameSeason'];
  //Making the Request to retrieve the matche IDs for later use in getting results
  //Entering all of the games into the DB
  $curl = curl_init();
  curl_setopt($curl, CURLOPT_URL, "http://api.sportradar.us/nfl/official/trial/v6/en/games/2021/$gameSeason/$week/schedule.json?api_key=wf63zubsw9ma6dkx9rqsyes7");
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
  $sportRadar = curl_exec($curl);
  curl_close($curl);
  $sportRadarDecoded = json_decode($sportRadar, true);
  $sportRadarFinal = $sportRadarDecoded['week']['games'];
  $finalMatches = array();
  foreach($sportRadarFinal as $s){
    $game = array();
  	foreach($finalOdds as $f){
    		if($s['home']['name'] == $f['home_team'] AND $s['away']['name'] == $f['away_team']){
          $game['week'] = $week;
          $game['team1'] = $f['team1'];
          $game['team2']= $f['team2'];
          $game['homeTeam'] = $f['home_team'];
          $game['underdog'] = $f['underdog'];
          $game['spread'] = $f['spread'];
          $game['time'] = $f['time'];
          $game['sportRadarId'] = $s['id'];
      		array_push($finalMatches, $game);
          }
  		}
  }
  return ($finalMatches);
}

function scheduleToDB($finalMatches){
  include 'db.php';
  $matchinput = 'INSERT INTO `matches` (`week`, `team1`, `team2`, `homeTeam`, `underdog`, `spread`, `time`, `sportRadarId`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
  $matchinput = $conn->prepare($matchinput);
  $matchinput -> bind_param("ssssssss", $week, $team1, $team2, $homeTeam, $underdog, $fspread, $time, $sportRadarId);
  foreach($finalMatches as $f){
    $week = $f['week'];
    $team1 = $f['team1'];
    $team2 = $f['team2'];
    $homeTeam = $f['homeTeam'];
    $underdog = $f['underdog'];
    $fspread = $f['spread'];
    $time = new DateTime($f['time']);
    $time->modify('+ 1 hour');
    $time = $time->format('Y-m-d H:i:s');
    $sportRadarId = $f['sportRadarId'];
    $matchinput -> execute();
  }
  mysqli_close($conn);
}

function updateSchedule(){
  include 'db.php';
  $updatedMatches = setSchedule('update');
  $currentMatches = getMatches();
  $currentMatchesIds = array();
  foreach($currentMatches as $c){
    array_push($currentMatchesIds, $c['sportRadarId']);
  }
  $test = array();
  $matchinput = 'INSERT INTO `matches` (`week`, `team1`, `team2`, `homeTeam`, `underdog`, `spread`, `time`, `sportRadarId`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
  $matchinput = $conn->prepare($matchinput);
  foreach($updatedMatches as $u){
      if(!in_array($u['sportRadarId'], $currentMatchesIds)){
        $matchinput -> bind_param("ssssssss", $week, $team1, $team2, $homeTeam, $underdog, $fspread, $time, $sportRadarId);
        $week = $f['week'];
        $team1 = $f['team1'];
        $team2 = $f['team2'];
        $homeTeam = $f['homeTeam'];
        $underdog = $f['underdog'];
        $fspread = $f['spread'];
        $time = $f['time'];
        $sportRadarId = $f['sportRadarId'];
        $matchinput -> execute();
      }
  }
  mysqli_close($conn);
}


function updateResults(){
  include 'db.php';
  $week = $_SESSION['gameWeek'];
  $gameSeason = $_SESSION['gameSeason'];
  //Making the Request to retrieve the matche IDs for later use in getting results
  $curl = curl_init();
  curl_setopt($curl, CURLOPT_URL, "http://api.sportradar.us/nfl/official/trial/v6/en/games/2021/$gameSeason/1/schedule.json?api_key=wf63zubsw9ma6dkx9rqsyes7");
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
  $sportRadar = curl_exec($curl);
  curl_close($curl);
  $sportRadarDecoded = json_decode($sportRadar, true);
  $sportRadarFinal = $sportRadarDecoded['week']['games'];

  foreach($sportRadarFinal as $s){
  	if($s['status'] == "closed"){
      if($s['scoring']['home_points'] > $s['scoring']['away_points']){
        $result = $s['home']['name'];
        $status = 'closed';
        $sportRadarId = $s['id'];
        $updateResult = mysqli_query($conn, "UPDATE matches SET status = '$status', result = IF(underdog = '$result', 'upset', '') WHERE sportRadarId = '$sportRadarId'");
      }
      elseif($s['scoring']['home_points'] < $s['scoring']['away_points']){
        $result = $s['away']['name'];
        $status = 'closed';
        $sportRadarId = $s['id'];
        $updateResult = mysqli_query($conn, "UPDATE matches SET status = '$status', result = IF(underdog = '$result', 'upset', '') WHERE sportRadarId = '$sportRadarId'");
      }
  	}
  }
  mysqli_close($conn);
}

function getMatches(){
  include 'db.php';
  $week = $_SESSION['gameWeek'];
  $matchesQuery = mysqli_query($conn, "SELECT matches.underdog, matches.team1, matches.team2, matches.spread, matches.time, matches.sportRadarId, teams.tag, teams.colour, teams.logo FROM matches JOIN teams ON matches.underdog = teams.name WHERE matches.week = $week ORDER BY matches.time ASC");
  $matches = array();
  $t = getTime();

  foreach($matchesQuery as $m){
    if(new DateTime() > new Datetime($m['time'])){
      $m['active'] = 'n';
    }
    else {
      $m['active'] = 'y';
    }
    $time = new DateTime($m['time']);
    $time ->setTimezone($t);
    $m['time'] = $time->format('M j g:i A');
    $m['picked'] = "n";
    if($m['underdog'] == $m['team1']){
      $fav = strrpos($m['team2'], ' ') + 1;
      $favTag = substr($m['team2'], $fav);
      $m['favourite'] = $favTag;
    }
    else{
      $fav = strrpos($m['team1'], ' ') + 1;
      $favTag = substr($m['team1'], $fav);
      $m['favourite'] = $favTag;
    }

    array_push($matches, $m);
  }
  return $matches;
  mysqli_close($conn);
}

function getTime(){
  $userIP = $_SERVER['REMOTE_ADDR'];
  $userIP = '109.255.7.191'; //needs to be removed on deployment
  $ipInfo = file_get_contents('http://ip-api.com/json/' . $userIP);
  $ipInfo = json_decode($ipInfo, true);
  $timezone = $ipInfo['timezone'];
  $_SESSION['timezone'] = $timezone;
  date_default_timezone_set('Europe/London');
  $time = new DateTimeZone($timezone);
  return $time;
}

function submitSelection($picks){
  include 'db.php';
  $pick = 'INSERT INTO picks (`userid`, `matchid`, `week`) VALUES (?,?,?)';
  $pick = $conn->prepare($pick);
  $id = $_SESSION['id'];
  $week = $_SESSION['gameWeek'];
  foreach($picks as $p){
    $matchid = $p;
    $pick -> bind_param("isi", $id, $matchid, $week);
    $pick -> execute();
  }
  mysqli_close($conn);
}

function deletePicks(){
  include 'db.php';
  $id = $_SESSION['id'];
  $week = $_SESSION['gameWeek'];
  $latestPicks = mysqli_query($conn, "SELECT picks.matchid, matches.time FROM picks JOIN matches ON picks.matchid = matches.sportRadarId WHERE picks.userid = $id AND picks.week = $week");
  $latestArray = array();
  foreach($latestPicks as $l){
    array_push($latestArray, $l['matchid']);
    if(new DateTime() < new DateTime($l['time'])){
      $matchid = $l['matchid'];
      mysqli_query($conn, "DELETE FROM picks WHERE userid = $id AND matchid = '$matchid'");
      $_SESSION['test'] = 'new one';
    }
  }
  $_SESSION['latestPicks'] = $latestArray;

  mysqli_close($conn);
}

function setSession(){
  include 'db.php';
  $currentWeek = mysqli_query($conn, "SELECT week, season, expiry FROM schedule WHERE (SELECT CURRENT_TIMESTAMP) > date ORDER BY date DESC LIMIT 1");
  foreach($currentWeek as $c){
    $_SESSION['gameWeek'] = $c['week'];
    $_SESSION['gameSeason'] = $c['season'];
    $t = getTime();
    $time = new DateTime( $c['expiry']);
    $time ->setTimezone($t);
    $_SESSION['deadlineTime'] = $time->format('M j g:i A');
    if(new DateTime() > new DateTime($c['expiry'])){
      $_SESSION['deadline'] = TRUE;
    }
    else{
      $_SESSION['deadline'] = FALSE;
    }
  }
  mysqli_close($conn);
}

function loginSession(){
  include 'db.php';
  $userid = $_SESSION['id'];
  $week = $_SESSION['gameWeek'];
  $picks = mysqli_query($conn, "SELECT id FROM picks WHERE userid = $userid AND week = $week");
  if(mysqli_num_rows($picks) === 0){
    $_SESSION['edit'] = FALSE;
  }
  else{
    $_SESSION['edit'] = TRUE;
  }
}

function getWeeksPicks(){
  include 'db.php';
  $week = $_SESSION['gameWeek'];
  $users = mysqli_query($conn, "SELECT id FROM users");
  $userIds = array();
  foreach($users as $u){
    array_push($userIds, $u['id']);
  }

  $thisWeeksPicksQuery =  mysqli_query($conn, "SELECT users.id, users.name, matches.underdog, matches.result FROM users JOIN picks ON users.id = picks.userid JOIN matches ON picks.matchid = matches.sportRadarId WHERE picks.week = $week");
  $orgPicks = array();
  foreach($userIds as $u){
    $orgPicks[$u] = array();
    $orgPicks[$u][1] = array();
    $orgPicks[$u][1]['team'] = '';
    $orgPicks[$u][1]['result'] = '';
    $orgPicks[$u][2] = array();
    $orgPicks[$u][2]['team'] = '';
    $orgPicks[$u][2]['result'] = '';
    $orgPicks[$u][3] = array();
    $orgPicks[$u][3]['team'] = '';
    $orgPicks[$u][3]['result'] = '';
    $c = 1;
    foreach($thisWeeksPicksQuery as $t){
      if($t['id'] == $u){
        $orgPicks[$u]['id'] = $t['id'];
        $orgPicks[$u]['name'] = $t['name'];
        $tag = strrpos($t['underdog'], ' ') + 1;
        $favTag = substr($t['underdog'], $tag);
        $orgPicks[$u][$c]['team'] = $favTag;
        $orgPicks[$u][$c]['result'] = $t['result'];
        $c++;
      }
    }
  }
  return $orgPicks;
}

function kickStart(){
  include 'db.php';
  $gameSeason = 'REG';
  $week=6;
  $curl = curl_init();
  curl_setopt($curl, CURLOPT_URL, "http://api.sportradar.us/nfl/official/trial/v6/en/games/2021/$gameSeason/$week/schedule.json?api_key=wf63zubsw9ma6dkx9rqsyes7");
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
  $sportRadar = curl_exec($curl);
  curl_close($curl);
  $sportRadarDecoded = json_decode($sportRadar, true);
  $sportRadarFinal = $sportRadarDecoded['week']['games'];
  $finalMatches = array();
  foreach($sportRadarFinal as $s){
    $game = array();
    $game['week'] = $week;
    $game['team1'] = $s['home']['name'];
    $game['team2']= $s['away']['name'];
    $game['homeTeam'] = $s['home']['name'];
    $game['underdog'] = '';
    $game['spread'] = 0;
    $game['time'] = $s['scheduled'];
    $game['status'] = $s['status'];
    $game['sportRadarId'] = $s['id'];
    array_push($finalMatches, $game);
  }
  scheduleToDB($finalMatches);
}

function allUserPicks(){
  include 'db.php';
  $week = $_SESSION['gameWeek'];
  $picksQuery = mysqli_query($conn, "SELECT picks.userid, users.name, picks.week, picks.matchid, matches.underdog, matches.result FROM picks JOIN matches ON picks.matchid = matches.sportRadarId JOIN users ON picks.userid = users.id WHERE picks.week != $week");
  $picks = array();
  $userPicks = array();
  foreach($picksQuery as $p){
    if($p['result'] == 'upset'){
      $p['result'] = "<i class='fa fa-check-circle' aria-hidden='true' style='color:#4cba39;'></i>";
    }
    else{
      $p['result'] = "<i class='fa fa-times-circle' aria-hidden='true' style='color:#d50a0b;'></i>";
    }
    if($p['userid'] == $_SESSION['id']){
      array_push($userPicks, $p);
    }
    array_push($picks, $p);
  }
  $_SESSION['fieldHistoricalPicks'] = $picks;
  $_SESSION['userHistoricalPicks'] = $userPicks;
}

?>

<?php 
session_start(); 
require("config.php");
if(isset($_SESSION["phase"])) {  session_unset(); ?><!DOCTYPE html>
<html lang="en">
<head>
<title>Who are We? - The Game - Phase 1</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<h1><a href="https://whoarewe.games/" title="Who are We?"><em>Who are We?</em> - The Game</a></h1> 
<h2>Phase 1</h2>
<p>A security alert was raised.</p>
<p>Unfortunately, this is the end of your game, if any was in progress.</p>
</body>
</html> 
<?php die(); } 
elseif( date("i") > 10 ) { session_unset(); ?><!DOCTYPE html>
<html lang="en">
<head>
<title>Who are We? - The Game - Phase 1</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<h1><a href="https://whoarewe.games/" title="Who are We?"><em>Who are We?</em> - The Game</a></h1> 
<h2>Phase 1</h2>
<p>Unfortunately, it is too late to register for this game.</p>
<p>However, you can join the next game.</p>
<p>It will start on <?=((new DateTime(date("r",time()-(time()%3600)+3600)))->setTimezone(new DateTimeZone(json_decode(file_get_contents("https://timeapi.io/api/Time/current/ip?ipAddress=".$_SERVER['REMOTE_ADDR']),true)["timeZone"])))->format('l, F j, Y \a\t H:i:s e \t\i\m\e') ?>.</p>
<p>You will be redirected to the homepage shortly.</p>
<script>setTimeout( function() { window.location.href="https://whoarewe.games/"; }, 20000); </script>
</body>
</html>
<?php die(); }
$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
if ($conn->connect_error) { session_unset(); ?><!DOCTYPE html>
<html lang="en">
<head>
<title>Who are We? - The Game - Phase 1</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<h1><a href="https://whoarewe.games/" title="Who are We?"><em>Who are We?</em> - The Game</a></h1> 
<h2>Phase 1</h2>
<p>Something wrong happened.</p>
<p>Please try again later.</p>
<p>Apologies for any inconvenience caused.</p>
</body>
</html> 
<?php die(); }
$stmt = $conn->prepare("INSERT INTO bookings(game, players) VALUES (?, 1) ON DUPLICATE KEY UPDATE players = players + 1");
if(!$stmt) { session_unset(); ?><!DOCTYPE html>
<html lang="en">
<head>
<title>Who are We? - The Game - Phase 1</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<h1><a href="https://whoarewe.games/" title="Who are We?"><em>Who are We?</em> - The Game</a></h1> 
<h2>Phase 1</h2>
<p>Something wrong happened.</p>
<p>Please try again later.</p>
<p>Apologies for any inconvenience caused.</p>
</body>
</html> 
<?php $conn->close(); die(); }
$stmt->bind_param("i", $game);
$game = date("YmdH");
if(!$stmt->execute()) { session_unset(); ?><!DOCTYPE html>
<html lang="en">
<head>
<title>Who are We? - The Game - Phase 1</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<h1><a href="https://whoarewe.games/" title="Who are We?"><em>Who are We?</em> - The Game</a></h1> 
<h2>Phase 1</h2>
<p>Something wrong happened.</p>
<p>Please try again later.</p>
<p>Apologies for any inconvenience caused.</p>
</body>
</html> 
<?php $stmt->close(); $conn->close(); die(); }
$stmt->close();
$conn->close();
$conn = null; $stmt = null;
$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
if ($conn->connect_error) { session_unset(); ?><!DOCTYPE html>
<html lang="en">
<head>
<title>Who are We? - The Game - Phase 1</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<h1><a href="https://whoarewe.games/" title="Who are We?"><em>Who are We?</em> - The Game</a></h1> 
<h2>Phase 1</h2>
<p>Something wrong happened.</p>
<p>Please try again later.</p>
<p>Apologies for any inconvenience caused.</p>
</body>
</html> 
<?php die(); }
$stmt = $conn->prepare("SELECT players FROM bookings WHERE game = ?");
if(!$stmt) { session_unset(); ?><!DOCTYPE html>
<html lang="en">
<head>
<title>Who are We? - The Game - Phase 1</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<h1><a href="https://whoarewe.games/" title="Who are We?"><em>Who are We?</em> - The Game</a></h1> 
<h2>Phase 1</h2>
<p>Something wrong happened.</p>
<p>Please try again later.</p>
<p>Apologies for any inconvenience caused.</p>
</body>
</html> 
<?php $conn->close(); die(); }
$stmt->bind_param("i", $game);
$game = date("YmdH");
if(!$stmt->execute()) { session_unset(); ?><!DOCTYPE html>
<html lang="en">
<head>
<title>Who are We? - The Game - Phase 1</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<h1><a href="https://whoarewe.games/" title="Who are We?"><em>Who are We?</em> - The Game</a></h1> 
<h2>Phase 1</h2>
<p>Something wrong happened.</p>
<p>Please try again later.</p>
<p>Apologies for any inconvenience caused.</p>
</body>
</html>	
<?php $stmt->close(); $conn->close(); die(); }
$stmt->bind_result($players);
$stmt->fetch();
$stmt->close();
$conn->close();
if($players > 100) { session_unset(); ?><!DOCTYPE html>
<html lang="en">
<head>
<title>Who are We? - The Game - Phase 1</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<h1><a href="https://whoarewe.games/" title="Who are We?"><em>Who are We?</em> - The Game</a></h1> 
<h2>Phase 1</h2>
<p>Unfortunately, the threshold of 100 players has already been reached for this game.</p>
<p>However, you can join the next game.</p>
<p>It will start on <?=((new DateTime(date("r",time()-(time()%3600)+3600)))->setTimezone(new DateTimeZone(json_decode(file_get_contents("https://timeapi.io/api/Time/current/ip?ipAddress=".$_SERVER['REMOTE_ADDR']),true)["timeZone"])))->format('l, F j, Y \a\t H:i:s e \t\i\m\e') ?>.</p>
<p>You will be redirected to the homepage shortly.</p>
<script>setTimeout( function() { window.location.href="https://whoarewe.games/"; }, 20000); </script>
</body>
</html>
<?php die(); }
$_SESSION["phase"] = 1;
$_SESSION["nonce"] = bin2hex(random_bytes(32));
?><!DOCTYPE html>
<html lang="en">
<head>
<title>Who are We? - The Game - Phase 1</title>
<link rel="stylesheet" href="style.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script>setInterval(function(){$.ajax({url: "alive.php"}).done(function( response ) {console.log(response);});},60000); </script>
<script>$(function() {$("#nickname").on("keyup",function(){$(this).val($(this).val().toUpperCase());});});</script>
</head>
<body>

<h1><a href="https://whoarewe.games/" title="Who are We?"><em>Who are We?</em> - The Game</a></h1> 

<h2>Phase 1</h2>

<p>You have to complete this phase by <strong id="deadline" data-deadline="<?=(time()-(time()%3600)+600)*1000?>"><?=((new DateTime(date("r",time()-(time()%3600)+600)))->setTimezone(new DateTimeZone(json_decode(file_get_contents("https://timeapi.io/api/Time/current/ip?ipAddress=".$_SERVER['REMOTE_ADDR']),true)["timeZone"])))->format('l, F j, Y \a\t H:i:s e \t\i\m\e') ?></strong>. When the time elapses, the form is submitted automatically, which will bring you to phase 2. If you are ready before that the time elapses, you can submit the form manually, and you will save some time for phase 2, in which you will have to think about the questions that you want to include in the survey that will be submitted to all other participants.</p>
<script>
var timeCheck = function(){ 
	if(Number($("#deadline").data("deadline")) < Date.now()) {
		$("form").submit(); 
	}
}
$(window).on("focus",timeCheck);
setInterval(timeCheck,10000);
</script>

<form action="phase2.php" method="post">

<fieldset>
<legend>Icebreaker</legend>
<ol>
<li><label for="nickname">Arcade-style Nickname: <input id="nickname" type="text" name="nickname" value="AAA" maxlength="3" size="3"></label></li>
<li><label for="source">How did you know about this game? <input id="source" type="text" name="source" maxlength="50" size="50"></label></li>
<li><label for="source">What motivated you to give it a try? <input id="motivation" type="text" name="motivation" maxlength="50" size="50"></label></li>
</ol>
</fieldset>

<fieldset>
<legend>Self-assessment</legend>
<ol>
<li><label for="identity"><strong>Gender identity:</strong> woman <input id="identity" type="range" name="identity" min="0" max="100"> man </label></li>
<li><label for="expression"><strong>Gender expression:</strong> feminine <input id="expression" type="range" name="expression" min="0" max="100"> masculine</label></li>
<li><label for="sex"><strong>Biological sex:</strong> female <input id="sex" type="range" name="sex" min="0" max="100"> male</label></li>
<li><label for="orientation"><strong>Sexual orientation:</strong> heterosexual <input id="orientation" type="range" name="orientation" min="0" max="100"> homosexual</label></li>
</ol>
</fieldset>

<input type="hidden" name="nonce" value="<?=$_SESSION["nonce"]?>">

<button type="submit">Submit (remember you cannot come back once submitted)</button>

</form>

</body>
</html>

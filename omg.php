<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Who are We? - The Game</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<h1><a href="https://whoarewe.games/" title="Who are We?"><em>Who are We?</em> - The Game</a></h1> 
<div id="resume">
	<p>Something wrong happened.</p>
	<p>Unfortunately, the game must be suspended.</p>
	<p>Please take note of the following details:</p>
	<table><thead><tr><td>Game</td><td>Player ID</td><td>Nickname</td><td>Phase</td></tr></thead><tbody><td><?=$_SESSION["game"]?></td><td><?=$_SESSION["player"]?></td><td><?=$_SESSION["nickname"]?></td><td><?=$_SESSION["phase"]?></td></tr></table>
	<p>Please visit the <a href="https://whoarewe.games/resume/" title="Resume page">resume page</a> in the coming days.</p>
	<p>Apologies for any inconvenience caused.</p>
</div>
</body>
</html> 
<?php session_unset(); die(); ?>
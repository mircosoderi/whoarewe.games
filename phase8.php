<?php
session_start(); 
require("config.php");

if(!isset($_SESSION["phase"])) { session_unset(); ?><!DOCTYPE html>
<html lang="en">
<head>
<title>Who are We? - The Game - Phase 8</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<h1><a href="https://whoarewe.games/" title="Who are We?"><em>Who are We?</em> - The Game</a></h1> 
<h2>Phase 8</h2>
<p>A security alert was raised.</p>
<p>Unfortunately, this is the end of your game, if any was in progress.</p>
</body>
</html> 
<?php die(); }
if(isset($_SESSION["phase"]) && $_SESSION["phase"] != 7 ) { session_unset();  ?><!DOCTYPE html>
<html lang="en">
<head>
<title>Who are We? - The Game - Phase 8</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<h1><a href="https://whoarewe.games/" title="Who are We?"><em>Who are We?</em> - The Game</a></h1> 
<h2>Phase 8</h2>
<p>A security alert was raised.</p>
<p>Unfortunately, this is the end of your game, if any was in progress.</p>
</body>
</html> 
<?php die(); } 
if($_GET["nonce"] != $_SESSION["nonce"] ) { session_unset();  ?><!DOCTYPE html>
<html lang="en">
<head>
<title>Who are We? - The Game - Phase 8</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<h1><a href="https://whoarewe.games/" title="Who are We?"><em>Who are We?</em> - The Game</a></h1> 
<h2>Phase 8</h2>
<p>A security alert was raised.</p>
<p>Unfortunately, this is the end of your game, if any was in progress.</p>
</body>
</html> 
<?php die(); } 

$result = array();
$selfass = array();
$selfassrank = array();
$bestsurvrank = array();

$driver = new mysqli_driver();
$driver->report_mode = MYSQLI_REPORT_STRICT | MYSQLI_REPORT_ERROR;

try {
	$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
	$stmt = $conn->prepare("select l.aspect, round(avg(l.label)) from clusters c, labels l where c.surveyor = l.surveyor and c.aspect = l.aspect and c.cluster = l.cluster and c.player = ? group by l.aspect");
	$stmt->bind_param("i", $player );
	$player = $_SESSION["player"];
	if($stmt->execute()) {  
		$stmt->bind_result($aspect, $label);
		while($stmt->fetch()) $result[$aspect] = $label;
	}
	$stmt->close();
	$conn->close();
}
catch(Exception $e) { header("Location: https://whoarewe.games/omg.php"); die(); }
		
try {
	$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
	$stmt = $conn->prepare("select identity, expression, sex, orientation from players where id = ?");
	$stmt->bind_param("i", $player );
	$player = $_SESSION["player"];
	if($stmt->execute()) {  
		$stmt->bind_result($identity, $expression, $sex, $orientation);
		$stmt->fetch();
		$selfass["identity"] = $identity; 
		$selfass["expression"] = $expression; 
		$selfass["sex"] = $sex; 
		$selfass["orientation"] = $orientation; 
	}
	$stmt->close();
	$conn->close();
}
catch(Exception $e) { header("Location: https://whoarewe.games/omg.php"); die(); }

try {
	$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
	$stmt = $conn->prepare("select detail.player, players.nickname, players.country, detail.aspect, detail.grade, round(total.total/400*100) total from ( select c.player, c.aspect, 100-abs(round(avg(l.label))-case when c.aspect = 'identity' then p.identity when c.aspect = 'expression' then p.expression when c.aspect = 'sex' then p.sex else p.orientation end) grade from clusters c, labels l, players p where p.game = ? and c.surveyor = l.surveyor and c.aspect = l.aspect and c.cluster = l.cluster and c.player = p.id group by c.player, c.aspect) as detail join ( select player, sum(grade) total from ( select c.player, c.aspect, 100-abs(round(avg(l.label))-case when c.aspect = 'identity' then p.identity when c.aspect = 'expression' then p.expression when c.aspect = 'sex' then p.sex else p.orientation end) grade from clusters c, labels l, players p where p.game = ? and c.surveyor = l.surveyor and c.aspect = l.aspect and c.cluster = l.cluster and c.player = p.id group by c.player, c.aspect ) as itotal group by player ) as total on detail.player = total.player join players on detail.player = players.id order by total.total desc, total.player");
	$stmt->bind_param("ss", $game, $game );
	$game = $_SESSION["game"];
	if($stmt->execute()) {  
		$stmt->bind_result($player, $nickname, $country, $aspect, $grade, $total);
		while($stmt->fetch()) {
			if(isset($selfassrank[$player])) $selfassrank[$player][$aspect] = $grade;
			else $selfassrank[$player] = array( "country" => $country, "nickname" => $nickname, "identity" => $aspect == "identity" ? $grade : "", "expression" => $aspect == "expression" ? $grade : "", "sex" => $aspect == "sex" ? $grade : "", "orientation" => $aspect == "orientation" ? $grade : "", "total" => $total);
		}
	}
	$stmt->close();
	$conn->close();
}
catch(Exception $e) { header("Location: https://whoarewe.games/omg.php"); die(); }

try {
	$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
	$stmt = $conn->prepare("select opinions.surveyor, surveyor.nickname, surveyor.country, round(sum(100-abs(results.result-opinions.opinion))/(100*count(*))*100) accuracy from ( select c.player player, c.aspect aspect, round(avg(l.label)) result from clusters c, labels l, players p where c.aspect = l.aspect and c.cluster = l.cluster and c.surveyor = l.surveyor and c.player = p.id  and p.game = ?  group by c.player, c.aspect ) results, ( select c.player player, c.aspect aspect, c.surveyor surveyor, l.label opinion from clusters c, labels l, players p where c.aspect = l.aspect and c.cluster = l.cluster and c.surveyor = l.surveyor and c.player = p.id and p.game = ? ) opinions, players surveyor where results.player = opinions.player and results.aspect = opinions.aspect and opinions.surveyor = surveyor.id group by opinions.surveyor, surveyor.nickname, surveyor.country order by accuracy desc, opinions.surveyor");
	$stmt->bind_param("ss", $game, $game );
	$game = $_SESSION["game"];
	if($stmt->execute()) {  
		$stmt->bind_result($player, $nickname, $country, $accuracy);
		while($stmt->fetch()) {
			$bestsurvrank[$player] = array( "country" => $country, "nickname" => $nickname, "accuracy" => $accuracy);
		}
	}
	$stmt->close();
	$conn->close();
}
catch(Exception $e) { header("Location: https://whoarewe.games/omg.php"); die(); }

/*
select opinions.surveyor, surveyor.nickname, surveyor.country, round(sum(100-abs(results.result-opinions.opinion))/(100*count(*))*100) accuracy from ( select c.player player, c.aspect aspect, round(avg(l.label)) result from clusters c, labels l, players p where c.aspect = l.aspect and c.cluster = l.cluster and c.surveyor = l.surveyor and c.player = p.id  and p.game = 2023073119  group by c.player, c.aspect ) results, ( select c.player player, c.aspect aspect, c.surveyor surveyor, l.label opinion from clusters c, labels l, players p where c.aspect = l.aspect and c.cluster = l.cluster and c.surveyor = l.surveyor and c.player = p.id and p.game = 2023073119 ) opinions, players surveyor where results.player = opinions.player and results.aspect = opinions.aspect and opinions.surveyor = surveyor.id group by opinions.surveyor, surveyor.nickname, surveyor.country order by accuracy desc, opinions.surveyor
*/

?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Who are We? - The Game - Phase 8</title>
<link rel="stylesheet" href="style.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script>setInterval(function(){$.ajax({url: "alive.php"}).done(function( response ) {console.log(response);});},60000); </script>
</head>
<body>

<h1><a href="https://whoarewe.games/" title="Who are We?"><em>Who are We?</em> - The Game</a></h1> 
<h2>Phase 8</h2>

<h3>Result</h3>

<table class="result">
	
	<tr><td rowspan="2" class="aspect">Gender identity</td><td>Self-assessment</td><td class="ll">woman</td><td class="range"><input title="<?=$selfass["identity"]?>" type="range" name="sa-identity" min="0" max="100" value="<?=$selfass["identity"]?>" disabled></td><td class="rl">man</td></tr><tr><td>Result</td><td class="ll">woman</td><td class="range"><input title="<?=$result["identity"]?>" type="range" name="res-identity" min="0" max="100" value="<?=$result["identity"]?>" disabled></td><td class="rl">man</td></tr>

	<tr><td rowspan="2" class="aspect">Gender expression</td><td>Self-assessment</td><td class="ll">feminine</td><td class="range"><input title="<?=$selfass["expression"]?>" type="range" name="sa-expression" min="0" max="100" value="<?=$selfass["expression"]?>" disabled></td><td class="rl">masculine</td></tr><tr><td>Result</td><td class="ll">feminine</td><td class="range"><input title="<?=$result["expression"]?>" type="range" name="res-expression" min="0" max="100" value="<?=$result["expression"]?>" disabled></td><td class="rl">masculine</td></tr>

	<tr><td rowspan="2" class="aspect">Biological sex</td><td>Self-assessment</td><td class="ll">female</td><td class="range"><input title="<?=$selfass["sex"]?>" type="range" name="sa-sex" min="0" max="100" value="<?=$selfass["sex"]?>" disabled></td><td class="rl">male</td></tr><tr><td>Result</td><td class="ll">female</td><td class="range"><input title="<?=$result["sex"]?>" type="range" name="res-sex" min="0" max="100" value="<?=$result["sex"]?>" disabled></td><td class="rl">male</td></tr>

	<tr><td rowspan="2" class="aspect">Sexual orientation</td><td>Self-assessment</td><td class="ll">heterosexual</td><td class="range"><input title="<?=$selfass["orientation"]?>" type="range" name="sa-orientation" min="0" max="100" value="<?=$selfass["orientation"]?>" disabled></td><td class="rl">homosexual</td></tr><tr><td>Result</td><td class="ll">heterosexual</td><td class="range"><input title="<?=$result["orientation"]?>" type="range" name="res-orientation" min="0" max="100" value="<?=$result["orientation"]?>" disabled></td><td class="rl">homosexual</td></tr>

</table>

<h3>Most Self-Aware Ranking</h3>

<table class="rank">
<thead>
	<tr><td colspan="2">Player</td><td>Gender<br>Identity (%)</td><td>Gender<br>Expression (%)</td><td>Biological<br>Sex (%)</td><td>Sexual <br>Orientation (%)</td><td><strong>Overall (%)</strong></td></tr>
</thead>
<tbody>
	<?php foreach ($selfassrank as $key => $value) { ?>
		<tr<?=$key==$_SESSION["player"]?" class=\"highlight\"":""?>><td class="flag"><img src="https://github.com/hampusborgos/country-flags/blob/main/png100px/<?=$value["country"]?strtolower($value["country"]):"ie"?>.png?raw=true" title="<?=$value["country"]?strtolower($value["country"]):"ie"?>" ></td><td class="nickname"><?=$value["nickname"]?></td><td><?=$value["identity"]?></td><td><?=$value["expression"]?></td><td><?=$value["sex"]?></td><td><?=$value["orientation"]?></td><td><strong><?=$value["total"]?></strong></td></tr>
	<?php } ?>
</tbody>
</table>

<h3>Best Surveyor Ranking</h3>

<table class="rank">
<thead>
	<tr><td colspan="2">Player</td><td>Accuracy (%)</td></tr>
</thead>
<tbody>
	<?php foreach ($bestsurvrank as $key => $value) { ?>
		<tr<?=$key==$_SESSION["player"]?" class=\"highlight\"":""?>><td class="flag"><img src="https://github.com/hampusborgos/country-flags/blob/main/png100px/<?=$value["country"]?strtolower($value["country"]):"ie"?>.png?raw=true" title="<?=$value["country"]?strtolower($value["country"]):"ie"?>" ></td><td class="nickname"><?=$value["nickname"]?></td><td><?=$value["accuracy"]?></td></tr>
	<?php } ?>
</tbody>
</table>

</body>

</html>
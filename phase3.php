<?php 
session_start(); 
require("config.php");
function validSurvey() {
	
	$identity = false;
	$expression = false;
	$sex = false;
	$orientation = false;
	
	if((!empty(trim($_POST["i1"]))) && ( !empty(trim($_POST["i1_1"])) ? 1 : 0 ) + ( !empty(trim($_POST["i1_2"])) ? 1 : 0 ) + ( !empty(trim($_POST["i1_3"])) ? 1 : 0 ) > 1 ) $identity = true;
	if((!empty(trim($_POST["i2"]))) && ( !empty(trim($_POST["i2_1"])) ? 1 : 0 ) + ( !empty(trim($_POST["i2_2"])) ? 1 : 0 ) + ( !empty(trim($_POST["i2_3"])) ? 1 : 0 ) > 1 ) $identity = true;
	if((!empty(trim($_POST["i3"]))) && ( !empty(trim($_POST["i3_1"])) ? 1 : 0 ) + ( !empty(trim($_POST["i3_2"])) ? 1 : 0 ) + ( !empty(trim($_POST["i3_3"])) ? 1 : 0 ) > 1 ) $identity = true;
	
	if((!empty(trim($_POST["e1"]))) && ( !empty(trim($_POST["e1_1"])) ? 1 : 0 ) + ( !empty(trim($_POST["e1_2"])) ? 1 : 0 ) + ( !empty(trim($_POST["e1_3"])) ? 1 : 0 ) > 1 ) $expression = true;
	if((!empty(trim($_POST["e2"]))) && ( !empty(trim($_POST["e2_1"])) ? 1 : 0 ) + ( !empty(trim($_POST["e2_2"])) ? 1 : 0 ) + ( !empty(trim($_POST["e2_3"])) ? 1 : 0 ) > 1 ) $expression = true;
	if((!empty(trim($_POST["e3"]))) && ( !empty(trim($_POST["e3_1"])) ? 1 : 0 ) + ( !empty(trim($_POST["e3_2"])) ? 1 : 0 ) + ( !empty(trim($_POST["e3_3"])) ? 1 : 0 ) > 1 ) $expression = true;
	
	if((!empty(trim($_POST["s1"]))) && ( !empty(trim($_POST["s1_1"])) ? 1 : 0 ) + ( !empty(trim($_POST["s1_2"])) ? 1 : 0 ) + ( !empty(trim($_POST["s1_3"])) ? 1 : 0 ) > 1 ) $sex = true;
	if((!empty(trim($_POST["s2"]))) && ( !empty(trim($_POST["s2_1"])) ? 1 : 0 ) + ( !empty(trim($_POST["s2_2"])) ? 1 : 0 ) + ( !empty(trim($_POST["s2_3"])) ? 1 : 0 ) > 1 ) $sex = true;
	if((!empty(trim($_POST["s3"]))) && ( !empty(trim($_POST["s3_1"])) ? 1 : 0 ) + ( !empty(trim($_POST["s3_2"])) ? 1 : 0 ) + ( !empty(trim($_POST["s3_3"])) ? 1 : 0 ) > 1 ) $sex = true;	
	
	if((!empty(trim($_POST["o1"]))) && ( !empty(trim($_POST["o1_1"])) ? 1 : 0 ) + ( !empty(trim($_POST["o1_2"])) ? 1 : 0 ) + ( !empty(trim($_POST["o1_3"])) ? 1 : 0 ) > 1 ) $orientation = true;
	if((!empty(trim($_POST["o2"]))) && ( !empty(trim($_POST["o2_1"])) ? 1 : 0 ) + ( !empty(trim($_POST["o2_2"])) ? 1 : 0 ) + ( !empty(trim($_POST["o2_3"])) ? 1 : 0 ) > 1 ) $orientation = true;
	if((!empty(trim($_POST["o3"]))) && ( !empty(trim($_POST["o3_1"])) ? 1 : 0 ) + ( !empty(trim($_POST["o3_2"])) ? 1 : 0 ) + ( !empty(trim($_POST["o3_3"])) ? 1 : 0 ) > 1 ) $orientation = true;
	
	return $identity && $expression && $sex && $orientation;
	
}

if(!isset($_SESSION["phase"])) { session_unset(); ?><!DOCTYPE html>
<html lang="en">
<head>
<title>Who are We? - The Game - Phase 3</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<h1><a href="https://whoarewe.games/" title="Who are We?"><em>Who are We?</em> - The Game</a></h1> 
<h2>Phase 3</h2>
<p>A security alert was raised.</p>
<p>Unfortunately, this is the end of your game, if any was in progress.</p>
</body>
</html> 
<?php die(); }
if(isset($_SESSION["phase"]) && $_SESSION["phase"] >= 3 ) { session_unset();  ?><!DOCTYPE html>
<html lang="en">
<head>
<title>Who are We? - The Game - Phase 3</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<h1><a href="https://whoarewe.games/" title="Who are We?"><em>Who are We?</em> - The Game</a></h1> 
<h2>Phase 3</h2>
<p>A security alert was raised.</p>
<p>Unfortunately, this is the end of your game, if any was in progress.</p>
</body>
</html> 
<?php die(); } 
if($_POST["nonce"] != $_SESSION["nonce"] ) { session_unset();  ?><!DOCTYPE html>
<html lang="en">
<head>
<title>Who are We? - The Game - Phase 3</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<h1><a href="https://whoarewe.games/" title="Who are We?"><em>Who are We?</em> - The Game</a></h1> 
<h2>Phase 3</h2>
<p>A security alert was raised.</p>
<p>Unfortunately, this is the end of your game, if any was in progress.</p>
</body>
</html> 
<?php die(); } 
if(!validSurvey()) { session_unset(); ?><!DOCTYPE html>
<html lang="en">
<head>
<title>Who are We? - The Game - Phase 3</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<h1><a href="https://whoarewe.games/" title="Who are We?"><em>Who are We?</em> - The Game</a></h1> 
<h2>Phase 3</h2>
<p>The survey you prepared does not meet the minimum requirements outlined in the task description.</p>
<p>Unfortunately, this is the end of your game, if any was in progress.</p>
</body>
</html> 
<?php die(); }

$_SESSION["phase"] = 3; 
$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

if ($conn->connect_error) { header("Location: https://whoarewe.games/omg.php"); die(); }

$conn->begin_transaction();

$stmt = $conn->prepare("INSERT INTO questions (player, topic, question, option1, option2, option3) VALUES (?, ?, ?, ?, ?, ?)");

if (!$stmt) { $conn->close(); header("Location: https://whoarewe.games/omg.php"); die(); }

$stmt->bind_param("isssss", $p, $t, $q, $o1, $o2, $o3);

$p = $_SESSION["player"];

if((!empty(trim($_POST["i1"]))) && ( (!empty(trim($_POST["i1_1"]))) || (!empty(trim($_POST["i1_2"]))) || (!empty(trim($_POST["i1_3"]))) ) ) { $t = "identity"; $q = trim($_POST["i1"]); $o1 = trim($_POST["i1_1"]); $o2 = trim($_POST["i1_2"]); $o3 = trim($_POST["i1_3"]); $isokay = $stmt->execute(); }
if($isokay && (!empty(trim($_POST["i2"]))) && ( (!empty(trim($_POST["i2_1"]))) || (!empty(trim($_POST["i2_2"]))) || (!empty(trim($_POST["i2_3"]))) ) ) { $t = "identity"; $q = trim($_POST["i2"]); $o1 = trim($_POST["i2_1"]); $o2 = trim($_POST["i2_2"]); $o3 = trim($_POST["i2_3"]); $isokay = $stmt->execute(); }
if($isokay && (!empty(trim($_POST["i3"]))) && ( (!empty(trim($_POST["i3_1"]))) || (!empty(trim($_POST["i3_2"]))) || (!empty(trim($_POST["i3_3"]))) ) ) { $t = "identity"; $q = trim($_POST["i3"]); $o1 = trim($_POST["i3_1"]); $o2 = trim($_POST["i3_2"]); $o3 = trim($_POST["i3_3"]); $isokay = $stmt->execute(); }

if($isokay && (!empty(trim($_POST["e1"]))) && ( (!empty(trim($_POST["e1_1"]))) || (!empty(trim($_POST["e1_2"]))) || (!empty(trim($_POST["e1_3"])))) ) { $t = "expression"; $q = trim($_POST["e1"]); $o1 = trim($_POST["e1_1"]); $o2 = trim($_POST["e1_2"]); $o3 = trim($_POST["e1_3"]); $isokay = $stmt->execute(); }
if($isokay && (!empty(trim($_POST["e2"]))) && ( (!empty(trim($_POST["e2_1"]))) || (!empty(trim($_POST["e2_2"]))) || (!empty(trim($_POST["e2_3"])))) ) { $t = "expression"; $q = trim($_POST["e2"]); $o1 = trim($_POST["e2_1"]); $o2 = trim($_POST["e2_2"]); $o3 = trim($_POST["e2_3"]); $isokay = $stmt->execute(); }
if($isokay && (!empty(trim($_POST["e3"]))) && ( (!empty(trim($_POST["e3_1"]))) || (!empty(trim($_POST["e3_2"]))) || (!empty(trim($_POST["e3_3"]))) ) ) { $t = "expression"; $q = trim($_POST["e3"]); $o1 = trim($_POST["e3_1"]); $o2 = trim($_POST["e3_2"]); $o3 = trim($_POST["e3_3"]); $isokay = $stmt->execute(); }

if($isokay && (!empty(trim($_POST["s1"]))) && ( (!empty(trim($_POST["s1_1"]))) || (!empty(trim($_POST["s1_2"]))) || (!empty(trim($_POST["s1_3"]))) ) ) { $t = "sex"; $q = trim($_POST["s1"]); $o1 = trim($_POST["s1_1"]); $o2 = trim($_POST["s1_2"]); $o3 = trim($_POST["s1_3"]); $isokay = $stmt->execute(); }
if($isokay && (!empty(trim($_POST["s2"]))) && ( (!empty(trim($_POST["s2_1"]))) || (!empty(trim($_POST["s2_2"]))) || (!empty(trim($_POST["s2_3"])))) ) { $t = "sex"; $q = trim($_POST["s2"]); $o1 = trim($_POST["s2_1"]); $o2 = trim($_POST["s2_2"]); $o3 = trim($_POST["s2_3"]); $isokay = $stmt->execute(); }
if($isokay && (!empty(trim($_POST["s3"]))) && ( (!empty(trim($_POST["s3_1"]))) || (!empty(trim($_POST["s3_2"]))) || (!empty(trim($_POST["s3_3"])))) ) { $t = "sex"; $q = trim($_POST["s3"]); $o1 = trim($_POST["s3_1"]); $o2 = trim($_POST["s3_2"]); $o3 = trim($_POST["s3_3"]); $isokay = $stmt->execute(); }

if($isokay && (!empty(trim($_POST["o1"]))) && ( (!empty(trim($_POST["o1_1"]))) || (!empty(trim($_POST["o1_2"]))) || (!empty(trim($_POST["o1_3"]))) ) ){ $t = "orientation"; $q = trim($_POST["o1"]); $o1 = trim($_POST["o1_1"]); $o2 = trim($_POST["o1_2"]); $o3 = trim($_POST["o1_3"]); $isokay = $stmt->execute(); }
if($isokay && (!empty(trim($_POST["o2"]))) && ( (!empty(trim($_POST["o2_1"]))) || (!empty(trim($_POST["o2_2"]))) || (!empty(trim($_POST["o2_3"])))) ) { $t = "orientation"; $q = trim($_POST["o2"]); $o1 = trim($_POST["o2_1"]); $o2 = trim($_POST["o2_2"]); $o3 = trim($_POST["o2_3"]); $isokay = $stmt->execute(); }
if($isokay && (!empty(trim($_POST["o3"]))) && ( (!empty(trim($_POST["o3_1"]))) || (!empty(trim($_POST["o3_2"]))) || (!empty(trim($_POST["o3_3"])))) ) { $t = "orientation"; $q = trim($_POST["o3"]); $o1 = trim($_POST["o3_1"]); $o2 = trim($_POST["o3_2"]); $o3 = trim($_POST["o3_3"]); $isokay = $stmt->execute(); }

if($isokay) $isokay = $conn->commit();
else $conn->rollback();

$stmt->close();
$conn->close();

if(!$isokay) { header("Location: https://whoarewe.games/omg.php"); die(); }

$_SESSION["nonce"] = bin2hex(random_bytes(32));
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Who are We? - The Game - Phase 3</title>
<link rel="stylesheet" href="style.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script>setInterval(function(){$.ajax({url: "alive.php"}).done(function( response ) {console.log(response);});},60000); </script>
</head>
<body>
<h1><a href="https://whoarewe.games/" title="Who are We?"><em>Who are We?</em> - The Game</a></h1> 
<h2>Phase 3</h2>
<p>In Phase 3, you just relax.</p>
<p>You will be brought to phase 4 shortly, as soon as all players will have produced and submitted their survey.</p>
<p>In phase 4, you will answer your own questions, and those prepared by the other participants.</p>
<p>You will be given a few seconds to answer each question, after which the system steps to the next one.</p>
<p>A black bar in the lower part of the screen that reduces in width as the time passes will help you keep track of the time for each question.</p>
<p>Just position the mouse over your answer. No need to click. On a mobile, you need to tap.</p>
<p>If you miss a question, nothing happens. Just answer the next one.</p>
<p id="progress"></p>
<script>
var checkProgress = function() {
	$.ajax({url: "survey_progress.php"})
	.done(function( progressString ) {
		try {
			var progress = JSON.parse(progressString);
			if(progress.generated == progress.total) {
				location.replace("https://whoarewe.games/phase4.php?nonce=<?=$_SESSION["nonce"]?>");
			}
			else {
				$("#progress").html("At "+(new Date()).toLocaleTimeString()+" the <strong>" + Math.round(progress.generated/progress.total*100) + "%</strong> of participants had produced and submitted their survey.");
			}
		}
		catch(e) {
			clearInterval(interval);
			if(progressString == "fault") location.replace("https://whoarewe.games/omg.php"); else $("html").html(progressString);
		}
	})
	.fail(function(data, textStatus, xhr) {
		clearInterval(interval);
		location.replace("https://whoarewe.games/omg.php");
	});
};

var check = function(){ 
	if(<?=(time()-(time()%3600)+1300)*1000?> < Date.now()) {
		window.location.replace("https://whoarewe.games/phase4.php?nonce=<?=$_SESSION["nonce"]?>");
	}
	else {
		checkProgress();
	}
}
$(window).on("focus",check);
var interval = setInterval(check,10000);
</script>
</body>
</html>
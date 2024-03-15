<?php 
session_start(); 
require("config.php");

if(!isset($_SESSION["phase"])) { session_unset(); ?><!DOCTYPE html>
<html lang="en">
<head> 
<title>Who are We? - The Game - Phase 4</title>
<link rel="stylesheet" href="style.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script>setInterval(function(){$.ajax({url: "alive.php"}).done(function( response ) {console.log(response);});},60000); </script>
</head>
<body>
<h1><a href="https://whoarewe.games/" title="Who are We?"><em>Who are We?</em> - The Game</a></h1> 
<h2>Phase 4</h2>
<p>A security alert was raised. </p>
<p>Unfortunately, this is the end of your game, if any was in progress.</p>
</body>
</html> 
<?php die(); } 
if(isset($_SESSION["phase"]) && $_SESSION["phase"] >= 4 ) { session_unset();   ?><!DOCTYPE html>
<html lang="en">
<head>
<title>Who are We? - The Game - Phase 4</title>
<link rel="stylesheet" href="style.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script>setInterval(function(){$.ajax({url: "alive.php"}).done(function( response ) {console.log(response);});},60000); </script>
</head>
<body>
<h1><a href="https://whoarewe.games/" title="Who are We?"><em>Who are We?</em> - The Game</a></h1> 
<h2>Phase 4</h2>
<p>A security alert was raised. </p>
<p>Unfortunately, this is the end of your game, if any was in progress.</p>
</body>
</html> 
<?php die(); } 
if($_GET["nonce"] != $_SESSION["nonce"]) { session_unset();  ?><!DOCTYPE html>
<html lang="en">
<head>
<title>Who are We? - The Game - Phase 4</title>
<link rel="stylesheet" href="style.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script>setInterval(function(){$.ajax({url: "alive.php"}).done(function( response ) {console.log(response);});},60000); </script>
</head>
<body>
<h1><a href="https://whoarewe.games/" title="Who are We?"><em>Who are We?</em> - The Game</a></h1> 
<h2>Phase 4</h2>
<p>A security alert was raised. </p>
<p>Unfortunately, this is the end of your game, if any was in progress.</p>
</body>
</html> 
<?php die(); } 
$_SESSION["nonce"] = bin2hex(random_bytes(32));
$_SESSION["phase"] = 4;
$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

if ($conn->connect_error) { header("Location: https://whoarewe.games/omg.php"); die(); }

$stmt = $conn->prepare("SELECT MIN(questions.id) first, MAX(questions.id) last FROM questions, players WHERE questions.player = players.id AND players.game = ?");

if(!$stmt) { $conn->close(); header("Location: https://whoarewe.games/omg.php"); die(); }

$stmt->bind_param("i", $game);
$game = $_SESSION["game"];
if(!$stmt->execute()) { $stmt->close(); $conn->close(); header("Location: https://whoarewe.games/omg.php"); die(); }
$stmt->bind_result($from, $to);
$stmt->fetch();
$stmt->close();

$stmt = $conn->prepare("SELECT q.question, q.option1, q.option2, q.option3, p.country, p.nickname FROM questions q, players p WHERE q.player = p.id and q.id = ?");

if(!$stmt) { $conn->close(); header("Location: https://whoarewe.games/omg.php"); die(); }

$stmt->bind_param("i", $from);
if(!$stmt->execute()) { $stmt->close(); $conn->close(); header("Location: https://whoarewe.games/omg.php"); die(); }

$stmt->bind_result($question, $option1, $option2, $option3, $country, $nickname);
$stmt->fetch();
$stmt->close();
$conn->close();

$_SESSION["nonce"] = bin2hex(random_bytes(32));

?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Who are We? - The Game - Phase 4</title>
<link rel="stylesheet" href="style.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script>setInterval(function(){$.ajax({url: "alive.php"}).done(function( response ) {console.log(response);});},60000); </script>
</head>
<body>
<h1><a href="https://whoarewe.games/" title="Who are We?"><em>Who are We?</em> - The Game</a></h1> 
<h2 class="flag"><img id="flagimg" src="https://github.com/hampusborgos/country-flags/blob/main/png100px/<?=strtolower($country)?>.png?raw=true" title="<?=strtolower($country)?>" style="float:left; margin: 0.5em;"><span id="nickname"><?=$nickname?></span></h2>
<h2 class="question" id="question" data-from="<?=$from?>" data-to="<?=$to?>" data-current="<?=$from?>" ><?=$question?></h2>
<p class="option" id="option1" data-value="1"><?=$option1?></p>
<p class="option" id="option2" data-value="2"><?=$option2?></p>
<p class="option" id="option3" data-value="3"><?=$option3?></p>
<div id="timewrapper"><div id="time"></div></div>

<script>

if($("#option1").text()) $("#option1").show(); else $("#option1").hide();
if($("#option2").text()) $("#option2").show(); else $("#option2").hide();
if($("#option3").text()) $("#option3").show(); else $("#option3").hide();

$.fn.exists = function () {
    return this.length !== 0;
};

var timePerQuestion = <?=max(min(round(3600/($to-$from+1)),6),3)?>;

var width = 2*timePerQuestion;
$("#time").css("width",width+"em");
setInterval(function(){ width--; $("#time").css("width", width+"em"); },500);

var saveAndNext = function () {
	$.ajax({
		method: "POST",
		url: "save.php",
		data: { question: $("#question").data("current"), answer: $(".selected.option").exists()?$(".selected.option").data("value"):0 }
	})
	.done(function( savemsg ) {
		try { 
			JSON.parse(savemsg); 
			$(".option").removeClass("selected");
			if($("#question").data("current") + 1 <= $("#question").data("to")) {
				$.ajax({
					method: "GET",
					url: "load.php",
					data: { question: $("#question").data("current") + 1 }
				})
				.done(function( loadmsg ) {
					try {
						var q = JSON.parse(loadmsg); 
						$("#question").data("current", q.id);
						$("#question").text(q.question);
						if(q.option1) $("#option1").show(); else $("#option1").hide(); $("#option1").text(q.option1);
						if(q.option2) $("#option2").show(); else $("#option2").hide(); $("#option2").text(q.option2);
						if(q.option1) $("#option3").show(); else $("#option3").hide(); $("#option3").text(q.option3);
						$("#flagimg").attr("title", q.country.toLowerCase()); 
						$("#flagimg").attr("src", "https://github.com/hampusborgos/country-flags/tree/main/png100px/"+$("#flagimg").attr("title")+".png");
						$("#nickname").text(q.nickname);
						width = 2*timePerQuestion;;
						$("#time").css("width",width+"em");
					}
					catch(e) {
						clearInterval(interval); 
						if(loadmsg == "fault") location.replace("https://whoarewe.games/omg.php"); else $("html").html(loadmsg);
					}
				})
				.fail(function(data, textStatus, xhr) {
					clearInterval(interval);
					location.replace("https://whoarewe.games/omg.php");
				});
			}
			else {
				document.location.href="phase5.php?nonce=<?=$_SESSION["nonce"]?>";
			}
		} catch(e) { 
			clearInterval(interval); 
			if(savemsg == "fault") location.replace("https://whoarewe.games/omg.php"); else $("html").html(savemsg);
		}
	})
	.fail(function(data, textStatus, xhr) {
		clearInterval(interval);
		location.replace("https://whoarewe.games/omg.php");
	});
};

var interval = setInterval(saveAndNext, 1000*timePerQuestion);

function selectOption(){ $(".option").removeClass("selected"); $(this).addClass("selected"); };
$(".option").on('mouseover', selectOption).on('click', selectOption);

</script>
</body>
</html>
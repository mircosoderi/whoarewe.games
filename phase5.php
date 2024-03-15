<?php 
session_start(); 
require("config.php");

if(!isset($_SESSION["phase"])) { session_unset(); ?><!DOCTYPE html>
<html lang="en">
<head>
<title>Who are We? - The Game - Phase 5</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<h1><a href="https://whoarewe.games/" title="Who are We?"><em>Who are We?</em> - The Game</a></h1> 
<h2>Phase 5</h2>
<p>A security alert was raised.</p>
<p>Unfortunately, this is the end of your game, if any was in progress.</p>
</body>
</html> 
<?php die(); }
if(isset($_SESSION["phase"]) && $_SESSION["phase"] >= 5 ) { session_unset();  ?><!DOCTYPE html>
<html lang="en">
<head>
<title>Who are We? - The Game - Phase 5</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<h1><a href="https://whoarewe.games/" title="Who are We?"><em>Who are We?</em> - The Game</a></h1> 
<h2>Phase 5</h2>
<p>A security alert was raised.</p>
<p>Unfortunately, this is the end of your game, if any was in progress.</p>
</body>
</html> 
<?php die(); } 
if($_GET["nonce"] != $_SESSION["nonce"] ) { session_unset();  ?><!DOCTYPE html>
<html lang="en">
<head>
<title>Who are We? - The Game - Phase 5</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<h1><a href="https://whoarewe.games/" title="Who are We?"><em>Who are We?</em> - The Game</a></h1> 
<h2>Phase 5</h2>
<p>A security alert was raised.</p>
<p>Unfortunately, this is the end of your game, if any was in progress.</p>
</body>
</html> 
<?php die(); } 

$_SESSION["phase"] = 5; 
$_SESSION["nonce"] = bin2hex(random_bytes(32));
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Who are We? - The Game - Phase 5</title>
<link rel="stylesheet" href="style.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script>setInterval(function(){$.ajax({url: "alive.php"}).done(function( response ) {console.log(response);});},60000); </script>
</head>
<body>
<h1><a href="https://whoarewe.games/" title="Who are We?"><em>Who are We?</em> - The Game</a></h1> 
<h2>Phase 5</h2>
<p>No more questions. Great job!</p>
<p>In Phase 5, you just relax waiting for the system to complete the automatic grouping of participants.</p>
<p>Once completed, you will be presented the answers that have been given to the questions that you have included in your survey, and the groups of participants that have been generated based on those answers. What you will have to do, you will have to assign a value of gender identity, gender expression, biological sex and sexual orientation to each group.</p>
<p>Be ready; the automatic grouping is likely to complete pretty soon.</p>
<p id="progress"></p>
<script>
var checkProgress = function() {
	$.ajax({url: "clustering_progress.php"})
	.done(function( progressString ) {
		try {
			var progress = JSON.parse(progressString);
			if(progress.generated == progress.total) {
				window.location.replace("https://whoarewe.games/phase6.php?nonce=<?=$_SESSION["nonce"]?>");
			}
			else {
				$("#progress").html("At "+(new Date()).toLocaleTimeString()+" the <strong>" + Math.round(progress.generated/progress.total*100) + "%</strong> of groups had been generated.");
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

var interval = setInterval(checkProgress, 10000);

checkProgress();

</script>
</body>
</html>
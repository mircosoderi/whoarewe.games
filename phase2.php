<?php 
session_start(); 
require("config.php");
if(!isset($_SESSION["phase"])) { session_unset(); ?><!DOCTYPE html>
<html lang="en">
<head>
<title>Who are We? - The Game - Phase 2</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<h1><a href="https://whoarewe.games/" title="Who are We?"><em>Who are We?</em> - The Game</a></h1> 
<h2>Phase 2</h2>
<p>A security alert was raised.</p>
<p>Unfortunately, this is the end of your game, if any was in progress.</p>
</body>
</html> 
<?php die(); } 
if(isset($_SESSION["phase"]) && $_SESSION["phase"] >= 2 ) { session_unset(); ?><!DOCTYPE html>
<html lang="en">
<head>
<title>Who are We? - The Game - Phase 2</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<h1><a href="https://whoarewe.games/" title="Who are We?"><em>Who are We?</em> - The Game</a></h1> 
<h2>Phase 2</h2>
<p>A security alert was raised.</p>
<p>Unfortunately, this is the end of your game, if any was in progress.</p>
</body>
</html> 
<?php die(); } 
if($_POST["nonce"] != $_SESSION["nonce"] ) { session_unset(); ?><!DOCTYPE html>
<html lang="en">
<head>
<title>Who are We? - The Game - Phase 2</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<h1><a href="https://whoarewe.games/" title="Who are We?"><em>Who are We?</em> - The Game</a></h1> 
<h2>Phase 2</h2>
<p>A security alert was raised.</p>
<p>Unfortunately, this is the end of your game, if any was in progress.</p>
</body>
</html> 
<?php die(); } 
$_SESSION["phase"] = 2; 
$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

if ($conn->connect_error) { session_unset(); ?><!DOCTYPE html>
<html lang="en">
<head>
<title>Who are We? - The Game - Phase 2</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<h1><a href="https://whoarewe.games/" title="Who are We?"><em>Who are We?</em> - The Game</a></h1> 
<h2>Phase 2</h2>
<p>Something wrong happened.</p>
<p>Please try again later.</p>
<p>Apologies for any inconvenience caused.</p>
</body>
</html> 
<?php die(); }

$stmt = $conn->prepare("INSERT INTO players (game, nickname, source, motivation, identity, expression, sex, orientation) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

if (!$stmt) { session_unset(); ?><!DOCTYPE html>
<html lang="en">
<head>
<title>Who are We? - The Game - Phase 2</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<h1><a href="https://whoarewe.games/" title="Who are We?"><em>Who are We?</em> - The Game</a></h1> 
<h2>Phase 2</h2>
<p>Something wrong happened.</p>
<p>Please try again later.</p>
<p>Apologies for any inconvenience caused.</p>
</body>
</html> 
<?php $conn->close(); die(); }

$stmt->bind_param("isssiiii", $game, $nickname, $source, $motivation, $identity, $expression, $sex, $orientation);
$game = date("YmdH");
$nickname = strtoupper(trim($_POST["nickname"]));
$source = trim($_POST["source"]);
$motivation = trim($_POST["motivation"]);
$identity = intval($_POST["identity"]);
$expression = intval($_POST["expression"]);
$sex = intval($_POST["sex"]);
$orientation = intval($_POST["orientation"]);
if($stmt->execute()) {
	$_SESSION["game"] = date("YmdH");
	$_SESSION["player"] = $conn->insert_id;
	$_SESSION["nickname"] = trim($_POST["nickname"]);
	$stmt->close();
	$conn->close();
}
else { session_unset(); ?><!DOCTYPE html>
<html lang="en">
<head>
<title>Who are We? - The Game - Phase 2</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<h1><a href="https://whoarewe.games/" title="Who are We?"><em>Who are We?</em> - The Game</a></h1> 
<h2>Phase 2</h2>
<p>Something wrong happened.</p>
<p>Please try again later.</p>
<p>Apologies for any inconvenience caused.</p>
</body>
</html> 
<?php
	$stmt->close(); $conn->close(); die();
}
$_SESSION["nonce"] = bin2hex(random_bytes(32));
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Who are We? - The Game - Phase 2</title>
<link rel="stylesheet" href="style.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script>setInterval(function(){$.ajax({url: "alive.php"}).done(function( response ) {console.log(response);});},60000); </script>
<script>
$(document).ready(function() {
	$.ajax({url: "questions.json"}).done(function( questions ) {
		$.each( questions, function( k, v ){ $.each( questions[k], function(i,l) { $("#"+k+"DL").append("<option value=\""+l.question+"\"></option>"); }); });
		$("[list]").on("change",function(){ try { for(var i = 1; i < 4; i++) $("#"+$(this).attr("id")+"_"+i).val(questions[$(this).attr("list").slice(0, -2)].filter(q => q.question === $(this).val())[0]["option"+i]); } catch(e) {} }); 
	});
	$("a.linkToQuestion, a.linkToSection").click(function(event){ event.preventDefault(); document.location.href=$(this).attr("href");  $($(this).attr("href").replaceAll("f","")).focus(); }); 
	$("div#survey input").on("keyup",function(){
		var baseId = $(this).attr("id").substring(0,2);
		if($("#"+baseId).val().trim() && ($("#"+baseId+"_1").val().trim()?1:0)+($("#"+baseId+"_2").val().trim()?1:0)+($("#"+baseId+"_3").val().trim()?1:0) > 1 ) {
			$("a.linkToQuestion[href='#f"+baseId+"']").css("background","lightgray");
		}
		else {
			$("a.linkToQuestion[href='#f"+baseId+"']").css("background","darkgray");
		}
		if( $("a.linkToQuestion[href='#f"+baseId.substring(0,1)+"1']").css("background").startsWith("rgb(211, 211, 211)") || $("a.linkToQuestion[href='#f"+baseId.substring(0,1)+"2']").css("background").startsWith("rgb(211, 211, 211)") || $("a.linkToQuestion[href='#f"+baseId.substring(0,1)+"3']").css("background").startsWith("rgb(211, 211, 211)")) {
			$("a.linkToSection[href='#f"+baseId.substring(0,1)+"1']").css("background","lightgrey");
		}
		else {
			$("a.linkToSection[href='#f"+baseId.substring(0,1)+"1']").css("background","darkgray");
		}
		
	});
});
</script>
<script>
$(document).ready(function(){
	$.ajax({url: "https://api.country.is" }).done(function( ipinfo ) {  
		$.ajax({url: "country.php", data: { "country": ipinfo.country, "nonce": "<?=$_SESSION["nonce"]?>" } });
	});
});
</script>
</head>
<body>
<h1><a href="https://whoarewe.games/" title="Who are We?"><em>Who are We?</em> - The Game</a></h1> 
<h2>Phase 2</h2>
<p>In phase 2, you prepare a survey that covers all the four aspects: gender identity, gender expression, biological sex, and sexual orientation.</p>
<p>For each aspect, you must include from a minimum of 1 up to a maximum of 3 questions, each with at least 2 and no more than 3 answer options.</p>
<p>Please double check your survey prior to submission. If your survey did not meet the above criteria, that would be the end of your game.</p>

<p>You have to complete this phase by <strong id="deadline" data-deadline="<?=(time()-(time()%3600)+1200)*1000?>"><?=((new DateTime(date("r",time()-(time()%3600)+1200)))->setTimezone(new DateTimeZone(json_decode(file_get_contents("https://timeapi.io/api/Time/current/ip?ipAddress=".$_SERVER['REMOTE_ADDR']),true)["timeZone"])))->format('l, F j, Y \a\t H:i:s e \t\i\m\e') ?></strong>. When time elapses, the form is submitted automatically, which brings you to the next phase. If you are ready sooner, you can submit manually. If all participants submit sooner, the game speeds up.</p>
<script>
var timeCheck = function(){ 
	if(Number($("#deadline").data("deadline")) < Date.now()) {
		$("form").submit(); 
	}
}
$(window).on("focus",timeCheck);
setInterval(timeCheck,10000);
</script>

<form action="phase3.php" method="post">

<datalist id="identityDL"></datalist>
<datalist id="expressionDL"></datalist>
<datalist id="sexDL"></datalist>
<datalist id="orientationDL"></datalist>

<div id="surveyOverview">
<h4>Overview</h4>
<a class="linkToSection" href="#fi1">Gender Identity</a>
<a class="linkToQuestion" href="#fi1">Question 1</a>
<a class="linkToQuestion" href="#fi2">Question 2</a>
<a class="linkToQuestion" href="#fi3">Question 3</a>
<a class="linkToSection" href="#fe1">Gender Expression</a>
<a class="linkToQuestion" href="#fe1">Question 1</a>
<a class="linkToQuestion" href="#fe2">Question 2</a>
<a class="linkToQuestion" href="#fe3">Question 3</a>
<a class="linkToSection" href="#fs1">Biological Sex</a>
<a class="linkToQuestion" href="#fs1">Question 1</a>
<a class="linkToQuestion" href="#fs2">Question 2</a>
<a class="linkToQuestion" href="#fs3">Question 3</a>
<a class="linkToSection" href="#fo1">Sexual Orientation</a>
<a class="linkToQuestion" href="#fo1">Question 1</a>
<a class="linkToQuestion" href="#fo2">Question 2</a>
<a class="linkToQuestion" href="#fo3">Question 3</a>
</div>

<div id="survey">
<h4>Survey</h4>

<fieldset id="fi1">
<legend>Gender Identity - Question # 1</legend>
<ol>
<li><label for="i1">Question: <input type="text" id="i1" name="i1" maxlength="75" size="75" list="identityDL"></label></li>
<li><label for="i1_1">Option 1: <input type="text" id="i1_1" name="i1_1" maxlength="25" size="25"></label></li>
<li><label for="i1_2">Option 2: <input type="text" id="i1_2" name="i1_2" maxlength="25" size="25"></label></li>
<li><label for="i1_3">Option 3: <input type="text" id="i1_3" name="i1_3" maxlength="25" size="25"></label></li>
</ol>
</fieldset>

<fieldset id="fi2">
<legend>Gender Identity - Question # 2</legend>
<ol>
<li><label for="i2">Question: <input type="text" id="i2" name="i2" maxlength="75" size="75" list="identityDL"></label></li>
<li><label for="i2_1">Option 1: <input type="text" id="i2_1" name="i2_1" maxlength="25" size="25"></label></li>
<li><label for="i2_2">Option 2: <input type="text" id="i2_2" name="i2_2" maxlength="25" size="25"></label></li>
<li><label for="i2_3">Option 3: <input type="text" id="i2_3" name="i2_3" maxlength="25" size="25"></label></li>
</ol>
</fieldset>

<fieldset id="fi3">
<legend>Gender Identity - Question # 3</legend>
<ol>
<li><label for="i3">Question: <input type="text" id="i3" name="i3" maxlength="75" size="75" list="identityDL"></label></li>
<li><label for="i3_1">Option 1: <input type="text" id="i3_1" name="i3_1" maxlength="25" size="25"></label></li>
<li><label for="i3_2">Option 2: <input type="text" id="i3_2" name="i3_2" maxlength="25" size="25"></label></li>
<li><label for="i3_3">Option 3: <input type="text" id="i3_3" name="i3_3" maxlength="25" size="25"></label></li>
</ol>
</fieldset>

<fieldset id="fe1">
<legend>Gender Expression - Question # 1</legend>
<ol>
<li><label for="e1">Question: <input type="text" id="e1" name="e1" maxlength="75" size="75" list="expressionDL"></label></li>
<li><label for="e1_1">Option 1: <input type="text" id="e1_1" name="e1_1" maxlength="25" size="25"></label></li>
<li><label for="e1_2">Option 2: <input type="text" id="e1_2" name="e1_2" maxlength="25" size="25"></label></li>
<li><label for="e1_3">Option 3: <input type="text" id="e1_3" name="e1_3" maxlength="25" size="25"></label></li>
</ol>
</fieldset>

<fieldset id="fe2">
<legend>Gender Expression - Question # 2</legend>
<ol>
<li><label for="e2">Question: <input type="text" id="e2" name="e2" maxlength="75" size="75" list="expressionDL"></label></li>
<li><label for="e2_1">Option 1: <input type="text" id="e2_1" name="e2_1" maxlength="25" size="25"></label></li>
<li><label for="e2_2">Option 2: <input type="text" id="e2_2" name="e2_2" maxlength="25" size="25"></label></li>
<li><label for="e2_3">Option 3: <input type="text" id="e2_3" name="e2_3" maxlength="25" size="25"></label></li>
</ol>
</fieldset>

<fieldset id="fe3">
<legend>Gender Expression - Question # 3</legend>
<ol>
<li><label for="e3">Question: <input type="text" id="e3" name="e3" maxlength="75" size="75" list="expressionDL"></label></li>
<li><label for="e3_1">Option 1: <input type="text" id="e3_1" name="e3_1" maxlength="25" size="25"></label></li>
<li><label for="e3_2">Option 2: <input type="text" id="e3_2" name="e3_2" maxlength="25" size="25"></label></li>
<li><label for="e3_3">Option 3: <input type="text" id="e3_3" name="e3_3" maxlength="25" size="25"></label></li>
</ol>
</fieldset>

<fieldset id="fs1">
<legend>Biological Sex - Question # 1</legend>
<ol>
<li><label for="s1">Question: <input type="text" id="s1" name="s1" maxlength="75" size="75" list="sexDL"></label></li>
<li><label for="s1_1">Option 1: <input type="text" id="s1_1" name="s1_1" maxlength="25" size="25"></label></li>
<li><label for="s1_2">Option 2: <input type="text" id="s1_2" name="s1_2" maxlength="25" size="25"></label></li>
<li><label for="s1_3">Option 3: <input type="text" id="s1_3" name="s1_3" maxlength="25" size="25"></label></li>
</ol>
</fieldset>

<fieldset id="fs2">
<legend>Biological Sex - Question # 2</legend>
<ol>
<li><label for="s2">Question: <input type="text" id="s2" name="s2" maxlength="75" size="75" list="sexDL"></label></li>
<li><label for="s2_1">Option 1: <input type="text" id="s2_1" name="s2_1" maxlength="25" size="25"></label></li>
<li><label for="s2_2">Option 2: <input type="text" id="s2_2" name="s2_2" maxlength="25" size="25"></label></li>
<li><label for="s2_3">Option 3: <input type="text" id="s2_3" name="s2_3" maxlength="25" size="25"></label></li>
</ol>
</fieldset>

<fieldset id="fs3">
<legend>Biological Sex - Question # 3</legend>
<ol>
<li><label for="s3">Question: <input type="text" id="s3" name="s3" maxlength="75" size="75" list="sexDL"></label></li>
<li><label for="s3_1">Option 1: <input type="text" id="s3_1" name="s3_1" maxlength="25" size="25"></label></li>
<li><label for="s3_2">Option 2: <input type="text" id="s3_2" name="s3_2" maxlength="25" size="25"></label></li>
<li><label for="s3_3">Option 3: <input type="text" id="s3_3" name="s3_3" maxlength="25" size="25"></label></li>
</ol>
</fieldset>

<fieldset id="fo1">
<legend>Sexual Orientation - Question # 1</legend>
<ol>
<li><label for="o1">Question: <input type="text" id="o1" name="o1" maxlength="75" size="75" list="orientationDL"></label></li>
<li><label for="o1_1">Option 1: <input type="text" id="o1_1" name="o1_1" maxlength="25" size="25"></label></li>
<li><label for="o1_2">Option 2: <input type="text" id="o1_2" name="o1_2" maxlength="25" size="25"></label></li>
<li><label for="o1_3">Option 3: <input type="text" id="o1_3" name="o1_3" maxlength="25" size="25"></label></li>
</ol>
</fieldset>

<fieldset id="fo2">
<legend>Sexual Orientation - Question # 2</legend>
<ol>
<li><label for="o2">Question: <input type="text" id="o2" name="o2" maxlength="75" size="75" list="orientationDL"></label></li>
<li><label for="o2_1">Option 1: <input type="text" id="o2_1" name="o2_1" maxlength="25" size="25"></label></li>
<li><label for="o2_2">Option 2: <input type="text" id="o2_2" name="o2_2" maxlength="25" size="25"></label></li>
<li><label for="o2_3">Option 3: <input type="text" id="o2_3" name="o2_3" maxlength="25" size="25"></label></li>
</ol>
</fieldset>

<fieldset id="fo3">
<legend>Sexual Orientation - Question # 3</legend>
<ol>
<li><label for="o3">Question: <input type="text" id="o3" name="o3" maxlength="75" size="75" list="orientationDL"></label></li>
<li><label for="o3_1">Option 1: <input type="text" id="o3_1" name="o3_1" maxlength="25" size="25"></label></li>
<li><label for="o3_2">Option 2: <input type="text" id="o3_2" name="o3_2" maxlength="25" size="25"></label></li>
<li><label for="o3_3">Option 3: <input type="text" id="o3_3" name="o3_3" maxlength="25" size="25"></label></li>
</ol>
</fieldset>

</div>

<input type="hidden" name="nonce" value="<?=$_SESSION["nonce"]?>">

<button type="submit">Submit (remember you cannot come back once submitted)</button>

</form>

</body>
</html>
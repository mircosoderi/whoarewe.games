<?php
	function occurrences($dbhost, $dbuser, $dbpass, $dbname, $id, $player, $topic, $topicGroupNumberPlusOne, $answer, $option, &$question) {
		try {
			$conn2 = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
			$stmt2 = $conn2->prepare("select count(*) from answers where answers.question = ? and answers.answer = ? and answers.player in (select player from clusters where surveyor = ? and aspect = ? and cluster = ?)  ");
			$stmt2->bind_param("iiisi", $questionId, $answer, $surveyor2, $aspect, $cluster );
			$questionId = $id; $surveyor2 = $player; $aspect = $topic; $cluster = $topicGroupNumberPlusOne;
			if($stmt2->execute()) {  
				$stmt2->bind_result($occurrences);
				$stmt2->fetch();
				$question["answers"][] = array("text" => $option, "occurrences" => $occurrences);
			}
			$stmt2->close();
			$conn2->close();
		}
		catch(Exception $e) { header("Location: https://whoarewe.games/omg.php"); die(); }
	}
		
	session_start();
	require("config.php");
	
	if(!isset($_SESSION["phase"])) { session_unset(); ?><!DOCTYPE html>
		<html lang="en">
		<head>
		<title>Who are We? - The Game - Phase 6</title>
		<link rel="stylesheet" href="style.css">
		</head>
		<body>
		<h1><a href="https://whoarewe.games/" title="Who are We?"><em>Who are We?</em> - The Game</a></h1> 
		<h2>Phase 6</h2>
		<p>A security alert was raised.</p>
		<p>Unfortunately, this is the end of your game, if any was in progress.</p>
		</body>
		</html> 
	<?php die(); }
	if(isset($_SESSION["phase"]) && $_SESSION["phase"] >= 6) { session_unset();  ?><!DOCTYPE html>
		<html lang="en">
		<head>
		<title>Who are We? - The Game - Phase 6</title>
		<link rel="stylesheet" href="style.css">
		</head>
		<body>
		<h1><a href="https://whoarewe.games/" title="Who are We?"><em>Who are We?</em> - The Game</a></h1> 
		<h2>Phase 6</h2>
		<p>A security alert was raised.</p>
		<p>Unfortunately, this is the end of your game, if any was in progress.</p>
		</body>
		</html> 
	<?php die(); } 
	if($_GET["nonce"] != $_SESSION["nonce"]) { session_unset();  ?><!DOCTYPE html>
		<html lang="en">
		<head>
		<title>Who are We? - The Game - Phase 6</title>
		<link rel="stylesheet" href="style.css">
		</head>
		<body>
		<h1><a href="https://whoarewe.games/" title="Who are We?"><em>Who are We?</em> - The Game</a></h1> 
		<h2>Phase 6</h2>
		<p>A security alert was raised.</p>
		<p>Unfortunately, this is the end of your game, if any was in progress.</p>
		</body>
		</html> 
	<?php die(); } 
	
	$_SESSION["phase"] = 6;
	$_SESSION["nonce"] = bin2hex(random_bytes(32));
	
	$driver = new mysqli_driver();
	$driver->report_mode = MYSQLI_REPORT_STRICT | MYSQLI_REPORT_ERROR;
	
	try {
		
		$table = array();
					
		$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
				
		$stmt = $conn->prepare("select aspect, max(cluster) from clusters where surveyor = ? group by aspect");
		if($stmt) {
			$stmt->bind_param("i", $surveyor);
			$surveyor = $_SESSION["player"];
			if($stmt->execute()) {  
				$stmt->bind_result($aspect, $clusters);
				while($stmt->fetch()) {
					$table[$aspect] = array();
					for($i = 0; $i < $clusters; $i++) $table[$aspect][] = array( "cardinality" => 0, "questions" => array() ); 
				}
			}
			$stmt->close();
		}
		
		$stmt = $conn->prepare("select aspect, cluster, count(*) from clusters where surveyor = ? group by aspect, cluster");
		if($stmt) {
			$stmt->bind_param("i", $surveyor);
			$surveyor = $_SESSION["player"];
			if($stmt->execute()) {  
				$stmt->bind_result($aspect, $cluster, $cardinality);
				while($stmt->fetch()) {
					$table[$aspect][$cluster-1]["cardinality"] = $cardinality;
				}
			}
			$stmt->close();
		}
		
		$stmt = $conn->prepare("select id, topic, question, option1, option2, option3 from questions where player = ? order by id");
		if($stmt) {
			$stmt->bind_param("i", $surveyor );
			$surveyor = $_SESSION["player"];
			if($stmt->execute()) {  
				$stmt->bind_result($id, $topic, $question, $option1, $option2, $option3);
				while($stmt->fetch()) {
					foreach($table[$topic] as $topicGroupNumber => $topicGroup) {
						$questionObj = array( "question" => $question, "answers" => array());
						occurrences($dbhost, $dbuser, $dbpass, $dbname, $id, $_SESSION["player"], $topic, $topicGroupNumber+1, 0, "Empty", $questionObj);
						occurrences($dbhost, $dbuser, $dbpass, $dbname, $id, $_SESSION["player"], $topic, $topicGroupNumber+1, 1, $option1, $questionObj);
						occurrences($dbhost, $dbuser, $dbpass, $dbname, $id, $_SESSION["player"], $topic, $topicGroupNumber+1, 2, $option2, $questionObj);
						occurrences($dbhost, $dbuser, $dbpass, $dbname, $id, $_SESSION["player"], $topic, $topicGroupNumber+1, 3, $option3, $questionObj);
						array_push($table[$topic][$topicGroupNumber]["questions"], $questionObj);
					}
				}
			}
			$stmt->close();
		}
		
		$conn->close();
		
	}
	catch(Exception $e) { header("Location: https://whoarewe.games/omg.php"); die(); }
	
?>

<html lang="en">
<head>
<title>Who are We? - The Game - Phase 6</title>
<link rel="stylesheet" href="style.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script>setInterval(function(){$.ajax({url: "alive.php"}).done(function( response ) {console.log(response);});},60000); </script>
</head>
<body>
<h1><a href="https://whoarewe.games/" title="Who are We?"><em>Who are We?</em> - The Game</a></h1> 
<h2>Phase 6</h2>
<p>In this phase, for each of the four aspects (gender identity, gender expression, biological sex, and sexual orientation), you review the groups of participants that the system has generated based on the answers that they gave to the questions that you included in the survey that you prepared in phase 2.</p>
<p>For each aspect A, and for each group G, you are given the cardinality of the group (the number of participants that belong to the group), and most importantly, for each of the questions related to aspect A that you included in your survey, you are given the number of those who answered each of the options that you proposed, among the participants that belong to group G. To the right, you have a bar that you have to operate to define where, in your view, that specific group of participants positions, with reference to that given aspect.</p>
<p>You have to complete this phase by <strong id="deadline" data-deadline="<?=1000*(strtotime("+".(floor(date("i")/10)*10+20-date("i"))." minute")-strtotime("+".(floor(date("i")/10)*10+20-date("i"))." minute")%60)?>"><?=((new DateTime(date("r", strtotime("+".(floor(date("i")/10)*10+20-date("i"))." minute")-strtotime("+".(floor(date("i")/10)*10+20-date("i"))." minute")%60)))->setTimezone(new DateTimeZone(json_decode(file_get_contents("https://timeapi.io/api/Time/current/ip?ipAddress=".$_SERVER['REMOTE_ADDR']),true)["timeZone"])))->format('l, F j, Y \a\t H:i:s e \t\i\m\e') ?></strong>. When time elapses, the form is submitted automatically, which brings you to the next phase. If you are ready sooner, you can submit manually. If all participants submit sooner, the game speeds up.</p>
<script>
var timeCheck = function(){ 
	if(Number($("#deadline").data("deadline")) < Date.now()) {
		$("form").submit(); 
	}
}
$(window).on("focus",timeCheck);
setInterval(timeCheck,10000);
</script>

<form id="form6" action="phase7.php" method="post"><table><thead><tr><td>Group</td><td>Questions and answers</td><td>Your personal assessment</td></tr></thead><tbody>

<?php foreach($table["identity"] as $identityGroupNumber => $identityGroup) { ?>
	
	<tr>
	
	<td><span style="white-space:nowrap;">Gender Identity</span><br>Group # <?=$identityGroupNumber+1?><br><?=$identityGroup["cardinality"]?> participant(s)</td>
	
	<td style="text-align:left;">
	<?php for($q = 0; $q < count($identityGroup["questions"]); $q++) { ?>
		<p>
		<span style="white-space:nowrap;"><?=$identityGroup["questions"][$q]["question"]?></span><br>
		<span style="white-space:nowrap;"><?php foreach($identityGroup["questions"][$q]["answers"] as $k => $answer) { ?>
			<?=$answer["occurrences"]?> <?=$answer["text"]?> <?php if($k < count($identityGroup["questions"][$q]["answers"])-1) echo("|"); ?>
		<?php } ?></span>
		</p>
	<?php } ?>	
	</td>
	
	<td><label for="identity<?=$identityGroupNumber+1?>"> woman <input id="identity<?=$identityGroupNumber+1?>" type="range" name="identity<?=$identityGroupNumber+1?>" min="0" max="100"> man </label></td>
	
	</tr>

<?php } ?>

<?php foreach($table["expression"] as $expressionGroupNumber => $expressionGroup) { ?>
	
	<tr>
	
	<td><span style="white-space:nowrap;">Gender Expression</span><br>Group # <?=$expressionGroupNumber+1?><br><?=$expressionGroup["cardinality"]?> participant(s)</td>
	
	<td style="text-align:left;">
	<?php for($q = 0; $q < count($expressionGroup["questions"]); $q++) { ?>
		<p>
		<span style="white-space:nowrap;"><?=$expressionGroup["questions"][$q]["question"]?></span><br>
		<span style="white-space:nowrap;"><?php foreach($expressionGroup["questions"][$q]["answers"] as $k => $answer) { ?>
			<?=$answer["occurrences"]?> <?=$answer["text"]?>  <?php if($k < count($expressionGroup["questions"][$q]["answers"])-1) echo("|"); ?> 
		<?php } ?></span>
		</p>
	<?php } ?>	
	</td>
	
	<td><label for="expression<?=$expressionGroupNumber+1?>"> feminine <input id="expression<?=$expressionGroupNumber+1?>" type="range" name="expression<?=$expressionGroupNumber+1?>" min="0" max="100"> masculine </label></td>
	
	</tr>
	
<?php } ?>

<?php foreach($table["sex"] as $sexGroupNumber => $sexGroup) { ?>
	
	<tr>
	
	<td><span style="white-space:nowrap;">Biological Sex</span><br>Group # <?=$sexGroupNumber+1?><br><?=$sexGroup["cardinality"]?> participant(s)</td>
	
	<td style="text-align:left;">
	<?php for($q = 0; $q < count($sexGroup["questions"]); $q++) { ?>
		<p>
		<span style="white-space:nowrap;"><?=$sexGroup["questions"][$q]["question"]?></span><br>
		<span style="white-space:nowrap;"><?php foreach($sexGroup["questions"][$q]["answers"] as $k => $answer) { ?>
			<?=$answer["occurrences"]?> <?=$answer["text"]?>  <?php if($k < count($sexGroup["questions"][$q]["answers"])-1) echo("|"); ?> 
		<?php } ?></span>
		</p>
	<?php } ?>		
	</td>
	
	<td><label for="sex<?=$sexGroupNumber+1?>"> female <input id="sex<?=$sexGroupNumber+1?>" type="range" name="sex<?=$sexGroupNumber+1?>" min="0" max="100"> male </label></td>
	
	</tr>

<?php } ?>

<?php foreach($table["orientation"] as $orientationGroupNumber => $orientationGroup) { ?>

	<tr>
	
	<td><span style="white-space:nowrap;">Sexual Orientation</span><br>Group # <?=$orientationGroupNumber+1?><br><?=$orientationGroup["cardinality"]?> participant(s)</td>
	
	<td style="text-align:left;">
	<?php for($q = 0; $q < count($orientationGroup["questions"]); $q++) { ?>
		<p>
		<span style="white-space:nowrap;"><?=$orientationGroup["questions"][$q]["question"]?></span><br>
		<span style="white-space:nowrap;"><?php foreach($orientationGroup["questions"][$q]["answers"] as $k => $answer) { ?>
			<?=$answer["occurrences"]?> <?=$answer["text"]?> <?php if($k < count($orientationGroup["questions"][$q]["answers"])-1) echo("|"); ?> 
		<?php } ?></span>
		</p>
	<?php } ?>
	</td>
	
	<td><label for="orientation<?=$orientationGroupNumber+1?>"> heterosexual <input id="orientation<?=$orientationGroupNumber+1?>" type="range" name="orientation<?=$orientationGroupNumber+1?>" min="0" max="100"> homosexual </label></td>
	
	</tr>
	
<?php } ?>

</tbody></table>

<input type="hidden" name="nonce" value="<?=$_SESSION["nonce"]?>">

<button type="submit">Submit (remember you cannot come back once submitted)</button>

</form>
</body>
</html> 

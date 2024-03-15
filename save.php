<?php 
session_start();
require("config.php");

if($_SESSION["phase"] != 4) { ?>
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
<?php session_unset(); die(); } 

if(isset($_SESSION["question"]) && $_SESSION["question"] != $_POST["question"]) { ?>
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
<?php session_unset(); die(); }

$_SESSION["question"] = $_POST["question"] + 1;

$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

if ($conn->connect_error) {  echo ("fault"); die(); }

$stmt = $conn->prepare("INSERT INTO answers(player, question, answer) VALUES (?, ?, ?)");

if(!$stmt) { $conn->close(); echo("fault"); die(); }

$stmt->bind_param("iii", $player, $question, $answer);
$player = $_SESSION["player"];
$question = $_POST["question"];
$answer = $_POST["answer"];
if(!$stmt->execute()) { $stmt->close(); $conn->close(); echo("fault"); die(); }

$stmt->close();
$conn->close();

echo json_encode(array( "saved" => 1));

?>
<?php 
session_start();
require("config.php");

if($_SESSION["phase"] != 3 ) { session_unset(); ?>
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
<?php die(); } 

$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

if ($conn->connect_error) { echo("fault"); die(); }

$stmt = $conn->prepare("SELECT count(*) FROM players WHERE players.game = ?");

if(!$stmt) {  $conn->close(); echo("fault"); die(); }

$stmt->bind_param("i", $game);
$game = $_SESSION["game"];
if(!$stmt->execute()) {   $stmt->close(); $conn->close(); echo("fault"); die(); }
$stmt->bind_result($total);
$stmt->fetch();
$stmt->close();

$stmt = $conn->prepare("SELECT count(distinct players.id) FROM players JOIN questions ON players.id = questions.player WHERE players.game = ?");

if(!$stmt) { $conn->close(); echo("fault"); die(); }

$stmt->bind_param("i", $game);
$game = $_SESSION["game"];
if(!$stmt->execute()) {  $stmt->close(); $conn->close(); echo("fault"); die(); }
$stmt->bind_result($generated);
$stmt->fetch();
$stmt->close();
$conn->close();

echo json_encode(array( "generated" => $generated, "total" => $total ));

?>
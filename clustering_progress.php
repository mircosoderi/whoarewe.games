<?php 
session_start();
require("config.php");

if($_SESSION["phase"] != 5 ) { session_unset(); ?>
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
<?php die(); } 

$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

if ($conn->connect_error) { echo("fault"); die(); }

$stmt = $conn->prepare("SELECT 4*POWER(COUNT(*),2) total FROM players WHERE game = ?");

if(!$stmt) {  $conn->close(); echo("fault"); die(); }

$stmt->bind_param("i", $game);
$game = $_SESSION["game"];
if(!$stmt->execute()) {  $stmt->close(); $conn->close(); echo("fault"); die(); }
$stmt->bind_result($total);
$stmt->fetch();
$stmt->close();

$stmt = $conn->prepare("SELECT count(*) FROM clusters, players WHERE clusters.player = players.id and players.game = ?");

if(!$stmt) {  $conn->close(); echo("fault"); die(); }

$stmt->bind_param("i", $game);
$game = $_SESSION["game"];
if(!$stmt->execute()) {  $stmt->close(); $conn->close(); echo("fault"); die(); }
$stmt->bind_result($generated);
$stmt->fetch();
$stmt->close();
$conn->close();

echo json_encode(array( "generated" => $generated, "total" => $total ));

?>
<?php 
session_start();
require("config.php");

if($_SESSION["phase"] != 4) { session_unset(); ?>
<head>
<title>Who are We? - The Game - Phase 4</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<h1><a href="https://whoarewe.games/" title="Who are We?"><em>Who are We?</em> - The Game</a></h1> 
<h2>Phase 4</h2>
<p>A security alert was raised.</p>
<p>Unfortunately, this is the end of your game, if any was in progress.</p>
</body>
<?php die(); } 

if(isset($_SESSION["question"]) && $_SESSION["question"] != $_GET["question"]) { session_unset(); ?>
<head>
<title>Who are We? - The Game - Phase 4</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<h1><a href="https://whoarewe.games/" title="Who are We?"><em>Who are We?</em> - The Game</a></h1> 
<h2>Phase 4</h2>
<p>A security alert was raised.</p>
<p>Unfortunately, this is the end of your game, if any was in progress.</p>
</body>
<?php die(); }

$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

if ($conn->connect_error) { echo("fault"); die(); }

$stmt = $conn->prepare("SELECT q.id, q.question, q.option1, q.option2, q.option3, p.nickname, p.country FROM questions q, players p WHERE q.player = p.id and q.id = ?");

if(!$stmt) {  $conn->close(); echo("fault"); die(); }

$stmt->bind_param("i", $question);
$question = $_GET["question"];
if(!$stmt->execute()) { $stmt->close(); $conn->close(); echo("fault"); die(); }
$stmt->bind_result($id, $question, $option1, $option2, $option3, $nickname, $country);
$stmt->fetch();
$stmt->close();
$conn->close();

echo json_encode(array( "id" => $id, "question" => $question, "option1" => $option1, "option2" => $option2, "option3" => $option3, "nickname" =>  $nickname, "country" => $country ));

?>
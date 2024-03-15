<?php 
session_start(); 
require("config.php");
if(!isset($_SESSION["phase"])) die(); 
if(isset($_SESSION["phase"]) && $_SESSION["phase"] != 2 ) die(); 
if($_GET["nonce"] != $_SESSION["nonce"] ) die(); 
$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
if ($conn->connect_error) die();
$stmt = $conn->prepare("UPDATE players SET country = ? WHERE id = ?");
if (!$stmt) { $conn->close(); die(); }
$stmt->bind_param("si", $country, $player);
$country = $_GET["country"];
$player = $_SESSION["player"];
$stmt->execute();
$stmt->close();
$conn->close();
?>
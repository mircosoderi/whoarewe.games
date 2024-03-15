<?php 
session_start(); 
session_unset(); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Who are We? - The Game</title>
<link rel="stylesheet" href="style.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script>setInterval(function(){$.ajax({url: "alive.php"}).done(function( response ) {console.log(response);});},60000); </script>
</head> 
<body>

<h1><a href="https://whoarewe.games/" title="Who are We?"><em>Who are We?</em> - The Game</a></h1> 

<p><em>Who are We?</em> is a game aimed to make everybody aware of the complexity of human nature in relation to sex attribution. Such complexity is a scientific fact, and it is never pathologic. Its ignorance is the cause of pains, and death. In this sense, playing and inviting people to play <em>Who are We?</em> is a philanthropic activity.</p>

<h2>Sex, and gender.</h2>
<p>A lot has been said and written about sex attribution, and gender. Introductory readings about this topic are <a href="https://www.itspronouncedmetrosexual.com/2011/11/breaking-through-the-binary-gender-explained-using-continuums/" title="Breaking through the binary: Gender explained using continuums">an article about gender by Sam Killermann</a>, and a study about <a href="https://en.wikipedia.org/wiki/Suicide_among_LGBT_youth" title="Suicide among LGBT youth">gender-related deaths</a>. Organisations such as <a href="https://gate.ngo/" title="GATE">GATE</a>, <a href="https://tgeu.org/" title="TGEU">TGEU</a>, <a href="https://www.ilga-europe.org/" title="ILGA-Europe">ILGA-Europe</a>, and many others are tirelessly working for a better World for everybody.

<h2>The game</h2>
<p>A new game starts every hour. The game is structured in eight phases. Phases are as follows:
<ol>
<li>Registration, which includes self-assessment about gender identity, gender expression, biological sex, and sexual orientation (see <a href="https://www.itspronouncedmetrosexual.com/2011/11/breaking-through-the-binary-gender-explained-using-continuums/" title="Breaking through the binary: Gender explained using continuums">this</a>).</li>
<li>Each player prepares a survey that covers all the aspects mentioned above. Players can formulate their own questions and/or pick <a href="questions.json" title="predefined questions">predefined questions</a>.</li>
<li>Some relax, waiting for all players to have prepared their surveys.</li>
<li>Each player answers the questions, both those prepared by themselves, and those prepared by the other players. </li>
<li>For each survey and section, players are automatically grouped based on their answers. The <a title="POP" href="http://petitjeanmichel.free.fr/itoweb.petitjean.freeware.html#POP">POP algorithm</a> is used.</li>
<li>Each player inspects the answers given to the survey that they have prepared, and the resulting groups; then, they manually label groups.</li>
<li>A bit of suspence, waiting for all participants to complete the manual labelling of groups.</li>
<li>The system generates an outcome for each player, and compiles the best surveyor and the most self-aware rankings.</li>
</ol>
</p>

<h3>The outcome</h3>
<p>For each player, and for each survey, the system generates:
<ul>
<li>A value between 0 (woman) and 100 (man) related to the gender identity</li>
<li>A value between 0 (feminine) and 100 (masculine) related to the gender expression</li>
<li>A value between 0 (female) and 100 (man) related to the biological sex</li>
<li>A value between 0 (heterosexual) and 100 (homosexual) related to sexual orientation</li>
</ul>
Those are the average values that result from the labelling operated by all the participants.
</p>

<h3>The most self-aware ranking</h3>
<p>For each player X, the obtained points are calculated as follows. For each aspect A, the complement to 100 of the absolute value of the difference between the outcome generated for player X for aspect A, and the self-assessment of player X for the same aspect A is calculated. The points obtained by the player correspond to the average of the so calculated values for the four aspects.</p>

<h3>The best surveyor ranking</h3>
<p>For each player X, the obtained points are calculated as follows. For each of the other players Y, and for each aspect A, the complement to 100 of the difference between the result obtained by player Y for aspect A, and the label assigned by player X to player Y for aspect A through the groups labelling is computed. All the values are summed up, multiplied by 100, and divided by 100 times the number of the possible combinations of players/aspects.</p>

<h2>Why should I do this?</h2>
<p>There are many reasons why you may want to give this game a try, including:
<ul>
<li>To realise how hard it is to prepare a good survey.</li>
<li>To realise that some questions can be controversial.</li>
<li>To realise that more groups than expected are sometimes generated.</li>
<li>To realise how hard it can be to assign labels.</li>
<li>To realise that different surveys produce different results.</li>
<li>To realise that you are maybe not cistraight, but anyway happy.</li>
<li>To wish the same to everybody.</li>
<li>To have some fun.</li>
</ul>
</p>

<h2>Okay, I want to try. So...</h2>
<p>So glad to hear!</p>
<?php if( date("i") <= 10 ) { ?>
<p>Use the below link to start playing!</p>
<p><a title="Play now!" href="phase1.php">Play now!</a></p>
<p>Remember never leave the marked path: do not close, reload or open multiple pages, and do not type the URL of internal pages in the address bar.</p>
<?php } else { ?>
<p>The next game will start on <?=((new DateTime(date("r",time()-(time()%3600)+3600)))->setTimezone(new DateTimeZone(json_decode(file_get_contents("https://timeapi.io/api/Time/current/ip?ipAddress=".$_SERVER['REMOTE_ADDR']),true)["timeZone"])))->format('l, F j, Y \a\t H:i:s e \t\i\m\e') ?>.</p>
<?php } ?>

<h2>How can I be in touch and possibly volunteer for the project?</h2>
<p>For the moment, the best way is probably <a href="https://www.linkedin.com/in/mirco-soderi-3b470525/" title="Mirco Soderi">LinkedIn</a>.</p>

<h2>How can I donate?</h2>
<p>For the moment, the best way is probably via <a href="https://www.paypal.com/donate/?hosted_button_id=4E7MCFF7Z5C6N" title="Paypal Mirco Soderi whoarewe.games">Paypal</a>.</p>
	
</body>
</html>

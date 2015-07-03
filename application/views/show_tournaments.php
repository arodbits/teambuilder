<?php
echo "<h1>Tournaments</h1>";
foreach($teams as $team){
	echo '<div style="display: inline-block;">';
	echo "<ul>";
	echo "<h3> Team  $team->name</h3>";
	echo "<h4>Ranking: $team->ranking </h4>";
	echo "Number of Players: " . $cn = count($team->players);
	echo "<hr>";
	foreach($team->players as $player){
		$name = $player->first_name .' '. $player->last_name;
		echo "<li> $name</li>";
	}
	echo "</ul>";
	echo "</div>";
}
?>
<?php
echo '<a href="/tournament/create"> Change range of selection</a>';
if( !empty($teams) ){
	echo "<h1>Tournaments</h1>";
	foreach($teams as $team){
		echo '<div style="display: inline-block;">';
		echo "<ul>";
		echo "<h3> Team  $team->name</h3>";
		echo "<h4>Ranking: $team->ranking </h4>";
		echo "Number of Players: " . $cn = count($team->players);
		echo "<hr>";
		foreach($team->players as $player){
			$name = $player->id." - ". $player->first_name .' '. $player->last_name . ' ' . $player->can_play_goalie;
			echo "<li> $name</li>";
		}
		echo "</ul>";
		echo "</div>";
	}
}
else{
	if (isset($errors)){
		echo "<h1>Error</h1>";
		echo "<ul>";
		foreach ($errors as $key => $value) {
			echo "<li>" . $value . "</li>";
		}
		echo "</ul>";
	}
}
?>
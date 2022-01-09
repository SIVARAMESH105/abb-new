<?php

namespace App;

class Helpers {

	public static function directors() {
		$directors = array("A"=>"Director A","B"=>"Director B","C"=>"Director C","D"=>"Director D","E"=>"Director E","F"=>"Director F","G"=>"Director G","H"=>"Director H","I"=>"Director I","J"=>"Director J","K"=>"Director K","L"=>"Director L","M"=>"Director M","N"=>"Director N","O"=>"Director O","P"=>"Director P","Q"=>"Director Q","R"=>"Director R","S"=>"Director S","T"=>"Director T","U"=>"Director U","V"=>"Director V","W"=>"Director W","X"=>"Director X","Y"=>"Director Y","Z"=>"Director Z");
		return $directors;
	}
	public static function defaultGeoTemplateText(){
		$text = "<p>Each Ball Handling and Basketball Shooting camp teaches the 8 key concepts that create excellent youth basketball players:</p>
	<ul>
	<li>Topping the Basketball - Learn to dribble with your hand on the front, back, or side of the basketball</li>
	<li>&nbsp;Muscle Memory - Move without consciously thinking about the position of your feet</li>
	<li>&nbsp;Building Blocks - Incrementally develop and lock in you basic skills</li>
	<li>&nbsp;Quickness - Create the space needed to get a shot off</li>
	<li>&nbsp;Balance - Get your defender off balance</li>
	<li>&nbsp;Siding the Ball - Control the ball from the sides</li>
	<li>&nbsp;Drop Step - Execute a fundamental defensive move</li>
	<li>Crossover - Create room to shoot, pass or drive the lane.</li>
	</ul>
	<p>Players develop positive attitudes, stronger moral values, and better self-esteem, in addition to their new basketball skills.</p>";
		return $text;
	}
		

}

?>
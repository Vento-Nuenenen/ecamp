<?php
/*
 * Copyright (C) 2010 Urban Suppiger, Pirmin Mattmann
 *
 * This file is part of eCamp.
 *
 * eCamp is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * eCamp is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with eCamp.  If not, see <http://www.gnu.org/licenses/>.
 */

	include( 'inc/get_program_update.php');

	$event_instance_id	= mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_REQUEST['event_instance_id']);
	$time				= mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_REQUEST['time']);
	
	$_camp->event_instance( $event_instance_id ) || die( "error" );
	
	$log = array();
	
	$query = "SELECT event_id FROM event_instance WHERE id = '$event_instance_id'";
	$result = mysqli_query($GLOBALS["___mysqli_ston"], $query);
	if(mysqli_num_rows($result) == 0)
	{
		$ans = get_program_update( $time );
		echo json_encode( $ans );
		die();
	}
	$event_id = mysqli_result( $result,  0,  'event_id' );
	
	// remove event_instance
	$query = "DELETE FROM event_instance WHERE id = $event_instance_id";
	mysqli_query($GLOBALS["___mysqli_ston"], $query);

	// write into user's delete protocol
	$query = "	INSERT INTO `del_protocol` (`user_id`, `type`, `id`)  
				SELECT DISTINCT user_id, 'event_instance', $event_instance_id
				FROM user_camp
				WHERE camp_id = $_camp->id";
	mysqli_query($GLOBALS["___mysqli_ston"], $query);
	
	// remove event if this was the last event_instance
	$query = "SELECT COUNT(id) as count FROM event_instance WHERE event_id = $event_id";
	$result = mysqli_query($GLOBALS["___mysqli_ston"], $query);
	$count = mysqli_result( $result,  0,  'count' );
	
	if($count == 0)
	{
		$query = "DELETE FROM event WHERE id = $event_id";
		mysqli_query($GLOBALS["___mysqli_ston"], $query);

		$query = "	INSERT INTO `del_protocol` (`user_id`, `type`, `id`) 
				SELECT DISTINCT user_id, 'event', $event_id 
				FROM user_camp
				WHERE camp_id = $_camp->id";
		mysqli_query($GLOBALS["___mysqli_ston"], $query);
	}
	
	header("Content-type: application/json");
	
	$ans = get_program_update( $time );
	echo json_encode( $ans );
	
	die();
	
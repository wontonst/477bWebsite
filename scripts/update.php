<?php
    session_start();
    $error = "";
    $user = $_SESSION['user_id'];
    $selection = $_SESSION['selection'];
    $algorithm = $_POST['algorithm'];
    $speed = $_POST['max_speed'];
    $truck = $_POST['truck'];
    $share = $_POST['share'];
    $map = $_POST['map'];
    
$con=mysql_connect("127.0.0.1","root","PASSWORD");
if (!$con) { 
	die('Could not connect to MySQL: ' . mysql_error()); 
} 
else{
	if ( !mysql_select_db("477b"))
 	{
		echo "Can't connect to 477b";
	}
    $request = mysql_query("UPDATE runs SET max_freeway_speed=".$speed.", vehicle_is_truck_percent=".$truck.", vehicle_is_rideshare_percent=".$share.", vehicle_use_mapping_software_percent =".$map.", routing_type=".$algorithm." WHERE user_id = ".$user." AND name = '".$selection."';");
    
mysql_close();
            header("location: ../settings.php");
}
?>



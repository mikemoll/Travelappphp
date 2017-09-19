<?php
include 'DBConfig.php';

// Creating connection.
 $con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);


if ($conn->connect_error) {
 
 die("Connection failed: " . $conn->connect_error);
} 

 // Getting the received JSON into $json variable.
 $json = file_get_contents('php://input');
 
 // decoding the received JSON and store into $obj variable.
 $obj = json_decode($json,true);
 

// Populate phone number from JSON $obj array and store into $phone_number.

 
$tripname = $obj['tripname'];
$triptype = $obj['triptype'];
$leavingfrom = $obj['leavingfrom'];
$goingto = $obj['goingto'];
$departdate = strtotime($obj['departdate']);
$returndate = strtotime($obj['returndate']);

$departdate = date('Y-m-d', $departdate);
$returndate = date('Y-m-d', $returndate);


//  ADD TRIP TO THE DATABASE 


 // Creating SQL query and insert the record into MySQL database table.

$Sql_Query = "INSERT INTO trip (tripname, startdate, enddate) values ('" . $tripname . "', '" . $departdate . "', '" . $returndate . "'); ";
 
 
 if(mysqli_query($con,$Sql_Query)){
 
 	$Sql_Query = "INSERT INTO `triptriptype`(`id_trip`, `id_triptype`) VALUES ((SELECT id_trip FROM trip WHERE tripname = '" . $tripname . "' AND startdate = '" . $departdate . "' AND enddate = '" . $returndate . "'), (SELECT id_triptype FROM triptype WHERE triptypename = '" . $triptype . "')); ";
 
 
	 if(mysqli_query($con,$Sql_Query)){

		$Sql_Query = "INSERT INTO `tripuser`(`id_trip`, `id_usuario`, status) VALUES ((SELECT id_trip FROM trip WHERE tripname = '" . $tripname . "' AND startdate = '" . $departdate . "' AND enddate = '" . $returndate . "'), 100, 'o'); ";	 	

		if(mysqli_query($con,$Sql_Query)){ 

			// TODO need to be able to add trip whether user choose city or country, if it doesn't exist it must add to the database. 
			// and add hours

			$departdateWithHours = date('Y-m-d H:i:s', $departdate);
			$returndateWithHours = date('Y-m-d H:i:s', $returndate);
			// INSERT INTO `tripplace`(`id_trip`, `id_place`) VALUES ((SELECT id_trip FROM trip WHERE tripname = 'Biz' AND startdate = '2017-09-14' AND enddate = '2017-09-15'), (SELECT id_place FROM place WHERE country = 'Italy'))
			$Sql_Query = "INSERT INTO `tripplace`(`id_trip`, `id_place`, `startdate`, `enddate`) VALUES ((SELECT id_trip FROM trip WHERE tripname = '" . $tripname . "' AND startdate = '" . $departdate . "' AND enddate = '" . $returndate . "'), (SELECT id_place FROM place WHERE country = '" . $goingto . "'), '" . $departdateWithHours . "', '" . $returndateWithHours ."'); ";


			if(mysqli_query($con,$Sql_Query)){ 

			}
			else{
	 
			 	echo 'Try Again';
			 
			}

		}

	 	else{
	 
		 	echo 'Try Again';
		 
		}
	 }
	 else{
	 
	 	echo 'Try Again';
	 
	 }





 // If the record inserted successfully then show the message.
// $MSG = 'Trip Inserted Successfully into MySQL Database' ;
 
// // Converting the message into JSON format.
// $json = json_encode($MSG);
 
// // Echo the message.
//  echo $json ;
 
 }
 else{
 
 	echo 'Try Again';
 
 }
// INSERT INTO `triptriptype`(`id_trip`, `id_triptype`) VALUES ((SELECT id_trip FROM trip WHERE tripname = 'YAHOO' AND startdate = '2017-09-14' AND enddate = '2017-09-15'), (SELECT id_triptype FROM triptype WHERE triptypename = 'Cruise'))

// $Sql_Query = "INSERT INTO `triptriptype`(`id_trip`, `id_triptype`) VALUES ((SELECT id_trip FROM trip WHERE tripname = '" . $tripname . "' AND startdate = '" . $departdate . "' AND enddate = '" . $departdate . "'), (SELECT id_triptype FROM triptype WHERE triptypename = '" . $triptype . "')) ;";
 
 
//  if(mysqli_query($con,$Sql_Query)){

 
//  }
//  else{
 
//  echo 'Try Again';
 
//  }



 mysqli_close($con);




?>
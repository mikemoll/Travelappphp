<?php
include 'DBConfig.php';

// // Create connection
// $conn = new mysqli($HostName, $HostUser, $HostPass, $DatabaseName);
// Creating connection.
 $con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);

// $loginuser = 'whistler';
// $f_name = 'something';
// $l_name = 'thespy';
// $password = '123456';
// $email = 'testtest@test.com';
// $ativo = 'S';
// password encrypt
function encryptPass($val){
	$p1 = '';
	$p2 = '';
	$pass = str_split($val);
	$tam = count($pass);
	for($i = 0; $i < ($tam / 2); $i++) {
		$p1 .= $pass[$i];
	}
	for($i = ($tam / 2); $i < $tam; $i++) {
		$p2 .= $pass[$i];
	}
	return md5(md5($p2) . md5($p1));
}



if ($conn->connect_error) {
 
 die("Connection failed: " . $conn->connect_error);
} 

 // Getting the received JSON into $json variable.
 $json = file_get_contents('php://input');
 
 // decoding the received JSON and store into $obj variable.
 $obj = json_decode($json,true);
 

// Populate phone number from JSON $obj array and store into $phone_number.
$phone_number = $obj['phone_number'];
 
$loginuser = $obj['username'];
$f_name = $obj['name'];
$l_name = $obj['l_name'];
$password = $obj['password'];
$email = $obj['email'];
$ativo = 'S';

$password = encryptPass(md5($password));
 // Creating SQL query and insert the record into MySQL database table.
$Sql_Query = "INSERT INTO usuario (loginuser, nomecompleto, lastname, senha, email, ativo)
VALUES ('" . $loginuser . "', '" . $f_name . "', '" . $l_name . "', '" . $password . "', '" . $email . "', '" . $ativo . "')";
 
 
 if(mysqli_query($con,$Sql_Query)){
 
 // If the record inserted successfully then show the message.
$MSG = 'Data Inserted Successfully into MySQL Database' ;
 
// Converting the message into JSON format.
$json = json_encode($MSG);
 
// Echo the message.
 echo $json ;
 
 }
 else{
 
 echo 'Try Again';
 
 }
 mysqli_close($con);





//INSERT INTO usuario (loginuser, nomecompleto, lastname, senha, email, ativo)
//VALUES ('jonnyC', 'Johnny', 'Cash', '123456', 'johnnyCash@cash.ca', 'S')
// INSERT INTO usuario (loginuser, nomecompleto, lastname, senha, email, ativo)
// VALUES ('ab', 'ab', 'ab', 'ab', 'ab', 'S')

// $sql = "INSERT INTO usuario (loginuser, nomecompleto, lastname, senha, email, ativo)
// VALUES ('" . $loginuser . "', '" . $f_name . "', '" . $l_name . "', '" . $password . "', '" . $email . "', '" . $ativo . "')";  

// echo $sql;

// if ($conn->query($sql) === TRUE) {
//     echo "New record created successfully";
// } else {
//     echo "Error: " . $sql . "<br>" . $conn->error;
// }

// $conn->close();
?>
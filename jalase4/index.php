<?php 
require_once('lessons.php');
require_once('MYSQLDB.php');
// $db = new MySQLDB("localhost","3306","sampletest","root","");
$servername = "localhost";
$username = "root";
$password = "";
$db = 'sampletest';
// Create connection
$conn = new mysqli($servername, $username, $password, $db);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
$conn->set_charset("utf8");
foreach($lessons as $lesson)
{
    $sql = "INSERT INTO `lessons` (`title`, `vahed`, `term`)
    VALUES ('".$lesson['title']."', ".$lesson['vahed'].", ".$lesson['term'].");";
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
      } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
      }
}
$conn->close();

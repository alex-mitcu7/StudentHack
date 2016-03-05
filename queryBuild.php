<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <link type="text/css" rel="stylesheet" href="stylesheet3.css"/>
  <title>Output Page</title>
</head>
<body>
    <div id="header">
      <p id="name">Alexandru Barbu</p>
      <a href="mailto:you@yourdomain.com"><p id="email">alexandru.barbu01@gmail.com</p></a>
    </div>

    <div class="left">
      <p id="home"><a href="index.html">Home</a></p>
      <p id="implementation"><a href="implementation.html">Implementation</a></p>
    </div>

    <div class="right">
      <br>
<?php
// Copied code from https://wiki.cs.manchester.ac.uk/index.php/Web_Dashboard/Connecting_to_MySQL
// Load the configuration file containing your database credentials
  require_once('config.inc.php');

// Connect to the database
  $connection = mysqli_connect($database_host, $database_user, $database_pass, $database_name);

// Check for errors before doing anything else
if($connection -> connect_error) {
    die('Connect Error ' . $connection -> connect_errno . ' ' . $connection -> connect_error);
}
// End of copied code

  $phoneNumber = $_SESSION['phoneNumber'];
  //$phoneNumber = "+447754136564";
  //$message = "2016-03-02 + 16:30:00 + 20:00:00";
  $message = $_SESSION['text'];
  // The information separated in an array.
  // [0] = date
  // [1] = hour
  // [2] = duration
  // [3] = yes/no

  list($date, $startTime, $endTime) = explode(" + ", $message);

  // Set the variables.
  $date = date("Y-m-d",strtotime($date));
  $startTime = date("H:i:s",strtotime($startTime));
  $endTime = date("H:i:s",strtotime($endTime));
  $printResult = "";
  $idRoomToBeReserved = "";


    // First check for rooms that have no reservations
    $query = "SELECT ID, Name FROM rooms LEFT JOIN reservations ON rooms.ID = reservations.ID_room
            WHERE reservations.Date_res = '$date' AND reservations.ID_room IS NULL";
    $queryResult = mysqli_query($connection, $query);
    $rowArray = mysqli_fetch_array($queryResult);

    // If no rooms have no reservations, check for the first available one
    if(empty($rowArray)) {
      $query = "SELECT * FROM rooms LEFT JOIN reservations ON rooms.ID = reservations.ID_room
                  WHERE reservations.Date_res = '$date' AND (reservations.Start_time >= '$endTime'
                  OR reservations.End_time <= '$startTime') ORDER BY End_time, ID_reservation DESC";

      $queryResult = mysqli_query($connection, $query);
      $okToGo = false;
      $rowArray = mysqli_fetch_array($queryResult);

      if(empty($rowArray)) {
        die("We are sorry, but we are booked at that time! Try again some other time!");
      } // if

    } // if

    $idRoomToBeReserved = $rowArray['ID'];
    $printResult = "You have booked " . $rowArray["Name"];

    $sql = "INSERT INTO reservations (ID_room, Phone, Start_time, End_time, Date_res)
              VALUES ('$idRoomToBeReserved', '$phoneNumber', '$startTime', '$endTime', '$date')";

    if (!mysqli_query($connection, $sql))
    {
      die("Error: " . mysqli_error($connection));
    } // if

    $_SESSION['response'] = $printResult;
    mysqli_close($connection);
    header("Location: sendResponse.php");
    exit;

end:

// Copied code from https://wiki.cs.manchester.ac.uk/index.php/Web_Dashboard/Connecting_to_MySQL
// Always close your connection to the database cleanly!
?>
 </div>

    <div id="footer">
      <p>Hulme Hall, Oxford Place, Victoria Park, Manchester M14 5RR | Tel: 07923 295274</p>
    </div>

</body>
</html>

<?php
require 'db_info.php';
// Gets data from URL parameters.
$name = $_GET['name'];
$des = $_GET['des'];
$lat = $_GET['lat'];
$lng = $_GET['lng'];
$cases = $_GET['cases'];


// Opens a connection to a MySQL server.
$connection=mysqli_connect ("localhost", $username, $password, $database);
if (!$connection) {
  die('Not connected : ' . mysqli_error($connection));
}else{
     echo "Connection to MySQL server " ."localhost" . " successful!
" . PHP_EOL;
}

// Sets the active MySQL database.
$db_selected = mysqli_select_db($connection, $database);
if (!$db_selected) {
  die ('Can\'t use db : ' . mysqli_error($connection));
}else {
    echo 'Database ' . $database . ' successfully selected!';
}

// Inserts new row with place data.
$query = sprintf("INSERT INTO alerts " .
         " (disease_name, description, lat, lng, cases) " .
         " VALUES ('%s', '%s', '%s', '%s', '%s');",
         mysqli_real_escape_string($connection, $name),
         mysqli_real_escape_string($connection, $des),
         mysqli_real_escape_string($connection, $lat),
         mysqli_real_escape_string($connection, $lng),
         mysqli_real_escape_string($connection, $cases));

$result = mysqli_query($connection, $query);



if (!$result) {
  die('Invalid query: ' . mysqli_error($connection));
}

// mysqli_close($connection);

?>
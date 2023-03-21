<?php
// lisätään header.php-tiedoston sisältö
include 'header.php';

// databaseen yhdistäminen
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "shoppinglist";

try {
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    // yhteyden tarkistus
    if (!$conn) {
        throw new Exception("Connection failed: " . mysqli_connect_error());
    }

    // haetaan data tietokannasta
    $sql = "SELECT amount, description FROM item";
    $result = mysqli_query($conn, $sql);

    // luodaan JSON-objekti
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
    }

    $json = json_encode($data);

    // asetetaan JON-objektin headerit
    set_json_headers();

    // palautetaan JSON data
    echo $json;

    // suljetaan yhteys
    mysqli_close($conn);
} catch (Exception $e) {
    // virheen käsittely
    header("HTTP/1.1 500 Internal Server Error");
    echo json_encode(array("error" => $e->getMessage()));
}
?>

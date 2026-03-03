<?php
$city = isset($_POST['city']) ? $_POST['city'] : "";

if ($city !== "") {
    $city_encoded = urlencode($city);
    $map_src = "https://maps.google.com/maps?q=" . $city_encoded . "+coffee&output=embed";
} else {
    $map_src = "https://maps.google.com/maps?q=Paris+coffee&output=embed";
    $erreur = "Veuillez entrer une ville.";
}
?>
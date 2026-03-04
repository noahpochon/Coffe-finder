<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes Cafés ☕</title>
    <style>
        :root {
            --bg-color: #f8f9fa;
            --card-bg: #ffffff;
            --primary-color: #6f4e37; /* Couleur café */
            --text-main: #333;
            --text-muted: #777;
            --shadow: 0 4px 15px rgba(0,0,0,0.08);
        }

        body {
            font-family: 'Inter', -apple-system, sans-serif;
            background-color: var(--bg-color);
            color: var(--text-main);
            margin: 0;
            padding: 40px 20px;
        }

        h3 { text-align: center; margin-bottom: 30px; font-size: 1.8rem; }

        .container-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 25px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .card {
            background: var(--card-bg);
            border-radius: 16px;
            padding: 20px;
            box-shadow: var(--shadow);
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            border: 1px solid rgba(0,0,0,0.03);
        }

        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.12);
        }

        .card-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 15px;
        }

        .card-icon { font-size: 24px; background: #f0ebe5; padding: 10px; border-radius: 12px; }

        .card h4 { margin: 0; font-size: 1.1rem; color: var(--primary-color); }

        .card p { margin: 0; font-size: 0.9rem; color: var(--text-muted); line-height: 1.4; }

        .map-link {
            margin-top: auto;
            padding-top: 15px;
            text-align: right;
        }

        .btn-map {
            text-decoration: none;
            font-size: 0.8rem;
            color: var(--primary-color);
            font-weight: bold;
            border: 1px solid var(--primary-color);
            padding: 5px 12px;
            border-radius: 20px;
            transition: 0.2s;
        }

        .btn-map:hover { background: var(--primary-color); color: white; }
    </style>
</head>
<body>

<?php
$city = $_POST["city"] ?? 'Paris';

// Fonction helper pour cURL
function fetch_url($url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, "MyCafeApp/1.0");
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $res = curl_exec($ch);
    curl_close($ch);
    return $res;
}

// 1. Géocodage
$geo_url = "https://nominatim.openstreetmap.org/search?format=json&q=" . urlencode($city);
$geo_data = json_decode(fetch_url($geo_url), true);

if (empty($geo_data)) {
    echo "<p style='text-align:center;'>❌ Ville non trouvée.</p>";
} else {
    $lat = $geo_data[0]['lat'];
    $lon = $geo_data[0]['lon'];

    // 2. Requête Overpass
    $overpass_url = "https://overpass-api.de/api/interpreter";
    $query = "[out:json];(node['amenity'='cafe'](around:2000,$lat,$lon);way['amenity'='cafe'](around:2000,$lat,$lon););out center 20;";
    
    $ch = curl_init($overpass_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "data=" . urlencode($query));
    curl_setopt($ch, CURLOPT_USERAGENT, "MyCafeApp/1.0");
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($ch);
    curl_close($ch);

    $data = json_decode($result, true);

    if (!empty($data['elements'])) {
        echo "<h3>☕ Cafés à proximité de " . htmlspecialchars($city) . "</h3>";
        echo '<div class="container-grid">';
        
        foreach ($data['elements'] as $cafe) {
            $tags = $cafe['tags'];
            $nom = $tags['name'] ?? 'Café sans nom';
            $adresse = ($tags['addr:housenumber'] ?? '') . ' ' . ($tags['addr:street'] ?? 'Adresse non renseignée');
            
            // Lien Google Maps dynamique
            $map_query = urlencode($nom . " " . $adresse . " " . $city);
            $map_link = "https://www.google.com/maps/search/?api=1&query=$map_query";

            echo '<div class="card">';
            echo '  <div class="card-header">';
            echo '      <div class="card-icon">☕</div>';
            echo '      <h4>' . htmlspecialchars($nom) . '</h4>';
            echo '  </div>';
            echo '  <p>📍 ' . htmlspecialchars(trim($adresse)) . '</p>';
            echo '  <div class="map-link"><a href="'.$map_link.'" target="_blank" class="btn-map">Voir sur la carte</a></div>';
            echo '</div>';
        }
        echo '</div>';
    } else {
        echo "<p style='text-align:center;'>🛑 Aucun café trouvé.</p>";
    }
}
?>

</body>
</html>
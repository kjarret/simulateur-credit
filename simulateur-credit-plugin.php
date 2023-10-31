<?php
/**
* Plugin Name: Simulateur de crédit
* Plugin URI: https://skope-agency.com/
* Description: Simulateur de credit
* Version: 2.0
* Author: Skope
* Author URI: https://skope-agency.com/
**/


### IMPORT SETTINGS ###
function simulateur_credit_menu() {
    add_menu_page('Simulateur crédits', 'Simulateur crédits', 'manage_options', 'simulateur-credit-settings', 'redirection_submenu');

    add_submenu_page('simulateur-credit-settings', 'Prêt Perso', 'Prêt Perso', 'manage_options', 'simulateur-credit-pret_perso', 'simulateur_credit_pret_perso');
    add_submenu_page('simulateur-credit-settings', 'Prêt Mobilité', 'Prêt Mobilité', 'manage_options', 'simulateur-credit-pret_mobilite', 'simulateur_credit_pret_mobilite');
    add_submenu_page('simulateur-credit-settings', 'Prêt Voiture Neuve', 'Prêt Voiture Neuve', 'manage_options', 'simulateur-credit-pret_voiture_neuve', 'simulateur_credit_pret_voiture_neuve');
    add_submenu_page('simulateur-credit-settings', 'Prêt Voiture Occasion', 'Prêt Voiture Occasion', 'manage_options', 'simulateur-credit-pret_voiture_occasion', 'simulateur_credit_pret_voiture_occasion');
    add_submenu_page('simulateur-credit-settings', 'Prêt Moto Neuve', 'Prêt Moto Neuve', 'manage_options', 'simulateur-credit-pret_moto_neuve', 'simulateur_credit_pret_moto_neuve');
    add_submenu_page('simulateur-credit-settings', 'Prêt Moto Occasion', 'Prêt Moto Occasion', 'manage_options', 'simulateur-credit-pret_moto_occasion', 'simulateur_credit_pret_moto_occasion');

    add_submenu_page('simulateur-credit-settings', 'Prêt Travaux', 'Prêt Travaux', 'manage_options', 'simulateur-credit-pret_travaux', 'simulateur_credit_pret_travaux');
    add_submenu_page('simulateur-credit-settings', 'Prêt Énergie', 'Prêt Énergie', 'manage_options', 'simulateur-credit-pret_energie', 'simulateur_credit_pret_energie');
}

add_action('admin_menu', 'simulateur_credit_menu');


### FUNCTIONS DISPLAY ###


function redirection_submenu() {
    echo '<div class="card">';
    echo '<h3>Merci de choisir une sous-rubrique :</h3>';
    echo '<a href="' . admin_url('admin.php?page=simulateur-credit-pret_perso') . '"><button class="register-btn" style="width:50%"><span>Prêt Perso</span></button></a><br>';
    echo '<a href="' . admin_url('admin.php?page=simulateur-credit-pret_mobilite') . '"><button class="register-btn" style="width:50%"><span>Prêt Mobilité</span></button></a><br>';
    echo '<a href="' . admin_url('admin.php?page=simulateur-credit-pret_voiture_neuve') . '"><button class="register-btn" style="width:50%"><span>Voiture Neuve</span></button></a><br>';
    echo '<a href="' . admin_url('admin.php?page=simulateur-credit-pret_voiture_occasion') . '"><button class="register-btn" style="width:50%"><span>Prêt Voiture Occasion</span></button></a><br>';
    echo '<a href="' . admin_url('admin.php?page=simulateur-credit-pret_moto_neuve') . '"><button class="register-btn" style="width:50%"><span>Prêt Moto Neuve</span></button></a><br>';
    echo '<a href="' . admin_url('admin.php?page=simulateur-credit-pret_moto_occasion') . '"><button class="register-btn" style="width:50%"><span>Prêt Moto Occasion</span></button></a><br>';
    echo '<a href="' . admin_url('admin.php?page=simulateur-credit-pret_travaux') . '"><button class="register-btn" style="width:50%"><span>Prêt Travaux</span></button></a><br>';
    echo '<a href="' . admin_url('admin.php?page=simulateur-credit-pret_energie') . '"><button class="register-btn" style="width:50%"><span>Prêt Énergie</span></button></a><br>';
    echo '</div>';
}


### PRET PERSO ###
function simulateur_credit_pret_perso() {
    $json_file_path = plugin_dir_path(__FILE__) . 'pret_perso.json';
    $data_json = file_get_contents($json_file_path);

    if ($data_json === false) {
        die('Erreur lors de la lecture du fichier JSON');
    }

    $data = json_decode($data_json, true);

    if ($data === null) {
        die('Erreur lors du décodage JSON');
    }

    if (isset($data) && is_array($data)) {
        echo '<table border="2">';
        echo '<tr><th></th>';
        for ($i = 6; $i <= 120; $i += 6) {
            if ($i > 48) {
                $i = $i + 6;
                echo "<th>$i</th>";
            } else {
                echo "<th>$i</th>";
            }
        }
        echo '</tr>';

        foreach ($data as $key => $values) {
            echo '<tr>';
            echo "<td>$key</td>";
            foreach ($values as $duration => $value) {
                echo '<td contenteditable="true" data-key="' . $key . '" data-duration="' . $duration . '">' . $value . '</td>';
            }
            echo '</tr>';
        }
        echo '</table>';
        echo '<button id="register-button-perso" class="register-btn"><span>Enregistrer</span></button>';
        wp_enqueue_script('simulateur-custom-script', plugin_dir_url(__FILE__) . 'admin.js', array('jquery'), null, true);
    } else {
        echo 'Les données JSON ne sont pas au bon format.';
    }
}

function save_pret_perso_data() {
    if (isset($_POST['data'])) {
        $json_file_path = plugin_dir_path(__FILE__) . 'pret_perso.json';
        $data = $_POST['data'];

        array_walk_recursive($data, function (&$value, $key) {
            if ($value === '') {
                $value = null;
            }
        });

        $data = json_encode($data, JSON_PRETTY_PRINT);

        if (file_put_contents($json_file_path, $data)) {
            echo 'Données enregistrées avec succès.';
        } else {
            echo 'Erreur lors de l\'enregistrement des données.';
        }

        die();
    }
}

add_action('wp_ajax_save_pret_perso_data', 'save_pret_perso_data');
add_action('wp_ajax_nopriv_save_pret_perso_data', 'save_pret_perso_data');


### PRET MOBILITE ###
function simulateur_credit_pret_mobilite() {
    $json_file_path = plugin_dir_path(__FILE__) . 'pret_mobilite.json';
    $data_json = file_get_contents($json_file_path);

    if ($data_json === false) {
        die('Erreur lors de la lecture du fichier JSON');
    }

    $data = json_decode($data_json, true);

    if ($data === null) {
        die('Erreur lors du décodage JSON');
    }

    if (isset($data) && is_array($data)) {
        echo '<table border="2">';
        echo '<tr><th></th>';
        for ($i = 6; $i <= 120; $i += 6) {
            if ($i > 48) {
                $i = $i + 6;
                echo "<th>$i</th>";
            } else {
                echo "<th>$i</th>";
            }
        }
        echo '</tr>';

        foreach ($data as $key => $values) {
            echo '<tr>';
            echo "<td>$key</td>";
            foreach ($values as $duration => $value) {
                echo '<td contenteditable="true" data-key="' . $key . '" data-duration="' . $duration . '">' . $value . '</td>';
            }
            echo '</tr>';
        }
        echo '</table>';
        echo '<button id="register-button-mobilite" class="register-btn"><span>Enregistrer</span></button>';
        wp_enqueue_script('simulateur-custom-script', plugin_dir_url(__FILE__) . 'admin.js', array('jquery'), null, true);
    } else {
        echo 'Les données JSON ne sont pas au bon format.';
    }
}

function save_pret_mobilite_data() {
    if (isset($_POST['data'])) {
        $json_file_path = plugin_dir_path(__FILE__) . 'pret_mobilite.json';
        $data = $_POST['data'];

        array_walk_recursive($data, function (&$value, $key) {
            if ($value === '') {
                $value = null;
            }
        });

        $data = json_encode($data, JSON_PRETTY_PRINT);

        if (file_put_contents($json_file_path, $data)) {
            echo 'Données enregistrées avec succès.';
        } else {
            echo 'Erreur lors de l\'enregistrement des données.';
        }

        die();
    }
}

add_action('wp_ajax_save_pret_mobilite_data', 'save_pret_mobilite_data');
add_action('wp_ajax_nopriv_save_pret_mobilite_data', 'save_pret_mobilite_data');




### PRET VOITURE NEUVE ###
function simulateur_credit_pret_voiture_neuve() {
    $json_file_path = plugin_dir_path(__FILE__) . 'pret_voiture_neuve.json';
    $data_json = file_get_contents($json_file_path);

    if ($data_json === false) {
        die('Erreur lors de la lecture du fichier JSON');
    }

    $data = json_decode($data_json, true);

    if ($data === null) {
        die('Erreur lors du décodage JSON');
    }

    if (isset($data) && is_array($data)) {
        echo '<table border="2">';
        echo '<tr><th></th>';
        for ($i = 6; $i <= 120; $i += 6) {
            if ($i > 48) {
                $i = $i + 6;
                echo "<th>$i</th>";
            } else {
                echo "<th>$i</th>";
            }
        }
        echo '</tr>';

        foreach ($data as $key => $values) {
            echo '<tr>';
            echo "<td>$key</td>";
            foreach ($values as $duration => $value) {
                echo '<td contenteditable="true" data-key="' . $key . '" data-duration="' . $duration . '">' . $value . '</td>';
            }
            echo '</tr>';
        }
        echo '</table>';
        echo '<button id="register-button-new-car" class="register-btn"><span>Enregistrer</span></button>';
        wp_enqueue_script('simulateur-custom-script', plugin_dir_url(__FILE__) . 'admin.js', array('jquery'), null, true);
    } else {
        echo 'Les données JSON ne sont pas au bon format.';
    }
}


function save_pret_new_car_data() {
    if (isset($_POST['data'])) {
        $json_file_path = plugin_dir_path(__FILE__) . 'pret_voiture_neuve.json';
        $data = $_POST['data'];

        array_walk_recursive($data, function (&$value, $key) {
            if ($value === '') {
                $value = null;
            }
        });

        $data = json_encode($data, JSON_PRETTY_PRINT);

        if (file_put_contents($json_file_path, $data)) {
            echo 'Données enregistrées avec succès.';
        } else {
            echo 'Erreur lors de l\'enregistrement des données.';
        }

        die();
    }
}

add_action('wp_ajax_save_pret_new_car_data', 'save_pret_new_car_data');
add_action('wp_ajax_nopriv_save_pret_new_car_data', 'save_pret_new_car_data');




### PRET VOITURE OCCASION ###
function simulateur_credit_pret_voiture_occasion() {
    $json_file_path = plugin_dir_path(__FILE__) . 'pret_voiture_occasion.json';
    $data_json = file_get_contents($json_file_path);

    if ($data_json === false) {
        die('Erreur lors de la lecture du fichier JSON');
    }

    $data = json_decode($data_json, true);

    if ($data === null) {
        die('Erreur lors du décodage JSON');
    }

    if (isset($data) && is_array($data)) {
        echo '<table border="2">';
        echo '<tr><th></th>';
        for ($i = 6; $i <= 120; $i += 6) {
            if ($i > 48) {
                $i = $i + 6;
                echo "<th>$i</th>";
            } else {
                echo "<th>$i</th>";
            }
        }
        echo '</tr>';

        foreach ($data as $key => $values) {
            echo '<tr>';
            echo "<td>$key</td>";
            foreach ($values as $duration => $value) {
                echo '<td contenteditable="true" data-key="' . $key . '" data-duration="' . $duration . '">' . $value . '</td>';
            }
            echo '</tr>';
        }
        echo '</table>';
        echo '<button id="register-button-occasion-car" class="register-btn"><span>Enregistrer</span></button>';
        wp_enqueue_script('simulateur-custom-script', plugin_dir_url(__FILE__) . 'admin.js', array('jquery'), null, true);
    } else {
        echo 'Les données JSON ne sont pas au bon format.';
    }
}

function save_pret_voiture_occasion_data() {
    if (isset($_POST['data'])) {
        $json_file_path = plugin_dir_path(__FILE__) . 'pret_voiture_occasion.json';
        $data = $_POST['data'];

        array_walk_recursive($data, function (&$value, $key) {
            if ($value === '') {
                $value = null;
            }
        });

        $data = json_encode($data, JSON_PRETTY_PRINT);

        if (file_put_contents($json_file_path, $data)) {
            echo 'Données enregistrées avec succès.';
        } else {
            echo 'Erreur lors de l\'enregistrement des données.';
        }

        die();
    }
}

add_action('wp_ajax_save_pret_voiture_occasion_data', 'save_pret_voiture_occasion_data');
add_action('wp_ajax_nopriv_save_pret_voiture_occasion_data', 'save_pret_voiture_occasion_data');




### PRET MOTO NEUVE ###
function simulateur_credit_pret_moto_neuve() {
    $json_file_path = plugin_dir_path(__FILE__) . 'pret_moto_neuve.json';
    $data_json = file_get_contents($json_file_path);

    if ($data_json === false) {
        die('Erreur lors de la lecture du fichier JSON');
    }

    $data = json_decode($data_json, true);

    if ($data === null) {
        die('Erreur lors du décodage JSON');
    }

    if (isset($data) && is_array($data)) {
        echo '<table border="2">';
        echo '<tr><th></th>';
        for ($i = 6; $i <= 120; $i += 6) {
            if ($i > 48) {
                $i = $i + 6;
                echo "<th>$i</th>";
            } else {
                echo "<th>$i</th>";
            }
        }
        echo '</tr>';

        foreach ($data as $key => $values) {
            echo '<tr>';
            echo "<td>$key</td>";
            foreach ($values as $duration => $value) {
                echo '<td contenteditable="true" data-key="' . $key . '" data-duration="' . $duration . '">' . $value . '</td>';
            }
            echo '</tr>';
        }
        echo '</table>';
        echo '<button id="register-button-new-moto" class="register-btn"><span>Enregistrer</span></button>';
        wp_enqueue_script('simulateur-custom-script', plugin_dir_url(__FILE__) . 'admin.js', array('jquery'), null, true);
    } else {
        echo 'Les données JSON ne sont pas au bon format.';
    }
}

function save_pret_moto_neuve_data() {
    if (isset($_POST['data'])) {
        $json_file_path = plugin_dir_path(__FILE__) . 'pret_moto_neuve.json';
        $data = $_POST['data'];

        array_walk_recursive($data, function (&$value, $key) {
            if ($value === '') {
                $value = null;
            }
        });

        $data = json_encode($data, JSON_PRETTY_PRINT);

        if (file_put_contents($json_file_path, $data)) {
            echo 'Données enregistrées avec succès.';
        } else {
            echo 'Erreur lors de l\'enregistrement des données.';
        }

        die();
    }
}

add_action('wp_ajax_save_pret_moto_neuve_data', 'save_pret_moto_neuve_data');
add_action('wp_ajax_nopriv_save_pret_moto_neuve_data', 'save_pret_moto_neuve_data');


### PRET MOTO OCCASION ###
function simulateur_credit_pret_moto_occasion() {
    $json_file_path = plugin_dir_path(__FILE__) . 'pret_moto_occasion.json';
    $data_json = file_get_contents($json_file_path);

    if ($data_json === false) {
        die('Erreur lors de la lecture du fichier JSON');
    }

    $data = json_decode($data_json, true);

    if ($data === null) {
        die('Erreur lors du décodage JSON');
    }

    if (isset($data) && is_array($data)) {
        echo '<table border="2">';
        echo '<tr><th></th>';
        for ($i = 6; $i <= 120; $i += 6) {
            if ($i > 48) {
                $i = $i + 6;
                echo "<th>$i</th>";
            } else {
                echo "<th>$i</th>";
            }
        }
        echo '</tr>';

        foreach ($data as $key => $values) {
            echo '<tr>';
            echo "<td>$key</td>";
            foreach ($values as $duration => $value) {
                echo '<td contenteditable="true" data-key="' . $key . '" data-duration="' . $duration . '">' . $value . '</td>';
            }
            echo '</tr>';
        }
        echo '</table>';
        echo '<button id="register-button-occasion-moto" class="register-btn"><span>Enregistrer</span></button>';
        wp_enqueue_script('simulateur-custom-script', plugin_dir_url(__FILE__) . 'admin.js', array('jquery'), null, true);
    } else {
        echo 'Les données JSON ne sont pas au bon format.';
    }
}

function save_pret_moto_occasion_data() {
    if (isset($_POST['data'])) {
        $json_file_path = plugin_dir_path(__FILE__) . 'pret_moto_occasion.json';
        $data = $_POST['data'];

        array_walk_recursive($data, function (&$value, $key) {
            if ($value === '') {
                $value = null;
            }
        });

        $data = json_encode($data, JSON_PRETTY_PRINT);

        if (file_put_contents($json_file_path, $data)) {
            echo 'Données enregistrées avec succès.';
        } else {
            echo 'Erreur lors de l\'enregistrement des données.';
        }

        die();
    }
}

add_action('wp_ajax_save_pret_moto_occasion_data', 'save_pret_moto_occasion_data');
add_action('wp_ajax_nopriv_save_pret_moto_occasion_data', 'save_pret_moto_occasion_data');



### PRET TRAVAUX ###
function simulateur_credit_pret_travaux() {
    $json_file_path = plugin_dir_path(__FILE__) . 'pret_travaux.json';
    $data_json = file_get_contents($json_file_path);

    if ($data_json === false) {
        die('Erreur lors de la lecture du fichier JSON');
    }

    $data = json_decode($data_json, true);

    if ($data === null) {
        die('Erreur lors du décodage JSON');
    }

    if (isset($data) && is_array($data)) {
        echo '<table border="2">';
        echo '<tr><th></th>';
        for ($i = 6; $i <= 144; $i += 6) {
            if ($i > 48) {
                $i = $i + 6;
                echo "<th>$i</th>";
            } else {
                echo "<th>$i</th>";
            }
        }
        echo '</tr>';

        foreach ($data as $key => $values) {
            echo '<tr>';
            echo "<td>$key</td>";
            foreach ($values as $duration => $value) {
                echo '<td contenteditable="true" data-key="' . $key . '" data-duration="' . $duration . '">' . $value . '</td>';
            }
            echo '</tr>';
        }
        echo '</table>';
        echo '<button id="register-button-travaux" class="register-btn"><span>Enregistrer</span></button>';
        wp_enqueue_script('simulateur-custom-script', plugin_dir_url(__FILE__) . 'admin.js', array('jquery'), null, true);
    } else {
        echo 'Les données JSON ne sont pas au bon format.';
    }
}



function save_pret_travaux_data() {
    if (isset($_POST['data'])) {
        $json_file_path = plugin_dir_path(__FILE__) . 'pret_travaux.json';
        $data = $_POST['data'];

        array_walk_recursive($data, function (&$value, $key) {
            if ($value === '') {
                $value = null;
            }
        });

        $data = json_encode($data, JSON_PRETTY_PRINT);

        if (file_put_contents($json_file_path, $data)) {
            echo 'Données enregistrées avec succès.';
        } else {
            echo 'Erreur lors de l\'enregistrement des données.';
        }

        die();
    }
}

add_action('wp_ajax_save_pret_travaux_data', 'save_pret_travaux_data');
add_action('wp_ajax_nopriv_save_pret_travaux_data', 'save_pret_travaux_data');



### PRET ENERGIE ###
function simulateur_credit_pret_energie() {
    $json_file_path = plugin_dir_path(__FILE__) . 'pret_energie.json';
    $data_json = file_get_contents($json_file_path);

    if ($data_json === false) {
        die('Erreur lors de la lecture du fichier JSON');
    }

    $data = json_decode($data_json, true);

    if ($data === null) {
        die('Erreur lors du décodage JSON');
    }

    if (isset($data) && is_array($data)) {
        echo '<table border="2">';
        echo '<tr><th></th>';
        for ($i = 6; $i <= 144; $i += 6) {
            if ($i > 48) {
                $i = $i + 6;
                echo "<th>$i</th>";
            } else {
                echo "<th>$i</th>";
            }
        }
        echo '</tr>';

        foreach ($data as $key => $values) {
            echo '<tr>';
            echo "<td>$key</td>";
            foreach ($values as $duration => $value) {
                echo '<td contenteditable="true" data-key="' . $key . '" data-duration="' . $duration . '">' . $value . '</td>';
            }
            echo '</tr>';
        }
        echo '</table>';
        echo '<button id="register-button-energie" class="register-btn"><span>Enregistrer</span></button>';
        wp_enqueue_script('simulateur-custom-script', plugin_dir_url(__FILE__) . 'admin.js', array('jquery'), null, true);
    } else {
        echo 'Les données JSON ne sont pas au bon format.';
    }
}



function save_pret_energie_data() {
    if (isset($_POST['data'])) {
        $json_file_path = plugin_dir_path(__FILE__) . 'pret_energie.json';
        $data = $_POST['data'];

        array_walk_recursive($data, function (&$value, $key) {
            if ($value === '') {
                $value = null;
            }
        });

        $data = json_encode($data, JSON_PRETTY_PRINT);

        if (file_put_contents($json_file_path, $data)) {
            echo 'Données enregistrées avec succès.';
        } else {
            echo 'Erreur lors de l\'enregistrement des données.';
        }

        die();
    }
}

add_action('wp_ajax_save_pret_energie_data', 'save_pret_energie_data');
add_action('wp_ajax_nopriv_save_pret_energie_data', 'save_pret_energie_data');

function simulateur_credit_content() {
    $content = '

    <div class="container">
    <h1>Simulateur de crédit</h1>
    <label class="choice">Sélectionnez un type de prêt :</label>
    <div class="container-button">
        <div class="card selected" onclick="selectCard(this)" data-option="prêt perso">
            <img width="50" height="50" src="https://img.icons8.com/ios/50/defend-family--v2.png" alt="defend-family--v2"/>
            <br>Prêt Perso
        </div>
        <div class="card" onclick="selectCard(this)" data-option="mobilité">
            <img width="50" height="50" src="https://img.icons8.com/ios/50/kick-scooter.png" alt="yard-work"/>
            <br>Mobilité
        </div>
        <div class="card" onclick="selectCard(this)" data-option="voiture neuve">
            <img width="50" height="50" src="https://img.icons8.com/ios/50/tesla-model-3.png" alt="defend-family--v2"/>
            <br>Voiture Neuve</div>
        <div class="card" onclick="selectCard(this)" data-option="voiture occasion">
            <img width="50" height="50" src="https://img.icons8.com/ios/50/car--v1.png" alt="defend-family--v2"/>
            <br>Voiture d\'Occasion</div>
        <div class="card" onclick="selectCard(this)" data-option="moto neuve">
            <img width="50" height="50" src="https://img.icons8.com/ios/50/motorcycle.png" alt="defend-family--v2"/>
            <br>Moto Neuve</div>
        <div class="card" onclick="selectCard(this)" data-option="moto occasion">
            <img width="50" height="50" src="https://img.icons8.com/ios/50/scooter.png" alt="defend-family--v2"/>
            <br>Moto d\'Occasion</div>
        <div class="card" onclick="selectCard(this)" data-option="travaux">
            <img width="50" height="50" src="https://img.icons8.com/ios/50/yard-work.png" alt="defend-family--v2"/>
            <br>Travaux</div>
        <div class="card" onclick="selectCard(this)" data-option="énergie">
            <img width="50" height="50" src="https://img.icons8.com/ios/50/solar-panel--v1.png" alt="defend-family--v2"/>
            <br>Énergie</div>
    </div>
    
    <div class="container-champs">
        <label for="montant">Montant du prêt</label>
        <input type="number" id="amount" value="" placeholder="Exemple : 30 000" aria-valuemin="500" aria-valuemax="100000000">€
        <br>
        <label for="step-range">Sélectionnez une durée :</label>
        <div class="range-container">
            <input type="range" id="step-range" min="6" max="120" value="6">
            <div style="position: relative;">
                <div id="step-value" style="position: absolute;">6</div>
                <p id="step-label">Durée en mois :</p>                
            </div>
        </div>
        <div id="results">
        <h3>Résultat de votre simulation</h3>
        <p>Durée du crédit : <span id="month">0</span></p>
        <p>Votre mensualité : <span id="monthly-payment">0</span> €</p>
        <p>TAEG : <span id="interest-rate">X</span>%</p>
        <p>Montant total à payer au prêteur : <span id="total-repayment">0</span> €</p>
    </div>
        </div>
    </div>
    ';

    wp_enqueue_script('simulateur-credit-script');
    return $content;
}

add_shortcode('simulateur_credit', 'simulateur_credit_content');


### JS ###

function register_simulateur_credit_script() {
    wp_register_script('simulateur-credit-script', plugin_dir_url(__FILE__) . 'simulateur-credit.js', array('jquery'), null, true);
    
    $json_files = array(
        'pret_perso.json' => plugin_dir_url(__FILE__) . 'pret_perso.json',
        'pret_mobilite.json' => plugin_dir_url(__FILE__) . 'pret_mobilite.json',
        'pret_voiture_neuve.json' => plugin_dir_url(__FILE__) . 'pret_voiture_neuve.json',
        'pret_voiture_occasion.json' => plugin_dir_url(__FILE__) . 'pret_voiture_occasion.json',
        'pret_moto_neuve.json' => plugin_dir_url(__FILE__) . 'pret_moto_neuve.json',
        'pret_moto_occasion.json' => plugin_dir_url(__FILE__) . 'pret_moto_occasion.json',
        'pret_travaux.json' => plugin_dir_url(__FILE__) . 'pret_travaux.json',
        'pret_energie.json' => plugin_dir_url(__FILE__) . 'pret_energie.json',

    );

    wp_localize_script('simulateur-credit-script', 'simulateur_credit_data', $json_files);
}

add_action('wp_enqueue_scripts', 'register_simulateur_credit_script');




add_action('wp_enqueue_scripts', 'register_simulateur_credit_script');



#### CSS ###
function enqueue_simulateur_admin_styles() {
    wp_register_style('simulateur-admin-style', plugins_url('simulateur-admin.css', __FILE__));
    wp_enqueue_style('simulateur-admin-style');
}

add_action('admin_enqueue_scripts', 'enqueue_simulateur_admin_styles');



function enqueue_simulateur_credit_styles() {
    wp_register_style('simulateur-credit-style', plugin_dir_url(__FILE__) . 'simulateur-credit-style.css');
    wp_enqueue_style('simulateur-credit-style');
}

add_action('wp_enqueue_scripts', 'enqueue_simulateur_credit_styles');


###





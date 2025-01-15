<?php
// Générer une clé de chiffrement (32 caractères hexadécimaux)
$encryption_key = bin2hex(random_bytes(16)); // 128 bits (16 octets)
// Générer une clé MAC (32 caractères hexadécimaux)
$mac_key = bin2hex(random_bytes(16)); // 128 bits (16 octets)

// Afficher les clés générées
echo "Clé de chiffrement : " . $encryption_key . "<br>";
echo "Clé MAC : " . $mac_key . "<br>";
?>

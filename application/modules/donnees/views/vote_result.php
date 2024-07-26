<!-- application/views/vote_result.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Résultat du Vote</title>
</head>
<body>
    <h2>Résultat du Vote</h2>
    <p>Nombre de votes enregistrés: <?php echo $vote_count; ?></p>
    <a href="<?php echo base_url('vote'); ?>">Retour au Formulaire de Vote</a>
</body>
</html>

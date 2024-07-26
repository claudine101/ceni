<!-- application/views/vote_form.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Formulaire de Vote</title>
</head>
<body>
    <h2>Formulaire de Vote</h2>
    <form action="<?php echo base_url('donnees/Votes/submit_vote'); ?>" method="post">
        <label for="candidate_id">ID du Candidat:</label>
        <input type="text" id="candidate_id" name="candidate_id" required>
        <br><br>
        <label for="voter_id">ID de l'Électeur:</label>
        <input type="text" id="voter_id" name="voter_id" required>
        <br><br>
        <input type="submit" value="Voter">
    </form>
</body>
</html>

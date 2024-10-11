<h1>Résultats des votes</h1>
<table border="1">
    <tr>
        <th>Nom du candidat</th>
        <th>Prénom du candidat</th>
        <th>Nombre de votes</th>
    </tr>
    <?php if (!empty($votes_valides)) : ?>
        <?php foreach ($votes_valides as $vote) : ?>
            <tr>
                <td><?php echo $vote['NOM_CANDIDAT']; ?></td>
                <td><?php echo $vote['PRENOM_CANDIDAT']; ?></td>
                <td><?php echo $vote['nombre_votes']; ?></td>
            </tr>
        <?php endforeach; ?>
    <?php else : ?>
        <tr>
            <td colspan="3">Aucun vote valide trouvé.</td>
        </tr>
    <?php endif; ?>
</table>


<?php
// Nom du fichier de la base de données SQLite
$databaseFile = 'LHSQC-STHS.db';
// Connexion à la base de données SQLite
$db = new SQLite3($databaseFile);
// Requête pour récupérer les champs spécifiés, incluant ReceivingTeamThemeID
$query = "SELECT ReceivingTeamThemeID, ReceivingTeamName, ReceivingTeamText  FROM TradeLog  ORDER BY Number ASC  LIMIT 20";    
$result = $db->query($query);
// Initialiser un compteur pour suivre les lignes
$counter = 0;

?>


<div class="card my-5 tradetable frontpage-card top5Card">
    <div class="card-header">Latest Trades</div>
    <div class="card-body mt-0 pt-1 px-0 mx-0 text-primary"></div>
    
         
                    <table class="table  table-responsive" style='border-collapse: collapse; width: 100%;'>

                    <?php
                    // Boucle pour parcourir toutes les lignes
                    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                        // Si c'est la première ligne d'une paire, commence une nouvelle ligne de tableau
                        if ($counter % 2 == 0) {
                            echo "<tr>";
                        } ?>

                        <td style='border-bottom: 1px solid black; padding: 10px; text-align: center; width: 20%;'><img src='images/<?=$row['ReceivingTeamThemeID']?>.png' alt='<?= $row['ReceivingTeamName'] ?> Logo' width='50' height='50'></td>
                        <td style='border-bottom: 1px solid black; padding: 10px;'><?=$row['ReceivingTeamName'] ?> </td>
                        <td style='border-bottom: 1px solid black; padding: 10px;'><?=$row['ReceivingTeamText']  ?> </td>
                        
                        <?php
                        // Si c'est la deuxième ligne d'une paire, fermer la ligne de tableau
                        if ($counter % 2 == 1) {
                            echo "</tr>";
                        }
                        // Incrémenter le compteur
                        $counter++;
                    }

                    // Si le nombre de lignes est impair, on termine la dernière ligne du tableau sans diviseur
                    if ($counter % 2 != 0) {
                        echo "<td colspan='3' style='border-bottom: 1px solid black;'></td></tr>";  // Ajouter des cellules vides pour compléter la dernière ligne
                    }
                    ?>
                    </table>

    </div>
</div>

<?php
    // Fermer la connexion à la base de données
    $db->close();
?>
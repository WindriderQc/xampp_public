
<?php

function PrintStandingTableRow($row, $TypeText, $StandardStandingOutput, $LeagueGeneral, $LoopCount,$DatabaseFile,$ImagesCDNPath)
{
	echo "<tr><td>" . $LoopCount . "</td>";
	echo "<td><span class=\"" . $TypeText . "Standing_Team" . $row['Number'] . "\"></span>";
	If ($row['TeamThemeID'] > 0){echo "<img src=\"" . $ImagesCDNPath . "/images/" . $row['TeamThemeID'] .".png\" alt=\"\" class=\"STHSPHPStandingTeamImageMainPage\" />";}
	echo "<div class=\"darkText\"><a href=\"" . $TypeText . "Team.php?Team=" . $row['Number'] . "\">" . $row['Name'] . "</a></div>";
	echo "</td><td>" . $row['GP'] . "</td>";
    echo "<td>" . ($row['W'] + $row['OTW'] + $row['SOW']) . "</td>";
    echo "<td>" . $row['L'] . "</td>";
    echo "<td>" . ($row['OTL'] + $row['SOL']) . "</td>";
	echo "<td><strong>" . $row['Points'] . "</strong></td>";
	
    $dbS = new SQLite3($DatabaseFile);
	$Query = "SELECT count(*) AS count FROM Schedule" . $TypeText . " WHERE (VisitorTeam = " . $row['Number'] . " OR HomeTeam = " . $row['Number'] . ") AND Play = 'False' ORDER BY GameNumber LIMIT 1";
	$Result = $dbS->querySingle($Query,true);
}

?>
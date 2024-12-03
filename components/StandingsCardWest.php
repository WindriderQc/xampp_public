<?php

$side=2; 

if ($lang == "fr"){include 'LanguageFR-League.php';}else{include 'LanguageEN-League.php';}
if ($lang == "fr"){include 'LanguageFR-Stat.php';}else{include 'LanguageEN-Stat.php';}

$TypeText = (string)"Pro";$TitleType = $DynamicTitleLang['Pro'];
$TypeTextTeam = (string)"Pro";
$Playoff = (boolean)False;
$Title = (string)"";
$Search = (boolean)False;
$LeagueOutputOption = Null;
$ColumnPerTable = 18;


$Title = (string)"";
$LeagueName = (string)"";
if(isset($_GET['Farm'])){$TypeText = "Farm";$TypeTextTeam = (string)"Farm";$TitleType = $DynamicTitleLang['Farm'];}

$db = new SQLite3($DatabaseFile);

$Query = "Select Name, PointSystemW, PointSystemSO, NoOvertime, " . $TypeText . "ConferenceName1 AS ConferenceName1," . $TypeText . "ConferenceName2 AS ConferenceName2," . $TypeText . "DivisionName1 AS DivisionName1," . $TypeText . "DivisionName2 AS DivisionName2," . $TypeText . "DivisionName3 AS DivisionName3," . $TypeText . "DivisionName4 AS DivisionName4," . $TypeText . "DivisionName5 AS DivisionName5," . $TypeText . "DivisionName6 AS DivisionName6," . $TypeText . "HowManyPlayOffTeam AS HowManyPlayOffTeam," . $TypeText . "DivisionNewNHLPlayoff  AS DivisionNewNHLPlayoff,PlayOffWinner" . $TypeText . " AS PlayOffWinner, PlayOffStarted, PlayOffRound, TieBreaker2010, TieBreaker2019 FROM LeagueGeneral";
$LeagueGeneral = $db->querySingle($Query,true);		
$LeagueName = $LeagueGeneral['Name'];
$Query = "Select StandardStandingOutput From LeagueOutputOption";
$LeagueOutputOption = $db->querySingle($Query,true);		
$Conference = array($LeagueGeneral['ConferenceName1'], $LeagueGeneral['ConferenceName2']);
$Division = array($LeagueGeneral['DivisionName1'], $LeagueGeneral['DivisionName2'], $LeagueGeneral['DivisionName3'], $LeagueGeneral['DivisionName4'], $LeagueGeneral['DivisionName5'], $LeagueGeneral['DivisionName6']);
$Query = "Select " . $TypeText . "TwoConference AS TwoConference from LeagueSimulation";
$LeagueSimulation = $db->querySingle($Query,true);	

If (True == "False"){
    $ColumnPerTable = 21;
    If ($LeagueGeneral['PointSystemSO'] == "False"){$ColumnPerTable = $ColumnPerTable -1;}
    If ($LeagueGeneral['TieBreaker2019'] == "False"){$ColumnPerTable = $ColumnPerTable -1;}
    If ($LeagueGeneral['TieBreaker2019'] == "False" AND $LeagueGeneral['TieBreaker2010'] == "False"){$ColumnPerTable = $ColumnPerTable -1;}
}


if ($LeagueGeneral['PlayOffStarted'] == "True"){
    if(isset($_GET['Season'])){
        $Title = $LeagueName . " - " . $StandingLang['Standing'] . " " . $TitleType;
        $TypeTextTeam = $TypeTextTeam . "Season";
    }else{
        $Title = $LeagueName . " - " . $StandingLang['Playoff'] . " " . $TitleType;
        $Playoff = True;
    }
}else{		$Title = $LeagueName . " - " . $StandingLang['Standing'] . " " . $TitleType;	}







Function PrintStandingTable($Standing, $TypeText, $StandardStandingOutput, $LeagueGeneral, $ColumnPerTable, $LinesNumber ,$DatabaseFile,$ImagesCDNPath){
    $LoopCount =0;
    while ($row = $Standing ->fetchArray()) {
        $LoopCount +=1;
        PrintStandingTableRow($row, $TypeText, $StandardStandingOutput, $LeagueGeneral, $LoopCount, $DatabaseFile,$ImagesCDNPath);
        If ($LoopCount > 0 AND $LoopCount == $LinesNumber){echo "<tr class=\"static\"><td class=\"staticTD\" colspan=\"" . $ColumnPerTable . "\"><hr /></td></tr>";}
    }
    echo "</tbody></table>";
}


Function PrintStandingTableRow($row, $TypeText, $StandardStandingOutput, $LeagueGeneral, $LoopCount,$DatabaseFile,$ImagesCDNPath){
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

	echo "</tr>";

?>

<style>
    <?php 
    if ($Playoff == True){
        echo "#standing{display:none;}\n";
        
    }else{
        echo "#playoffs{display:none;}\n";
    }?>
</style>

</head>
<body>



<div id="standing" class="card shadow-0  px-0 mx-0 mb-3 frontpage-card top5Card  "  >
    <div class="card-header">Conférence de l'Est</div>
    <div class="card-body mt-0 pt-1 px-0 mx-0 text-primary">

        <table class="StandingsCard">
            <thead><tr>
                <th title="Position" class="STHSW35">PO</th>
                <th title="Team Name" class="STHSW200"> <?= $TeamLang['TeamName'] ?> </th>
                <th title="Games Played" class="STHSW30">GP</th>
                <th title="Wins" class="STHSW30">W</th>
                <th title="Loss" class="STHSW30">L</th>
                <th title="Overtime Loss" class="STHSW30">OTL</th>
                <th title="Points" class="STHSW30">P</th>
            </tr></thead>
            <tbody>
                <?php
                ($side==2) ? $div1 = $LeagueGeneral['DivisionName1']   : $div1 = $LeagueGeneral['DivisionName4'];
                ($side==2) ? $div2 = $LeagueGeneral['DivisionName2']   : $div2 = $LeagueGeneral['DivisionName5'];
                ($side==2) ? $div3 = $LeagueGeneral['ConferenceName1'] : $div3 = $LeagueGeneral['ConferenceName2'];
                ?>

                <tr class="static"><td class="staticTD" colspan="<?= $ColumnPerTable ?>"> <?= $div1 ?></td></tr>
                <?php
                /* Division 1 */
                $Query = "SELECT Team" . $TypeTextTeam . "Stat.*, Team" . $TypeText . "Info.Conference, Team" . $TypeText . "Info.Division,Team" . $TypeText . "Info.TeamThemeID, RankingOrder.Type 
                            FROM (Team" . $TypeTextTeam . "Stat INNER JOIN Team" . $TypeText . "Info ON Team" . $TypeTextTeam . "Stat.Number = Team" . $TypeText . "Info.Number) INNER JOIN RankingOrder ON Team" . $TypeTextTeam . "Stat.Number = RankingOrder.Team" . $TypeText . "Number 
                            WHERE (((Team" . $TypeText . "Info.Division)=\"" . $div1 . "\") AND ((RankingOrder.Type)=0)) 
                            ORDER BY RankingOrder.TeamOrder LIMIT 3";
                $Standing = $db->query($Query);
                $LoopCount =0;

                if (empty($Standing) == false){while ($row = $Standing ->fetchArray()) {
                    $LoopCount +=1;
                    PrintStandingTableRow($row, $TypeText, True, $LeagueGeneral, $LoopCount,$DatabaseFile,$ImagesCDNPath);
                }}
                ?>
            
                <tr class="static"><td class="staticTD" colspan="<?= $ColumnPerTable ?>"> <?= $div2 ?></td></tr>
                <?php
                /* Division 2 */	
                $Query = "SELECT Team" . $TypeTextTeam . "Stat.*, Team" . $TypeText . "Info.Conference, Team" . $TypeText . "Info.Division,Team" . $TypeText . "Info.TeamThemeID, RankingOrder.Type 
                            FROM (Team" . $TypeTextTeam . "Stat INNER JOIN Team" . $TypeText . "Info ON Team" . $TypeTextTeam . "Stat.Number = Team" . $TypeText . "Info.Number) INNER JOIN RankingOrder ON Team" . $TypeTextTeam . "Stat.Number = RankingOrder.Team" . $TypeText . "Number 
                            WHERE (((Team" . $TypeText . "Info.Division)=\"" . $div2 . "\") AND ((RankingOrder.Type)=0)) 
                            ORDER BY RankingOrder.TeamOrder LIMIT 3";
                $Standing = $db->query($Query);
                $LoopCount =0;
                if (empty($Standing) == false){while ($row = $Standing ->fetchArray()) {
                    $LoopCount +=1;
                    PrintStandingTableRow($row, $TypeText, True, $LeagueGeneral, $LoopCount,$DatabaseFile,$ImagesCDNPath);
                }}
                ?>

                <tr class="static"><td class="staticTD" colspan="<?= $ColumnPerTable ?>"> Wildcard </td></tr>
                <?php
                /* Overall for Conference 1 */	
                $Query = "SELECT Team" . $TypeTextTeam . "Stat.*, Team" . $TypeText . "Info.Conference, Team" . $TypeText . "Info.Division,Team" . $TypeText . "Info.TeamThemeID, RankingOrder.Type 
                            FROM (Team" . $TypeTextTeam . "Stat INNER JOIN Team" . $TypeText . "Info ON Team" . $TypeTextTeam . "Stat.Number = Team" . $TypeText . "Info.Number) INNER JOIN RankingOrder ON Team" . $TypeTextTeam . "Stat.Number = RankingOrder.Team" . $TypeText . "Number 
                            WHERE (((Team" . $TypeText . "Info.Conference)=\"" . $div3 . "\") AND ((RankingOrder.Type)=1)) 
                            ORDER BY RankingOrder.TeamOrder";
                $Standing = $db->query($Query);
                $LoopCount =0;

                if (empty($Standing) == false){while ($row = $Standing ->fetchArray()) {
                    $LoopCount +=1;
                    If ($LoopCount > 6 ){PrintStandingTableRow($row, $TypeText, True, $LeagueGeneral, $LoopCount,$DatabaseFile,$ImagesCDNPath);}
                    If ($LoopCount == 8){echo "<tr class=\"\"><td class=\"\" colspan=\"" . $ColumnPerTable . "\"><hr /></td></tr>";}
                }}
         ?>
            </tbody>
        </table>


            <?php

            // echo "<h2>" . $LeagueGeneral['ConferenceName2'] . "</h2>";
            // PrintStandingTop($TeamLang, True, $LeagueGeneral);

            // /* Division 4 */
            // Echo "<tr class=\"static\"><td class=\"staticTD\" colspan=\"" . $ColumnPerTable . "\">" . $LeagueGeneral['DivisionName4'] . "</td></tr>";
            // $Query = "SELECT Team" . $TypeTextTeam . "Stat.*, Team" . $TypeText . "Info.Conference, Team" . $TypeText . "Info.Division,Team" . $TypeText . "Info.TeamThemeID, RankingOrder.Type 
          //  FROM (Team" . $TypeTextTeam . "Stat INNER JOIN Team" . $TypeText . "Info ON Team" . $TypeTextTeam . "Stat.Number = Team" . $TypeText . "Info.Number) INNER JOIN RankingOrder ON Team" . $TypeTextTeam . "Stat.Number = RankingOrder.Team" . $TypeText . "Number 
         //   WHERE (((Team" . $TypeText . "Info.Division)=\"" . $LeagueGeneral['DivisionName4'] . "\") AND ((RankingOrder.Type)=0)) ORDER BY RankingOrder.TeamOrder LIMIT 3";
            // $Standing = $db->query($Query);
            // $LoopCount =0;

            // if (empty($Standing) == false){while ($row = $Standing ->fetchArray()) {
            //     $LoopCount +=1;
            //     PrintStandingTableRow($row, $TypeText, True, $LeagueGeneral, $LoopCount,$DatabaseFile,$ImagesCDNPath);
            // }}

                

            // /* Division 5 */	
            // Echo "<tr class=\"static\"><td class=\"staticTD\" colspan=\"" . $ColumnPerTable . "\">" . $LeagueGeneral['DivisionName5'] . "</td></tr>";
            // $Query = "SELECT Team" . $TypeTextTeam . "Stat.*, Team" . $TypeText . "Info.Conference, Team" . $TypeText . "Info.Division,Team" . $TypeText . "Info.TeamThemeID, RankingOrder.Type FROM (Team" . $TypeTextTeam . "Stat INNER JOIN Team" . $TypeText . "Info ON Team" . $TypeTextTeam . "Stat.Number = Team" . $TypeText . "Info.Number) INNER JOIN RankingOrder ON Team" . $TypeTextTeam . "Stat.Number = RankingOrder.Team" . $TypeText . "Number WHERE (((Team" . $TypeText . "Info.Division)=\"" . $LeagueGeneral['DivisionName5'] . "\") AND ((RankingOrder.Type)=0)) ORDER BY RankingOrder.TeamOrder LIMIT 3";
            // $Standing = $db->query($Query);
            // $LoopCount =0;

            // if (empty($Standing) == false){while ($row = $Standing ->fetchArray()) {
            //     $LoopCount +=1;
            //     PrintStandingTableRow($row, $TypeText, True, $LeagueGeneral, $LoopCount,$DatabaseFile,$ImagesCDNPath);
            // }}


            // /* Overall for Conference 2 */	
            // Echo "<tr class=\"static\"><td class=\"staticTD\" colspan=\"" . $ColumnPerTable . "\">" . $StandingLang['Wildcard'] . "</td></tr>";
            // $Query = "SELECT Team" . $TypeTextTeam . "Stat.*, Team" . $TypeText . "Info.Conference, Team" . $TypeText . "Info.Division,Team" . $TypeText . "Info.TeamThemeID, RankingOrder.Type FROM (Team" . $TypeTextTeam . "Stat INNER JOIN Team" . $TypeText . "Info ON Team" . $TypeTextTeam . "Stat.Number = Team" . $TypeText . "Info.Number) INNER JOIN RankingOrder ON Team" . $TypeTextTeam . "Stat.Number = RankingOrder.Team" . $TypeText . "Number WHERE (((Team" . $TypeText . "Info.Conference)=\"" . $LeagueGeneral['ConferenceName2'] . "\") AND ((RankingOrder.Type)=2)) ORDER BY RankingOrder.TeamOrder";
            // $Standing = $db->query($Query);
            // $LoopCount =0;
            // if (empty($Standing) == false){while ($row = $Standing ->fetchArray()) {
            //     $LoopCount +=1;
            //     If ($LoopCount > 6 ){PrintStandingTableRow($row, $TypeText, True, $LeagueGeneral, $LoopCount,$DatabaseFile,$ImagesCDNPath);}
            //     If ($LoopCount == 8){echo "<tr class=\"static\"><td class=\"staticTD\" colspan=\"" . $ColumnPerTable . "\"><hr /></td></tr>";}
            // }}
            // echo "</tbody></table>";
        
        ?>
        </div>


       
       
        <div class="<?php if ($Playoff == True){echo " active";}?>" id="playoffs">
        <?php
        

            If ($LeagueGeneral['PlayOffWinner'] != 0 AND $Playoff == True){

                $Winner = $db->querySingle("Select Team" . $TypeText . "Info.Name,Team" . $TypeText . "Info.TeamThemeID from Team" . $TypeText . "Info WHERE Team" . $TypeText . "Info.Number = ". $LeagueGeneral['PlayOffWinner'],true);
                echo "<div class=\"STHSCenter\">";
                echo "<td>";If ($Winner['TeamThemeID'] > 0){echo "<img src=\"" . $ImagesCDNPath . "/images/" . $Winner['TeamThemeID'] .".png\" alt=\"\" class=\"STHSPHPStandingPlayoffWinnerImage \" />";}
                echo "<h1>" . $Winner['Name'] . $StandingLang['WinsPlayoff'] . "</h1><br /><br /></div>";
            }

            echo "<table class=\"STHSTableFullW\"><tr>";

            for($Round = 1; $Round <= 5; $Round++){
                If ($Round <= $LeagueGeneral['PlayOffRound']){
                    echo "<td><b> " . $StandingLang['Round'] . $Round . "</b></td>";
                }else{
                    echo "<td></td>";
                }
            }
            echo "</tr>";

            $Query = "SELECT Playoff" . $TypeText . "Number.* FROM Playoff" . $TypeText . "Number ORDER BY Playoff" . $TypeText . "Number.Number";
            $PlayoffStanding = $db->query($Query);

            if (empty($PlayoffStanding) == false){while ($Row = $PlayoffStanding ->fetchArray()) {

                echo "<tr>";

                If ($Row['Round1'] == 0){echo "<td></td>";}else{
                    $Round1 = $db->querySingle("SELECT Playoff" . $TypeText . ".*, TeamInfoHome.Name as HomeTeamName, TeamInfoVisitor.Name as VisitorTeamName, TeamInfoHome.TeamThemeID as HomeThemID, TeamInfoVisitor.TeamThemeID as VisitorThemID FROM (Playoff" . $TypeText . " INNER JOIN Team" . $TypeText . "Info AS TeamInfoHome ON Playoff" . $TypeText . ".HomeTeam = TeamInfoHome.Number) LEFT JOIN Team" . $TypeText . "Info AS TeamInfoVisitor ON Playoff" . $TypeText . ".VisitorTeam = TeamInfoVisitor.Number WHERE Playoff" . $TypeText . ".Number = " . $Row['Round1'],true);	
                    if($Round1 != Null){

                        echo "<td>";If ($Round1['VisitorThemID'] > 0){echo "<img src=\"" . $ImagesCDNPath . "/images/" . $Round1['VisitorThemID'] .".png\" alt=\"\" class=\"STHSPHPStandingTeamImage\" />";
                        echo "<a href=\"" . $TypeText . "Team.php?Team=" . $Round1['VisitorTeam'] . "\">" . $Round1['VisitorTeamName'] . " - " . $Round1['VisitorWin'] . "</a><br />";}
                        If ($Round1['HomeThemID'] > 0){echo "<img src=\"" . $ImagesCDNPath . "/images/" . $Round1['HomeThemID'] .".png\" alt=\"\" class=\"STHSPHPStandingTeamImage\" />";
                        echo "<a href=\"" . $TypeText . "Team.php?Team=" . $Round1['HomeTeam'] . "\">" . $Round1['HomeTeamName'] . " - " . $Round1['HomeWin'] . "</a><br /><br /></td>\n";}
                    }
                }

                If ($Row['Round2'] == 0){echo "<td></td>";}else{
                    $Round2 = $db->querySingle("SELECT Playoff" . $TypeText . ".*, TeamInfoHome.Name as HomeTeamName, TeamInfoVisitor.Name as VisitorTeamName, TeamInfoHome.TeamThemeID as HomeThemID, TeamInfoVisitor.TeamThemeID as VisitorThemID FROM (Playoff" . $TypeText . " INNER JOIN Team" . $TypeText . "Info AS TeamInfoHome ON Playoff" . $TypeText . ".HomeTeam = TeamInfoHome.Number) LEFT JOIN Team" . $TypeText . "Info AS TeamInfoVisitor ON Playoff" . $TypeText . ".VisitorTeam = TeamInfoVisitor.Number WHERE Playoff" . $TypeText . ".Number = " . $Row['Round2'],true);

                    if($Round2 != Null){
                        echo "<td>";If ($Round2['VisitorThemID'] > 0){echo "<img src=\"" . $ImagesCDNPath . "/images/" . $Round2['VisitorThemID'] .".png\" alt=\"\" class=\"STHSPHPStandingTeamImage\" />";
                        echo "<a href=\"" . $TypeText . "Team.php?Team=" . $Round2['VisitorTeam'] . "\">" . $Round2['VisitorTeamName'] . " - " . $Round2['VisitorWin'] . "</a><br />";}
                        If ($Round2['HomeThemID'] > 0){echo "<img src=\"" . $ImagesCDNPath . "/images/" . $Round2['HomeThemID'] .".png\" alt=\"\" class=\"STHSPHPStandingTeamImage\" />";
                        echo "<a href=\"" . $TypeText . "Team.php?Team=" . $Round2['HomeTeam'] . "\">" . $Round2['HomeTeamName'] . " - " . $Round2['HomeWin'] . "</a><br /><br /></td>\n";}
                    }
                }

                If ($Row['Round3'] == 0){echo "<td></td>";}else{
                    $Round3 = $db->querySingle("SELECT Playoff" . $TypeText . ".*, TeamInfoHome.Name as HomeTeamName, TeamInfoVisitor.Name as VisitorTeamName, TeamInfoHome.TeamThemeID as HomeThemID, TeamInfoVisitor.TeamThemeID as VisitorThemID FROM (Playoff" . $TypeText . " INNER JOIN Team" . $TypeText . "Info AS TeamInfoHome ON Playoff" . $TypeText . ".HomeTeam = TeamInfoHome.Number) LEFT JOIN Team" . $TypeText . "Info AS TeamInfoVisitor ON Playoff" . $TypeText . ".VisitorTeam = TeamInfoVisitor.Number WHERE Playoff" . $TypeText . ".Number = " . $Row['Round3'],true);	
                    if($Round3 != Null){
                        echo "<td>";If ($Round3['VisitorThemID'] > 0){echo "<img src=\"" . $ImagesCDNPath . "/images/" . $Round3['VisitorThemID'] .".png\" alt=\"\" class=\"STHSPHPStandingTeamImage\" />";		
                        echo "<a href=\"" . $TypeText . "Team.php?Team=" . $Round3['VisitorTeam'] . "\">" . $Round3['VisitorTeamName'] . " - " . $Round3['VisitorWin'] . "</a><br />";}
                        If ($Round3['HomeThemID'] > 0){echo "<img src=\"" . $ImagesCDNPath . "/images/" . $Round3['HomeThemID'] .".png\" alt=\"\" class=\"STHSPHPStandingTeamImage\" />";
                        echo "<a href=\"" . $TypeText . "Team.php?Team=" . $Round3['HomeTeam'] . "\">" . $Round3['HomeTeamName'] . " - " . $Round3['HomeWin'] . "</a><br /><br /></td>\n";}
                    }
                }

                If ($Row['Round4'] == 0){echo "<td></td>";}else{
                    $Round4 = $db->querySingle("SELECT Playoff" . $TypeText . ".*, TeamInfoHome.Name as HomeTeamName, TeamInfoVisitor.Name as VisitorTeamName, TeamInfoHome.TeamThemeID as HomeThemID, TeamInfoVisitor.TeamThemeID as VisitorThemID FROM (Playoff" . $TypeText . " INNER JOIN Team" . $TypeText . "Info AS TeamInfoHome ON Playoff" . $TypeText . ".HomeTeam = TeamInfoHome.Number) LEFT JOIN Team" . $TypeText . "Info AS TeamInfoVisitor ON Playoff" . $TypeText . ".VisitorTeam = TeamInfoVisitor.Number WHERE Playoff" . $TypeText . ".Number = " . $Row['Round4'],true);	
                    if($Round4 != Null){
                        echo "<td>";If ($Round4['VisitorThemID'] > 0){echo "<img src=\"" . $ImagesCDNPath . "/images/" . $Round4['VisitorThemID'] .".png\" alt=\"\" class=\"STHSPHPStandingTeamImage\" />";			
                        echo "<a href=\"" . $TypeText . "Team.php?Team=" . $Round4['VisitorTeam'] . "\">" . $Round4['VisitorTeamName'] . " - " . $Round4['VisitorWin'] . "</a><br />";}
                        If ($Round4['HomeThemID'] > 0){echo "<img src=\"" . $ImagesCDNPath . "/images/" . $Round4['HomeThemID'] .".png\" alt=\"\" class=\"STHSPHPStandingTeamImage\" />";
                        echo "<a href=\"" . $TypeText . "Team.php?Team=" . $Round4['HomeTeam'] . "\">" . $Round4['HomeTeamName'] . " - " . $Round4['HomeWin'] . "</a><br /><br /></td>\n";}
                    }
                }

                If ($Row['Round5'] == 0){echo "<td></td>";}else{
                    $Round5 = $db->querySingle("SELECT Playoff" . $TypeText . ".*, TeamInfoHome.Name as HomeTeamName, TeamInfoVisitor.Name as VisitorTeamName, TeamInfoHome.TeamThemeID as HomeThemID, TeamInfoVisitor.TeamThemeID as VisitorThemID FROM (Playoff" . $TypeText . " INNER JOIN Team" . $TypeText . "Info AS TeamInfoHome ON Playoff" . $TypeText . ".HomeTeam = TeamInfoHome.Number) LEFT JOIN Team" . $TypeText . "Info AS TeamInfoVisitor ON Playoff" . $TypeText . ".VisitorTeam = TeamInfoVisitor.Number WHERE Playoff" . $TypeText . ".Number = " . $Row['Round5'],true);	
                    if($Round5 != Null){
                        echo "<td>";If ($Round5['VisitorThemID'] > 0){echo "<img src=\"" . $ImagesCDNPath . "/images/" . $Round5['VisitorThemID'] .".png\" alt=\"\" class=\"STHSPHPStandingTeamImage\" />";	
                        echo "<a href=\"" . $TypeText . "Team.php?Team=" . $Round5['VisitorTeam'] . "\">" . $Round5['VisitorTeamName'] . " - " . $Round5['VisitorWin'] . "</a><br />";}
                        If ($Round4['HomeThemID'] > 0){echo "<img src=\"" . $ImagesCDNPath . "/images/" . $Round4['HomeThemID'] .".png\" alt=\"\" class=\"STHSPHPStandingTeamImage\" />";
                        echo "<a href=\"" . $TypeText . "Team.php?Team=" . $Round5['HomeTeam'] . "\">" . $Round5['HomeTeamName'] . " - " . $Round5['HomeWin'] . "</a><br /><br /></td>\n";}
                    }
                }
                echo "</tr>";
            }}
            echo "</table>";
        ?>



      

        </div>
        </div>
</div> 


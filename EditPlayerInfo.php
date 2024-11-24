<?php include "Header.php";

$Team = (integer)-1; /* -1 All Team */
$Title = (string)"";
$InformationMessage = (string)"";

If (file_exists($DatabaseFile) == false){	Goto STHSErrorPlayerInfo; }else{
try{

	$Type = (integer)0; /* 0 = All / 1 = Pro / 2 = Farm */

	$TypeQuery = "Number > 0";
	$TeamQuery = "Team >= 0";
	$LeagueName = (string)"";
	$PlayerNumber = (integer)0;
	$PlayerName = (string)"";	
	$PlayerDraftYear = (integer)0;
	$PlayerDraftOverallPick = (integer)0;
	$PlayerNHLID = (integer)0;
	$PlayerJersey = (integer)0;
	$PlayerLink = (string)"";

	if(isset($_GET['Type'])){$Type = filter_var($_GET['Type'], FILTER_SANITIZE_NUMBER_INT);} 
	if(isset($_GET['Team'])){$Team = filter_var($_GET['Team'], FILTER_SANITIZE_NUMBER_INT);}


	$db = new SQLite3($DatabaseFile, SQLITE3_OPEN_READWRITE);


    // Fetch league name 
    $LeagueGeneral = $db->querySingle("SELECT Name FROM LeagueGeneral", true); 
    $LeagueName = $LeagueGeneral['Name'];

  
    if ($CookieTeamNumber > 0 AND $CookieTeamNumber <= 102){

        if(isset($_POST['TeamEdit'])){$TeamEdit = filter_var($_POST['TeamEdit'], FILTER_SANITIZE_NUMBER_INT);}

        if ($TeamEdit == $CookieTeamNumber){	

            if(isset($_POST['PlayerNumber'])){$PlayerNumber = filter_var($_POST['PlayerNumber'], FILTER_SANITIZE_NUMBER_INT);} 
            if(isset($_POST['PlayerName'])){$PlayerName =  filter_var($_POST['PlayerName'], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW || FILTER_FLAG_STRIP_HIGH || FILTER_FLAG_NO_ENCODE_QUOTES || FILTER_FLAG_STRIP_BACKTICK);}
            
            
            
            //if(isset($_POST['DraftYear'])){$PlayerDraftYear = filter_var($_POST['DraftYear'], FILTER_SANITIZE_NUMBER_INT, FILTER_SANITIZE_NUMBER_INT);} If (empty($PlayerDraftYear)){$PlayerDraftYear =0 ;}
            if (isset($_POST['DraftYear'])) {
                $PlayerDraftYear = filter_var($_POST['DraftYear'], FILTER_SANITIZE_NUMBER_INT);
                $PlayerDraftYear = ($PlayerDraftYear >= 1900 && $PlayerDraftYear <= date('Y')) ? (int)$PlayerDraftYear : 0;
            } else {
                $PlayerDraftYear = 0;
            }
            
            
            
            
            if(isset($_POST['DraftOverallPick'])){$PlayerDraftOverallPick = filter_var($_POST['DraftOverallPick'], FILTER_SANITIZE_NUMBER_INT);} If (empty($PlayerDraftOverallPick)){$PlayerDraftOverallPick =0 ;}
            if(isset($_POST['NHLID'])){$PlayerNHLID = filter_var($_POST['NHLID'], FILTER_SANITIZE_NUMBER_INT);} If (empty($PlayerNHLID)){$PlayerNHLID ="" ;}
            if(isset($_POST['Jersey'])){$PlayerJersey = filter_var($_POST['Jersey'], FILTER_SANITIZE_NUMBER_INT);} If (empty($PlayerJersey)){$PlayerJersey =0 ;}
            if(isset($_POST['Hyperlink'])){$PlayerLink = filter_var($_POST['Hyperlink'], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW || FILTER_FLAG_STRIP_HIGH || FILTER_FLAG_NO_ENCODE_QUOTES || FILTER_FLAG_STRIP_BACKTICK);}	

            try {

                if ($PlayerNumber > 0 and $PlayerNumber <= 10000){

                        $Query = "UPDATE PlayerInfo SET 
                        DraftYear = '" . $PlayerDraftYear . "', 
                        DraftOverallPick = '" . $PlayerDraftOverallPick . "', 
                        NHLID = '" . $PlayerNHLID . "', 
                        Jersey = '" . $PlayerJersey  . "', 
                        URLLink = '" . str_replace("'", "''", $PlayerLink) . "', 
                        WebClientModify = 'True' 
                    WHERE Number = " . $PlayerNumber;
                    
                    if ($db->exec($Query) === false) {
                       log2console("Error updating record: " . $db->lastErrorMsg());
                    } else {
                        log2console("Having fun: " . $db->lastErrorMsg());
                        $InformationMessage = $PlayersLang['EditConfirm'] . $PlayerName; 
                    }
                

                }elseif($PlayerNumber > 10000 and $PlayerNumber <= 11000){

                    $Query = "Update GoalerInfo SET DraftYear = '" . $PlayerDraftYear . "', DraftOverallPick = '" . $PlayerDraftOverallPick . "', NHLID = '" . $PlayerNHLID . "', Jersey = '" . $PlayerJersey  . "', NHLID = '" . $PlayerNHLID . "', URLLink = '" . str_replace("'","''",$PlayerLink). "', WebClientModify = 'True' WHERE Number = " . ($PlayerNumber - 10000);
                    $db->exec($Query);
                    $InformationMessage = $PlayersLang['EditConfirm'] . $PlayerName;

                }else{
                    $InformationMessage = $PlayersLang['EditFail'];
                }

            } catch (Exception $e) {  $InformationMessage = $PlayersLang['EditFail'];	}	

        }
    }

					

    /* Team or All */
    if ($Team >= 0){
        $QueryTeam = "SELECT Name FROM TeamProInfo WHERE Number = " . $Team;
        $TeamName = $db->querySingle($QueryTeam,true);	 
        $TeamQuery = "Team = " . $Team;
    }else{
        $TeamQuery = "Team >= 0"; /* All Teams */
    }


    /* Pro Only or Farm  */
    if    ($Type == 1)	$TypeQuery = "Status1 >= 2";
    elseif($Type == 2)	$TypeQuery = "Status1 <= 1";
    else			    $TypeQuery = "Number > 0";    /* Default Place Order Where everything will return */
		

    /* Main Query with correct Variable */
    $Query = "SELECT MainTable.* FROM (SELECT PlayerInfo.Number, PlayerInfo.Name, PlayerInfo.Team, PlayerInfo.TeamName, PlayerInfo.ProTeamName, PlayerInfo.TeamThemeID, PlayerInfo.Age, PlayerInfo.AgeDate, PlayerInfo.URLLink, PlayerInfo.NHLID, PlayerInfo.DraftYear, PlayerInfo.DraftOverallPick, PlayerInfo.Jersey, PlayerInfo.PosC, PlayerInfo.PosLW, PlayerInfo.PosRW, PlayerInfo.PosD, 'False' AS PosG, PlayerInfo.Retire as Retire FROM PlayerInfo WHERE " . $TeamQuery . " AND Retire = \"False\" AND " . $TypeQuery . " UNION ALL SELECT GoalerInfo.Number, GoalerInfo.Name, GoalerInfo.Team, GoalerInfo.TeamName, GoalerInfo.ProTeamName, GoalerInfo.TeamThemeID, GoalerInfo.Age, GoalerInfo.AgeDate, GoalerInfo.URLLink, GoalerInfo.NHLID, GoalerInfo.DraftYear, GoalerInfo.DraftOverallPick, GoalerInfo.Jersey, 'False' AS PosC, 'False' AS PosLW, 'False' AS PosRW, 'False' AS PosD, 'True' AS PosG, GoalerInfo.Retire as Retire FROM GoalerInfo WHERE " . $TeamQuery . " AND Retire = \"False\" AND " . $TypeQuery . ") AS MainTable ORDER BY MainTable.Name ASC";

		/* Ran Query */	
		$PlayerInfo = $db->query($Query);

       /* $playerQuery = "SELECT * FROM PlayerInfo WHERE $TeamQuery AND Retire = 'False' AND $TypeQuery";
        $goalieQuery = "SELECT * FROM GoalerInfo WHERE $TeamQuery AND Retire = 'False' AND $TypeQuery";
        $playerInfo = $db->query($playerQuery);
        $goalieInfo = $db->query($goalieQuery);
        
        $PlayerInfo = array_merge($playerInfo->fetchArray(SQLITE3_ASSOC), $goalieInfo->fetchArray(SQLITE3_ASSOC));
        
*/




	

	

} catch (Exception $e) {
STHSErrorPlayerInfo:
	$LeagueName = $DatabaseNotFound;
	$PlayerInfo = Null;
	$FreeAgentYear = Null;	
}}?>


   <!-- DataTables CSS -->
   <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">


</head><body>

<?php include "Menu.php";?>


<?php if ($InformationMessage != ""){echo "<div class=\"STHSDivInformationMessage\">" . $InformationMessage . "<br /></div>";}?>

<div id="EditPlayerInfoMainDiv" style="width:99%;margin:auto;">
    <h1> Players Information - Edit </h1>


    <div class="py-2">
        Toggle column: 
        <a class="toggle-vis" data-column="0" data-attribute="mainTable" ><?php echo $PlayersLang['PlayerName']; ?></a>
        <a class="toggle-vis" data-column="1" data-attribute="mainTable"><?php echo $PlayersLang['TeamName']; ?></a>
        <a class="toggle-vis" data-column="2" data-attribute="mainTable">POS</a>
        <a class="toggle-vis" data-column="3" data-attribute="mainTable"><?php echo $PlayersLang['Age']; ?></a>
        <a class="toggle-vis" data-column="4" data-attribute="mainTable"><?php echo $PlayersLang['Birthday']; ?></a>
        <a class="toggle-vis" data-column="5" data-attribute="mainTable"><?php echo $PlayersLang['DraftYear']; ?></a>
        <a class="toggle-vis" data-column="6" data-attribute="mainTable"><?php echo $PlayersLang['DraftOverallPick']; ?></a>
        <a class="toggle-vis" data-column="7" data-attribute="mainTable"><?php echo $PlayersLang['Jersey']; ?></a>
        <a class="toggle-vis" data-column="8" data-attribute="mainTable"><?php echo $PlayersLang['NHLID']; ?></a>
        <a class="toggle-vis" data-column="9" data-attribute="mainTable"><?php echo $PlayersLang['Link']; ?></a>
        <a class="toggle-vis" data-column="10" data-attribute="mainTable"><?php echo $PlayersLang['Edit']; ?></a>
    </div>


    <table id="mainTable" class="table table-striped table-bordered tablesorter " style="width:100%">
        <thead><tr>
        <th data-priority="critical" title="Player Name" class="STHSW140Min"><?php echo $PlayersLang['PlayerName'];?></th>
        <?php 
        if($Team >= 0){ echo "<th class=\"columnSelector-false STHSW140Min\" data-priority=\"6\" title=\"Team Name\">" . $PlayersLang['TeamName'] . "</th>";}
        else{ echo "<th data-priority=\"2\" title=\"Team Name\" class=\"STHSW140Min\">" . $PlayersLang['TeamName'] ."</th>";}?>
        <th data-priority="2" title="Position" class="STHSW45">POS</th>
        <th data-priority="5" title="Age" class=" STHSW25"><?php echo $PlayersLang['Age'];?></th>
        <th data-priority="5" title="Birthday" class="STHSW45"><?php echo $PlayersLang['Birthday'];?></th>
        <th data-priority="4" title="Draft Year" class="STHSW55"><?php echo $PlayersLang['DraftYear'];?></th>
        <th data-priority="4" title="Overall Pick" class="STHSW55"><?php echo $PlayersLang['DraftOverallPick'];?></th>
        <th data-priority="4" title="Jersey #" class="STHSW55"><?php echo $PlayersLang['Jersey'];?></th>
        <th data-priority="3" title="NHLID" class="STHSW55"><?php echo $PlayersLang['NHLID'];?></th>
        <th data-priority="3" title="Hyperlink" class="STHSW140Min"><?php echo $PlayersLang['Link'];?></th>
        <th data-priority="2" title="Edit" class="STHSW55"><?php echo $PlayersLang['Edit'];?></th>
        </tr></thead>
    
        <tbody>
<?php 

while ($Row = $PlayerInfo->fetchArray()) { 
    echo "<tr> <form action=\"EditPlayerInfo.php?Type={$Type}" . ($Team > 0 ? "&Team={$Team}" : "") . ($lang == "fr" ? "&Lang=fr" : "") . "\" method=\"post\">";
    // Determine the link based on position
    $linkType = $Row['PosG'] == "True" ? "GoalieReport.php?Goalie=" : "PlayerReport.php?Player=";
    echo "<td><a href=\"{$linkType}{$Row['Number']}\">{$Row['Name']}</a></td>";

    // Display team name with optional image
    echo "<td>";
    if ($Row['TeamThemeID'] > 0) {        echo "<img src=\"{$ImagesCDNPath}/images/{$Row['TeamThemeID']}.png\" alt=\"\" class=\"STHSPHPGoaliesRosterTeamImage\" />";    }
    echo "{$Row['TeamName']}</td>";

    // Calculate position
    $Position = "";
    $Position .= $Row['PosC'] == "True" ? "C" : "";
    $Position .= $Row['PosLW'] == "True" ? ($Position ? "/LW" : "LW") : "";
    $Position .= $Row['PosRW'] == "True" ? ($Position ? "/RW" : "RW") : "";
    $Position .= $Row['PosD'] == "True" ? ($Position ? "/D" : "D") : "";
    $Position .= $Row['PosG'] == "True" ? ($Position ? "/G" : "G") : "";
    echo "<td>{$Position}</td>";

    // Age and birth date
    echo "<td>{$Row['Age']}</td>";
    echo "<td>{$Row['AgeDate']}</td>";

    // Draft Year, Draft Overall Pick, Jersey, NHL ID, and Hyperlink
    echo "<td> <input type=\"number\" min=\"0\" max=\"3000\" name=\"DraftYear\" value=\"{$Row['DraftYear']}\"> </td>";
    echo "<td> <input type=\"number\" min=\"0\" max=\"1000\" name=\"DraftOverallPick\" value=\"{$Row['DraftOverallPick']}\"> </td>";
    echo "<td> <input type=\"number\" min=\"0\" max=\"99\" name=\"Jersey\" value=\"{$Row['Jersey']}\"> </td>";
    echo "<td> <input type=\"number\" min=\"0\" max=\"999999999\" name=\"NHLID\" value=\"{$Row['NHLID']}\"> </td>";
    echo "<td> <input type=\"url\" name=\"Hyperlink\" value=\"{$Row['URLLink']}\" size=\"60\"> </td>";

    // Submit button and hidden fields
    echo "<td> 
                <input type=\"submit\" class=\"SubmitButtonSmall\" value=\"{$PlayersLang['Edit']}\">
                <input type=\"hidden\" name=\"TeamEdit\" value=\"{$CookieTeamNumber}\">
                <input type=\"hidden\" name=\"PlayerName\" value=\"{$Row['Name']}\">
                <input type=\"hidden\" name=\"PlayerNumber\" value=\"" . ($Row['PosG'] == "True" ? ($Row['Number'] + 10000) : $Row['Number']) . "\">
            </td>";
          
    echo "</form> </tr>";
}


?>

</tbody></table></div>


 <!-- jQuery -->
 <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    
<script>
    $(document).ready(function() {
        $('#mainTable').DataTable();
    });
</script>


<?php include "Footer.php";?>
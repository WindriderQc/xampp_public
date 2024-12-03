<?php include "Header.php"; ?>

<?php 
If ($lang == "fr") include 'LanguageFR-Main.php';
else include 'LanguageEN-Main.php';

$IndexQueryOK = (boolean)False;

If (file_exists($DatabaseFile) == false){	Goto STHSErrorIndex;}
else{
$LeagueName = (string)"";
try{

	$db = new SQLite3($DatabaseFile);
	$Query = "Select Name, ScheduleNextDay, IndexHeadLineDay0, IndexHeadLineDay1 ,IndexHeadLineDay2, DefaultSimulationPerDay, PointSystemSO, OffSeason, Days73StarPro, Days303StarPro, Days73StarFarm, Days303StarFarm, Today3StarPro1, Today3StarPro2, Today3StarPro3, Today3StarFarm1, Today3StarFarm2, Today3StarFarm3 from LeagueGeneral";

	$LeagueGeneral = $db->querySingle($Query,true);		
	$LeagueName = $LeagueGeneral['Name'];


    
	$Query = "SELECT LeagueLog.* FROM LeagueLog WHERE (Datetxt = '" . $LeagueGeneral['IndexHeadLineDay0'] . "') AND ((LeagueLog.TransactionType = 2) OR (LeagueLog.TransactionType = 3) OR (LeagueLog.TransactionType = 6)) ORDER BY LeagueLog.Number ";
	$Headlines0 = $db->query($Query);
	$Query = "SELECT TradeLog.* FROM TradeLog WHERE (Datetxt = '" . $LeagueGeneral['IndexHeadLineDay0'] . "') ORDER BY TradeLog.Number";
	$Transaction0 = $db->query($Query);
	$Query = "SELECT LeagueLog.* FROM LeagueLog WHERE (Datetxt = '" . $LeagueGeneral['IndexHeadLineDay1'] . "') AND ((LeagueLog.TransactionType = 2) OR (LeagueLog.TransactionType = 3) OR (LeagueLog.TransactionType = 6)) ORDER BY LeagueLog.Number ";
	$Headlines1 = $db->query($Query);
	$Query = "SELECT TradeLog.* FROM TradeLog WHERE (Datetxt = '" . $LeagueGeneral['IndexHeadLineDay1'] . "') ORDER BY TradeLog.Number";
	$Transaction1 = $db->query($Query);
	$Query = "SELECT LeagueLog.* FROM LeagueLog WHERE (Datetxt = '" . $LeagueGeneral['IndexHeadLineDay2'] . "') AND ((LeagueLog.TransactionType = 2) OR (LeagueLog.TransactionType = 3) OR (LeagueLog.TransactionType = 6)) ORDER BY LeagueLog.Number ";
	$Headlines2 = $db->query($Query);
	$Query = "SELECT TradeLog.* FROM TradeLog WHERE (Datetxt = '" . $LeagueGeneral['IndexHeadLineDay2'] . "') ORDER BY TradeLog.Number";
	$Transaction2 = $db->query($Query);

	$Query = "Select PlayersMugShotBaseURL, PlayersMugShotFileExtension, ProMinimumGamePlayerLeader, ShowFarmScoreinPHPHomePage, NumberofNewsinPHPHomePage, NumberofLatestScoreinPHPHomePage from LeagueOutputOption";

	$LeagueOutputOption = $db->querySingle($Query,true);		
	

    $Query = "SELECT *,'Pro' as Type FROM SchedulePro WHERE Day >= " . ($LeagueGeneral['ScheduleNextDay'] - $LeagueGeneral['DefaultSimulationPerDay']) . " AND PLAY = 'True' ORDER BY GameNumber ";
   

    //  TODO  :    set le 365 / 10 JRS back sur la DB, param pour la query et param pour la longueur du gameScroller....
   
    $QuerySchedule = "SELECT SchedulePro.*, 'Pro' AS Type, TeamProStatVisitor.Last10W AS VLast10W, TeamProStatVisitor.Last10L AS VLast10L, TeamProStatVisitor.Last10T AS VLast10T, TeamProStatVisitor.Last10OTW AS VLast10OTW, TeamProStatVisitor.Last10OTL AS VLast10OTL, TeamProStatVisitor.Last10SOW AS VLast10SOW, TeamProStatVisitor.Last10SOL AS VLast10SOL, TeamProStatVisitor.GP AS VGP, TeamProStatVisitor.W AS VW, TeamProStatVisitor.L AS VL, TeamProStatVisitor.T AS VT, TeamProStatVisitor.OTW AS VOTW, TeamProStatVisitor.OTL AS VOTL, TeamProStatVisitor.SOW AS VSOW, TeamProStatVisitor.SOL AS VSOL, TeamProStatVisitor.Points AS VPoints, TeamProStatVisitor.Streak AS VStreak, TeamProStatHome.Last10W AS HLast10W, TeamProStatHome.Last10L AS HLast10L, TeamProStatHome.Last10T AS HLast10T, TeamProStatHome.Last10OTW AS HLast10OTW, TeamProStatHome.Last10OTL AS HLast10OTL, TeamProStatHome.Last10SOW AS HLast10SOW, TeamProStatHome.Last10SOL AS HLast10SOL, TeamProStatHome.GP AS HGP, TeamProStatHome.W AS HW, TeamProStatHome.L AS HL, TeamProStatHome.T AS HT, TeamProStatHome.OTW AS HOTW, TeamProStatHome.OTL AS HOTL, TeamProStatHome.SOW AS HSOW, TeamProStatHome.SOL AS HSOL, TeamProStatHome.Points AS HPoints, TeamProStatHome.Streak AS HStreak FROM (SchedulePRO LEFT JOIN TeamProStat AS TeamProStatHome ON SchedulePRO.HomeTeam = TeamProStatHome.Number) LEFT JOIN TeamProStat AS TeamProStatVisitor ON SchedulePRO.VisitorTeam = TeamProStatVisitor.Number WHERE DAY >= " . $LeagueGeneral['ScheduleNextDay'] . " AND DAY <= " . ($LeagueGeneral['ScheduleNextDay'] + 31 -1) . " ORDER BY Day, GameNumber";
	

	$LatestScore = $db->query($Query);
	$Schedule = $db->query($QuerySchedule);

	echo "<title>" . $LeagueName . " - " . $IndexLang['IndexTitle'] . "</title>";
	echo "<style>";

	If ($LeagueGeneral['OffSeason'] == "True"){
		echo ".STHSIndex_Score{display:none;}";
		echo ".STHSIndex_Top5Table {display:none;}";
		echo "@media screen and (max-width: 890px) {.STHSIndex_Top5 {display:none;}}";
	}else{
		echo ".STHSIndex_Top20FreeAgents {display:none;}";
		echo "@media screen and (max-width: 890px) {.STHSIndex_Score{display:none;}}";
		echo "@media screen and (max-width: 1210px) {.STHSIndex_Top5 {display:none;}}";
	}
    echo "</style>";

	$IndexQueryOK = True;

} catch (Exception $e) {
STHSErrorIndex:
	$LeagueName = $DatabaseNotFound;
	$Transaction = Null;
	$Schedule = Null;
	$LeagueGeneral = Null;
	$LeagueOutputOption = Null;
	echo "<title>" . $DatabaseNotFound . "</title>";
	echo "<style>";
	echo ".STHSIndex_Main{display:none;}";
	echo "#cssmenu{display:none;}";
    echo "</style>";
}}

?>
</head>
<body>

<div class="container-fluid p-0 m-0">   
    <header>
        <?php include "components/GamesScroller.php"; 
        
       // log2console($LeagueName);
        ?>
        <?php include "Menu.php"; ?>	
        <div class="clearfix header-content" style="display:inline-block;">
            

            <div class="row mt-2  mx-2 " >
				<div class="col-lg-4 col-12"><div> <?php $side=3; include "components/StandingsCard.php"; ?> </div> </div>
                <div class="col-lg-4 col-12"><div> <?php          include "components/TopStars.html";     ?> </div> </div>   
                <div class="col-lg-4 col-12"><div> <?php $side=0; include "components/StandingsCard.php"; ?> </div> </div> 
            </div>

			<div class="row mt-2  mx-2 " >
				<div class="col-lg-12 col-12 transaction-card"> <?php include "components/Transaction2.php"; ?> <?= $$LeagueGeneral['Today3StarPro1'] ?> </div> 
            </div>
        </div>
    </header>
</div> <!-- container-fluid -->

<?php include "Footer.php"; ?>




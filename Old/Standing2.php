<!DOCTYPE html>
<?php include "Header.php";?><?php
$LeagueName = (string)"";
$Title = (string)"";
$Active = 1; /* Show Webpage Top Menu */
$PlayerInfo = (string)"Name, TeamName";
$GoalerInfo = (string)"Name, TeamName";
If (file_exists($DatabaseFile) == false){
	$LeagueName = $DatabaseNotFound;
	$TodayGame = Null;
	$PlayerInfo = Null;
	$GoalerInfo = Null;
	$LeagueGeneral = Null;
	echo "<title>" . $DatabaseNotFound . "</title>";
}else{
	$db = new SQLite3($DatabaseFile);
	
	$Type = (integer)0; /* 0 = All / 1 = Pro / 2 = Farm */
	if(isset($_GET['Type'])){$Type = filter_var($_GET['Type'], FILTER_SANITIZE_NUMBER_INT);} 
	
	$Query = "Select Name, OutputName, DefaultSimulationPerDay, ScheduleNextDay, DatabaseCreationDate, PointSystemSO, Today3StarPro,Today3StarPro1, Today3StarPro2,Today3StarPro3, Today3StarFarm from LeagueGeneral";
	$LeagueGeneral = $db->querySingle($Query,true);	
	$Query = "SELECT Name, TeamName,Team ,Jersey , NHLID from PlayerInfo";
	$PlayerInfo = $db->query($Query);
	$Query = "SELECT Name, TeamName,Team ,Jersey , NHLID from GoalerInfo";
	$GoalerInfo = $db->query($Query);
	
	
	$LeagueName = $LeagueGeneral['Name'];
	
	/* Pro Only, Farm Only or Both  */ 
	if($Type == 1){
		/* Pro Only */
		$Query = "SELECT TodayGame.* FROM TodayGame WHERE TodayGame.GameNumber Like 'Pro%'";
		$TypeText = (string)"Pro";$TitleType = $DynamicTitleLang['Pro'];
		$Title = $LeagueName . " - " . $TodayGamesLang['TodayGamesTitle'] . $DynamicTitleLang['Pro'];
		$QuerySchedule = "SELECT SchedulePro.*, 'Pro' AS Type, TeamProStatVisitor.HomeW AS VHW,TeamProStatVisitor.HomeL AS VHL,TeamProStatVisitor.HomeOTW AS VHOTW,TeamProStatVisitor.HomeOTL AS VHOTL,TeamProStatVisitor.HomeSOW AS VHSOW,TeamProStatVisitor.HomeSOL AS VHSOL, TeamProStatVisitor.OTW AS VOTW, TeamProStatVisitor.OTL AS VOTL, TeamProStatVisitor.SOW AS VSOW, TeamProStatVisitor.SOL AS VSOL, TeamProStatVisitor.Points AS VPoints, TeamProStatVisitor.Streak AS VStreak, TeamProStatHome.Last10W AS HLast10W, TeamProStatHome.Last10L AS HLast10L, TeamProStatHome.Last10T AS HLast10T, TeamProStatHome.Last10OTW AS HLast10OTW,TeamProStatHome.PKGoalGA AS PKGA,TeamProStatHome.PKAttemp AS PKAttemp,TeamProStatHome.GF AS HGF, TeamProStatHome.GA AS HGA,TeamProStatHome.GP AS HGP,TeamProStatHome.Last10OTL AS HLast10OTL, TeamProStatHome.Last10SOW AS HLast10SOW, TeamProStatHome.Last10SOL AS HLast10SOL, TeamProStatHome.GP AS HGP, TeamProStatHome.W AS HW, TeamProStatHome.L AS HL, TeamProStatHome.Points AS HPoints,TeamProStatHome.PPAttemp AS HPPAttemp,TeamProStatHome.PKAttemp AS HPKAttemp,TeamProStatHome.PKGoalGA AS HPKGA,TeamProStatHome.PPGoal AS HPPGoal, TeamProStatHome.T AS HT, TeamProStatHome.OTW AS HOTW, TeamProStatHome.OTL AS HOTL, TeamProStatHome.SOW AS HSOW, TeamProStatHome.SOL AS HSOL, TeamProStatHome.Points AS HPoints,TeamProStatHome.HomeW AS HHW,TeamProStatHome.HomeL AS HHL,TeamProStatHome.HomeOTW AS HHOTW,TeamProStatHome.HomeOTL AS HHOTL,TeamProStatHome.HomeSOW AS HHSOW,TeamProStatHome.HomeSOL AS HHSOL, TeamProStatHome.Streak AS HStreak,TeamProStatVisitor.Last10W AS VLast10W,TeamProStatVisitor.GF AS VGF,TeamProStatHome.PKGoalGA AS PKGA,TeamProStatHome.PKAttemp AS PKAttemp,TeamProStatHome.GF AS HGF, TeamProStatHome.GA AS HGA,TeamProStatHome.GP AS HGP,TeamProStatVisitor.GA AS VGA,TeamProStatVisitor.PKGoalGA AS VPKGA,TeamProStatVisitor.PKAttemp AS VPKAttemp,TeamProStatVisitor.PPGoal AS VPPGoal,TeamProStatVisitor.PPAttemp AS VPPAttemp,TeamProStatVisitor.GP AS VGP, TeamProStatVisitor.Last10L AS VLast10L, TeamProStatVisitor.Last10T AS VLast10T, TeamProStatVisitor.Last10OTW AS VLast10OTW, TeamProStatVisitor.Last10OTL AS VLast10OTL, TeamProStatVisitor.Last10SOW AS VLast10SOW, TeamProStatVisitor.Last10SOL AS VLast10SOL, TeamProStatVisitor.GP AS VGP, TeamProStatVisitor.W AS VW, TeamProStatVisitor.L AS VL, TeamProStatVisitor.T AS VT, TeamProStatVisitor.OTW AS VOTW, TeamProStatVisitor.OTL AS VOTL, TeamProStatVisitor.SOW AS VSOW, TeamProStatVisitor.SOL AS VSOL, TeamProStatVisitor.Points AS VPoints, TeamProStatVisitor.Streak AS VStreak, TeamProStatHome.Last10W AS HLast10W, TeamProStatHome.Last10L AS HLast10L, TeamProStatHome.Last10T AS HLast10T, TeamProStatHome.Last10OTW AS HLast10OTW, TeamProStatHome.Last10OTL AS HLast10OTL, TeamProStatHome.Last10SOW AS HLast10SOW, TeamProStatHome.Last10SOL AS HLast10SOL, TeamProStatHome.GP AS HGP, TeamProStatHome.W AS HW, TeamProStatHome.L AS HL, TeamProStatHome.T AS HT, TeamProStatHome.OTW AS HOTW, TeamProStatHome.OTL AS HOTL, TeamProStatHome.SOW AS HSOW, TeamProStatHome.SOL AS HSOL, TeamProStatHome.Points AS HPoints, TeamProStatHome.Streak AS HStreak FROM (SchedulePRO LEFT JOIN TeamProStat AS TeamProStatHome ON SchedulePRO.HomeTeam = TeamProStatHome.Number) LEFT JOIN TeamProStat AS TeamProStatVisitor ON SchedulePRO.VisitorTeam = TeamProStatVisitor.Number WHERE DAY >= " . $LeagueGeneral['ScheduleNextDay'] . " AND DAY <= " . ($LeagueGeneral['ScheduleNextDay'] + $LeagueGeneral['DefaultSimulationPerDay'] -1) . " ORDER BY Day, GameNumber";
		$QueryGameInfo = "SELECT SchedulePro.*, 'Pro' AS Type, TeamProInfoHome.Arena AS HArena FROM (SchedulePRO LEFT JOIN TeamProInfo AS TeamProInfoHome ON SchedulePRO.HomeTeam = TeamProInfoHome.Number) WHERE DAY >= " . $LeagueGeneral['ScheduleNextDay'] . " AND DAY <= " . ($LeagueGeneral['ScheduleNextDay'] + $LeagueGeneral['DefaultSimulationPerDay'] -1) . " ORDER BY Day, GameNumber";

	}elseif($Type == 2){
		/* Farm Only */
		$Query = "SELECT TodayGame.* FROM TodayGame WHERE TodayGame.GameNumber Like 'Farm%'";
		$TypeText = (string)"Farm";$TitleType = $DynamicTitleLang['Farm'];
		$Title = $LeagueName . " - " . $TodayGamesLang['TodayGamesTitle'] .  $DynamicTitleLang['Farm'];
		$QuerySchedule = "SELECT ScheduleFarm.*, 'Farm' AS Type, TeamFarmStatVisitor.Last10W AS VLast10W, TeamFarmStatVisitor.Last10L AS VLast10L, TeamFarmStatVisitor.Last10T AS VLast10T, TeamFarmStatVisitor.Last10OTW AS VLast10OTW, TeamFarmStatVisitor.Last10OTL AS VLast10OTL, TeamFarmStatVisitor.Last10SOW AS VLast10SOW, TeamFarmStatVisitor.Last10SOL AS VLast10SOL, TeamFarmStatVisitor.GP AS VGP, TeamFarmStatVisitor.W AS VW, TeamFarmStatVisitor.L AS VL, TeamFarmStatVisitor.T AS VT, TeamFarmStatVisitor.OTW AS VOTW, TeamFarmStatVisitor.OTL AS VOTL, TeamFarmStatVisitor.SOW AS VSOW, TeamFarmStatVisitor.SOL AS VSOL, TeamFarmStatVisitor.Points AS VPoints, TeamFarmStatVisitor.Streak AS VStreak, TeamFarmStatHome.Last10W AS HLast10W, TeamFarmStatHome.Last10L AS HLast10L, TeamFarmStatHome.Last10T AS HLast10T, TeamFarmStatHome.Last10OTW AS HLast10OTW, TeamFarmStatHome.Last10OTL AS HLast10OTL, TeamFarmStatHome.Last10SOW AS HLast10SOW, TeamFarmStatHome.Last10SOL AS HLast10SOL, TeamFarmStatHome.GP AS HGP, TeamFarmStatHome.W AS HW, TeamFarmStatHome.L AS HL, TeamFarmStatHome.T AS HT, TeamFarmStatHome.OTW AS HOTW, TeamFarmStatHome.OTL AS HOTL, TeamFarmStatHome.SOW AS HSOW, TeamFarmStatHome.SOL AS HSOL, TeamFarmStatHome.Points AS HPoints, TeamFarmStatHome.Streak AS HStreak FROM (ScheduleFarm LEFT JOIN TeamFarmStat AS TeamFarmStatHome ON ScheduleFarm.HomeTeam = TeamFarmStatHome.Number) LEFT JOIN TeamFarmStat AS TeamFarmStatVisitor ON ScheduleFarm.HomeTeam = TeamFarmStatVisitor.Number WHERE DAY >= " . $LeagueGeneral['ScheduleNextDay'] . " AND DAY <= " . ($LeagueGeneral['ScheduleNextDay'] + $LeagueGeneral['DefaultSimulationPerDay'] -1) . " ORDER BY Day, GameNumber";
	}else{
		/* Both */
		$Query = "SELECT TodayGame.* FROM TodayGame WHERE TodayGame.GameNumber Like 'Pro%'";
		$TypeText = (string)"Pro";$TitleType = $DynamicTitleLang['Pro'];
		$Title = $LeagueName . " - " . $TodayGamesLang['TodayGamesTitle'] . $DynamicTitleLang['Pro'];
		$QuerySchedule = "SELECT SchedulePro.*, 'Pro' AS Type,TeamProStatVisitor.HomeW AS VHW,TeamProStatVisitor.HomeL AS VHL,TeamProStatVisitor.HomeOTW AS VHOTW,TeamProStatVisitor.HomeOTL AS VHOTL,TeamProStatVisitor.HomeSOW AS VHSOW,TeamProStatVisitor.HomeSOL AS VHSOL, TeamProStatVisitor.OTW AS VOTW, TeamProStatVisitor.OTL AS VOTL, TeamProStatVisitor.SOW AS VSOW, TeamProStatVisitor.SOL AS VSOL, TeamProStatVisitor.Points AS VPoints, TeamProStatVisitor.Streak AS VStreak, TeamProStatHome.Last10W AS HLast10W, TeamProStatHome.Last10L AS HLast10L, TeamProStatHome.Last10T AS HLast10T, TeamProStatHome.Last10OTW AS HLast10OTW,TeamProStatHome.PKGoalGA AS PKGA,TeamProStatHome.PKAttemp AS PKAttemp,TeamProStatHome.GF AS HGF, TeamProStatHome.GA AS HGA,TeamProStatHome.GP AS HGP,TeamProStatHome.Last10OTL AS HLast10OTL, TeamProStatHome.Last10SOW AS HLast10SOW, TeamProStatHome.Last10SOL AS HLast10SOL, TeamProStatHome.GP AS HGP, TeamProStatHome.W AS HW, TeamProStatHome.L AS HL, TeamProStatHome.Points AS HPoints,TeamProStatHome.PPAttemp AS HPPAttemp,TeamProStatHome.PKAttemp AS HPKAttemp,TeamProStatHome.PKGoalGA AS HPKGA,TeamProStatHome.PPGoal AS HPPGoal, TeamProStatHome.T AS HT, TeamProStatHome.OTW AS HOTW, TeamProStatHome.OTL AS HOTL, TeamProStatHome.SOW AS HSOW, TeamProStatHome.SOL AS HSOL, TeamProStatHome.Points AS HPoints,TeamProStatHome.HomeW AS HHW,TeamProStatHome.HomeL AS HHL,TeamProStatHome.HomeOTW AS HHOTW,TeamProStatHome.HomeOTL AS HHOTL,TeamProStatHome.HomeSOW AS HHSOW,TeamProStatHome.HomeSOL AS HHSOL, TeamProStatHome.Streak AS HStreak,TeamProStatVisitor.GF AS VGF,TeamProStatHome.PKGoalGA AS PKGA,TeamProStatHome.PKAttemp AS PKAttemp,TeamProStatHome.GF AS HGF, TeamProStatHome.GA AS HGA,TeamProStatHome.GP AS HGP,TeamProStatVisitor.GA AS VGA,TeamProStatVisitor.PKGoalGA AS VPKGA,TeamProStatVisitor.PKAttemp AS VPKAttemp,TeamProStatVisitor.PPGoal AS VPPGoal,TeamProStatVisitor.PPAttemp AS VPPAttemp,TeamProStatVisitor.GP AS VGP, TeamProStatVisitor.Last10W AS VLast10W, TeamProStatVisitor.Last10L AS VLast10L, TeamProStatVisitor.Last10T AS VLast10T, TeamProStatVisitor.Last10OTW AS VLast10OTW, TeamProStatVisitor.Last10OTL AS VLast10OTL, TeamProStatVisitor.Last10SOW AS VLast10SOW, TeamProStatVisitor.Last10SOL AS VLast10SOL, TeamProStatVisitor.GP AS VGP, TeamProStatVisitor.W AS VW, TeamProStatVisitor.L AS VL, TeamProStatVisitor.T AS VT, TeamProStatVisitor.OTW AS VOTW, TeamProStatVisitor.OTL AS VOTL, TeamProStatVisitor.SOW AS VSOW, TeamProStatVisitor.SOL AS VSOL, TeamProStatVisitor.Points AS VPoints, TeamProStatVisitor.Streak AS VStreak, TeamProStatHome.Last10W AS HLast10W, TeamProStatHome.Last10L AS HLast10L, TeamProStatHome.Last10T AS HLast10T, TeamProStatHome.Last10OTW AS HLast10OTW, TeamProStatHome.Last10OTL AS HLast10OTL, TeamProStatHome.Last10SOW AS HLast10SOW, TeamProStatHome.Last10SOL AS HLast10SOL, TeamProStatHome.GP AS HGP, TeamProStatHome.W AS HW, TeamProStatHome.L AS HL, TeamProStatHome.T AS HT, TeamProStatHome.OTW AS HOTW, TeamProStatHome.OTL AS HOTL, TeamProStatHome.SOW AS HSOW, TeamProStatHome.SOL AS HSOL, TeamProStatHome.Points AS HPoints, TeamProStatHome.Streak AS HStreak FROM (SchedulePRO LEFT JOIN TeamProStat AS TeamProStatHome ON SchedulePRO.HomeTeam = TeamProStatHome.Number) LEFT JOIN TeamProStat AS TeamProStatVisitor ON SchedulePRO.VisitorTeam = TeamProStatVisitor.Number WHERE DAY >= " . $LeagueGeneral['ScheduleNextDay'] . " AND DAY <= " . ($LeagueGeneral['ScheduleNextDay'] + $LeagueGeneral['DefaultSimulationPerDay'] -1) . " ORDER BY Day, GameNumber";
		$QueryGameInfo = "SELECT SchedulePro.*, 'Pro' AS Type, TeamProInfoHome.Arena AS HArena FROM (SchedulePRO LEFT JOIN TeamProInfo AS TeamProInfoHome ON SchedulePRO.HomeTeam = TeamProInfoHome.Number) WHERE DAY >= " . $LeagueGeneral['ScheduleNextDay'] . " AND DAY <= " . ($LeagueGeneral['ScheduleNextDay'] + $LeagueGeneral['DefaultSimulationPerDay'] -1) . " ORDER BY Day, GameNumber";


	}
	$TodayGame = $db->query($Query);
	$Schedule = $db->query($QuerySchedule);
	$GameInfo = $db->query($QuerySchedule);


	$Query = "SELECT Count(TodayGame.GameNumber) AS GameInTable FROM TodayGame";
	$TodayGameCount = $db->querySingle($Query,True);
}
echo "<title>" . $Title . "</title>";


Function PrintGames($Row, $TodayGamesLang){

	echo "<table class=\"STHSTodayGame_GameData\" style=border-collapse:collapse><tbody style=border-collapse:collapse>";
	echo "<tr colspan=\"3 \" style=padding-left:10px;line-height:28px;color:#383732;font-family:Rajdhani,Oswald,Barlow,Khand,sans-serif;font-weight:bold;font-size:14px;margin:0px><td colspan=2 style=padding-left:10px><a style=color:#383732;text-decoration:none href=\"" . $Row['Link'] ."\">" . "Final " . "</a>";
if ($Row['Note'] != ""){echo " / " . $Row['Note'];
}else{
		echo "";
	}

	echo "</td></tr><tr style=line-height:28px;><td style=padding-left:10px;color:white;font-weight:bold;margin:0px;width:35px;height:35px;padding-left:10px><img src=\"/images/LogoTeams/Pro/" . $Row['VisitorTeamNumber'] . "." . svg . "\" alt=\"" . $TeamName . "\" style=vertical-align:middle;padding-right:4px;width:32px;height:32px></td><td style=font-size:15px;margin:0px;vertical-align:middle;padding-right:6px;font-weight:bold;font-family:Rajdhani,Oswald,Barlow,Khand,sans-serif;color:#383732>";
 	If ($Row['VisitorTeamScore'] < $Row['HomeTeamScore']){echo "<span style=\"color:#66737C;font-weight:bold;margin:0px;font-size:15px;font-family:Rajdhani,Oswald,Barlow,Khand,sans-serif\">". $Row['VisitorTeam'] ."</span>";}else{echo $Row['VisitorTeam'];}
 	echo  "</td><td style=font-size:24px;margin:0px;vertical-align:middle;padding-right:6px;font-weight:bold;font-family:Rajdhani,Oswald,Barlow,Khand,sans-serif;color:#383732;text-align:right>";
	If ($Row['VisitorTeamScore'] < $Row['HomeTeamScore']){echo "<span style=\"color:#66737C;font-weight:bold;margin:0px;font-size:24px;font-family:Rajdhani,Oswald,Barlow,Khand,sans-serif\">". $Row['VisitorTeamScore']."</span>";}else{echo $Row['VisitorTeamScore'];}
	echo "</td></tr><tr style=line-height:28px><td style=padding-left:10px;color:white;font-weight:bold;margin:0px;width:35px;height:35px;padding-left:10px><img src=\"/images/LogoTeams/Pro/" . $Row['HomeTeamNumber'] . "." . svg  . "\" alt=\"" . $TeamName . "\" style=vertical-align:middle;padding-right:4px;width:32px;height:32px></td><td style=font-size:15px;margin:0px;vertical-align:middle;padding-right:6px;font-weight:bold;font-family:Rajdhani,Oswald,Barlow,Khand,sans-serif;color:#383732>";
	If ($Row['VisitorTeamScore'] > $Row['HomeTeamScore']){echo "<span style=\"color:#66737C;font-weight:bold;margin:0px;font-size:15px;font-family:Rajdhani,Oswald,Barlow,Khand,sans-serif\">". $Row['HomeTeam'] ."</span>";}else{echo $Row['HomeTeam'];}
	echo"</td><td style=font-size:24px;margin:0px;vertical-align:middle;padding-right:6px;font-weight:bold;font-family:Rajdhani,Oswald,Barlow,Khand,sans-serif;color:#383732;text-align:right>";
	If ($Row['VisitorTeamScore'] > $Row['HomeTeamScore']){echo "<span style=\"color:#66737C;font-weight:bold;margin:0px;font-size:24px;font-family:Rajdhani,Oswald,Barlow,Khand,sans-serif\">". $Row['HomeTeamScore'] ."</span>";}else{echo $Row['HomeTeamScore'];}
	 echo"</td></tr>";

	echo "<tr style=background:#F3F4F5;border-top-style:solid;border-top-width:1px;border-top-color:#E6E8EA;line-height:30px><td style=padding-left:10px;color:#383732;font-family:Rajdhani,Oswald,Barlow,Khand,sans-serif;font-size:14px;font-weight:bold colspan=3><a style=color:#383732;text-decoration:none href=\"" . $Row['Link'] ."\">" . "Summary" ."</a></td></tr></tbody></table>\n";
}
?> 

<link rel="stylesheet" type="text/css" href="../../playoffs.css">
<?php
$Title = (string)"";
$Active = 2; /* Show Webpage Top Menu */
If (file_exists($DatabaseFile) == false){
	$LeagueName = $DatabaseNotFound;
	$Schedule = Null;
	$LeagueOutputOption = Null;
	echo "<title>" . $DatabaseNotFound . "</title>";
	$Title = $DatabaseNotFound;
}else{
	$Team = (integer)0; /* 0 All Team */
	$TypeText = (string)"Pro";$TitleType = $DynamicTitleLang['Pro'];
	$LeagueName = (string)"";
	if(isset($_GET['Farm'])){$TypeText = "Farm";$TitleType = $DynamicTitleLang['Farm'];$Active = 3;}
	if(isset($_GET['Team'])){$Team = filter_var($_GET['Team'], FILTER_SANITIZE_NUMBER_INT);}

	$db = new SQLite3($DatabaseFile);
	
	$Query = "Select ScheduleUseDateInsteadofDay, ScheduleRealDate from LeagueOutputOption";
	$LeagueOutputOption = $db->querySingle($Query,true);	
	$Query = "Select Name, DefaultSimulationPerDay, OffSeason, TradeDeadLine, ProScheduleTotalDay, ScheduleNextDay from LeagueGeneral";
	$LeagueGeneral = $db->querySingle($Query,true);		
	$LeagueName = $LeagueGeneral['Name'];
	
	If ($Team == 0){
		$Title = $ScheduleLang['ScheduleTitle1'] . $ScheduleLang['ScheduleTitle2'] . " " . $TitleType;
		$Query = "SELECT * FROM Schedule" . $TypeText . " ORDER BY GameNumber";
	}else{
		$Query = "SELECT Name, City FROM Team" . $TypeText . "Info WHERE Number = " . $Team ;
		$TeamName = $db->querySingle($Query);
		$Title =  $ScheduleLang['TeamTitle'] . $TitleType . " " .  $TeamName;
		
		$Query = "SELECT * FROM Schedule" . $TypeText . " WHERE (VisitorTeam = " . $Team . " OR HomeTeam = " . $Team . ") ORDER BY GameNumber";
	}
	$Schedule = $db->query($Query);
	
	$Query = "SELECT * FROM ProRivalryInfo WHERE Team1 = " . $Team . " ORDER BY Team2";
	$RivalryInfo = $db->query($Query);	
	echo "<title>" . $LeagueName . " - " . $Title . "</title>";
}?>
<?php
$Title = (string)"";
$Active = 2; /* Show Webpage Top Menu */
If (file_exists($DatabaseFile) == false){
	$LeagueName = $DatabaseNotFound;
	$Schedule = Null;
	$TeamInfo = Null;
	$LeagueOutputOption = Null;
	echo "<title>" . $DatabaseNotFound . "</title>";
	$Title = $DatabaseNotFound;
}else{
	$Team = (integer)0; /* 0 All Team */
	$TypeText = (string)"Pro";$TitleType = $DynamicTitleLang['Pro'];
	$LeagueName = (string)"";
	if(isset($_GET['Farm'])){$TypeText = "Farm";$TitleType = $DynamicTitleLang['Farm'];$Active = 3;}
	if(isset($_GET['Team'])){$Team = filter_var($_GET['Team'], FILTER_SANITIZE_NUMBER_INT);}

	$db = new SQLite3($DatabaseFile);
	
	$Query = "SELECT City FROM TeamProInfo WHERE Number = " . $Team;
	$TeamInfo = $db->querySingle($Query,true);
	$Query = "Select ScheduleUseDateInsteadofDay, ScheduleRealDate from LeagueOutputOption";
	$LeagueOutputOption = $db->querySingle($Query,true);	
	$Query = "Select Name, DefaultSimulationPerDay, TradeDeadLine, OffSeason, ProScheduleTotalDay, ScheduleNextDay from LeagueGeneral";
	$LeagueGeneral = $db->querySingle($Query,true);		
	$LeagueName = $LeagueGeneral['Name'];
	
	If ($Team == 0){
		$Title = $ScheduleLang['ScheduleTitle1'] . $ScheduleLang['ScheduleTitle2'] . " " . $TitleType;
		$Query = "SELECT * FROM Schedule" . $TypeText . " ORDER BY GameNumber";
	}else{
		$Query = "SELECT Name FROM Team" . $TypeText . "Info WHERE Number = " . $Team ;
		$TeamName = $db->querySingle($Query);
		$Title =  $ScheduleLang['TeamTitle'] . $TitleType . " " .  $TeamName;
		
		$Query = "SELECT * FROM Schedule" . $TypeText . " WHERE (VisitorTeam = " . $Team . " OR HomeTeam = " . $Team . ") ORDER BY GameNumber";
	}
	$Schedule = $db->query($Query);
	
	$Query = "SELECT * FROM ProRivalryInfo WHERE Team1 = " . $Team . " ORDER BY Team2";
	$RivalryInfo = $db->query($Query);	
	echo "<title>" . $LeagueName . " - " . $Title . "</title>";
}?>

<?php
$TypeText = (string)"Pro";$TitleType = $DynamicTitleLang['Pro'];
$TypeTextTeam = (string)"Pro";
$Playoff = (boolean)False;
$Title = (string)"";
$DatabaseFound = (boolean)False;
$Active = 2; /* Show Webpage Top Menu */
If (file_exists($DatabaseFile) == false){
	$DatabaseFound = False;
	$LeagueName = $DatabaseNotFound;
	$Standing = Null;
	$LeagueGeneral = Null;
	echo "<title>" . $DatabaseNotFound . "</title>";
	$Title = $DatabaseNotFound;
}else{
	$DatabaseFound = True;
	$Title = (string)"";
	$LeagueName = (string)"";
	if(isset($_GET['Farm'])){$TypeText = "Farm";$TypeTextTeam = (string)"Farm";$TitleType = $DynamicTitleLang['Farm'];$Active = 3;}
	
	$db = new SQLite3($DatabaseFile);
	
	$Query = "Select Name, PointSystemW," . $TypeText . "ConferenceName1 AS ConferenceName1," . $TypeText . "ConferenceName2 AS ConferenceName2," . $TypeText . "DivisionName1 AS DivisionName1," . $TypeText . "DivisionName2 AS DivisionName2," . $TypeText . "DivisionName3 AS DivisionName3," . $TypeText . "DivisionName4 AS DivisionName4," . $TypeText . "DivisionName5 AS DivisionName5," . $TypeText . "DivisionName6 AS DivisionName6," . $TypeText . "HowManyPlayOffTeam AS HowManyPlayOffTeam," . $TypeText . "DivisionNewNHLPlayoff  AS DivisionNewNHLPlayoff,PlayOffWinner" . $TypeText . " AS PlayOffWinner, PlayOffStarted, PlayOffRound from LeagueGeneral";
	$LeagueGeneral = $db->querySingle($Query,true);		
	$LeagueName = $LeagueGeneral['Name'];
	$Conference = array($LeagueGeneral['ConferenceName1'], $LeagueGeneral['ConferenceName2']);
	$Division = array($LeagueGeneral['DivisionName1'], $LeagueGeneral['DivisionName2'], $LeagueGeneral['DivisionName3'], $LeagueGeneral['DivisionName4'], $LeagueGeneral['DivisionName5'], $LeagueGeneral['DivisionName6']);
	
	$Query = "Select " . $TypeText . "TwoConference AS TwoConference from LeagueSimulation";
	$LeagueSimulation = $db->querySingle($Query,true);	
	
	if(isset($_GET['Season'])){
		$TypeTextTeam = $TypeTextTeam . "Season";
		$Title = $LeagueName . " - " . $StandingLang['Standing'] . " " . $TitleType;
	}else{
		if ($LeagueGeneral['PlayOffStarted'] == "True"){
			$Title = $LeagueName . " - " . $StandingLang['Playoff'] . " " . $TitleType;
			$Playoff = True;
		}else{
			$Title = $LeagueName . " - " . $StandingLang['Standing'] . " " . $TitleType;
		}
	}
}
echo "<title>" . $Title . "</title>";

function PrintStandingTop($TeamStatLang) {
echo "<table class=\"tablesorter STHSPHPStanding_Table\" style=padding:20px;background-color:white;border-collapse:collapse><thead><tr>";
echo "<th colspan=\"2\" style=text-align:center;font-weight:bold;border-width:0px;background-color:#2a2a2a;color:#fff;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase;text-transform:uppercase data-priority=\"1\" title=\"Team Name\" class=\"STHSW200\">" . $TeamStatLang['TeamName'] ."</th>";
echo "<th style=text-align:center;font-weight:bold;border-width:0px;background-color:#2a2a2a;color:#fff;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase;text-transform:uppercase data-priority=\"1\"title=\"Games Played\" class=\"STHSW30\"  style=text-align:center>GP</th>";
echo "<th  style=text-align:center;font-weight:bold;border-width:0px;background-color:#2a2a2a;color:#fff;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase;text-transform:uppercase data-priority=\"1\"title=\"Wins\" class=\"STHSW30\">W</th>";
echo "<th  style=text-align:center;font-weight:bold;border-width:0px;background-color:#2a2a2a;color:#fff;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase;text-transform:uppercase data-priority=\"1\"title=\"Loss\" class=\"STHSW30\">L</th>";
echo "<th  style=text-align:center;font-weight:bold;border-width:0px;background-color:#2a2a2a;color:#fff;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase;text-transform:uppercase data-priority=\"1\"title=\"Overtime Loss\" class=\"STHSW30\">OTL</th>";
echo "<th  style=text-align:center;font-weight:bold;border-width:0px;background-color:#2a2a2a;color:#fff;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase;text-transform:uppercase data-priority=\"1\"title=\"Points\" class=\"STHSW30\">PTS</th>";
echo "<th  style=text-align:center;font-weight:bold;border-width:0px;background-color:#2a2a2a;color:#fff;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase;text-transform:uppercase data-priority=\"1\"title=\"Normal Wins\" class=\"STHSW30\">RW</th>";
echo "<th  style=text-align:center;font-weight:bold;border-width:0px;background-color:#2a2a2a;color:#fff;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase;text-transform:uppercase data-priority=\"1\"title=\"Normal Wins + Overtime Win\" class=\"STHSW30\">ROW</th>";
echo "<th  style=text-align:center;font-weight:bold;border-width:0px;background-color:#2a2a2a;color:#fff;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase;text-transform:uppercase data-priority=\"1\" title=\"Goals For\" class=\"STHSW30\">GF</th>";
echo "<th  style=text-align:center;font-weight:bold;border-width:0px;background-color:#2a2a2a;color:#fff;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase;text-transform:uppercase data-priority=\"1\" title=\"Goals Against\" class=\"STHSW30\">GA</th>";
echo "<th  style=text-align:center;font-weight:bold;border-width:0px;background-color:#2a2a2a;color:#fff;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase;text-transform:uppercase data-priority=\"1\" title=\"Goals For Diffirencial against Goals Against\" class=\"STHSW30\">Diff</th>";
echo "<th id=browser  style=text-align:center;font-weight:bold;border-width:0px;background-color:#2a2a2a;color:#fff;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase;text-transform:uppercase data-priority=\"2\"title=\"Home Only\" class=\"STHSW75\">" . $TeamStatLang['Home'] ."</th>";
echo "<th id=browser style=text-align:center;font-weight:bold;border-width:0px;background-color:#2a2a2a;color:#fff;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase;text-transform:uppercase data-priority=\"2\"title=\"Visitor Only\" class=\"STHSW75\">" . $TeamStatLang['Visitor'] ."</th>";
echo "<th  style=text-align:center;font-weight:bold;border-width:0px;background-color:#2a2a2a;color:#fff;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase;text-transform:uppercase title=\"Shootout Record\" class=\"STHSW30\">" . "S/O" ."</th>";
echo "<th   style=text-align:center;font-weight:bold;border-width:0px;background-color:#2a2a2a;color:#fff;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase;text-transform:uppercase data-priority=\"1\"title=\"Last 10 Game\" class=\"STHSW75\">" . $TeamStatLang['Last10'] ."</th>";
echo "<th  style=text-align:center;font-weight:bold;border-width:0px;background-color:#2a2a2a;color:#fff;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase;text-transform:uppercase data-priority=\"1\"title=\"Streak\" class=\"STHSW30\">STK</th>";
echo "<th  style=text-align:center;font-weight:bold;border-width:0px;background-color:#2a2a2a;color:#fff;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase;text-transform:uppercase data-priority=\"critica\"title=\"Next Opponent\" class=\"STHSW75\">Last 5</th>";
echo "<th  style=text-align:center;font-weight:bold;border-width:0px;background-color:#2a2a2a;color:#fff;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase;text-transform:uppercase data-priority=\"critical\"title=\"Next Opponent\" class=\"STHSW30\">Next</th>";
echo "</tr></thead><tbody>";
}

Function PrintStandingTable($Standing, $TypeText, $PointSystem, $LinesNumber = 0,$DatabaseFile){
$LoopCount =0;
while ($row = $Standing ->fetchArray()) {
	$LoopCount +=1;
	PrintStandingTableRow($row, $TypeText, $PointSystem, $LoopCount,$DatabaseFile);
	If ($LoopCount > 0 AND $LoopCount == $LinesNumber){echo "<hr />";}
}
echo "</tbody></table>";
}

Function PrintStandingTableRow($row, $TypeText, $PointSystem, $LoopCount,$DatabaseFile){
	echo "<tr style=line-height:40px;font-size:12px;color:#2b2b2b;border-width:1px;border-style:solid;border-color:#ccc>";
	?>
	
<?php
	echo "<td style=text-align:center;width:8px><span style=padding-left:8px;font-weight:bold>". $LoopCount ."</span></td><td style=\"width:13em\"><span><img src=\"/images/LogoTeams/" . $TypeText . "/" . $row['Number'] . "." . svg  . "\" alt=\"" . $TeamName . "\" style=width:32px;height:32px;padding-left:8px;vertical-align:middle></span><a href=\"" . $TypeText . "Team.php?Team=" . $row['Number'] . "\" style=font-size:14px;padding-left:8px;>";
	echo "<span style=font-weight:bold;letter-spacing:0.3px;font-family:Rajdhani,Oswald,Barlow,Khand,sans-serif;text-transform:uppercase>" . $row['City'] . "</a>";
	if($row['StandingPlayoffTitle']=="E"){echo " - e";
	} else if($row['StandingPlayoffTitle']=="X"){echo " - x";
	} else if($row['StandingPlayoffTitle']=="Y"){echo " - y";
	} else if($row['StandingPlayoffTitle']=="Z"){echo " - z";
	} else if($row['StandingPlayoffTitle']=="Z" && $row['PowerRanking']==1){
	  echo " - p";}
	echo "</td><td style=text-align:center>" . $row['GP'] . "</td>";
	echo "<td style=text-align:center>" . ($row['W'] + $row['OTW'] + $row['SOW']) . "</td>";
	echo "<td style=text-align:center>" . $row['L'] . "</td>";
	echo "<td style=text-align:center>" . ($row['OTL'] + $row['SOL']) . "</td>";	
	echo "<td style=text-align:center><strong>" . $row['Points'] . "</strong></td>";	
	echo "<td style=text-align:center>" . $row['W'] . "</td>";		
	echo "<td style=text-align:center>" . ($row['W'] + $row['OTW']) . "</td>";		
	echo "<td style=text-align:center>" . $row['GF'] . "</td>";
	echo "<td style=text-align:center>" . $row['GA'] . "</td>";
	echo "<td style=text-align:center>";
	If (($row['GF'] - $row['GA']) > 0){echo "<span style=\"color:#00b300;font-weight:bold\">" . "+" . ($row['GF'] - $row['GA']) ."</span>";}if (($row['GF'] - $row['GA']) < 0){echo "<span style=\"color:#d60000;font-weight:bold\">"  . ($row['GF'] - $row['GA']) ."</span>";}if (($row['GF'] - $row['GA']) == 0){echo "<span style=\"color:#262525;font-weight:bold\">" .   ($row['GF'] - $row['GA']) ."</span>";}
	echo "</td>";
	echo "<td  style=text-align:center>" . ($row['HomeW'] + $row['HomeOTW'] + $row['HomeSOW'])."-".$row['HomeL']."-".($row['HomeOTL']+$row['HomeSOL']) . "</td>";
	echo "<td  style=text-align:center>" . ($row['W'] + $row['OTW'] + $row['SOW'] - $row['HomeW'] - $row['HomeOTW'] - $row['HomeSOW'])."-".($row['L'] - $row['HomeL'])."-".($row['OTL']+$row['SOL']-$row['HomeOTL']-$row['HomeSOL']) . "</td>";
	echo "<td style=text-align:center>" . $row['SOW']."-". $row['SOL'] . "</td>";	
	echo "<td style=text-align:center>" . ($row['Last10W'] + $row['Last10OTW'] + $row['Last10SOW'])."-".$row['Last10L']."-".($row['Last10OTL']+$row['Last10SOL']) . "</td>";
	echo "<td style=text-align:center>";
	If ($row['Streak'] == W1){echo "<span style=\"color:#00b300;font-weight:bold\">" . ($row['Streak']) ."</span>";}else if ($row['Streak'] == W2){echo "<span style=\"color:#00b300;font-weight:bold\">" . ($row['Streak']) ."</span>";}else if ($row['Streak'] == W3){echo "<span style=\"color:#00b300;font-weight:bold\">" . ($row['Streak']) ."</span>";}else if ($row['Streak'] == W4){echo "<span style=\"color:#00b300;font-weight:bold\">" . ($row['Streak']) ."</span>";}else if ($row['Streak'] == W5){echo "<span style=\"color:#00b300;font-weight:bold\">" . ($row['Streak']) ."</span>";}else if ($row['Streak'] == W6){echo "<span style=\"color:#00b300;font-weight:bold\">" . ($row['Streak']) ."</span>";}else if ($row['Streak'] == W7){echo "<span style=\"color:#00b300;font-weight:bold\">" . ($row['Streak']) ."</span>";}else if ($row['Streak'] == W8){echo "<span style=\"color:#00b300;font-weight:bold\">" . ($row['Streak']) ."</span>";}else if ($row['Streak'] == W9){echo "<span style=\"color:#00b300;font-weight:bold\">" . ($row['Streak']) ."</span>";}else if ($row['Streak'] == W10){echo "<span style=\"color:#00b300;font-weight:bold\">" . ($row['Streak']) ."</span>";}else if ($row['Streak'] == W11){echo "<span style=\"color:#00b300;font-weight:bold\">" . ($row['Streak']) ."</span>";}else if ($row['Streak'] == W12){echo "<span style=\"color:#00b300;font-weight:bold\">" . ($row['Streak']) ."</span>";}else if ($row['Streak'] == W13){echo "<span style=\"color:#00b300;font-weight:bold\">" . ($row['Streak']) ."</span>";}else if ($row['Streak'] == W14){echo "<span style=\"color:#00b300;font-weight:bold\">" . ($row['Streak']) ."</span>";}else if ($row['Streak'] == W15){echo "<span style=\"color:#00b300;font-weight:bold\">" . ($row['Streak']) ."</span>";}else{echo "<span style=\"color:#d60000;font-weight:bold\">" . ($row['Streak']) ."</span>";}

	echo "</td><td style=text-align:center>";
		$dbS = new SQLite3($DatabaseFile);
	$Query = "SELECT count(*) AS count FROM Schedule" . $TypeText . " WHERE (VisitorTeam = " . $row['Number'] . " OR HomeTeam = " . $row['Number'] . ") AND Play = 'True' ORDER BY GameNumber DESC LIMIT 5";
	$Result = $dbS->querySingle($Query,true);
	If ($Result['count'] > 0){
		$Query = "SELECT * FROM Schedule" . $TypeText . " WHERE (VisitorTeam = " . $row['Number'] . " OR HomeTeam = " . $row['Number'] . ") AND Play = 'True' ORDER BY GameNumber DESC LIMIT 4, 4";
		$ScheduleNext = $dbS->querySingle($Query,true);			
		If ($ScheduleNext['HomeTeam'] == $row['Number']){
			if ($ScheduleNext['HomeScore'] > $ScheduleNext['VisitorScore']){
				 echo "<span  title=\"" . "VS " . $ScheduleNext['VisitorTeamAbbre'] . "\"  style=background:#156bac;border-radius:50%;display:inline-block;height:10px;margin-left:4px;margin-right:4px;width:10px;></span>";}
				 			elseif (($ScheduleNext['HomeScore'] < $ScheduleNext['VisitorScore']) AND $ScheduleNext['Overtime'] == "False"){	echo "<span  title=\"" . "VS " . $ScheduleNext['VisitorTeamAbbre'] . "\" style=background:#c8202f;border-radius:50%;display:inline-block;height:10px;margin-left:4px;margin-right:4px;width:10px;></span>";}
				 				elseif ($ScheduleNext['HomeScore'] < $ScheduleNext['VisitorScore'] AND $ScheduleNext['Overtime'] = True){	echo "<span  title=\"" . "VS " . $ScheduleNext['VisitorTeamAbbre'] . "\" style=background:#fff;border-radius:50%;display:inline-block;height:6px;margin-left:4px;margin-right:4px;width:6px;border-width:2px;border-style:solid;border-color:#c8202f></span>";}

		}elseif($ScheduleNext['VisitorTeam'] == $row['Number']){
			if ($ScheduleNext['HomeScore'] < $ScheduleNext['VisitorScore']){
				 echo "<span title=\"" . "@ " . $ScheduleNext['HomeTeamAbbre'] . "\"   style=background:#156bac;border-radius:50%;display:inline-block;height:10px;margin-left:4px;margin-right:4px;width:10px;></span>";}
				 	elseif(($ScheduleNext['HomeScore'] > $ScheduleNext['VisitorScore']) AND $ScheduleNext['Overtime'] == "False"){	echo "<span title=\"" . "@ " . $ScheduleNext['HomeTeamAbbre'] . "\" style=background:#c8202f;border-radius:50%;display:inline-block;height:10px;margin-left:4px;margin-right:4px;width:10px;></span>";}
				 		else{	echo "<span title=\"" . "@ " . $ScheduleNext['HomeTeamAbbre'] . "\" style=background:#fff;border-radius:50%;display:inline-block;height:6px;margin-left:4px;margin-right:4px;width:6px;border-width:2px;border-style:solid;border-color:#c8202f></span>";}
		}
	}else{
		echo "<span></span>";
	}
		$dbS = new SQLite3($DatabaseFile);
	$Query = "SELECT count(*) AS count FROM Schedule" . $TypeText . " WHERE (VisitorTeam = " . $row['Number'] . " OR HomeTeam = " . $row['Number'] . ") AND Play = 'True' ORDER BY GameNumber DESC LIMIT 5";
	$Result = $dbS->querySingle($Query,true);
	If ($Result['count'] > 0){
		$Query = "SELECT * FROM Schedule" . $TypeText . " WHERE (VisitorTeam = " . $row['Number'] . " OR HomeTeam = " . $row['Number'] . ") AND Play = 'True' ORDER BY GameNumber DESC LIMIT 3, 3";
		$ScheduleNext = $dbS->querySingle($Query,true);			
		If ($ScheduleNext['HomeTeam'] == $row['Number']){
			if ($ScheduleNext['HomeScore'] > $ScheduleNext['VisitorScore']){
				 echo "<span  title=\"" . "VS " . $ScheduleNext['VisitorTeamAbbre'] . "\"  style=background:#156bac;border-radius:50%;display:inline-block;height:10px;margin-left:4px;margin-right:4px;width:10px;></span>";}
				 			elseif (($ScheduleNext['HomeScore'] < $ScheduleNext['VisitorScore']) AND $ScheduleNext['Overtime'] == "False"){	echo "<span  title=\"" . "VS " . $ScheduleNext['VisitorTeamAbbre'] . "\" style=background:#c8202f;border-radius:50%;display:inline-block;height:10px;margin-left:4px;margin-right:4px;width:10px;></span>";}
				 				elseif ($ScheduleNext['HomeScore'] < $ScheduleNext['VisitorScore'] AND $ScheduleNext['Overtime'] = True){	echo "<span  title=\"" . "VS " . $ScheduleNext['VisitorTeamAbbre'] . "\" style=background:#fff;border-radius:50%;display:inline-block;height:6px;margin-left:4px;margin-right:4px;width:6px;border-width:2px;border-style:solid;border-color:#c8202f></span>";}

		}elseif($ScheduleNext['VisitorTeam'] == $row['Number']){
			if ($ScheduleNext['HomeScore'] < $ScheduleNext['VisitorScore']){
				 echo "<span title=\"" . "@ " . $ScheduleNext['HomeTeamAbbre'] . "\"  style=background:#156bac;border-radius:50%;display:inline-block;height:10px;margin-left:4px;margin-right:4px;width:10px;></span>";}
				 	elseif(($ScheduleNext['HomeScore'] > $ScheduleNext['VisitorScore']) AND $ScheduleNext['Overtime'] == "False"){	echo "<span title=\"" . "@ " . $ScheduleNext['HomeTeamAbbre'] . "\" style=background:#c8202f;border-radius:50%;display:inline-block;height:10px;margin-left:4px;margin-right:4px;width:10px;></span>";}
				 		else{	echo "<span title=\"" . "@ " . $ScheduleNext['HomeTeamAbbre'] . "\" style=background:#fff;border-radius:50%;display:inline-block;height:6px;margin-left:4px;margin-right:4px;width:6px;border-width:2px;border-style:solid;border-color:#c8202f></span>";}
		}
	}else{
		echo "<span></span>";
	}
		$dbS = new SQLite3($DatabaseFile);
	$Query = "SELECT count(*) AS count FROM Schedule" . $TypeText . " WHERE (VisitorTeam = " . $row['Number'] . " OR HomeTeam = " . $row['Number'] . ") AND Play = 'True' ORDER BY GameNumber DESC LIMIT 5";
	$Result = $dbS->querySingle($Query,true);
	If ($Result['count'] > 0){
		$Query = "SELECT * FROM Schedule" . $TypeText . " WHERE (VisitorTeam = " . $row['Number'] . " OR HomeTeam = " . $row['Number'] . ") AND Play = 'True' ORDER BY GameNumber DESC LIMIT 2, 2";
		$ScheduleNext = $dbS->querySingle($Query,true);			
		If ($ScheduleNext['HomeTeam'] == $row['Number']){
			if ($ScheduleNext['HomeScore'] > $ScheduleNext['VisitorScore']){
				 echo "<span  title=\"" . "VS " . $ScheduleNext['VisitorTeamAbbre'] . "\"  style=background:#156bac;border-radius:50%;display:inline-block;height:10px;margin-left:4px;margin-right:4px;width:10px;></span>";}
				 			elseif (($ScheduleNext['HomeScore'] < $ScheduleNext['VisitorScore']) AND $ScheduleNext['Overtime'] == "False"){	echo "<span  title=\"" . "VS " . $ScheduleNext['VisitorTeamAbbre'] . "\" style=background:#c8202f;border-radius:50%;display:inline-block;height:10px;margin-left:4px;margin-right:4px;width:10px;></span>";}
				 				elseif ($ScheduleNext['HomeScore'] < $ScheduleNext['VisitorScore'] AND $ScheduleNext['Overtime'] = True){	echo "<span  title=\"" . "VS " . $ScheduleNext['VisitorTeamAbbre'] . "\" style=background:#fff;border-radius:50%;display:inline-block;height:6px;margin-left:4px;margin-right:4px;width:6px;border-width:2px;border-style:solid;border-color:#c8202f></span>";}

		}elseif($ScheduleNext['VisitorTeam'] == $row['Number']){
			if ($ScheduleNext['HomeScore'] < $ScheduleNext['VisitorScore']){
				 echo "<span title=\"" . "@ " . $ScheduleNext['HomeTeamAbbre'] . "\"  style=background:#156bac;border-radius:50%;display:inline-block;height:10px;margin-left:4px;margin-right:4px;width:10px;></span>";}
				 	elseif(($ScheduleNext['HomeScore'] > $ScheduleNext['VisitorScore']) AND $ScheduleNext['Overtime'] == "False"){	echo "<span title=\"" . "@ " . $ScheduleNext['HomeTeamAbbre'] . "\" style=background:#c8202f;border-radius:50%;display:inline-block;height:10px;margin-left:4px;margin-right:4px;width:10px;></span>";}
				 		else{	echo "<span title=\"" . "@ " . $ScheduleNext['HomeTeamAbbre'] . "\" style=background:#fff;border-radius:50%;display:inline-block;height:6px;margin-left:4px;margin-right:4px;width:6px;border-width:2px;border-style:solid;border-color:#c8202f></span>";}
		}
	}else{
		echo "<span></span>";
	}
		$dbS = new SQLite3($DatabaseFile);
	$Query = "SELECT count(*) AS count FROM Schedule" . $TypeText . " WHERE (VisitorTeam = " . $row['Number'] . " OR HomeTeam = " . $row['Number'] . ") AND Play = 'True' ORDER BY GameNumber DESC LIMIT 5 ";
	$Result = $dbS->querySingle($Query,true);
	If ($Result['count'] > 0){
		$Query = "SELECT * FROM Schedule" . $TypeText . " WHERE (VisitorTeam = " . $row['Number'] . " OR HomeTeam = " . $row['Number'] . ") AND Play = 'True' ORDER BY GameNumber DESC LIMIT 1, 1";
		$ScheduleNext = $dbS->querySingle($Query,true);			
		If ($ScheduleNext['HomeTeam'] == $row['Number']){
			if ($ScheduleNext['HomeScore'] > $ScheduleNext['VisitorScore']){
				 echo "<span  title=\"" . "VS " . $ScheduleNext['VisitorTeamAbbre'] . "\"  style=background:#156bac;border-radius:50%;display:inline-block;height:10px;margin-left:4px;margin-right:4px;width:10px;></span>";}
				 			elseif (($ScheduleNext['HomeScore'] < $ScheduleNext['VisitorScore']) AND $ScheduleNext['Overtime'] == "False"){	echo "<span  title=\"" . "VS " . $ScheduleNext['VisitorTeamAbbre'] . "\" style=background:#c8202f;border-radius:50%;display:inline-block;height:10px;margin-left:4px;margin-right:4px;width:10px;></span>";}
				 				elseif ($ScheduleNext['HomeScore'] < $ScheduleNext['VisitorScore'] AND $ScheduleNext['Overtime'] = True){	echo "<span  title=\"" . "VS " . $ScheduleNext['VisitorTeamAbbre'] . "\" style=background:#fff;border-radius:50%;display:inline-block;height:6px;margin-left:4px;margin-right:4px;width:6px;border-width:2px;border-style:solid;border-color:#c8202f></span>";}

		}elseif($ScheduleNext['VisitorTeam'] == $row['Number']){
			if ($ScheduleNext['HomeScore'] < $ScheduleNext['VisitorScore']){
				 echo "<span title=\"" . "@ " . $ScheduleNext['HomeTeamAbbre'] . "\"  style=background:#156bac;border-radius:50%;display:inline-block;height:10px;margin-left:4px;margin-right:4px;width:10px;></span>";}
				 	elseif(($ScheduleNext['HomeScore'] > $ScheduleNext['VisitorScore']) AND $ScheduleNext['Overtime'] == "False"){	echo "<span title=\"" . "@ " . $ScheduleNext['HomeTeamAbbre'] . "\" style=background:#c8202f;border-radius:50%;display:inline-block;height:10px;margin-left:4px;margin-right:4px;width:10px;></span>";}
				 		else{	echo "<span title=\"" . "@ " . $ScheduleNext['HomeTeamAbbre'] . "\" style=background:#fff;border-radius:50%;display:inline-block;height:6px;margin-left:4px;margin-right:4px;width:6px;border-width:2px;border-style:solid;border-color:#c8202f></span>";}
		}
	}else{
		echo "<span></span>";
	}
		$dbS = new SQLite3($DatabaseFile);
	$Query = "SELECT count(*) AS count FROM Schedule" . $TypeText . " WHERE (VisitorTeam = " . $row['Number'] . " OR HomeTeam = " . $row['Number'] . ") AND Play = 'True' ORDER BY GameNumber DESC LIMIT 1";
	$Result = $dbS->querySingle($Query,true);
	If ($Result['count'] > 0){
		$Query = "SELECT * FROM Schedule" . $TypeText . " WHERE (VisitorTeam = " . $row['Number'] . " OR HomeTeam = " . $row['Number'] . ") AND Play = 'True' ORDER BY GameNumber DESC LIMIT 1";
		$ScheduleNext = $dbS->querySingle($Query,true);			
		If ($ScheduleNext['HomeTeam'] == $row['Number']){
			if ($ScheduleNext['HomeScore'] > $ScheduleNext['VisitorScore']){
				 echo "<span  title=\"" . "VS " . $ScheduleNext['VisitorTeamAbbre'] . "\"  style=background:#156bac;border-radius:50%;display:inline-block;height:10px;margin-left:4px;margin-right:4px;width:10px;></span>";}
				 			elseif (($ScheduleNext['HomeScore'] < $ScheduleNext['VisitorScore']) AND $ScheduleNext['Overtime'] == "False"){	echo "<span  title=\"" . "VS " . $ScheduleNext['VisitorTeamAbbre'] . "\" style=background:#c8202f;border-radius:50%;display:inline-block;height:10px;margin-left:4px;margin-right:4px;width:10px;></span>";}
				 				elseif ($ScheduleNext['HomeScore'] < $ScheduleNext['VisitorScore'] AND $ScheduleNext['Overtime'] = True){	echo "<span  title=\"" . "VS " . $ScheduleNext['VisitorTeamAbbre'] . "\" style=background:#fff;border-radius:50%;display:inline-block;height:6px;margin-left:4px;margin-right:4px;width:6px;border-width:2px;border-style:solid;border-color:#c8202f></span>";}

		}elseif($ScheduleNext['VisitorTeam'] == $row['Number']){
			if ($ScheduleNext['HomeScore'] < $ScheduleNext['VisitorScore']){
				 echo "<span title=\"" . "@ " . $ScheduleNext['HomeTeamAbbre'] . "\"  style=background:#156bac;border-radius:50%;display:inline-block;height:10px;margin-left:4px;margin-right:4px;width:10px;></span>";}
				 	elseif(($ScheduleNext['HomeScore'] > $ScheduleNext['VisitorScore']) AND $ScheduleNext['Overtime'] == "False"){	echo "<span title=\"" . "@ " . $ScheduleNext['HomeTeamAbbre'] . "\" style=background:#c8202f;border-radius:50%;display:inline-block;height:10px;margin-left:4px;margin-right:4px;width:10px;></span>";}
				 		else{	echo "<span title=\"" . "@ " . $ScheduleNext['HomeTeamAbbre'] . "\" style=background:#fff;border-radius:50%;display:inline-block;height:6px;margin-left:4px;margin-right:4px;width:6px;border-width:2px;border-style:solid;border-color:#c8202f></span>";}
		}
	}else{
		echo "<span></span>";
	}

	$dbS = new SQLite3($DatabaseFile);
	$Query = "SELECT count(*) AS count FROM Schedule" . $TypeText . " WHERE (VisitorTeam = " . $row['Number'] . " OR HomeTeam = " . $row['Number'] . ") AND Play = 'False' ORDER BY GameNumber LIMIT 1";
	$Result = $dbS->querySingle($Query,true);
	If ($Result['count'] > 0){
		$Query = "SELECT * FROM Schedule" . $TypeText . " WHERE (VisitorTeam = " . $row['Number'] . " OR HomeTeam = " . $row['Number'] . ") AND Play = 'False' ORDER BY GameNumber LIMIT 1";
		$ScheduleNext = $dbS->querySingle($Query,true);			
		If ($ScheduleNext['HomeTeam'] == $row['Number']){
			echo "<td style=text-align:center><span><img src=\"/images/LogoTeams/" . $TypeText . "/" . $ScheduleNext['VisitorTeam'] . "." . svg  . "\" title=\"" . "VS " . $ScheduleNext['VisitorTeamAbbre'] . "\" style=width:32px;height:32px;padding-left:8px;vertical-align:middle></span></td>";
		}elseif($ScheduleNext['VisitorTeam'] == $row['Number']){
			echo "<td style=text-align:center><span><img src=\"/images/LogoTeams/" . $TypeText . "/" . $ScheduleNext['HomeTeam'] . "." . svg  . "\" title=\"" . "@ " . $ScheduleNext['HomeTeamAbbre'] . "\" style=width:32px;height:32px;padding-left:8px;vertical-align:middle></span></td>";
		}
	}else{
		echo "<td></td>";
	}
	echo "</tr>\n"; /* The \n is for a new line in the HTML Code */
}

?>

<style>
@media screen and (max-width: 1060px) {
.STHSWarning {display:none;}
.STHSPHPStanding_Table thead th:nth-last-child(1){display:none;}
.STHSPHPStanding_Table tbody td:nth-last-child(1){display:none;}
.STHSPHPStanding_Table thead th:nth-last-child(3){display:none;}
.STHSPHPStanding_Table tbody td:nth-last-child(3){display:none;}
.STHSPHPStanding_Table thead th:nth-last-child(4){display:none;}
.STHSPHPStanding_Table tbody td:nth-last-child(4){display:none;}
.STHSPHPStanding_Table thead th:nth-last-child(5){display:none;}
.STHSPHPStanding_Table tbody td:nth-last-child(5){display:none;}
}@media screen and (max-width: 890px) {
.STHSPHPStanding_Table thead th:nth-last-child(2){display:none;}
.STHSPHPStanding_Table tbody td:nth-last-child(2){display:none;}
.STHSPHPStanding_Table thead th:nth-last-child(6){display:none;}
.STHSPHPStanding_Table tbody td:nth-last-child(6){display:none;}
}
.STHSPHPStanding_Table tbody td.staticTD {font-size:9pt;border-right:hidden; border-left:hidden;}

<?php 
if ($Playoff == True){
	echo "#tabmain1{display:none;}\n";
	echo "#tabmain2{display:none;}\n";
	echo "#tabmain3{display:none;}\n";
	echo "#tabmain4{display:none;}\n";
}else{
	echo "#tabmain5{display:none;}\n";
	echo "#tabmain6{display:none;}\n";
}?>
</style>
<link rel="icon" type="image/png" href="/images/LHGMQ.png" /> 

</head><body style="background-position:center;background-repeat:no-repeat;background-attachment:fixed;background-color: #eeeeee;">
<?php include "Menu.php";
If (file_exists($DatabaseFile) == false){echo "<br /><br /><h1 class=\"STHSCenter\">" . $DatabaseNotFound . "</h1>";}
?>
<div id="web" style="width:100%;max-width:800px;text-align:center;margin-top:15px;margin:auto"><amp-auto-ads type="adsense"
              data-ad-client="ca-pub-5168254807958021">
</amp-auto-ads>
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- Haut -->
<ins class="adsbygoogle"
     style="display:inline-block;width:728px;height:90px;margin-top:15px"
     data-ad-client="ca-pub-5168254807958021"
     data-ad-slot="4225758386"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
</div>

<?php
	$Query = "Select Name, PointSystemW," . $TypeText . "ConferenceName1 AS ConferenceName1," . $TypeText . "ConferenceName2 AS ConferenceName2," . $TypeText . "DivisionName1 AS DivisionName1," . $TypeText . "DivisionName2 AS DivisionName2," . $TypeText . "DivisionName3 AS DivisionName3," . $TypeText . "DivisionName4 AS DivisionName4," . $TypeText . "DivisionName5 AS DivisionName5," . $TypeText . "DivisionName6 AS DivisionName6," . $TypeText . "HowManyPlayOffTeam AS HowManyPlayOffTeam," . $TypeText . "DivisionNewNHLPlayoff  AS DivisionNewNHLPlayoff,PlayOffWinner" . $TypeText . " AS PlayOffWinner, PlayOffStarted,ScheduleNextDay, PlayOffRound from LeagueGeneral";
	$LeagueGeneral = $db->querySingle($Query,true);		
?>
<div style="width:100%;margin:auto;margin-top:20px;border-radius: 10px;background-color:white;max-width:1284px;box-shadow:0 2px 3px rgba(0,0,0,.1)">

<h1 style="text-align: left;margin-left:0px;margin-right:0px;padding-top:32px;padding-left:20px;padding-bottom:32px;border-bottom:1px solid grey;    font-size: 32px;font-weight:bold;   color:#2b2c2d;font-size:16px">Standings</h1>
<div class="STHSWarning"><?php echo $WarningResolution;?><br /></div>
<div style="overflow:hidden;width:100%;margin:auto;">
<div class="tabsmain standard" style="width:100%;margin-left:0%;background-color:white;padding-left:0px">
<ul class="tabmain-links" style="text-align:center;font-size:14px;padding-left:0px;margin-bottom:0px">
<?php
if ($LeagueGeneral['PlayOffStarted'] == "True"){
	echo "<li style=padding:0px;font-size:14px;text-align:center;line-height:38px;padding-left:0px;padding-right:0px><a class=\"activemain\" href=\"#tabmain5\" class=\"border3_32\" style=padding:0px;margin:12px;text-transform:uppercase>" ."Stanley Cup ". $StandingLang['Playoff'] . "</a></li>";
	echo "<li style=padding:0px;font-size:14px;text-align:center;line-height:38px;padding-left:0px;padding-right:0px><a class=\"activemain\" href=\"#tabmain6\" class=\"border3_32\" style=padding:0px;margin:12px;text-transform:uppercase>" ."Calder Cup ". $StandingLang['Playoff'] . "</a></li>";
}else{
	If ($LeagueGeneral['DivisionNewNHLPlayoff'] == "True"){
		echo "<li style=padding:0px;font-size:14px;text-align:center;line-height:38px;padding-left:0px;padding-right:0px\"><a href=\"#tabmain1\" class=\"border3_32\" style=padding:0px;margin:12px;text-transform:uppercase>" . $StandingLang['Wildcard'] . "</a></li>";
		echo "<li style=padding:0px;font-size:14px;text-align:center;line-height:38px;padding-left:0px;padding-right:0px><a href=\"#tabmain2\" class=\"border3_32\" style=padding:0px;margin:12px;text-transform:uppercase>" . "Division" . "</a></li>";
	}else{
		echo "<li style=padding:0px;font-size:14px;text-align:center;line-height:38px;padding-left:0px;padding-right:0px class=\"activemain\"><a href=\"#tabmain2\" class=\"border3_32\" style=padding:0px;margin:12px;text-transform:uppercase>" . "Division" . "</a></li>";
	}
	echo "<li style=padding:0px;font-size:14px;text-align:center;line-height:38px;padding-left:0px;padding-right:0px><a href=\"#tabmain3\" class=\"border3_32\" style=padding:0px;margin:12px;text-transform:uppercase>" . $StandingLang['Overall'] . "</a></li>";
	echo "<li style=padding:0px;font-size:14px;text-align:center;line-height:38px;padding-left:0px;padding-right:0px><a href=\"#tabmain4\" class=\"border3_32\" style=padding:0px;margin:12px;text-transform:uppercase>" . "Power Ranking" . "</a></li>";
	If ($TypeText == "Pro"){
	echo "<li style=padding:0px;font-size:14px;text-align:center;line-height:38px;padding-left:0px;padding-right:0px><a href=\"#tabmain5\" class=\"border3_32\" style=padding:0px;margin:12px;text-transform:uppercase>" ."Stanley Cup ". "Playoffs" . "</a></li>";
	}else{
	echo "<li style=padding:0px;font-size:14px;text-align:center;line-height:38px;padding-left:0px;padding-right:0px><a href=\"#tabmain6\" class=\"border3_32\" style=padding:0px;margin:12px;text-transform:uppercase>" ."Calder Cup ". "Playoffs" . "</a></li>";
	}

}
?>

</ul><div class="tabmain-content" style="background-color:white;padding-left:0px">
<div class="tabmain active" id="tabmain1" style="padding:0px">

<?php
If ($DatabaseFound == True){
	echo "<h4 style=background-position:right;background-repeat:no-repeat;font-weight:bold;color:#2b2c2d;font-size:16px;text-transform:uppercase;margin-bottom:0px><span><img src=\"/images/" . $LeagueGeneral['ConferenceName1'] . "." . png . "\" alt=\"" . $TeamName . "\" style=width:50px;vertical-align:middle;padding-right:12px></span>" . $LeagueGeneral['ConferenceName1'] . "</h4><span style=float:right;display:inline-block;font-size:12px;margin-right:12px;color:#8a9299>OT Loss</span><span style=background:transparent;border-radius:50%;display:inline-block;height:6px;margin-left:4px;margin-right:4px;width:6px;float:right;border-width:2px;border-style:solid;border-color:#c8202f></span><span style=float:right;display:inline-block;font-size:12px;color:#8a9299>Loss</span><span style=background:#c8202f;border-radius:50%;display:inline-block;height:10px;margin-left:4px;margin-right:4px;width:10px;float:right></span><span style=float:right;display:inline-block;font-size:12px;color:#8a9299>Win</span><span style=background:#156bac;border-radius:50%;display:inline-block;height:10px;margin-left:4px;margin-right:4px;width:10px;float:right></span>";
echo "<table class=\"tablesorter STHSPHPStanding_Table\" style=padding:20px;background-color:white;border-collapse:collapse>";

	/* Division 1 */
echo "<thead><tr>";
echo "<th  colspan=\"2\" data-priority=\"1\"style=font-weight:bold;border-width:0px;background-color:#C51031;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase title=\"Team Name\" class=\"STHSW200\">" .$LeagueGeneral['DivisionName1'] ."</th>";
echo "<th data-priority=\"1\"style=text-align:center;font-weight:bold;border-width:0px;background-color:#C51031;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase title=\"Games Played\" class=\"STHSW30\"  style=text-align:center>GP</th>";
echo "<th  data-priority=\"1\"style=text-align:center;font-weight:bold;border-width:0px;background-color:#C51031;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase title=\"Wins\" class=\"STHSW30\">W</th>";
echo "<th  data-priority=\"1\"style=text-align:center;font-weight:bold;border-width:0px;background-color:#C51031;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase title=\"Loss\" class=\"STHSW30\">L</th>";
echo "<th  data-priority=\"1\"style=text-align:center;font-weight:bold;border-width:0px;background-color:#C51031;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase title=\"Overtime Loss\" class=\"STHSW30\">OTL</th>";
echo "<th  data-priority=\"1\"style=text-align:center;font-weight:bold;border-width:0px;background-color:#C51031;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase title=\"Points\" class=\"STHSW30\">PTS</th>";
echo "<th  style=text-align:center;font-weight:bold;border-width:0px;background-color:#C51031;color:#fff;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase;text-transform:uppercase data-priority=\"1\"title=\"Normal Wins\" class=\"STHSW30\">RW</th>";
echo "<th   data-priority=\"1\"style=text-align:center;font-weight:bold;border-width:0px;background-color:#C51031;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase title=\"Normal Wins + Overtime Win\" class=\"STHSW30\">ROW</th>";
echo "<th  data-priority=\"1\"style=text-align:center;font-weight:bold;border-width:0px;background-color:#C51031;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase title=\"Goals For\" class=\"STHSW30\">GF</th>";
echo "<th data-priority=\"1\"style=text-align:center;font-weight:bold;border-width:0px;background-color:#C51031;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase title=\"Goals Against\" class=\"STHSW30\">GA</th>";
echo "<th data-priority=\"1\" style=text-align:center;font-weight:bold;border-width:0px;background-color:#C51031;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase title=\"Goals For Diffirencial against Goals Against\" class=\"STHSW30\">Diff</th>";
echo "<th   data-priority=\"5\" style=text-align:center;font-weight:bold;border-width:0px;background-color:#C51031;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase title=\"Home Only\" class=\"STHSW75\">" . $TeamStatLang['Home'] ."</th>";
echo "<th   data-priority=\"5\"style=text-align:center;font-weight:bold;border-width:0px;background-color:#C51031;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase title=\"Visitor Only\" class=\"STHSW75\">" . $TeamStatLang['Visitor'] ."</th>";
echo "<th data-priority=\"5\"style=text-align:center;font-weight:bold;border-width:0px;background-color:#C51031;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase title=\"Shootout Record\" class=\"STHSW30\">" . "S/O" ."</th>";
echo "<th data-priority=\"5\" style=text-align:center;font-weight:bold;border-width:0px;background-color:#C51031;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase title=\"Last 10 Game\" class=\"STHSW75\">" . $TeamStatLang['Last10'] ."</th>";
echo "<th data-priority=\"5\" style=text-align:center;font-weight:bold;border-width:0px;background-color:#C51031;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase title=\"Streak\" class=\"STHSW30\">STK</th>";
echo "<th data-priority=\"5\"  style=text-align:center;font-weight:bold;border-width:0px;background-color:#C51031;color:#fff;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase;text-transform:uppercase data-priority=\"critical\"title=\"Last 5\" class=\"STHSW75\">Last 5</th>";
echo "<th data-priority=\"1\" style=text-align:center;font-weight:bold;border-width:0px;background-color:#C51031;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase data-priority=\"critical\" title=\"Next Opponent\" class=\"STHSW30\">Next</th>";
echo "</tr></thead>	";
	$Query = " SELECT Team" . $TypeTextTeam . "Stat.*, Team" . $TypeText . "Info.Conference, Team" . $TypeText . "Info.City, Team" . $TypeText . "Info.Division, RankingOrder.Type FROM (Team" . $TypeTextTeam . "Stat INNER JOIN Team" . $TypeText . "Info ON Team" . $TypeTextTeam . "Stat.Number = Team" . $TypeText . "Info.Number) INNER JOIN RankingOrder ON Team" . $TypeTextTeam . "Stat.Number = RankingOrder.Team" . $TypeText . "Number WHERE (((Team" . $TypeText . "Info.Division)=\"" . $LeagueGeneral['DivisionName1'] . "\") AND ((RankingOrder.Type)=0)) ORDER BY RankingOrder.TeamOrder LIMIT 3";
	$Standing = $db->query($Query);
	$LoopCount =0;
	if (empty($Standing) == false){while ($row = $Standing ->fetchArray()) {
		$LoopCount +=1;
		PrintStandingTableRow($row, $TypeText, $LeagueGeneral['PointSystemW'], $LoopCount,$DatabaseFile);
	}}
		
	/* Division 2 */	
echo "<thead><tr>";
echo "<th  colspan=\"2\" data-priority=\"1\" style=font-weight:bold;border-width:0px;background-color:#C51031;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase title=\"Team Name\" class=\"STHSW200\">" . $LeagueGeneral['DivisionName2'] ."</th>";
echo "<th data-priority=\"1\"style=text-align:center;font-weight:bold;border-width:0px;background-color:#C51031;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase title=\"Games Played\" class=\"STHSW30\"  style=text-align:center>GP</th>";
echo "<th  data-priority=\"1\"style=text-align:center;font-weight:bold;border-width:0px;background-color:#C51031;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase title=\"Wins\" class=\"STHSW30\">W</th>";
echo "<th  data-priority=\"1\"style=text-align:center;font-weight:bold;border-width:0px;background-color:#C51031;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase title=\"Loss\" class=\"STHSW30\">L</th>";
echo "<th data-priority=\"1\" style=text-align:center;font-weight:bold;border-width:0px;background-color:#C51031;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase title=\"Overtime Loss\" class=\"STHSW30\">OTL</th>";
echo "<th data-priority=\"1\" style=text-align:center;font-weight:bold;border-width:0px;background-color:#C51031;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase title=\"Points\" class=\"STHSW30\">PTS</th>";
echo "<th  style=text-align:center;font-weight:bold;border-width:0px;background-color:#C51031;color:#fff;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase;text-transform:uppercase data-priority=\"1\"title=\"Normal Wins\" class=\"STHSW30\">RW</th>";
echo "<th  data-priority=\"1\" style=text-align:center;font-weight:bold;border-width:0px;background-color:#C51031;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase title=\"Normal Wins + Overtime Win\" class=\"STHSW30\">ROW</th>";
echo "<th  data-priority=\"1\" style=text-align:center;font-weight:bold;border-width:0px;background-color:#C51031;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase title=\"Goals For\" class=\"STHSW30\">GF</th>";
echo "<th data-priority=\"1\" style=text-align:center;font-weight:bold;border-width:0px;background-color:#C51031;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase title=\"Goals Against\" class=\"STHSW30\">GA</th>";
echo "<th  data-priority=\"1\" style=text-align:center;font-weight:bold;border-width:0px;background-color:#C51031;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase title=\"Goals For Diffirencial against Goals Against\" class=\"STHSW30\">Diff</th>";
echo "<th  data-priority=\"2\" style=text-align:center;font-weight:bold;border-width:0px;background-color:#C51031;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase title=\"Home Only\" class=\"STHSW75\">" . $TeamStatLang['Home'] ."</th>";
echo "<th  data-priority=\"1\"style=text-align:center;font-weight:bold;border-width:0px;background-color:#C51031;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase title=\"Visitor Only\" class=\"STHSW75\">" . $TeamStatLang['Visitor'] ."</th>";
echo "<th data-priority=\"1\" style=text-align:center;font-weight:bold;border-width:0px;background-color:#C51031;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase title=\"Shootout Record\" class=\"STHSW30\">" . "S/O" ."</th>";
echo "<th  data-priority=\"1\" style=text-align:center;font-weight:bold;border-width:0px;background-color:#C51031;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase title=\"Last 10 Game\" class=\"STHSW75\">" . $TeamStatLang['Last10'] ."</th>";
echo "<th  data-priority=\"1\" style=text-align:center;font-weight:bold;border-width:0px;background-color:#C51031;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase title=\"Streak\" class=\"STHSW30\">STK</th>";
echo "<th  data-priority=\"1\" style=text-align:center;font-weight:bold;border-width:0px;background-color:#C51031;color:#fff;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase;text-transform:uppercase data-priority=\"1\" title=\"Last 5\" class=\"STHSW75\">Last 5</th>";
echo "<th data-priority=\"1\" style=text-align:center;font-weight:bold;border-width:0px;background-color:#C51031;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase data-priority=\"1\" title=\"Next Opponent\" class=\"STHSW30\">Next</th>";echo "</tr></thead>	";
	$Query = " SELECT Team" . $TypeTextTeam . "Stat.*, Team" . $TypeText . "Info.Conference, Team" . $TypeText . "Info.City, Team" . $TypeText . "Info.Division, RankingOrder.Type FROM (Team" . $TypeTextTeam . "Stat INNER JOIN Team" . $TypeText . "Info ON Team" . $TypeTextTeam . "Stat.Number = Team" . $TypeText . "Info.Number) INNER JOIN RankingOrder ON Team" . $TypeTextTeam . "Stat.Number = RankingOrder.Team" . $TypeText . "Number WHERE (((Team" . $TypeText . "Info.Division)=\"" . $LeagueGeneral['DivisionName2'] . "\") AND ((RankingOrder.Type)=0)) ORDER BY RankingOrder.TeamOrder LIMIT 3";
	$Standing = $db->query($Query);
	$LoopCount =0;
	if (empty($Standing) == false){while ($row = $Standing ->fetchArray()) {
		$LoopCount +=1;
		PrintStandingTableRow($row, $TypeText, $LeagueGeneral['PointSystemW'], $LoopCount,$DatabaseFile);
	}}

	/* Overall for Conference 1 */	
echo "<thead><tr>";
echo "<th  colspan=\"2\" style=font-weight:bold;border-width:0px;background-color:#C51031;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase title=\"Team Name\" class=\"STHSW200\">" . $StandingLang['Wildcard'] ."</th>";
echo "<th style=text-align:center;font-weight:bold;border-width:0px;background-color:#C51031;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase title=\"Games Played\" class=\"STHSW30\"  style=text-align:center>GP</th>";
echo "<th  style=text-align:center;font-weight:bold;border-width:0px;background-color:#C51031;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase title=\"Wins\" class=\"STHSW30\">W</th>";
echo "<th  style=text-align:center;font-weight:bold;border-width:0px;background-color:#C51031;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase title=\"Loss\" class=\"STHSW30\">L</th>";
echo "<th  style=text-align:center;font-weight:bold;border-width:0px;background-color:#C51031;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase title=\"Overtime Loss\" class=\"STHSW30\">OTL</th>";
echo "<th  style=text-align:center;font-weight:bold;border-width:0px;background-color:#C51031;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase title=\"Points\" class=\"STHSW30\">PTS</th>";
echo "<th  style=text-align:center;font-weight:bold;border-width:0px;background-color:#C51031;color:#fff;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase;text-transform:uppercase data-priority=\"1\"title=\"Normal Wins\" class=\"STHSW30\">RW</th>";

echo "<th   style=text-align:center;font-weight:bold;border-width:0px;background-color:#C51031;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase title=\"Normal Wins + Overtime Win\" class=\"STHSW30\">ROW</th>";
echo "<th  style=text-align:center;font-weight:bold;border-width:0px;background-color:#C51031;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase title=\"Goals For\" class=\"STHSW30\">GF</th>";
echo "<th   style=text-align:center;font-weight:bold;border-width:0px;background-color:#C51031;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase title=\"Goals Against\" class=\"STHSW30\">GA</th>";
echo "<th  style=text-align:center;font-weight:bold;border-width:0px;background-color:#C51031;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase title=\"Goals For Diffirencial against Goals Against\" class=\"STHSW30\">Diff</th>";
echo "<th   style=text-align:center;font-weight:bold;border-width:0px;background-color:#C51031;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase title=\"Home Only\" class=\"STHSW75\">" . $TeamStatLang['Home'] ."</th>";
echo "<th  style=text-align:center;font-weight:bold;border-width:0px;background-color:#C51031;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase title=\"Visitor Only\" class=\"STHSW75\">" . $TeamStatLang['Visitor'] ."</th>";
echo "<th data-priority=\"1\"style=text-align:center;font-weight:bold;border-width:0px;background-color:#C51031;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase title=\"Shootout Record\" class=\"STHSW30\">" . "S/O" ."</th>";
echo "<th  style=text-align:center;font-weight:bold;border-width:0px;background-color:#C51031;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase title=\"Last 10 Game\" class=\"STHSW75\">" . $TeamStatLang['Last10'] ."</th>";
echo "<th  data-priority=\"1\" style=text-align:center;font-weight:bold;border-width:0px;background-color:#C51031;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase title=\"Streak\" class=\"STHSW30\">STK</th>";
echo "<th  data-priority=\"1\" style=text-align:center;font-weight:bold;border-width:0px;background-color:#C51031;color:#fff;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase;text-transform:uppercase data-priority=\"1\" title=\"Last 5\" class=\"STHSW75\">Last 5</th>";
echo "<th data-priority=\"1\" style=text-align:center;font-weight:bold;border-width:0px;background-color:#C51031;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase  data-priority=\"1\" title=\"Next Opponent\" class=\"STHSW30\">Next</th>";echo "</tr></thead>";
	$Query = " SELECT Team" . $TypeTextTeam . "Stat.*, Team" . $TypeText . "Info.Conference, Team" . $TypeText . "Info.City, Team" . $TypeText . "Info.Division, RankingOrder.Type FROM (Team" . $TypeTextTeam . "Stat INNER JOIN Team" . $TypeText . "Info ON Team" . $TypeTextTeam . "Stat.Number = Team" . $TypeText . "Info.Number) INNER JOIN RankingOrder ON Team" . $TypeTextTeam . "Stat.Number = RankingOrder.Team" . $TypeText . "Number WHERE (((Team" . $TypeText . "Info.Conference)=\"" . $LeagueGeneral['ConferenceName1'] . "\") AND ((RankingOrder.Type)=1)) ORDER BY RankingOrder.TeamOrder";
	$Standing = $db->query($Query);
	$LoopCount =0;
	if (empty($Standing) == false){while ($row = $Standing ->fetchArray()) {
		$LoopCount +=1;
		If ($LoopCount > 6 ){PrintStandingTableRow($row, $TypeText, $LeagueGeneral['PointSystemW'], $LoopCount,$DatabaseFile);}
		If ($LoopCount == 8){echo "<tr class=\"static\"  style=\"background-color:#cb1c29;height:4px;font-family:Rajdhani,Oswald,Barlow,Khand,sans-serif;color:white;\"><td style=padding:1px class=\"staticTD\" colspan=\"19\"></td></tr><tr></tr>";}
	}}

	echo "</tbody></table>";	


	echo "<h4 style=background-position:right;background-repeat:no-repeat;font-weight:bold;color:#2b2c2d;font-size:16px;text-transform:uppercase;margin-bottom:0px><span><img src=\"/images/" . $LeagueGeneral['ConferenceName2'] . "." . png . "\" alt=\"" . $TeamName . "\" style=width:50px;vertical-align:middle;padding-right:12px></span>" . $LeagueGeneral['ConferenceName2'] . "</h4>";
echo "<table class=\"tablesorter STHSPHPStanding_Table\" style=padding:20px;background-color:white;border-collapse:collapse><tr></tr>";

	/* Division 4 */
echo "<th  colspan=\"2\" data-priority=\"1\"  style=font-weight:bold;border-width:0px;background-color:#0d243c;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase title=\"Team Name\" class=\"STHSW200\">" .$LeagueGeneral['DivisionName4'] ."</th>";
echo "<th data-priority=\"1\"  style=text-align:center;font-weight:bold;border-width:0px;background-color:#0d243c;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase title=\"Games Played\" class=\"STHSW30\"  style=text-align:center>GP</th>";
echo "<th data-priority=\"1\"   style=text-align:center;font-weight:bold;border-width:0px;background-color:#0d243c;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase title=\"Wins\" class=\"STHSW30\">W</th>";
echo "<th  data-priority=\"1\"  style=text-align:center;font-weight:bold;border-width:0px;background-color:#0d243c;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase title=\"Loss\" class=\"STHSW30\">L</th>";
echo "<th data-priority=\"1\"   style=text-align:center;font-weight:bold;border-width:0px;background-color:#0d243c;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase title=\"Overtime Loss\" class=\"STHSW30\">OTL</th>";
echo "<th data-priority=\"1\"   style=text-align:center;font-weight:bold;border-width:0px;background-color:#0d243c;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase title=\"Points\" class=\"STHSW30\">PTS</th>";
echo "<th  style=text-align:center;font-weight:bold;border-width:0px;background-color:#0d243c;color:#fff;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase;text-transform:uppercase data-priority=\"1\"title=\"Normal Wins\" class=\"STHSW30\">RW</th>";

echo "<th data-priority=\"1\"   style=text-align:center;font-weight:bold;border-width:0px;background-color:#0d243c;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase title=\"Normal Wins + Overtime Win\" class=\"STHSW30\">ROW</th>";
echo "<th data-priority=\"1\"   style=text-align:center;font-weight:bold;border-width:0px;background-color:#0d243c;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase title=\"Goals For\" class=\"STHSW30\">GF</th>";
echo "<th data-priority=\"1\"   style=text-align:center;font-weight:bold;border-width:0px;background-color:#0d243c;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase title=\"Goals Against\" class=\"STHSW30\">GA</th>";
echo "<th data-priority=\"1\"   style=text-align:center;font-weight:bold;border-width:0px;background-color:#0d243c;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase title=\"Goals For Diffirencial against Goals Against\" class=\"STHSW30\">Diff</th>";
echo "<th  data-priority=\"6\"   style=text-align:center;font-weight:bold;border-width:0px;background-color:#0d243c;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase title=\"Home Only\" class=\"STHSW75\">" . $TeamStatLang['Home'] ."</th>";
echo "<th  id=browser data-priority=\"6\"  style=text-align:center;font-weight:bold;border-width:0px;background-color:#0d243c;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase title=\"Visitor Only\" class=\"STHSW75\">" . $TeamStatLang['Visitor'] ."</th>";
echo "<th  id=browser  data-priority=\"6\" style=text-align:center;font-weight:bold;border-width:0px;background-color:#0d243c;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase title=\"Shootout Record\" class=\"STHSW30\">" . "S/O" ."</th>";
echo "<th  id=browser  data-priority=\"6\"   style=text-align:center;font-weight:bold;border-width:0px;background-color:#0d243c;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase title=\"Last 10 Game\" class=\"STHSW75\">" . $TeamStatLang['Last10'] ."</th>";
echo "<th  id=browser  data-priority=\"6\"   style=text-align:center;font-weight:bold;border-width:0px;background-color:#0d243c;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase title=\"Streak\" class=\"STHSW30\">STK</th>";
echo "<th  id=browser   style=text-align:center;font-weight:bold;border-width:0px;background-color:#0d243c;color:#fff;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase;text-transform:uppercase data-priority=\"critical\"title=\"Last 5\" class=\"STHSW75\">Last 5</th>";
echo "<th  id=browser  data-priority=\"1\" style=text-align:center;font-weight:bold;border-width:0px;background-color:#0d243c;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase  data-priority=\"critical\" title=\"Next Opponent\" class=\"STHSW30\">Next</th>";echo "</tr></thead>	";
	$Query = " SELECT Team" . $TypeTextTeam . "Stat.*, Team" . $TypeText . "Info.Conference, Team" . $TypeText . "Info.City, Team" . $TypeText . "Info.Division, RankingOrder.Type FROM (Team" . $TypeTextTeam . "Stat INNER JOIN Team" . $TypeText . "Info ON Team" . $TypeTextTeam . "Stat.Number = Team" . $TypeText . "Info.Number) INNER JOIN RankingOrder ON Team" . $TypeTextTeam . "Stat.Number = RankingOrder.Team" . $TypeText . "Number WHERE (((Team" . $TypeText . "Info.Division)=\"" . $LeagueGeneral['DivisionName4'] . "\") AND ((RankingOrder.Type)=0)) ORDER BY RankingOrder.TeamOrder LIMIT 3";
	$Standing = $db->query($Query);
	$LoopCount =0;
	if (empty($Standing) == false){while ($row = $Standing ->fetchArray()) {
		$LoopCount +=1;
		PrintStandingTableRow($row, $TypeText, $LeagueGeneral['PointSystemW'], $LoopCount,$DatabaseFile);
	}}
		
	/* Division 5 */	
echo "<th  colspan=\"2\" data-priority=\"1\"  style=font-weight:bold;border-width:0px;background-color:#0d243c;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase title=\"Team Name\" class=\"STHSW200\">" .$LeagueGeneral['DivisionName5'] ."</th>";
echo "<th data-priority=\"1\"  style=text-align:center;font-weight:bold;border-width:0px;background-color:#0d243c;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase title=\"Games Played\" class=\"STHSW30\"  style=text-align:center>GP</th>";
echo "<th data-priority=\"1\"   style=text-align:center;font-weight:bold;border-width:0px;background-color:#0d243c;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase title=\"Wins\" class=\"STHSW30\">W</th>";
echo "<th data-priority=\"1\"   style=text-align:center;font-weight:bold;border-width:0px;background-color:#0d243c;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase title=\"Loss\" class=\"STHSW30\">L</th>";
echo "<th data-priority=\"1\"   style=text-align:center;font-weight:bold;border-width:0px;background-color:#0d243c;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase title=\"Overtime Loss\" class=\"STHSW30\">OTL</th>";
echo "<th data-priority=\"1\"   style=text-align:center;font-weight:bold;border-width:0px;background-color:#0d243c;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase title=\"Points\" class=\"STHSW30\">PTS</th>";
echo "<th  style=text-align:center;font-weight:bold;border-width:0px;background-color:#0d243c;color:#fff;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase;text-transform:uppercase data-priority=\"1\"title=\"Normal Wins\" class=\"STHSW30\">RW</th>";

echo "<th  data-priority=\"1\"   style=text-align:center;font-weight:bold;border-width:0px;background-color:#0d243c;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase title=\"Normal Wins + Overtime Win\" class=\"STHSW30\">ROW</th>";
echo "<th  data-priority=\"1\"   style=text-align:center;font-weight:bold;border-width:0px;background-color:#0d243c;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase title=\"Goals For\" class=\"STHSW30\">GF</th>";
echo "<th  data-priority=\"1\"   style=text-align:center;font-weight:bold;border-width:0px;background-color:#0d243c;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase title=\"Goals Against\" class=\"STHSW30\">GA</th>";
echo "<th data-priority=\"1\"   style=text-align:center;font-weight:bold;border-width:0px;background-color:#0d243c;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase title=\"Goals For Diffirencial against Goals Against\" class=\"STHSW30\">Diff</th>";
echo "<th data-priority=\"1\"   style=text-align:center;font-weight:bold;border-width:0px;background-color:#0d243c;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase title=\"Home Only\" class=\"STHSW75\">" . $TeamStatLang['Home'] ."</th>";
echo "<th  id=browser   data-priority=\"1\"  style=text-align:center;font-weight:bold;border-width:0px;background-color:#0d243c;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase title=\"Visitor Only\" class=\"STHSW75\">" . $TeamStatLang['Visitor'] ."</th>";
echo "<th  id=browser   data-priority=\"1\"  style=text-align:center;font-weight:bold;border-width:0px;background-color:#0d243c;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase title=\"Shootout Record\" class=\"STHSW30\">" . "S/O" ."</th>";
echo "<th  id=browser   data-priority=\"1\"   style=text-align:center;font-weight:bold;border-width:0px;background-color:#0d243c;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase title=\"Last 10 Game\" class=\"STHSW75\">" . $TeamStatLang['Last10'] ."</th>";
echo "<th  id=browser  data-priority=\"1\"   style=text-align:center;font-weight:bold;border-width:0px;background-color:#0d243c;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase title=\"Streak\" class=\"STHSW30\">STK</th>";
echo "<th  id=browser   style=text-align:center;font-weight:bold;border-width:0px;background-color:#0d243c;color:#fff;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase;text-transform:uppercase  data-priority=\"critical\" title=\"Last 5\" class=\"STHSW75\">Last 5</th>";
echo "<th  id=browser  data-priority=\"1\" style=text-align:center;font-weight:bold;border-width:0px;background-color:#0d243c;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase  data-priority=\"critical\" title=\"Next Opponent\" class=\"STHSW30\">Next</th>";echo "</tr></thead>	";
	$Query = " SELECT Team" . $TypeTextTeam . "Stat.*, Team" . $TypeText . "Info.Conference, Team" . $TypeText . "Info.City, Team" . $TypeText . "Info.Division, RankingOrder.Type FROM (Team" . $TypeTextTeam . "Stat INNER JOIN Team" . $TypeText . "Info ON Team" . $TypeTextTeam . "Stat.Number = Team" . $TypeText . "Info.Number) INNER JOIN RankingOrder ON Team" . $TypeTextTeam . "Stat.Number = RankingOrder.Team" . $TypeText . "Number WHERE (((Team" . $TypeText . "Info.Division)=\"" . $LeagueGeneral['DivisionName5'] . "\") AND ((RankingOrder.Type)=0)) ORDER BY RankingOrder.TeamOrder LIMIT 3";
	$Standing = $db->query($Query);
	$LoopCount =0;
	if (empty($Standing) == false){while ($row = $Standing ->fetchArray()) {
		$LoopCount +=1;
		PrintStandingTableRow($row, $TypeText, $LeagueGeneral['PointSystemW'], $LoopCount,$DatabaseFile);
	}}

	/* Overall for Conference 2 */	
echo "<th  colspan=\"2\" style=font-weight:bold;border-width:0px;background-color:#0d243c;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase title=\"Team Name\" class=\"STHSW200\">" . $StandingLang['Wildcard'] . "</th>";
echo "<th style=text-align:center;font-weight:bold;border-width:0px;background-color:#0d243c;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase title=\"Games Played\" class=\"STHSW30\"  style=text-align:center>GP</th>";
echo "<th  style=text-align:center;font-weight:bold;border-width:0px;background-color:#0d243c;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase title=\"Wins\" class=\"STHSW30\">W</th>";
echo "<th  style=text-align:center;font-weight:bold;border-width:0px;background-color:#0d243c;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase title=\"Loss\" class=\"STHSW30\">L</th>";
echo "<th  style=text-align:center;font-weight:bold;border-width:0px;background-color:#0d243c;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase title=\"Overtime Loss\" class=\"STHSW30\">OTL</th>";
echo "<th  style=text-align:center;font-weight:bold;border-width:0px;background-color:#0d243c;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase title=\"Points\" class=\"STHSW30\">PTS</th>";
echo "<th  style=text-align:center;font-weight:bold;border-width:0px;background-color:#0d243c;color:#fff;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase;text-transform:uppercase data-priority=\"1\"title=\"Normal Wins\" class=\"STHSW30\">RW</th>";

echo "<th   style=text-align:center;font-weight:bold;border-width:0px;background-color:#0d243c;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase title=\"Normal Wins + Overtime Win\" class=\"STHSW30\">ROW</th>";
echo "<th   style=text-align:center;font-weight:bold;border-width:0px;background-color:#0d243c;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase title=\"Goals For\" class=\"STHSW30\">GF</th>";
echo "<th   style=text-align:center;font-weight:bold;border-width:0px;background-color:#0d243c;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase title=\"Goals Against\" class=\"STHSW30\">GA</th>";
echo "<th  style=text-align:center;font-weight:bold;border-width:0px;background-color:#0d243c;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase title=\"Goals For Diffirencial against Goals Against\" class=\"STHSW30\">Diff</th>";
echo "<th  style=text-align:center;font-weight:bold;border-width:0px;background-color:#0d243c;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase title=\"Home Only\" class=\"STHSW75\">" . $TeamStatLang['Home'] ."</th>";
echo "<th  id=browser  style=text-align:center;font-weight:bold;border-width:0px;background-color:#0d243c;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase title=\"Visitor Only\" class=\"STHSW75\">" . $TeamStatLang['Visitor'] ."</th>";
echo "<th   id=browser  data-priority=\"1\" style=text-align:center;font-weight:bold;border-width:0px;background-color:#0d243c;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase title=\"Shootout Record\" class=\"STHSW30\">" . "S/O" ."</th>";
echo "<th  id=browser    style=text-align:center;font-weight:bold;border-width:0px;background-color:#0d243c;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase title=\"Last 10 Game\" class=\"STHSW75\">" . $TeamStatLang['Last10'] ."</th>";
echo "<th   id=browser  style=text-align:center;font-weight:bold;border-width:0px;background-color:#0d243c;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase title=\"Streak\" class=\"STHSW30\">STK</th>";
echo "<th  id=browser   style=text-align:center;font-weight:bold;border-width:0px;background-color:#0d243c;color:#fff;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase;text-transform:uppercase  data-priority=\"critical\"title=\"Last 5\" class=\"STHSW75\">Last 5</th>";
echo "<th  id=browser  data-priority=\"1\" style=text-align:center;font-weight:bold;border-width:0px;background-color:#0d243c;color:white;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase  data-priority=\"critical\" title=\"Next Opponent\" class=\"STHSW30\">Next</th>";echo "</tr></thead>	";
	$Query = " SELECT Team" . $TypeTextTeam . "Stat.*, Team" . $TypeText . "Info.Conference, Team" . $TypeText . "Info.City, Team" . $TypeText . "Info.Division, RankingOrder.Type FROM (Team" . $TypeTextTeam . "Stat INNER JOIN Team" . $TypeText . "Info ON Team" . $TypeTextTeam . "Stat.Number = Team" . $TypeText . "Info.Number) INNER JOIN RankingOrder ON Team" . $TypeTextTeam . "Stat.Number = RankingOrder.Team" . $TypeText . "Number WHERE (((Team" . $TypeText . "Info.Conference)=\"" . $LeagueGeneral['ConferenceName2'] . "\") AND ((RankingOrder.Type)=2)) ORDER BY RankingOrder.TeamOrder";
	$Standing = $db->query($Query);
	$LoopCount =0;
	if (empty($Standing) == false){while ($row = $Standing ->fetchArray()) {
		$LoopCount +=1;
		If ($LoopCount > 6 ){PrintStandingTableRow($row, $TypeText, $LeagueGeneral['PointSystemW'], $LoopCount,$DatabaseFile);}
		If ($LoopCount == 8){echo "<tr class=\"static\"  style=\"background-color:#cb1c29;height:4px;font-family:Rajdhani,Oswald,Barlow,Khand,sans-serif;color:white;\"><td style=padding:1px class=\"staticTD\" colspan=\"19\"></td></tr><tr></tr>";}
	}}

	echo "</tbody></table>";
}
?>

</div>
<div class="tabmain" id="tabmain2" style="padding:0px">
<?php
If ($DatabaseFound == True){
	foreach ($Division as $Value){
		$Query = " SELECT Team" . $TypeText . "Stat.*, Team" . $TypeText . "Info.Conference, Team" . $TypeText . "Info.City, Team" . $TypeText . "Info.Division,Team" . $TypeText . "Info.City, RankingOrder.Type FROM (Team" . $TypeText . "Stat INNER JOIN Team" . $TypeText . "Info ON Team" . $TypeText . "Stat.Number = Team" . $TypeText . "Info.Number) INNER JOIN RankingOrder ON Team" . $TypeText . "Stat.Number = RankingOrder.Team" . $TypeText . "Number WHERE (((Team" . $TypeText . "Info.Division)=\"" . $Value . "\") AND ((RankingOrder.Type)=0)) ORDER BY RankingOrder.TeamOrder";
		$Standing = $db->query($Query);
		$DataReturn = $db->query($Query); /* Run the Query Twice to Loop Second Array to confirm the first Query Return Data  */
		if($DataReturn->fetchArray()){ /* Only Print Information if Query has row */
			echo "<h4 style=background-position:right;background-repeat:no-repeat;font-weight:bold;color:#2b2c2d;font-size:16px>" . $Value . "</h4>";
			PrintStandingTop($TeamStatLang);
			PrintStandingTable($Standing, $TypeText, $LeagueGeneral['PointSystemW'],0,$DatabaseFile);
		}
	}
}
?>
</div>

<div class="tabmain" id="tabmain3" style="padding:0px">
<?php
If ($DatabaseFound == True){
	Echo "<h4 style=background-image:url(/images/background/Pro.png);background-position:right;background-repeat:no-repeat;font-weight:bold;color:#2b2c2d;font-size:16px>" . $StandingLang['Overall'] . "</h4>";
	$Query = " SELECT Team" . $TypeText . "Stat.*, Team" . $TypeText . "Info.Conference, Team" . $TypeText . "Info.City, Team" . $TypeText . "Info.Division,Team" . $TypeText . "Info.City, RankingOrder.Type FROM (Team" . $TypeText . "Stat INNER JOIN Team" . $TypeText . "Info ON Team" . $TypeText . "Stat.Number = Team" . $TypeText . "Info.Number) INNER JOIN RankingOrder ON Team" . $TypeText . "Stat.Number = RankingOrder.Team" . $TypeText . "Number WHERE (((RankingOrder.Type)=0)) ORDER BY RankingOrder.TeamOrder";
	$Standing = $db->query($Query);
	PrintStandingTop($TeamStatLang);
	PrintStandingTable($Standing, $TypeText, $LeagueGeneral['PointSystemW'],0,$DatabaseFile);
}
?>
</div>
<div class="tabmain" id="tabmain4" style="padding:0px">
<?php
$LeagueName = (string)"";
$Active = 2; /* Show Webpage Top Menu */
$TypeText = (string)"Pro";$TitleType = $DynamicTitleLang['Pro'];
if(isset($_GET['Farm'])){$TypeText = "Farm";$TitleType = $DynamicTitleLang['Farm'];$Active = 3;}

If (file_exists($DatabaseFile) == false){
	$LeagueName = $DatabaseNotFound;
	$PowerRanking = Null;
}else{

	$db = new SQLite3($DatabaseFile);
	$Query = "SELECT PowerRanking" . $TypeText . ".*, Team" . $TypeText . "Info.Name,Team" . $TypeText . "Info.City  FROM PowerRanking" . $TypeText . " LEFT JOIN Team" . $TypeText . "Info ON PowerRanking" . $TypeText . ".Teams = Team" . $TypeText . "Info.Number ORDER BY PowerRanking" . $TypeText . ".TodayRanking;";
	$PowerRanking = $db->query($Query);

	$Query = "Select Name, OutputName from LeagueGeneral";
	$LeagueGeneral = $db->querySingle($Query,true);		
	$LeagueName = $LeagueGeneral['Name'];
}
echo "<title>" . $LeagueName . " - " . $PowerRankingLang['PowerRanking'] . " " . $TitleType . "</title>";

?>


<h1 style="text-align: left;    font-size: 30px;text-transform:uppercase; font-weight:bold;   color:#2b2c2d;font-size:16px">
Power Ranking</h1>


<script type="text/javascript">$(function(){$(".STHSPowerRanking_Table").tablesorter();});</script>

<div style="width:100%;margin:auto;">
<table class="STHSPowerRanking_Table tablesorter" style="border-collapse:collapse"><thead><tr>
<th title="Actual Rank" class="STHSW55" style=text-align:center;font-weight:bold;border-width:0px;background-color:#2a2a2a;color:#fff;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase >Rank</th>
<th title="Team Name" colspan="2" class="STHSW75"style=font-weight:bold;border-width:0px;background-color:#2a2a2a;color:#fff;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase ><?php echo $PowerRankingLang['TeamName'];?></th>
<th title="Last Rank" class="STHSW75" style="width:75px;text-align:center;text-align:center;font-weight:bold;border-width:0px;background-color:#2a2a2a;color:#fff;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase "><?php echo $PowerRankingLang['LastRank'];?></th>
<th title="Points" class="STHSW45" style="text-align:center;text-align:center;font-weight:bold;border-width:0px;background-color:#2a2a2a;color:#fff;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase ">Points</th>
<th title="Wins" class="STHSW10" style="text-align:center;text-align:center;font-weight:bold;border-width:0px;background-color:#2a2a2a;color:#fff;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase ">W</th>
<th title="Loss" class="STHSW10" style="text-align:center;text-align:center;font-weight:bold;border-width:0px;background-color:#2a2a2a;color:#fff;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase ">L</th>
<th title="Ties" class="STHSW10" style="text-align:center;text-align:center;font-weight:bold;border-width:0px;background-color:#2a2a2a;color:#fff;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase ">T</th>
<th title="Overtime Loss" class="STHSW10" style="text-align:center;text-align:center;font-weight:bold;border-width:0px;background-color:#2a2a2a;color:#fff;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase ">OTL</th>
<th title="Shootout Loss" class="STHSW10" style="text-align:center;text-align:center;font-weight:bold;border-width:0px;background-color:#2a2a2a;color:#fff;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase ">SOL</th>
<th title="Goals For" class="STHSW10" style="text-align:center;text-align:center;font-weight:bold;border-width:0px;background-color:#2a2a2a;color:#fff;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase ">GF</th>
<th title="Goals Against" class="STHSW10" style="text-align:center;text-align:center;font-weight:bold;border-width:0px;background-color:#2a2a2a;color:#fff;padding-top:0px;padding-bottom:0px;padding-left:8px;padding-right:8px;text-shadow:none;font-size:12px;text-transform:uppercase ">GA</th>
</tr></thead>
<tbody>
<?php
if (empty($PowerRanking) == false){while ($Row = $PowerRanking ->fetchArray()) {
	echo "<tr class=\"border_" . $Row['Teams'] . "\"><td style=\"color: #383732;text-align:center;font-size:14px;font-family:Rajdhani,Oswald,Barlow,Khand,sans-serif;font-weight: bold;vertical-align:middle\"><span style=font-size:24px>" . $Row['TodayRanking'] . "</span><br>";
	If ($Row['TodayRanking'] > $Row['LastRanking']){echo "<span style=\"color:red;font-weight:bold\"><img src=\"http://a.espncdn.com/i/sportsnation/rd-arrow" . "." . png . "\" alt=\"" . $TeamName . "\"style=\"vertical-align:middle\">" . ($Row['TodayRanking'] - $Row['LastRanking']) ."</span>";}if ($Row['TodayRanking'] < $Row['LastRanking']){echo "<span style=\"color:green;font-weight:bold\"><img src=\"http://a.espncdn.com/i/sportsnation/gn-arrow" . "." . png . "\" alt=\"" . $TeamName . "\"style=\"vertical-align:middle\">" . ($Row['LastRanking'] - $Row['TodayRanking']) ."</span>";}if ($Row['TodayRanking'] == $Row['LastRanking']){echo "<span style=\"color:#2b2c2d;font-size:16px;font-weight:bold\"><img src=\"http://a.espncdn.com/i/nba/misc/sw_ye_40" . "." . png . "\" alt=\"" . $TeamName . "\" style=\"width:17px;vertical-align:middle\"\"></span>";}
	echo "</td>";
	echo "<td style=padding-left:10px;color:white;font-weight:bold;margin:0px;width:32px;height:32px;padding-left:10px><img src=\"/images/LogoTeams/Pro/" . $Row['Teams'] . "." . svg  . "\" alt=\"" . $TeamName . "\" style=vertical-align:middle;padding-right:4px;width:45px;height:45px></td><td style=font-size:15px;margin:0px;vertical-align:middle;padding-right:6px;font-weight:bold;color:#383732;line-height:16px><span style=\"color:#686c73;font-weight:bold;margin:0px;font-size:12px;font-family:Nunito,sans-serif;text-transform:uppercase;letter-spacing:0.3px\">". $Row['City'] ."</span><br><span style=font-family:Rajdhani,Oswald,Barlow,Khand,sans-serif;font-size:20px;color:#000;letter-spacing:0.2px;font-weight:bold>" .$Row['Name'] . "</td>";
	echo "<td class=\"STHSTodayGame_TeamScore\"  style=\"color: #383732;text-align:center;font-size:14px;font-family:Rajdhani,Oswald,Barlow,Khand,sans-serif;font-weight: bold;vertical-align:middle\"><h4 style=\"color: #383732;width:75px;font-size:14px;font-family:Rajdhani,Oswald,Barlow,Khand,sans-serif;font-weight: bold;vertical-align:middle\">" . $Row['LastRanking'] ."</h4></td>";
	echo "<td style=\"color: #383732;text-align:center;font-size:14px;font-family:Rajdhani,Oswald,Barlow,Khand,sans-serif;font-weight: bold;vertical-align:middle\"><h4 style=\"color: #383732;font-size:14px;font-family:Rajdhani,Oswald,Barlow,Khand,sans-serif;font-weight: ;vertical-align:middle\">" . $Row['Points'] . "</h4></td>";
	echo "<td style=\"color: #383732;text-align:center;font-size:14px;font-family:Rajdhani,Oswald,Barlow,Khand,sans-serif;font-weight: bold;vertical-align:middle\"><h4 style=\"color: #383732;font-size:14px;font-family:Rajdhani,Oswald,Barlow,Khand,sans-serif;font-weight: ;vertical-align:middle\">" . $Row['W'] . "</h4></td>";
	echo "<td style=\"color: #383732;text-align:center;font-size:14px;font-family:Rajdhani,Oswald,Barlow,Khand,sans-serif;font-weight: bold;vertical-align:middle\"><h4 style=\"color: #383732;font-size:14px;font-family:Rajdhani,Oswald,Barlow,Khand,sans-serif;font-weight: ;vertical-align:middle\">" . $Row['L'] . "</h4></td>";
	echo "<td style=\"color: #383732;text-align:center;font-size:14px;font-family:Rajdhani,Oswald,Barlow,Khand,sans-serif;font-weight: bold;vertical-align:middle\"><h4 style=\"color: #383732;font-size:14px;font-family:Rajdhani,Oswald,Barlow,Khand,sans-serif;font-weight: ;vertical-align:middle\">" . $Row['T'] . "</h4></td>";
	echo "<td style=\"color: #383732;text-align:center;font-size:14px;font-family:Rajdhani,Oswald,Barlow,Khand,sans-serif;font-weight: bold;vertical-align:middle\"><h4 style=\"color: #383732;font-size:14px;font-family:Rajdhani,Oswald,Barlow,Khand,sans-serif;font-weight: ;vertical-align:middle\">" . $Row['OTL'] . "</h4></td>";
	echo "<td style=\"color: #383732;text-align:center;font-size:14px;font-family:Rajdhani,Oswald,Barlow,Khand,sans-serif;font-weight: bold;vertical-align:middle\"><h4 style=\"color: #383732;font-size:14px;font-family:Rajdhani,Oswald,Barlow,Khand,sans-serif;font-weight: ;vertical-align:middle\">" . $Row['SOL'] . "</h4></td>";	
	echo "<td style=\"color: #383732;text-align:center;text-align:center;font-size:14px;font-family:Rajdhani,Oswald,Barlow,Khand,sans-serif;font-weight: bold;vertical-align:middle\"><h4 style=\"color: #383732;font-size:14px;font-family:Rajdhani,Oswald,Barlow,Khand,sans-serif;font-weight: ;vertical-align:middle\">" . $Row['GF'] . "</h4></td>";	
	echo "<td style=\"color: #383732;text-align:center;font-size:14px;font-family:Rajdhani,Oswald,Barlow,Khand,sans-serif;font-weight: bold;vertical-align:middle\"><h4 style=\"color: #383732;font-size:14px;font-family:Rajdhani,Oswald,Barlow,Khand,sans-serif;font-weight: ;vertical-align:middle\">" . $Row['GA'] . "</h4></td>";		
	echo "</tr>\n"; /* The \n is for a new line in the HTML Code */
}}
?>
</tbody></table>
</div>

</div>

<div class="tabmain active"  id="tabmain5" style="display:<?php if ($TypeText == Farm){echo "none";}?>">
<h1 style="text-align: left;    font-size: 30px;text-transform:uppercase; font-weight:bold;   color:#2b2c2d;font-size:16px">Stanley Cup Playoffs</h1>
<?php
	$Query = "SELECT * FROM PlayoffPro";
	$PlayoffStanding = $db->query($Query);
?>

<div class="row">
									<div class="col-lg-12">
						<div class="standing-playoffs">
							<table class="table table-condensed" style="width:100%">
								<tbody>
								<tr>
									<td colspan="2">
											<div class="bracket-container">
											<div class="center-logo-container" id="center-logo-container"><img class="center-logo" src="/images/Playoffs2022.png"></div>
											<div class="bracket-box western division-upper matchup-upper round-1"></div>
											<div class="bracket-box western division-upper matchup-lower round-1"></div>
											<div class="bracket-box western division-lower matchup-upper round-1"></div>
											<div class="bracket-box western division-lower matchup-lower round-1"></div>
											<div class="bracket-box eastern division-upper matchup-upper round-1"></div>
											<div class="bracket-box eastern division-upper matchup-lower round-1"></div>
											<div class="bracket-box eastern division-lower matchup-upper round-1"></div>
											<div class="bracket-box eastern division-lower matchup-lower round-1"></div>
											<div class="bracket-box western division-upper round-2"></div>
											<div class="bracket-box western division-lower round-2"></div>
											<div class="bracket-box eastern division-upper round-2"></div>
											<div class="bracket-box eastern division-lower round-2"></div>
											<div class="bracket-box western round-3"></div>
											<div class="bracket-box eastern round-3"></div>
											<div class="bracket-box western round-4"></div>
											<div class="bracket-box eastern round-4"></div>
											<div class="bracket-slot eastern atlantic round-1 rank-1">
												<a href="/ProTeam.php?Team=3" target="_blank"><div class="bracket-slot-content logo-round-team logo-bg--team-<?php $Query = "SELECT * FROM PlayoffPro WHERE PlayoffPro.Number = 1";$PlayoffPro = $db->querySingle($Query,true);echo $PlayoffPro['HomeTeam'];?>"></div></a></div>
											<div class="bracket-slot eastern atlantic round-1 rank-wc">
												<a href="/ProTeam.php?Team=19" target="_blank"><div class="bracket-slot-content logo-round-team logo-bg--team-<?php $Query = "SELECT * FROM PlayoffPro WHERE PlayoffPro.Number = 1";$PlayoffPro = $db->querySingle($Query,true);echo $PlayoffPro['VisitorTeam'];?>"></div></a></div>
											<div class="bracket-slot eastern atlantic round-1 rank-2">
												<a href="/ProTeam.php?Team=29" target="_blank"><div class="bracket-slot-content logo-round-team logo-bg--team-<?php $Query = "SELECT * FROM PlayoffPro WHERE PlayoffPro.Number = 2";$PlayoffPro = $db->querySingle($Query,true);echo $PlayoffPro['HomeTeam'];?>"></div></a></div>
											<div class="bracket-slot eastern atlantic round-1 rank-3">
												<a href="/ProTeam.php?Team=1" target="_blank"><div class="bracket-slot-content logo-round-team logo-bg--team-<?php $Query = "SELECT * FROM PlayoffPro WHERE PlayoffPro.Number = 2";$PlayoffPro = $db->querySingle($Query,true);echo $PlayoffPro['VisitorTeam'];?>"></div></a></div>
											<div class="bracket-slot eastern metropolitan round-1 rank-1">
												<a href="/ProTeam.php?Team=15" target="_blank"><div class="bracket-slot-content logo-round-team logo-bg--team-<?php $Query = "SELECT * FROM PlayoffPro WHERE PlayoffPro.Number = 3";$PlayoffPro = $db->querySingle($Query,true);echo $PlayoffPro['HomeTeam'];?>"></div></a></div>
											<div class="bracket-slot eastern metropolitan round-1 rank-wc">
												<a href="/ProTeam.php?Team=27" target="_blank"><div class="bracket-slot-content logo-round-team logo-bg--team-<?php $Query = "SELECT * FROM PlayoffPro WHERE PlayoffPro.Number = 3";$PlayoffPro = $db->querySingle($Query,true);echo $PlayoffPro['VisitorTeam'];?>"></div></a></div>
											<div class="bracket-slot eastern metropolitan round-1 rank-2">
												<a href="/ProTeam.php?Team=7" target="_blank"><div class="bracket-slot-content logo-round-team logo-bg--team-<?php $Query = "SELECT * FROM PlayoffPro WHERE PlayoffPro.Number = 4";$PlayoffPro = $db->querySingle($Query,true);echo $PlayoffPro['HomeTeam'];?>"></div></a></div>
											<div class="bracket-slot eastern metropolitan round-1 rank-3">
												<a href="/ProTeam.php?Team=9" target="_blank"><div class="bracket-slot-content logo-round-team logo-bg--team-<?php $Query = "SELECT * FROM PlayoffPro WHERE PlayoffPro.Number = 4";$PlayoffPro = $db->querySingle($Query,true);echo $PlayoffPro['VisitorTeam'];?>"></div></a></div>
											<div class="bracket-slot western central round-1 rank-1">
												<a href="/ProTeam.php?Team=2" target="_blank"><div class="bracket-slot-content logo-round-team logo-bg--team-<?php $Query = "SELECT * FROM PlayoffPro WHERE PlayoffPro.Number = 5";$PlayoffPro = $db->querySingle($Query,true);echo $PlayoffPro['HomeTeam'];?>"></div></a></div>
											<div class="bracket-slot western central round-1 rank-wc">
												<a href="/ProTeam.php?Team=8" target="_blank"><div class="bracket-slot-content logo-round-team logo-bg--team-<?php $Query = "SELECT * FROM PlayoffPro WHERE PlayoffPro.Number = 5";$PlayoffPro = $db->querySingle($Query,true);echo $PlayoffPro['VisitorTeam'];?>"></div></a></div>
											<div class="bracket-slot western central round-1 rank-2">
												<a href="/ProTeam.php?Team=6" target="_blank"><div class="bracket-slot-content logo-round-team logo-bg--team-<?php $Query = "SELECT * FROM PlayoffPro WHERE PlayoffPro.Number = 6";$PlayoffPro = $db->querySingle($Query,true);echo $PlayoffPro['HomeTeam'];?>"></div></a></div>
											<div class="bracket-slot western central round-1 rank-3">
												<a href="/ProTeam.php?Team=11" target="_blank"><div class="bracket-slot-content logo-round-team logo-bg--team-<?php $Query = "SELECT * FROM PlayoffPro WHERE PlayoffPro.Number = 6";$PlayoffPro = $db->querySingle($Query,true);echo $PlayoffPro['VisitorTeam'];?>"></div></a></div>
											<div class="bracket-slot western pacific round-1 rank-1">
												<a href="/ProTeam.php?Team=14" target="_blank"><div class="bracket-slot-content logo-round-team logo-bg--team-<?php $Query = "SELECT * FROM PlayoffPro WHERE PlayoffPro.Number = 7";$PlayoffPro = $db->querySingle($Query,true);echo $PlayoffPro['HomeTeam'];?>"></div></a></div>
											<div class="bracket-slot western pacific round-1 rank-wc">
												<a href="/ProTeam.php?Team=12" target="_blank"><div class="bracket-slot-content logo-round-team logo-bg--team-<?php $Query = "SELECT * FROM PlayoffPro WHERE PlayoffPro.Number = 7";$PlayoffPro = $db->querySingle($Query,true);echo $PlayoffPro['VisitorTeam'];?>"></div></a></div>
											<div class="bracket-slot western pacific round-1 rank-2">
												<a href="/ProTeam.php?Team=20" target="_blank"><div class="bracket-slot-content logo-round-team logo-bg--team-<?php $Query = "SELECT * FROM PlayoffPro WHERE PlayoffPro.Number = 8";$PlayoffPro = $db->querySingle($Query,true);echo $PlayoffPro['HomeTeam'];?>"></div></a></div>
											<div class="bracket-slot western pacific round-1 rank-3">
												<a href="/ProTeam.php?Team=31" target="_blank"><div class="bracket-slot-content logo-round-team logo-bg--team-<?php $Query = "SELECT * FROM PlayoffPro WHERE PlayoffPro.Number = 8";$PlayoffPro = $db->querySingle($Query,true);echo $PlayoffPro['VisitorTeam'];?>"></div></a></div>
											<div class="bracket-slot eastern atlantic round-2 team-upper">
												<a href="/ProTeam.php?Team=3" target="_blank"><div class="bracket-slot-content logo-round-team logo-bg--team-<?php $Query = "SELECT * FROM PlayoffPro WHERE PlayoffPro.Number = 1";$PlayoffPro = $db->querySingle($Query,true);
												if ($PlayoffPro['HomeWin'] == 4){echo $PlayoffPro['HomeTeam'];}elseif ($PlayoffPro['VisitorWin'] == 4){echo $PlayoffPro['VisitorTeam'];}else{echo "";};?>"></div></a></div>
											<div class="bracket-slot eastern atlantic round-2 team-lower">
												<a href="/ProTeam.php?Team=1" target="_blank"><div class="bracket-slot-content logo-round-team logo-bg--team-<?php $Query = "SELECT * FROM PlayoffPro WHERE PlayoffPro.Number = 2";$PlayoffPro = $db->querySingle($Query,true);
												if ($PlayoffPro['HomeWin'] == 4){echo $PlayoffPro['HomeTeam'];}elseif ($PlayoffPro['VisitorWin'] == 4){echo $PlayoffPro['VisitorTeam'];}else{echo "";};?>"></div></a></div>
											<div class="bracket-slot eastern metropolitan round-2 team-upper">
												<a href="/ProTeam.php?Team=23" target="_blank"><div class="bracket-slot-content logo-round-team logo-bg--team-<?php $Query = "SELECT * FROM PlayoffPro WHERE PlayoffPro.Number = 3";$PlayoffPro = $db->querySingle($Query,true);
												if ($PlayoffPro['HomeWin'] == 4){echo $PlayoffPro['HomeTeam'];}elseif ($PlayoffPro['VisitorWin'] == 4){echo $PlayoffPro['VisitorTeam'];}else{echo "";};?>"></div></a></div>
											<div class="bracket-slot eastern metropolitan round-2 team-lower">
												<a href="/ProTeam.php?Team=9" target="_blank"><div class="bracket-slot-content logo-round-team logo-bg--team-<?php $Query = "SELECT * FROM PlayoffPro WHERE PlayoffPro.Number = 4";$PlayoffPro = $db->querySingle($Query,true);
												if ($PlayoffPro['HomeWin'] == 4){echo $PlayoffPro['HomeTeam'];}elseif ($PlayoffPro['VisitorWin'] == 4){echo $PlayoffPro['VisitorTeam'];}else{echo "";};?>"></div></a></div>
											<div class="bracket-slot western central round-2 team-upper">
												<a href="/ProTeam.php?Team=26" target="_blank"><div class="bracket-slot-content logo-round-team logo-bg--team-<?php $Query = "SELECT * FROM PlayoffPro WHERE PlayoffPro.Number = 5";$PlayoffPro = $db->querySingle($Query,true);
												if ($PlayoffPro['HomeWin'] == 4){echo $PlayoffPro['HomeTeam'];}elseif ($PlayoffPro['VisitorWin'] == 4){echo $PlayoffPro['VisitorTeam'];}else{echo "";};?>"></div></a></div>
											<div class="bracket-slot western central round-2 team-lower">
												<a href="/ProTeam.php?Team=16" target="_blank"><div class="bracket-slot-content logo-round-team logo-bg--team-<?php $Query = "SELECT * FROM PlayoffPro WHERE PlayoffPro.Number = 6";$PlayoffPro = $db->querySingle($Query,true);
												if ($PlayoffPro['HomeWin'] == 4){echo $PlayoffPro['HomeTeam'];}elseif ($PlayoffPro['VisitorWin'] == 4){echo $PlayoffPro['VisitorTeam'];}else{echo "";};?>"></div></a></div>
											<div class="bracket-slot western pacific round-2 team-upper">
												<a href="/ProTeam.php?Team=8" target="_blank"><div class="bracket-slot-content logo-round-team logo-bg--team-<?php $Query = "SELECT * FROM PlayoffPro WHERE PlayoffPro.Number = 7";$PlayoffPro = $db->querySingle($Query,true);
												if ($PlayoffPro['HomeWin'] == 4){echo $PlayoffPro['HomeTeam'];}elseif ($PlayoffPro['VisitorWin'] == 4){echo $PlayoffPro['VisitorTeam'];}else{echo "";};?>"></div></a></div>
											<div class="bracket-slot western pacific round-2 team-lower">
												<a href="/ProTeam.php?Team=30" target="_blank"><div class="bracket-slot-content logo-round-team logo-bg--team-<?php $Query = "SELECT * FROM PlayoffPro WHERE PlayoffPro.Number = 8";$PlayoffPro = $db->querySingle($Query,true);
												if ($PlayoffPro['HomeWin'] == 4){echo $PlayoffPro['HomeTeam'];}elseif ($PlayoffPro['VisitorWin'] == 4){echo $PlayoffPro['VisitorTeam'];}else{echo "";};?>"></div></a></div>
											<div class="bracket-slot eastern atlantic round-3">
												<a href="/ProTeam.php?Team=3" target="_blank"><div class="bracket-slot-content logo-round-team logo-bg--team-<?php $Query = "SELECT * FROM PlayoffPro WHERE PlayoffPro.Number = 9";$PlayoffPro = $db->querySingle($Query,true);
												if ($PlayoffPro['HomeWin'] == 4){echo $PlayoffPro['HomeTeam'];}elseif ($PlayoffPro['VisitorWin'] == 4){echo $PlayoffPro['VisitorTeam'];}else{echo "";};?>"></div></a></div>
											<div class="bracket-slot eastern metropolitan round-3">
												<a href="/ProTeam.php?Team=6" target="_blank"><div class="bracket-slot-content logo-round-team logo-bg--team-<?php $Query = "SELECT * FROM PlayoffPro WHERE PlayoffPro.Number = 10";$PlayoffPro = $db->querySingle($Query,true);
												if ($PlayoffPro['HomeWin'] == 4){echo $PlayoffPro['HomeTeam'];}elseif ($PlayoffPro['VisitorWin'] == 4){echo $PlayoffPro['VisitorTeam'];}else{echo "";};?>"></div></a></div>
											<div class="bracket-slot western central round-3">
												<a href="/ProTeam.php?Team=22" target="_blank"><div class="bracket-slot-content logo-round-team logo-bg--team-<?php $Query = "SELECT * FROM PlayoffPro WHERE PlayoffPro.Number = 11";$PlayoffPro = $db->querySingle($Query,true);
												if ($PlayoffPro['HomeWin'] == 4){echo $PlayoffPro['HomeTeam'];}elseif ($PlayoffPro['VisitorWin'] == 4){echo $PlayoffPro['VisitorTeam'];}else{echo "";};?>"></div></a></div>
											<div class="bracket-slot western pacific round-3">
												<a href="/ProTeam.php?Team=31" target="_blank"><div class="bracket-slot-content logo-round-team logo-bg--team-<?php $Query = "SELECT * FROM PlayoffPro WHERE PlayoffPro.Number = 12";$PlayoffPro = $db->querySingle($Query,true);
												if ($PlayoffPro['HomeWin'] == 4){echo $PlayoffPro['HomeTeam'];}elseif ($PlayoffPro['VisitorWin'] == 4){echo $PlayoffPro['VisitorTeam'];}else{echo "";};?>"></div></a></div>
											<div class="bracket-slot eastern round-4">
												<a href="/ProTeam.php?Team=22" target="_blank"><div class="bracket-slot-content logo-round-team logo-bg--team-<?php $Query = "SELECT * FROM PlayoffPro WHERE PlayoffPro.Number = 13";$PlayoffPro = $db->querySingle($Query,true);
												if ($PlayoffPro['HomeWin'] == 4){echo $PlayoffPro['HomeTeam'];}elseif ($PlayoffPro['VisitorWin'] == 4){echo $PlayoffPro['VisitorTeam'];}else{echo "";};?>"></div></a></div>
											<div class="bracket-slot western round-4">
												<a href="/ProTeam.php?Team=6" target="_blank"><div class="bracket-slot-content logo-round-team logo-bg--team-<?php $Query = "SELECT * FROM PlayoffPro WHERE PlayoffPro.Number = 14";$PlayoffPro = $db->querySingle($Query,true);
												if ($PlayoffPro['HomeWin'] == 4){echo $PlayoffPro['HomeTeam'];}elseif ($PlayoffPro['VisitorWin'] == 4){echo $PlayoffPro['VisitorTeam'];}else{echo "";};?>"></div></a></div>
											<div class="bracket-slot round-4-winner">
												<a href="/ProTeam.php?Team=6" target="_blank"><div class="bracket-slot-content logo-round-team logo-bg--team-<?php $Query = "SELECT * FROM PlayoffPro WHERE PlayoffPro.Number = 15";$PlayoffPro = $db->querySingle($Query,true);
												if ($PlayoffPro['HomeWin'] == 4){echo $PlayoffPro['HomeTeam'];}elseif ($PlayoffPro['VisitorWin'] == 4){echo $PlayoffPro['VisitorTeam'];}else{echo "";};?>"></div></a></div>
											<div class="broadcaster-logo-container" id="broadcaster-logo-container" style="width:50%;margin:auto"><img class="broadcaster-logo" src="http://nhl.bamcontent.com/images/logos/league/cup-broadcasters-enca-v5.svg" ></div>
											<div class="series-status eastern atlantic round-1 series-top">
											<?php $Query = "SELECT PlayoffPro.*, TeamInfoHome.Abbre as HomeTeamName, TeamInfoVisitor.Abbre as VisitorTeamName FROM (PlayoffPro INNER JOIN TeamProInfo AS TeamInfoHome ON PlayoffPro.HomeTeam = TeamInfoHome.Number) LEFT JOIN TeamProInfo AS TeamInfoVisitor ON PlayoffPro.VisitorTeam = TeamInfoVisitor.Number WHERE PlayoffPro.Number = 1";$PlayoffPro = $db->querySingle($Query,true);
 											if ($PlayoffPro['HomeWin'] > $PlayoffPro['VisitorWin'] AND $PlayoffPro['HomeWin'] == 4 ){echo "<span>" . $PlayoffPro['HomeTeamName'] . " wins " . $PlayoffPro['HomeWin'] . "-" . $PlayoffPro['VisitorWin'] ."</span>";}
 											elseif ($PlayoffPro['HomeWin'] > $PlayoffPro['VisitorWin']){echo "<span>" . $PlayoffPro['HomeTeamName'] . " leads " . $PlayoffPro['HomeWin'] . "-" . $PlayoffPro['VisitorWin'] ."</span>";}
    										elseif ($PlayoffPro['VisitorWin'] === $PlayoffPro['HomeWin']){echo "<span>" .  "Series tied " . $PlayoffPro['VisitorWin'] . "-" . $PlayoffPro['HomeWin'] ."</span>";}
											elseif ($PlayoffPro['VisitorWin'] > $PlayoffPro['HomeWin'] AND $PlayoffPro['VisitorWin'] == 4 ){echo "<span>" . $PlayoffPro['VisitorTeamName'] . " wins " . $PlayoffPro['VisitorWin'] . "-" . $PlayoffPro['HomeWin'] ."</span>";}
											elseif ($PlayoffPro['VisitorWin'] > $PlayoffPro['HomeWin']){echo "<span>" . $PlayoffPro['VisitorTeamName'] . " leads " . $PlayoffPro['VisitorWin'] . "-" . $PlayoffPro['HomeWin'] ."</span>";}
											else {echo "";}?></div>
											
											
											<div class="series-status eastern atlantic round-1 series-bottom">											<?php $Query = "SELECT PlayoffPro.*, TeamInfoHome.Abbre as HomeTeamName, TeamInfoVisitor.Abbre as VisitorTeamName FROM (PlayoffPro INNER JOIN TeamProInfo AS TeamInfoHome ON PlayoffPro.HomeTeam = TeamInfoHome.Number) LEFT JOIN TeamProInfo AS TeamInfoVisitor ON PlayoffPro.VisitorTeam = TeamInfoVisitor.Number WHERE PlayoffPro.Number = 2";$PlayoffPro = $db->querySingle($Query,true);
 											if ($PlayoffPro['HomeWin'] > $PlayoffPro['VisitorWin'] AND $PlayoffPro['HomeWin'] == 4 ){echo "<span>" . $PlayoffPro['HomeTeamName'] . " wins " . $PlayoffPro['HomeWin'] . "-" . $PlayoffPro['VisitorWin'] ."</span>";}
 											elseif ($PlayoffPro['HomeWin'] > $PlayoffPro['VisitorWin']){echo "<span>" . $PlayoffPro['HomeTeamName'] . " leads " . $PlayoffPro['HomeWin'] . "-" . $PlayoffPro['VisitorWin'] ."</span>";}
    										elseif ($PlayoffPro['VisitorWin'] === $PlayoffPro['HomeWin']){echo "<span>" .  "Series tied " . $PlayoffPro['VisitorWin'] . "-" . $PlayoffPro['HomeWin'] ."</span>";}
  											elseif ($PlayoffPro['VisitorWin'] > $PlayoffPro['HomeWin'] AND $PlayoffPro['VisitorWin'] == 4 ){echo "<span>" . $PlayoffPro['VisitorTeamName'] . " wins " . $PlayoffPro['VisitorWin'] . "-" . $PlayoffPro['HomeWin'] ."</span>";}
											elseif ($PlayoffPro['VisitorWin'] > $PlayoffPro['HomeWin']){echo "<span>" . $PlayoffPro['VisitorTeamName'] . " leads " . $PlayoffPro['VisitorWin'] . "-" . $PlayoffPro['HomeWin'] ."</span>";}
											else {echo "";}?></div>
											
											
											<div class="series-status eastern metropolitan round-1 series-top">													<?php $Query = "SELECT PlayoffPro.*, TeamInfoHome.Abbre as HomeTeamName, TeamInfoVisitor.Abbre as VisitorTeamName FROM (PlayoffPro INNER JOIN TeamProInfo AS TeamInfoHome ON PlayoffPro.HomeTeam = TeamInfoHome.Number) LEFT JOIN TeamProInfo AS TeamInfoVisitor ON PlayoffPro.VisitorTeam = TeamInfoVisitor.Number WHERE PlayoffPro.Number = 3";$PlayoffPro = $db->querySingle($Query,true);
 											if ($PlayoffPro['HomeWin'] > $PlayoffPro['VisitorWin'] AND $PlayoffPro['HomeWin'] == 4 ){echo "<span>" . $PlayoffPro['HomeTeamName'] . " wins " . $PlayoffPro['HomeWin'] . "-" . $PlayoffPro['VisitorWin'] ."</span>";}
 											elseif ($PlayoffPro['HomeWin'] > $PlayoffPro['VisitorWin']){echo "<span>" . $PlayoffPro['HomeTeamName'] . " leads " . $PlayoffPro['HomeWin'] . "-" . $PlayoffPro['VisitorWin'] ."</span>";}
     										elseif ($PlayoffPro['VisitorWin'] === $PlayoffPro['HomeWin']){echo "<span>" .  "Series tied " . $PlayoffPro['VisitorWin'] . "-" . $PlayoffPro['HomeWin'] ."</span>";}
 											elseif ($PlayoffPro['VisitorWin'] > $PlayoffPro['HomeWin'] AND $PlayoffPro['VisitorWin'] == 4 ){echo "<span>" . $PlayoffPro['VisitorTeamName'] . " wins " . $PlayoffPro['VisitorWin'] . "-" . $PlayoffPro['HomeWin'] ."</span>";}
											elseif ($PlayoffPro['VisitorWin'] > $PlayoffPro['HomeWin']){echo "<span>" . $PlayoffPro['VisitorTeamName'] . " leads " . $PlayoffPro['VisitorWin'] . "-" . $PlayoffPro['HomeWin'] ."</span>";}else {echo "";}?></div>
											
											
											<div class="series-status eastern metropolitan round-1 series-bottom">													<?php $Query = "SELECT PlayoffPro.*, TeamInfoHome.Abbre as HomeTeamName, TeamInfoVisitor.Abbre as VisitorTeamName FROM (PlayoffPro INNER JOIN TeamProInfo AS TeamInfoHome ON PlayoffPro.HomeTeam = TeamInfoHome.Number) LEFT JOIN TeamProInfo AS TeamInfoVisitor ON PlayoffPro.VisitorTeam = TeamInfoVisitor.Number WHERE PlayoffPro.Number = 4";$PlayoffPro = $db->querySingle($Query,true);
 											if ($PlayoffPro['HomeWin'] > $PlayoffPro['VisitorWin'] AND $PlayoffPro['HomeWin'] == 4 ){echo "<span>" . $PlayoffPro['HomeTeamName'] . " wins " . $PlayoffPro['HomeWin'] . "-" . $PlayoffPro['VisitorWin'] ."</span>";}
 											elseif ($PlayoffPro['HomeWin'] > $PlayoffPro['VisitorWin']){echo "<span>" . $PlayoffPro['HomeTeamName'] . " leads " . $PlayoffPro['HomeWin'] . "-" . $PlayoffPro['VisitorWin'] ."</span>";}
    										elseif ($PlayoffPro['VisitorWin'] === $PlayoffPro['HomeWin']){echo "<span>" .  "Series tied " . $PlayoffPro['VisitorWin'] . "-" . $PlayoffPro['HomeWin'] ."</span>";}
  											elseif ($PlayoffPro['VisitorWin'] > $PlayoffPro['HomeWin'] AND $PlayoffPro['VisitorWin'] == 4 ){echo "<span>" . $PlayoffPro['VisitorTeamName'] . " wins " . $PlayoffPro['VisitorWin'] . "-" . $PlayoffPro['HomeWin'] ."</span>";}
											elseif ($PlayoffPro['VisitorWin'] > $PlayoffPro['HomeWin']){echo "<span>" . $PlayoffPro['VisitorTeamName'] . " leads " . $PlayoffPro['VisitorWin'] . "-" . $PlayoffPro['HomeWin'] ."</span>";}else {echo "";}?></div>
											
											
											<div class="series-status western central round-1 series-top">												<?php $Query = "SELECT PlayoffPro.*, TeamInfoHome.Abbre as HomeTeamName, TeamInfoVisitor.Abbre as VisitorTeamName FROM (PlayoffPro INNER JOIN TeamProInfo AS TeamInfoHome ON PlayoffPro.HomeTeam = TeamInfoHome.Number) LEFT JOIN TeamProInfo AS TeamInfoVisitor ON PlayoffPro.VisitorTeam = TeamInfoVisitor.Number WHERE PlayoffPro.Number = 5";$PlayoffPro = $db->querySingle($Query,true);
 											if ($PlayoffPro['HomeWin'] > $PlayoffPro['VisitorWin'] AND $PlayoffPro['HomeWin'] == 4 ){echo "<span>" . $PlayoffPro['HomeTeamName'] . " wins " . $PlayoffPro['HomeWin'] . "-" . $PlayoffPro['VisitorWin'] ."</span>";}
 											elseif ($PlayoffPro['HomeWin'] > $PlayoffPro['VisitorWin']){echo "<span>" . $PlayoffPro['HomeTeamName'] . " leads " . $PlayoffPro['HomeWin'] . "-" . $PlayoffPro['VisitorWin'] ."</span>";}
     										elseif ($PlayoffPro['VisitorWin'] === $PlayoffPro['HomeWin']){echo "<span>" .  "Series tied " . $PlayoffPro['VisitorWin'] . "-" . $PlayoffPro['HomeWin'] ."</span>";}
 											elseif ($PlayoffPro['VisitorWin'] > $PlayoffPro['HomeWin'] AND $PlayoffPro['VisitorWin'] == 4 ){echo "<span>" . $PlayoffPro['VisitorTeamName'] . " wins " . $PlayoffPro['VisitorWin'] . "-" . $PlayoffPro['HomeWin'] ."</span>";}
											elseif ($PlayoffPro['VisitorWin'] > $PlayoffPro['HomeWin']){echo "<span>" . $PlayoffPro['VisitorTeamName'] . " leads " . $PlayoffPro['VisitorWin'] . "-" . $PlayoffPro['HomeWin'] ."</span>";}else {echo "";}?></div>
											
											
											<div class="series-status western central round-1 series-bottom">												<?php $Query = "SELECT PlayoffPro.*, TeamInfoHome.Abbre as HomeTeamName, TeamInfoVisitor.Abbre as VisitorTeamName FROM (PlayoffPro INNER JOIN TeamProInfo AS TeamInfoHome ON PlayoffPro.HomeTeam = TeamInfoHome.Number) LEFT JOIN TeamProInfo AS TeamInfoVisitor ON PlayoffPro.VisitorTeam = TeamInfoVisitor.Number WHERE PlayoffPro.Number = 6";$PlayoffPro = $db->querySingle($Query,true);
 											if ($PlayoffPro['HomeWin'] > $PlayoffPro['VisitorWin'] AND $PlayoffPro['HomeWin'] == 4 ){echo "<span>" . $PlayoffPro['HomeTeamName'] . " wins " . $PlayoffPro['HomeWin'] . "-" . $PlayoffPro['VisitorWin'] ."</span>";}
 											elseif ($PlayoffPro['HomeWin'] > $PlayoffPro['VisitorWin']){echo "<span>" . $PlayoffPro['HomeTeamName'] . " leads " . $PlayoffPro['HomeWin'] . "-" . $PlayoffPro['VisitorWin'] ."</span>";}
    										elseif ($PlayoffPro['VisitorWin'] === $PlayoffPro['HomeWin']){echo "<span>" .  "Series tied " . $PlayoffPro['VisitorWin'] . "-" . $PlayoffPro['HomeWin'] ."</span>";}
  											elseif ($PlayoffPro['VisitorWin'] > $PlayoffPro['HomeWin'] AND $PlayoffPro['VisitorWin'] == 4 ){echo "<span>" . $PlayoffPro['VisitorTeamName'] . " wins " . $PlayoffPro['VisitorWin'] . "-" . $PlayoffPro['HomeWin'] ."</span>";}
											elseif ($PlayoffPro['VisitorWin'] > $PlayoffPro['HomeWin']){echo "<span>" . $PlayoffPro['VisitorTeamName'] . " leads " . $PlayoffPro['VisitorWin'] . "-" . $PlayoffPro['HomeWin'] ."</span>";}else {echo "";}?></div>
											
											
											<div class="series-status western pacific round-1 series-top">												<?php $Query = "SELECT PlayoffPro.*, TeamInfoHome.Abbre as HomeTeamName, TeamInfoVisitor.Abbre as VisitorTeamName FROM (PlayoffPro INNER JOIN TeamProInfo AS TeamInfoHome ON PlayoffPro.HomeTeam = TeamInfoHome.Number) LEFT JOIN TeamProInfo AS TeamInfoVisitor ON PlayoffPro.VisitorTeam = TeamInfoVisitor.Number WHERE PlayoffPro.Number = 7";$PlayoffPro = $db->querySingle($Query,true);
 											if ($PlayoffPro['HomeWin'] > $PlayoffPro['VisitorWin'] AND $PlayoffPro['HomeWin'] == 4 ){echo "<span>" . $PlayoffPro['HomeTeamName'] . " wins " . $PlayoffPro['HomeWin'] . "-" . $PlayoffPro['VisitorWin'] ."</span>";}
 											elseif ($PlayoffPro['HomeWin'] > $PlayoffPro['VisitorWin']){echo "<span>" . $PlayoffPro['HomeTeamName'] . " leads " . $PlayoffPro['HomeWin'] . "-" . $PlayoffPro['VisitorWin'] ."</span>";}
    										elseif ($PlayoffPro['VisitorWin'] === $PlayoffPro['HomeWin']){echo "<span>" .  "Series tied " . $PlayoffPro['VisitorWin'] . "-" . $PlayoffPro['HomeWin'] ."</span>";}
  											elseif ($PlayoffPro['VisitorWin'] > $PlayoffPro['HomeWin'] AND $PlayoffPro['VisitorWin'] == 4 ){echo "<span>" . $PlayoffPro['VisitorTeamName'] . " wins " . $PlayoffPro['VisitorWin'] . "-" . $PlayoffPro['HomeWin'] ."</span>";}
											elseif ($PlayoffPro['VisitorWin'] > $PlayoffPro['HomeWin']){echo "<span>" . $PlayoffPro['VisitorTeamName'] . " leads " . $PlayoffPro['VisitorWin'] . "-" . $PlayoffPro['HomeWin'] ."</span>";}else {echo "";}?></div>
											
											
											<div class="series-status western pacific round-1 series-bottom">												<?php $Query = "SELECT PlayoffPro.*, TeamInfoHome.Abbre as HomeTeamName, TeamInfoVisitor.Abbre as VisitorTeamName FROM (PlayoffPro INNER JOIN TeamProInfo AS TeamInfoHome ON PlayoffPro.HomeTeam = TeamInfoHome.Number) LEFT JOIN TeamProInfo AS TeamInfoVisitor ON PlayoffPro.VisitorTeam = TeamInfoVisitor.Number WHERE PlayoffPro.Number = 8";$PlayoffPro = $db->querySingle($Query,true);
 											if ($PlayoffPro['HomeWin'] > $PlayoffPro['VisitorWin'] AND $PlayoffPro['HomeWin'] == 4 ){echo "<span>" . $PlayoffPro['HomeTeamName'] . " wins " . $PlayoffPro['HomeWin'] . "-" . $PlayoffPro['VisitorWin'] ."</span>";}
 											elseif ($PlayoffPro['HomeWin'] > $PlayoffPro['VisitorWin']){echo "<span>" . $PlayoffPro['HomeTeamName'] . " leads " . $PlayoffPro['HomeWin'] . "-" . $PlayoffPro['VisitorWin'] ."</span>";}
     										elseif ($PlayoffPro['VisitorWin'] === $PlayoffPro['HomeWin']){echo "<span>" .  "Series tied " . $PlayoffPro['VisitorWin'] . "-" . $PlayoffPro['HomeWin'] ."</span>";}
 											elseif ($PlayoffPro['VisitorWin'] > $PlayoffPro['HomeWin'] AND $PlayoffPro['VisitorWin'] == 4 ){echo "<span>" . $PlayoffPro['VisitorTeamName'] . " wins " . $PlayoffPro['VisitorWin'] . "-" . $PlayoffPro['HomeWin'] ."</span>";}
											elseif ($PlayoffPro['VisitorWin'] > $PlayoffPro['HomeWin']){echo "<span>" . $PlayoffPro['VisitorTeamName'] . " leads " . $PlayoffPro['VisitorWin'] . "-" . $PlayoffPro['HomeWin'] ."</span>";}else {echo "";}?></div>
											
											
											<div class="series-status eastern atlantic round-2">											<?php $Query = "SELECT PlayoffPro.*, TeamInfoHome.Abbre as HomeTeamName, TeamInfoVisitor.Abbre as VisitorTeamName FROM (PlayoffPro INNER JOIN TeamProInfo AS TeamInfoHome ON PlayoffPro.HomeTeam = TeamInfoHome.Number) LEFT JOIN TeamProInfo AS TeamInfoVisitor ON PlayoffPro.VisitorTeam = TeamInfoVisitor.Number WHERE PlayoffPro.Number = 9";$PlayoffPro = $db->querySingle($Query,true);
 											if ($PlayoffPro['HomeWin'] > $PlayoffPro['VisitorWin'] AND $PlayoffPro['HomeWin'] == 4 ){echo "<span>" . $PlayoffPro['HomeTeamName'] . " wins " . $PlayoffPro['HomeWin'] . "-" . $PlayoffPro['VisitorWin'] ."</span>";}
 											elseif ($PlayoffPro['HomeWin'] > $PlayoffPro['VisitorWin']){echo "<span>" . $PlayoffPro['HomeTeamName'] . " leads " . $PlayoffPro['HomeWin'] . "-" . $PlayoffPro['VisitorWin'] ."</span>";}
      										elseif ($PlayoffPro['VisitorWin'] === $PlayoffPro['HomeWin']){echo "<span>" .  "Series tied " . $PlayoffPro['VisitorWin'] . "-" . $PlayoffPro['HomeWin'] ."</span>";}
											elseif ($PlayoffPro['VisitorWin'] > $PlayoffPro['HomeWin'] AND $PlayoffPro['VisitorWin'] == 4 ){echo "<span>" . $PlayoffPro['VisitorTeamName'] . " wins " . $PlayoffPro['VisitorWin'] . "-" . $PlayoffPro['HomeWin'] ."</span>";}
											elseif ($PlayoffPro['VisitorWin'] > $PlayoffPro['HomeWin']){echo "<span>" . $PlayoffPro['VisitorTeamName'] . " leads " . $PlayoffPro['VisitorWin'] . "-" . $PlayoffPro['HomeWin'] ."</span>";}else {echo "";}?></div>
											
											
											<div class="series-status eastern metropolitan round-2">											<?php $Query = "SELECT PlayoffPro.*, TeamInfoHome.Abbre as HomeTeamName, TeamInfoVisitor.Abbre as VisitorTeamName FROM (PlayoffPro INNER JOIN TeamProInfo AS TeamInfoHome ON PlayoffPro.HomeTeam = TeamInfoHome.Number) LEFT JOIN TeamProInfo AS TeamInfoVisitor ON PlayoffPro.VisitorTeam = TeamInfoVisitor.Number WHERE PlayoffPro.Number = 10";$PlayoffPro = $db->querySingle($Query,true);
 											if ($PlayoffPro['HomeWin'] > $PlayoffPro['VisitorWin'] AND $PlayoffPro['HomeWin'] == 4 ){echo "<span>" . $PlayoffPro['HomeTeamName'] . " wins " . $PlayoffPro['HomeWin'] . "-" . $PlayoffPro['VisitorWin'] ."</span>";}
 											elseif ($PlayoffPro['HomeWin'] > $PlayoffPro['VisitorWin']){echo "<span>" . $PlayoffPro['HomeTeamName'] . " leads " . $PlayoffPro['HomeWin'] . "-" . $PlayoffPro['VisitorWin'] ."</span>";}
      										elseif ($PlayoffPro['VisitorWin'] === $PlayoffPro['HomeWin']){echo "<span>" .  "Series tied " . $PlayoffPro['VisitorWin'] . "-" . $PlayoffPro['HomeWin'] ."</span>";}
											elseif ($PlayoffPro['VisitorWin'] > $PlayoffPro['HomeWin'] AND $PlayoffPro['VisitorWin'] == 4 ){echo "<span>" . $PlayoffPro['VisitorTeamName'] . " wins " . $PlayoffPro['VisitorWin'] . "-" . $PlayoffPro['HomeWin'] ."</span>";}
											elseif ($PlayoffPro['VisitorWin'] > $PlayoffPro['HomeWin']){echo "<span>" . $PlayoffPro['VisitorTeamName'] . " leads " . $PlayoffPro['VisitorWin'] . "-" . $PlayoffPro['HomeWin'] ."</span>";}else {echo "";}?></div>
											
											
											<div class="series-status western central round-2">											<?php $Query = "SELECT PlayoffPro.*, TeamInfoHome.Abbre as HomeTeamName, TeamInfoVisitor.Abbre as VisitorTeamName FROM (PlayoffPro INNER JOIN TeamProInfo AS TeamInfoHome ON PlayoffPro.HomeTeam = TeamInfoHome.Number) LEFT JOIN TeamProInfo AS TeamInfoVisitor ON PlayoffPro.VisitorTeam = TeamInfoVisitor.Number WHERE PlayoffPro.Number = 11";$PlayoffPro = $db->querySingle($Query,true);
 											if ($PlayoffPro['HomeWin'] > $PlayoffPro['VisitorWin'] AND $PlayoffPro['HomeWin'] == 4 ){echo "<span>" . $PlayoffPro['HomeTeamName'] . " wins " . $PlayoffPro['HomeWin'] . "-" . $PlayoffPro['VisitorWin'] ."</span>";}
 											elseif ($PlayoffPro['HomeWin'] > $PlayoffPro['VisitorWin']){echo "<span>" . $PlayoffPro['HomeTeamName'] . " leads " . $PlayoffPro['HomeWin'] . "-" . $PlayoffPro['VisitorWin'] ."</span>";}
      										elseif ($PlayoffPro['VisitorWin'] === $PlayoffPro['HomeWin']){echo "<span>" .  "Series tied " . $PlayoffPro['VisitorWin'] . "-" . $PlayoffPro['HomeWin'] ."</span>";}
											elseif ($PlayoffPro['VisitorWin'] > $PlayoffPro['HomeWin'] AND $PlayoffPro['VisitorWin'] == 4 ){echo "<span>" . $PlayoffPro['VisitorTeamName'] . " wins " . $PlayoffPro['VisitorWin'] . "-" . $PlayoffPro['HomeWin'] ."</span>";}
											elseif ($PlayoffPro['VisitorWin'] > $PlayoffPro['HomeWin']){echo "<span>" . $PlayoffPro['VisitorTeamName'] . " leads " . $PlayoffPro['VisitorWin'] . "-" . $PlayoffPro['HomeWin'] ."</span>";}else {echo "";}?></div>
											
											
											<div class="series-status western pacific round-2">											<?php $Query = "SELECT PlayoffPro.*, TeamInfoHome.Abbre as HomeTeamName, TeamInfoVisitor.Abbre as VisitorTeamName FROM (PlayoffPro INNER JOIN TeamProInfo AS TeamInfoHome ON PlayoffPro.HomeTeam = TeamInfoHome.Number) LEFT JOIN TeamProInfo AS TeamInfoVisitor ON PlayoffPro.VisitorTeam = TeamInfoVisitor.Number WHERE PlayoffPro.Number = 12";$PlayoffPro = $db->querySingle($Query,true);
 											if ($PlayoffPro['HomeWin'] > $PlayoffPro['VisitorWin'] AND $PlayoffPro['HomeWin'] == 4 ){echo "<span>" . $PlayoffPro['HomeTeamName'] . " wins " . $PlayoffPro['HomeWin'] . "-" . $PlayoffPro['VisitorWin'] ."</span>";}
 											elseif ($PlayoffPro['HomeWin'] > $PlayoffPro['VisitorWin']){echo "<span>" . $PlayoffPro['HomeTeamName'] . " leads " . $PlayoffPro['HomeWin'] . "-" . $PlayoffPro['VisitorWin'] ."</span>";}
     										elseif ($PlayoffPro['VisitorWin'] === $PlayoffPro['HomeWin']){echo "<span>" .  "Series tied " . $PlayoffPro['VisitorWin'] . "-" . $PlayoffPro['HomeWin'] ."</span>";}
 											elseif ($PlayoffPro['VisitorWin'] > $PlayoffPro['HomeWin'] AND $PlayoffPro['VisitorWin'] == 4 ){echo "<span>" . $PlayoffPro['VisitorTeamName'] . " wins " . $PlayoffPro['VisitorWin'] . "-" . $PlayoffPro['HomeWin'] ."</span>";}
											elseif ($PlayoffPro['VisitorWin'] > $PlayoffPro['HomeWin']){echo "<span>" . $PlayoffPro['VisitorTeamName'] . " leads " . $PlayoffPro['VisitorWin'] . "-" . $PlayoffPro['HomeWin'] ."</span>";}else {echo "";}?></div>
											
											
											<div class="series-status eastern round-3">											<?php $Query = "SELECT PlayoffPro.*, TeamInfoHome.Abbre as HomeTeamName, TeamInfoVisitor.Abbre as VisitorTeamName FROM (PlayoffPro INNER JOIN TeamProInfo AS TeamInfoHome ON PlayoffPro.HomeTeam = TeamInfoHome.Number) LEFT JOIN TeamProInfo AS TeamInfoVisitor ON PlayoffPro.VisitorTeam = TeamInfoVisitor.Number WHERE PlayoffPro.Number = 13";$PlayoffPro = $db->querySingle($Query,true);
 											if ($PlayoffPro['HomeWin'] > $PlayoffPro['VisitorWin'] AND $PlayoffPro['HomeWin'] == 4 ){echo "<span>" . $PlayoffPro['HomeTeamName'] . " wins " . $PlayoffPro['HomeWin'] . "-" . $PlayoffPro['VisitorWin'] ."</span>";}
 											elseif ($PlayoffPro['HomeWin'] > $PlayoffPro['VisitorWin']){echo "<span>" . $PlayoffPro['HomeTeamName'] . " leads " . $PlayoffPro['HomeWin'] . "-" . $PlayoffPro['VisitorWin'] ."</span>";}
     										elseif ($PlayoffPro['VisitorWin'] === $PlayoffPro['HomeWin']){echo "<span>" .  "Series tied " . $PlayoffPro['VisitorWin'] . "-" . $PlayoffPro['HomeWin'] ."</span>";}
 											elseif ($PlayoffPro['VisitorWin'] > $PlayoffPro['HomeWin'] AND $PlayoffPro['VisitorWin'] == 4 ){echo "<span>" . $PlayoffPro['VisitorTeamName'] . " wins " . $PlayoffPro['VisitorWin'] . "-" . $PlayoffPro['HomeWin'] ."</span>";}
											elseif ($PlayoffPro['VisitorWin'] > $PlayoffPro['HomeWin']){echo "<span>" . $PlayoffPro['VisitorTeamName'] . " leads " . $PlayoffPro['VisitorWin'] . "-" . $PlayoffPro['HomeWin'] ."</span>";}else {echo "";}?></div>
											
											
											<div class="series-status western round-3">											<?php $Query = "SELECT PlayoffPro.*, TeamInfoHome.Abbre as HomeTeamName, TeamInfoVisitor.Abbre as VisitorTeamName FROM (PlayoffPro INNER JOIN TeamProInfo AS TeamInfoHome ON PlayoffPro.HomeTeam = TeamInfoHome.Number) LEFT JOIN TeamProInfo AS TeamInfoVisitor ON PlayoffPro.VisitorTeam = TeamInfoVisitor.Number WHERE PlayoffPro.Number = 14";$PlayoffPro = $db->querySingle($Query,true);
 											if ($PlayoffPro['HomeWin'] > $PlayoffPro['VisitorWin'] AND $PlayoffPro['HomeWin'] == 4 ){echo "<span>" . $PlayoffPro['HomeTeamName'] . " wins " . $PlayoffPro['HomeWin'] . "-" . $PlayoffPro['VisitorWin'] ."</span>";}
 											elseif ($PlayoffPro['HomeWin'] > $PlayoffPro['VisitorWin']){echo "<span>" . $PlayoffPro['HomeTeamName'] . " leads " . $PlayoffPro['HomeWin'] . "-" . $PlayoffPro['VisitorWin'] ."</span>";}
     										elseif ($PlayoffPro['VisitorWin'] === $PlayoffPro['HomeWin']){echo "<span>" .  "Series tied " . $PlayoffPro['VisitorWin'] . "-" . $PlayoffPro['HomeWin'] ."</span>";}
 											elseif ($PlayoffPro['VisitorWin'] > $PlayoffPro['HomeWin'] AND $PlayoffPro['VisitorWin'] == 4 ){echo "<span>" . $PlayoffPro['VisitorTeamName'] . " wins " . $PlayoffPro['VisitorWin'] . "-" . $PlayoffPro['HomeWin'] ."</span>";}
											elseif ($PlayoffPro['VisitorWin'] > $PlayoffPro['HomeWin']){echo "<span>" . $PlayoffPro['VisitorTeamName'] . " leads " . $PlayoffPro['VisitorWin'] . "-" . $PlayoffPro['HomeWin'] ."</span>";}else {echo "";}?></div>
											
											
											<div class="series-status round-4">
																				<?php $Query = "SELECT PlayoffPro.*, TeamInfoHome.City as HomeTeamName, TeamInfoVisitor.City as VisitorTeamName FROM (PlayoffPro INNER JOIN TeamProInfo AS TeamInfoHome ON PlayoffPro.HomeTeam = TeamInfoHome.Number) LEFT JOIN TeamProInfo AS TeamInfoVisitor ON PlayoffPro.VisitorTeam = TeamInfoVisitor.Number WHERE PlayoffPro.Number = 15";$PlayoffPro = $db->querySingle($Query,true);
 											if ($PlayoffPro['HomeWin'] > $PlayoffPro['VisitorWin'] AND $PlayoffPro['HomeWin'] == 4 ){echo "<span>" . $PlayoffPro['HomeTeamName'] . " wins Stanley Cup " . $PlayoffPro['HomeWin'] . "-" . $PlayoffPro['VisitorWin'] ."</span>";}
 											elseif ($PlayoffPro['HomeWin'] > $PlayoffPro['VisitorWin']){echo "<span>" . $PlayoffPro['HomeTeamName'] . " leads " . $PlayoffPro['HomeWin'] . "-" . $PlayoffPro['VisitorWin'] ."</span>";}
     										elseif ($PlayoffPro['VisitorWin'] === $PlayoffPro['HomeWin']){echo "<span>" .  "Series tied " . $PlayoffPro['VisitorWin'] . "-" . $PlayoffPro['HomeWin'] ."</span>";}
 											elseif ($PlayoffPro['VisitorWin'] > $PlayoffPro['HomeWin'] AND $PlayoffPro['VisitorWin'] == 4 ){echo "<span>" . $PlayoffPro['VisitorTeamName'] . " wins Stanley Cup " . $PlayoffPro['VisitorWin'] . "-" . $PlayoffPro['HomeWin'] ."</span>";}
											elseif ($PlayoffPro['VisitorWin'] > $PlayoffPro['HomeWin']){echo "<span>" . $PlayoffPro['VisitorTeamName'] . " leads " . $PlayoffPro['VisitorWin'] . "-" . $PlayoffPro['HomeWin'] ."</span>";}else {echo "";}?></div>
											

											<div class="bracket-rank eastern atlantic rank-1">(1)</div>
											<div class="bracket-rank eastern atlantic rank-wc">(WC)</div>
											<div class="bracket-rank eastern atlantic rank-2">(2)</div>
											<div class="bracket-rank eastern atlantic rank-3">(3)</div>
											<div class="bracket-rank eastern metropolitan rank-1">(1)</div>
											<div class="bracket-rank eastern metropolitan rank-wc">(WC)</div>
											<div class="bracket-rank eastern metropolitan rank-2">(2)</div>
											<div class="bracket-rank eastern metropolitan rank-3">(3)</div>
											<div class="bracket-rank western central rank-1">(1)</div>
											<div class="bracket-rank western central rank-wc">(WC)</div>
											<div class="bracket-rank western central rank-2">(2)</div>
											<div class="bracket-rank western central rank-3">(3)</div>
											<div class="bracket-rank western pacific rank-1">(1)</div>
											<div class="bracket-rank western pacific rank-wc">(WC)</div>
											<div class="bracket-rank western pacific rank-2">(2)</div>
											<div class="bracket-rank western pacific rank-3">(3)</div>
										</div>
									</td>
								</tr>
							</tbody></table>
						</div>
					</div>
								</div></div>






<div class="tabmain active"  id="tabmain6"  style="display:<?php if ($TypeText == Pro){echo "none";}?>">
<h1 style="text-align: left;    font-size: 30px;text-transform:uppercase; font-weight:bold;   color:#2b2c2d;font-size:16px">Calder Cup Playoffs</h1>
<?php
	$Query = "SELECT * FROM PlayoffFarm";
	$PlayoffStanding = $db->query($Query);
?>

<div class="row">
									<div class="col-lg-12">
						<div class="standing-playoffs">
							<table class="table table-condensed" style="width:100%">
								<tbody>
								<tr>
									<td colspan="2">
											<div class="bracket-container">
											<div class="center-logo-container" id="center-logo-container">
												<img class="center-logo" src="/images/CalderCup.png" style="padding-left:0px"></div>
											<div class="bracket-box western division-upper matchup-upper round-1"></div>
											<div class="bracket-box western division-upper matchup-lower round-1"></div>
											<div class="bracket-box western division-lower matchup-upper round-1"></div>
											<div class="bracket-box western division-lower matchup-lower round-1"></div>
											<div class="bracket-box eastern division-upper matchup-upper round-1"></div>
											<div class="bracket-box eastern division-upper matchup-lower round-1"></div>
											<div class="bracket-box eastern division-lower matchup-upper round-1"></div>
											<div class="bracket-box eastern division-lower matchup-lower round-1"></div>
											<div class="bracket-box western division-upper round-2"></div>
											<div class="bracket-box western division-lower round-2"></div>
											<div class="bracket-box eastern division-upper round-2"></div>
											<div class="bracket-box eastern division-lower round-2"></div>
											<div class="bracket-box western round-3"></div>
											<div class="bracket-box eastern round-3"></div>
											<div class="bracket-box western round-4"></div>
											<div class="bracket-box eastern round-4"></div>
											<div class="bracket-slot eastern atlantic round-1 rank-1">
												<a href="/ProTeam.php?Team=3" target="_blank"><div class="bracket-slot-content logo-round-team logo-bg--Farmteam-<?php $Query = "SELECT * FROM PlayoffFarm WHERE PlayoffFarm.Number = 1";$PlayoffFarm = $db->querySingle($Query,true);echo $PlayoffFarm['HomeTeam'];?>"></div></a></div>
											<div class="bracket-slot eastern atlantic round-1 rank-wc">
												<a href="/ProTeam.php?Team=19" target="_blank"><div class="bracket-slot-content logo-round-team logo-bg--Farmteam-<?php $Query = "SELECT * FROM PlayoffFarm WHERE PlayoffFarm.Number = 1";$PlayoffFarm = $db->querySingle($Query,true);echo $PlayoffFarm['VisitorTeam'];?>"></div></a></div>
											<div class="bracket-slot eastern atlantic round-1 rank-2">
												<a href="/ProTeam.php?Team=29" target="_blank"><div class="bracket-slot-content logo-round-team logo-bg--Farmteam-<?php $Query = "SELECT * FROM PlayoffFarm WHERE PlayoffFarm.Number = 2";$PlayoffFarm = $db->querySingle($Query,true);echo $PlayoffFarm['HomeTeam'];?>"></div></a></div>
											<div class="bracket-slot eastern atlantic round-1 rank-3">
												<a href="/ProTeam.php?Team=1" target="_blank"><div class="bracket-slot-content logo-round-team logo-bg--Farmteam-<?php $Query = "SELECT * FROM PlayoffFarm WHERE PlayoffFarm.Number = 2";$PlayoffFarm = $db->querySingle($Query,true);echo $PlayoffFarm['VisitorTeam'];?>"></div></a></div>
											<div class="bracket-slot eastern metropolitan round-1 rank-1">
												<a href="/ProTeam.php?Team=15" target="_blank"><div class="bracket-slot-content logo-round-team logo-bg--Farmteam-<?php $Query = "SELECT * FROM PlayoffFarm WHERE PlayoffFarm.Number = 3";$PlayoffFarm = $db->querySingle($Query,true);echo $PlayoffFarm['HomeTeam'];?>"></div></a></div>
											<div class="bracket-slot eastern metropolitan round-1 rank-wc">
												<a href="/ProTeam.php?Team=27" target="_blank"><div class="bracket-slot-content logo-round-team logo-bg--Farmteam-<?php $Query = "SELECT * FROM PlayoffFarm WHERE PlayoffFarm.Number = 3";$PlayoffFarm = $db->querySingle($Query,true);echo $PlayoffFarm['VisitorTeam'];?>"></div></a></div>
											<div class="bracket-slot eastern metropolitan round-1 rank-2">
												<a href="/ProTeam.php?Team=7" target="_blank"><div class="bracket-slot-content logo-round-team logo-bg--Farmteam-<?php $Query = "SELECT * FROM PlayoffFarm WHERE PlayoffFarm.Number = 4";$PlayoffFarm = $db->querySingle($Query,true);echo $PlayoffFarm['HomeTeam'];?>"></div></a></div>
											<div class="bracket-slot eastern metropolitan round-1 rank-3">
												<a href="/ProTeam.php?Team=9" target="_blank"><div class="bracket-slot-content logo-round-team logo-bg--Farmteam-<?php $Query = "SELECT * FROM PlayoffFarm WHERE PlayoffFarm.Number = 4";$PlayoffFarm = $db->querySingle($Query,true);echo $PlayoffFarm['VisitorTeam'];?>"></div></a></div>
											<div class="bracket-slot western central round-1 rank-1">
												<a href="/ProTeam.php?Team=2" target="_blank"><div class="bracket-slot-content logo-round-team logo-bg--Farmteam-<?php $Query = "SELECT * FROM PlayoffFarm WHERE PlayoffFarm.Number = 5";$PlayoffFarm = $db->querySingle($Query,true);echo $PlayoffFarm['HomeTeam'];?>"></div></a></div>
											<div class="bracket-slot western central round-1 rank-wc">
												<a href="/ProTeam.php?Team=8" target="_blank"><div class="bracket-slot-content logo-round-team logo-bg--Farmteam-<?php $Query = "SELECT * FROM PlayoffFarm WHERE PlayoffFarm.Number = 5";$PlayoffFarm = $db->querySingle($Query,true);echo $PlayoffFarm['VisitorTeam'];?>"></div></a></div>
											<div class="bracket-slot western central round-1 rank-2">
												<a href="/ProTeam.php?Team=6" target="_blank"><div class="bracket-slot-content logo-round-team logo-bg--Farmteam-<?php $Query = "SELECT * FROM PlayoffFarm WHERE PlayoffFarm.Number = 6";$PlayoffFarm = $db->querySingle($Query,true);echo $PlayoffFarm['HomeTeam'];?>"></div></a></div>
											<div class="bracket-slot western central round-1 rank-3">
												<a href="/ProTeam.php?Team=11" target="_blank"><div class="bracket-slot-content logo-round-team logo-bg--Farmteam-<?php $Query = "SELECT * FROM PlayoffFarm WHERE PlayoffFarm.Number = 6";$PlayoffFarm = $db->querySingle($Query,true);echo $PlayoffFarm['VisitorTeam'];?>"></div></a></div>
											<div class="bracket-slot western pacific round-1 rank-1">
												<a href="/ProTeam.php?Team=14" target="_blank"><div class="bracket-slot-content logo-round-team logo-bg--Farmteam-<?php $Query = "SELECT * FROM PlayoffFarm WHERE PlayoffFarm.Number = 7";$PlayoffFarm = $db->querySingle($Query,true);echo $PlayoffFarm['HomeTeam'];?>"></div></a></div>
											<div class="bracket-slot western pacific round-1 rank-wc">
												<a href="/ProTeam.php?Team=12" target="_blank"><div class="bracket-slot-content logo-round-team logo-bg--Farmteam-<?php $Query = "SELECT * FROM PlayoffFarm WHERE PlayoffFarm.Number = 7";$PlayoffFarm = $db->querySingle($Query,true);echo $PlayoffFarm['VisitorTeam'];?>"></div></a></div>
											<div class="bracket-slot western pacific round-1 rank-2">
												<a href="/ProTeam.php?Team=20" target="_blank"><div class="bracket-slot-content logo-round-team logo-bg--Farmteam-<?php $Query = "SELECT * FROM PlayoffFarm WHERE PlayoffFarm.Number = 8";$PlayoffFarm = $db->querySingle($Query,true);echo $PlayoffFarm['HomeTeam'];?>"></div></a></div>
											<div class="bracket-slot western pacific round-1 rank-3">
												<a href="/ProTeam.php?Team=31" target="_blank"><div class="bracket-slot-content logo-round-team logo-bg--Farmteam-<?php $Query = "SELECT * FROM PlayoffFarm WHERE PlayoffFarm.Number = 8";$PlayoffFarm = $db->querySingle($Query,true);echo $PlayoffFarm['VisitorTeam'];?>"></div></a></div>
											<div class="bracket-slot eastern atlantic round-2 team-upper">
												<a href="/ProTeam.php?Team=3" target="_blank"><div class="bracket-slot-content logo-round-team logo-bg--Farmteam-<?php $Query = "SELECT * FROM PlayoffFarm WHERE PlayoffFarm.Number = 1";$PlayoffFarm = $db->querySingle($Query,true);
												if ($PlayoffFarm['HomeWin'] == 4){echo $PlayoffFarm['HomeTeam'];}elseif ($PlayoffFarm['VisitorWin'] == 4){echo $PlayoffFarm['VisitorTeam'];}else{echo "";};?>"></div></a></div>
											<div class="bracket-slot eastern atlantic round-2 team-lower">
												<a href="/ProTeam.php?Team=1" target="_blank"><div class="bracket-slot-content logo-round-team logo-bg--Farmteam-<?php $Query = "SELECT * FROM PlayoffFarm WHERE PlayoffFarm.Number = 2";$PlayoffFarm = $db->querySingle($Query,true);
												if ($PlayoffFarm['HomeWin'] == 4){echo $PlayoffFarm['HomeTeam'];}elseif ($PlayoffFarm['VisitorWin'] == 4){echo $PlayoffFarm['VisitorTeam'];}else{echo "";};?>"></div></a></div>
											<div class="bracket-slot eastern metropolitan round-2 team-upper">
												<a href="/ProTeam.php?Team=23" target="_blank"><div class="bracket-slot-content logo-round-team logo-bg--Farmteam-<?php $Query = "SELECT * FROM PlayoffFarm WHERE PlayoffFarm.Number = 3";$PlayoffFarm = $db->querySingle($Query,true);
												if ($PlayoffFarm['HomeWin'] == 4){echo $PlayoffFarm['HomeTeam'];}elseif ($PlayoffFarm['VisitorWin'] == 4){echo $PlayoffFarm['VisitorTeam'];}else{echo "";};?>"></div></a></div>
											<div class="bracket-slot eastern metropolitan round-2 team-lower">
												<a href="/ProTeam.php?Team=9" target="_blank"><div class="bracket-slot-content logo-round-team logo-bg--Farmteam-<?php $Query = "SELECT * FROM PlayoffFarm WHERE PlayoffFarm.Number = 4";$PlayoffFarm = $db->querySingle($Query,true);
												if ($PlayoffFarm['HomeWin'] == 4){echo $PlayoffFarm['HomeTeam'];}elseif ($PlayoffFarm['VisitorWin'] == 4){echo $PlayoffFarm['VisitorTeam'];}else{echo "";};?>"></div></a></div>
											<div class="bracket-slot western central round-2 team-upper">
												<a href="/ProTeam.php?Team=26" target="_blank"><div class="bracket-slot-content logo-round-team logo-bg--Farmteam-<?php $Query = "SELECT * FROM PlayoffFarm WHERE PlayoffFarm.Number = 5";$PlayoffFarm = $db->querySingle($Query,true);
												if ($PlayoffFarm['HomeWin'] == 4){echo $PlayoffFarm['HomeTeam'];}elseif ($PlayoffFarm['VisitorWin'] == 4){echo $PlayoffFarm['VisitorTeam'];}else{echo "";};?>"></div></a></div>
											<div class="bracket-slot western central round-2 team-lower">
												<a href="/ProTeam.php?Team=16" target="_blank"><div class="bracket-slot-content logo-round-team logo-bg--Farmteam-<?php $Query = "SELECT * FROM PlayoffFarm WHERE PlayoffFarm.Number = 6";$PlayoffFarm = $db->querySingle($Query,true);
												if ($PlayoffFarm['HomeWin'] == 4){echo $PlayoffFarm['HomeTeam'];}elseif ($PlayoffFarm['VisitorWin'] == 4){echo $PlayoffFarm['VisitorTeam'];}else{echo "";};?>"></div></a></div>
											<div class="bracket-slot western pacific round-2 team-upper">
												<a href="/ProTeam.php?Team=8" target="_blank"><div class="bracket-slot-content logo-round-team logo-bg--Farmteam-<?php $Query = "SELECT * FROM PlayoffFarm WHERE PlayoffFarm.Number = 7";$PlayoffFarm = $db->querySingle($Query,true);
												if ($PlayoffFarm['HomeWin'] == 4){echo $PlayoffFarm['HomeTeam'];}elseif ($PlayoffFarm['VisitorWin'] == 4){echo $PlayoffFarm['VisitorTeam'];}else{echo "";};?>"></div></a></div>
											<div class="bracket-slot western pacific round-2 team-lower">
												<a href="/ProTeam.php?Team=30" target="_blank"><div class="bracket-slot-content logo-round-team logo-bg--Farmteam-<?php $Query = "SELECT * FROM PlayoffFarm WHERE PlayoffFarm.Number = 8";$PlayoffFarm = $db->querySingle($Query,true);
												if ($PlayoffFarm['HomeWin'] == 4){echo $PlayoffFarm['HomeTeam'];}elseif ($PlayoffFarm['VisitorWin'] == 4){echo $PlayoffFarm['VisitorTeam'];}else{echo "";};?>"></div></a></div>
											<div class="bracket-slot eastern atlantic round-3">
												<a href="/ProTeam.php?Team=3" target="_blank"><div class="bracket-slot-content logo-round-team logo-bg--Farmteam-<?php $Query = "SELECT * FROM PlayoffFarm WHERE PlayoffFarm.Number = 9";$PlayoffFarm = $db->querySingle($Query,true);
												if ($PlayoffFarm['HomeWin'] == 4){echo $PlayoffFarm['HomeTeam'];}elseif ($PlayoffFarm['VisitorWin'] == 4){echo $PlayoffFarm['VisitorTeam'];}else{echo "";};?>"></div></a></div>
											<div class="bracket-slot eastern metropolitan round-3">
												<a href="/ProTeam.php?Team=22" target="_blank"><div class="bracket-slot-content logo-round-team logo-bg--Farmteam-<?php $Query = "SELECT * FROM PlayoffFarm WHERE PlayoffFarm.Number = 10";$PlayoffFarm = $db->querySingle($Query,true);
												if ($PlayoffFarm['HomeWin'] == 4){echo $PlayoffFarm['HomeTeam'];}elseif ($PlayoffFarm['VisitorWin'] == 4){echo $PlayoffFarm['VisitorTeam'];}else{echo "";};?>"></div></a></div>
											<div class="bracket-slot western central round-3">
												<a href="/ProTeam.php?Team=6" target="_blank"><div class="bracket-slot-content logo-round-team logo-bg--Farmteam-<?php $Query = "SELECT * FROM PlayoffFarm WHERE PlayoffFarm.Number = 11";$PlayoffFarm = $db->querySingle($Query,true);
												if ($PlayoffFarm['HomeWin'] == 4){echo $PlayoffFarm['HomeTeam'];}elseif ($PlayoffFarm['VisitorWin'] == 4){echo $PlayoffFarm['VisitorTeam'];}else{echo "";};?>"></div></a></div>
											<div class="bracket-slot western pacific round-3">
												<a href="/ProTeam.php?Team=31" target="_blank"><div class="bracket-slot-content logo-round-team logo-bg--Farmteam-<?php $Query = "SELECT * FROM PlayoffFarm WHERE PlayoffFarm.Number = 12";$PlayoffFarm = $db->querySingle($Query,true);
												if ($PlayoffFarm['HomeWin'] == 4){echo $PlayoffFarm['HomeTeam'];}elseif ($PlayoffFarm['VisitorWin'] == 4){echo $PlayoffFarm['VisitorTeam'];}else{echo "";};?>"></div></a></div>
											<div class="bracket-slot eastern round-4">
												<a href="/ProTeam.php?Team=22" target="_blank"><div class="bracket-slot-content logo-round-team logo-bg--Farmteam-<?php $Query = "SELECT * FROM PlayoffFarm WHERE PlayoffFarm.Number = 13";$PlayoffFarm = $db->querySingle($Query,true);
												if ($PlayoffFarm['HomeWin'] == 4){echo $PlayoffFarm['HomeTeam'];}elseif ($PlayoffFarm['VisitorWin'] == 4){echo $PlayoffFarm['VisitorTeam'];}else{echo "";};?>"></div></a></div>
											<div class="bracket-slot western round-4">
												<a href="/ProTeam.php?Team=6" target="_blank"><div class="bracket-slot-content logo-round-team logo-bg--Farmteam-<?php $Query = "SELECT * FROM PlayoffFarm WHERE PlayoffFarm.Number = 14";$PlayoffFarm = $db->querySingle($Query,true);
												if ($PlayoffFarm['HomeWin'] == 4){echo $PlayoffFarm['HomeTeam'];}elseif ($PlayoffFarm['VisitorWin'] == 4){echo $PlayoffFarm['VisitorTeam'];}else{echo "";};?>"></div></a></div>
											<div class="bracket-slot round-4-winner">
												<a href="/ProTeam.php?Team=6" target="_blank"><div class="bracket-slot-content logo-round-team logo-bg--Farmteam-<?php $Query = "SELECT * FROM PlayoffFarm WHERE PlayoffFarm.Number = 15";$PlayoffFarm = $db->querySingle($Query,true);
												if ($PlayoffFarm['HomeWin'] == 4){echo $PlayoffFarm['HomeTeam'];}elseif ($PlayoffFarm['VisitorWin'] == 4){echo $PlayoffFarm['VisitorTeam'];}else{echo "";};?>"></div></a></div>
											<div class="broadcaster-logo-container" id="broadcaster-logo-container" style="width:50%;margin:auto"><img class="broadcaster-logo" src="http://nhl.bamcontent.com/images/logos/league/cup-broadcasters-enca-v5.svg" ></div>
											<div class="series-status eastern atlantic round-1 series-top">
											<?php $Query = "SELECT PlayoffFarm.*, TeamInfoHome.Abbre as HomeTeamName, TeamInfoVisitor.Abbre as VisitorTeamName FROM (PlayoffFarm INNER JOIN TeamFarmInfo AS TeamInfoHome ON PlayoffFarm.HomeTeam = TeamInfoHome.Number) LEFT JOIN TeamFarmInfo AS TeamInfoVisitor ON PlayoffFarm.VisitorTeam = TeamInfoVisitor.Number WHERE PlayoffFarm.Number = 1";$PlayoffFarm = $db->querySingle($Query,true);
 											if ($PlayoffFarm['HomeWin'] > $PlayoffFarm['VisitorWin'] AND $PlayoffFarm['HomeWin'] == 4 ){echo "<span>" . $PlayoffFarm['HomeTeamName'] . " wins " . $PlayoffFarm['HomeWin'] . "-" . $PlayoffFarm['VisitorWin'] ."</span>";}
 											elseif ($PlayoffFarm['HomeWin'] > $PlayoffFarm['VisitorWin']){echo "<span>" . $PlayoffFarm['HomeTeamName'] . " leads " . $PlayoffFarm['HomeWin'] . "-" . $PlayoffFarm['VisitorWin'] ."</span>";}
    										elseif ($PlayoffFarm['VisitorWin'] === $PlayoffFarm['HomeWin']){echo "<span>" .  "Series tied " . $PlayoffFarm['VisitorWin'] . "-" . $PlayoffFarm['HomeWin'] ."</span>";}
											elseif ($PlayoffFarm['VisitorWin'] > $PlayoffFarm['HomeWin'] AND $PlayoffFarm['VisitorWin'] == 4 ){echo "<span>" . $PlayoffFarm['VisitorTeamName'] . " wins " . $PlayoffFarm['VisitorWin'] . "-" . $PlayoffFarm['HomeWin'] ."</span>";}
											elseif ($PlayoffFarm['VisitorWin'] > $PlayoffFarm['HomeWin']){echo "<span>" . $PlayoffFarm['VisitorTeamName'] . " leads " . $PlayoffFarm['VisitorWin'] . "-" . $PlayoffFarm['HomeWin'] ."</span>";}
											else {echo "";}?></div>
											
											
											<div class="series-status eastern atlantic round-1 series-bottom">											<?php $Query = "SELECT PlayoffFarm.*, TeamInfoHome.Abbre as HomeTeamName, TeamInfoVisitor.Abbre as VisitorTeamName FROM (PlayoffFarm INNER JOIN TeamFarmInfo AS TeamInfoHome ON PlayoffFarm.HomeTeam = TeamInfoHome.Number) LEFT JOIN TeamFarmInfo AS TeamInfoVisitor ON PlayoffFarm.VisitorTeam = TeamInfoVisitor.Number WHERE PlayoffFarm.Number = 2";$PlayoffFarm = $db->querySingle($Query,true);
 											if ($PlayoffFarm['HomeWin'] > $PlayoffFarm['VisitorWin'] AND $PlayoffFarm['HomeWin'] == 4 ){echo "<span>" . $PlayoffFarm['HomeTeamName'] . " wins " . $PlayoffFarm['HomeWin'] . "-" . $PlayoffFarm['VisitorWin'] ."</span>";}
 											elseif ($PlayoffFarm['HomeWin'] > $PlayoffFarm['VisitorWin']){echo "<span>" . $PlayoffFarm['HomeTeamName'] . " leads " . $PlayoffFarm['HomeWin'] . "-" . $PlayoffFarm['VisitorWin'] ."</span>";}
    										elseif ($PlayoffFarm['VisitorWin'] === $PlayoffFarm['HomeWin']){echo "<span>" .  "Series tied " . $PlayoffFarm['VisitorWin'] . "-" . $PlayoffFarm['HomeWin'] ."</span>";}
  											elseif ($PlayoffFarm['VisitorWin'] > $PlayoffFarm['HomeWin'] AND $PlayoffFarm['VisitorWin'] == 4 ){echo "<span>" . $PlayoffFarm['VisitorTeamName'] . " wins " . $PlayoffFarm['VisitorWin'] . "-" . $PlayoffFarm['HomeWin'] ."</span>";}
											elseif ($PlayoffFarm['VisitorWin'] > $PlayoffFarm['HomeWin']){echo "<span>" . $PlayoffFarm['VisitorTeamName'] . " leads " . $PlayoffFarm['VisitorWin'] . "-" . $PlayoffFarm['HomeWin'] ."</span>";}
											else {echo "";}?></div>
											
											
											<div class="series-status eastern metropolitan round-1 series-top">													<?php $Query = "SELECT PlayoffFarm.*, TeamInfoHome.Abbre as HomeTeamName, TeamInfoVisitor.Abbre as VisitorTeamName FROM (PlayoffFarm INNER JOIN TeamFarmInfo AS TeamInfoHome ON PlayoffFarm.HomeTeam = TeamInfoHome.Number) LEFT JOIN TeamFarmInfo AS TeamInfoVisitor ON PlayoffFarm.VisitorTeam = TeamInfoVisitor.Number WHERE PlayoffFarm.Number = 3";$PlayoffFarm = $db->querySingle($Query,true);
 											if ($PlayoffFarm['HomeWin'] > $PlayoffFarm['VisitorWin'] AND $PlayoffFarm['HomeWin'] == 4 ){echo "<span>" . $PlayoffFarm['HomeTeamName'] . " wins " . $PlayoffFarm['HomeWin'] . "-" . $PlayoffFarm['VisitorWin'] ."</span>";}
 											elseif ($PlayoffFarm['HomeWin'] > $PlayoffFarm['VisitorWin']){echo "<span>" . $PlayoffFarm['HomeTeamName'] . " leads " . $PlayoffFarm['HomeWin'] . "-" . $PlayoffFarm['VisitorWin'] ."</span>";}
     										elseif ($PlayoffFarm['VisitorWin'] === $PlayoffFarm['HomeWin']){echo "<span>" .  "Series tied " . $PlayoffFarm['VisitorWin'] . "-" . $PlayoffFarm['HomeWin'] ."</span>";}
 											elseif ($PlayoffFarm['VisitorWin'] > $PlayoffFarm['HomeWin'] AND $PlayoffFarm['VisitorWin'] == 4 ){echo "<span>" . $PlayoffFarm['VisitorTeamName'] . " wins " . $PlayoffFarm['VisitorWin'] . "-" . $PlayoffFarm['HomeWin'] ."</span>";}
											elseif ($PlayoffFarm['VisitorWin'] > $PlayoffFarm['HomeWin']){echo "<span>" . $PlayoffFarm['VisitorTeamName'] . " leads " . $PlayoffFarm['VisitorWin'] . "-" . $PlayoffFarm['HomeWin'] ."</span>";}else {echo "";}?></div>
											
											
											<div class="series-status eastern metropolitan round-1 series-bottom">													<?php $Query = "SELECT PlayoffFarm.*, TeamInfoHome.Abbre as HomeTeamName, TeamInfoVisitor.Abbre as VisitorTeamName FROM (PlayoffFarm INNER JOIN TeamFarmInfo AS TeamInfoHome ON PlayoffFarm.HomeTeam = TeamInfoHome.Number) LEFT JOIN TeamFarmInfo AS TeamInfoVisitor ON PlayoffFarm.VisitorTeam = TeamInfoVisitor.Number WHERE PlayoffFarm.Number = 4";$PlayoffFarm = $db->querySingle($Query,true);
 											if ($PlayoffFarm['HomeWin'] > $PlayoffFarm['VisitorWin'] AND $PlayoffFarm['HomeWin'] == 4 ){echo "<span>" . $PlayoffFarm['HomeTeamName'] . " wins " . $PlayoffFarm['HomeWin'] . "-" . $PlayoffFarm['VisitorWin'] ."</span>";}
 											elseif ($PlayoffFarm['HomeWin'] > $PlayoffFarm['VisitorWin']){echo "<span>" . $PlayoffFarm['HomeTeamName'] . " leads " . $PlayoffFarm['HomeWin'] . "-" . $PlayoffFarm['VisitorWin'] ."</span>";}
    										elseif ($PlayoffFarm['VisitorWin'] === $PlayoffFarm['HomeWin']){echo "<span>" .  "Series tied " . $PlayoffFarm['VisitorWin'] . "-" . $PlayoffFarm['HomeWin'] ."</span>";}
  											elseif ($PlayoffFarm['VisitorWin'] > $PlayoffFarm['HomeWin'] AND $PlayoffFarm['VisitorWin'] == 4 ){echo "<span>" . $PlayoffFarm['VisitorTeamName'] . " wins " . $PlayoffFarm['VisitorWin'] . "-" . $PlayoffFarm['HomeWin'] ."</span>";}
											elseif ($PlayoffFarm['VisitorWin'] > $PlayoffFarm['HomeWin']){echo "<span>" . $PlayoffFarm['VisitorTeamName'] . " leads " . $PlayoffFarm['VisitorWin'] . "-" . $PlayoffFarm['HomeWin'] ."</span>";}else {echo "";}?></div>
											
											
											<div class="series-status western central round-1 series-top">												<?php $Query = "SELECT PlayoffFarm.*, TeamInfoHome.Abbre as HomeTeamName, TeamInfoVisitor.Abbre as VisitorTeamName FROM (PlayoffFarm INNER JOIN TeamFarmInfo AS TeamInfoHome ON PlayoffFarm.HomeTeam = TeamInfoHome.Number) LEFT JOIN TeamFarmInfo AS TeamInfoVisitor ON PlayoffFarm.VisitorTeam = TeamInfoVisitor.Number WHERE PlayoffFarm.Number = 5";$PlayoffFarm = $db->querySingle($Query,true);
 											if ($PlayoffFarm['HomeWin'] > $PlayoffFarm['VisitorWin'] AND $PlayoffFarm['HomeWin'] == 4 ){echo "<span>" . $PlayoffFarm['HomeTeamName'] . " wins " . $PlayoffFarm['HomeWin'] . "-" . $PlayoffFarm['VisitorWin'] ."</span>";}
 											elseif ($PlayoffFarm['HomeWin'] > $PlayoffFarm['VisitorWin']){echo "<span>" . $PlayoffFarm['HomeTeamName'] . " leads " . $PlayoffFarm['HomeWin'] . "-" . $PlayoffFarm['VisitorWin'] ."</span>";}
     										elseif ($PlayoffFarm['VisitorWin'] === $PlayoffFarm['HomeWin']){echo "<span>" .  "Series tied " . $PlayoffFarm['VisitorWin'] . "-" . $PlayoffFarm['HomeWin'] ."</span>";}
 											elseif ($PlayoffFarm['VisitorWin'] > $PlayoffFarm['HomeWin'] AND $PlayoffFarm['VisitorWin'] == 4 ){echo "<span>" . $PlayoffFarm['VisitorTeamName'] . " wins " . $PlayoffFarm['VisitorWin'] . "-" . $PlayoffFarm['HomeWin'] ."</span>";}
											elseif ($PlayoffFarm['VisitorWin'] > $PlayoffFarm['HomeWin']){echo "<span>" . $PlayoffFarm['VisitorTeamName'] . " leads " . $PlayoffFarm['VisitorWin'] . "-" . $PlayoffFarm['HomeWin'] ."</span>";}else {echo "";}?></div>
											
											
											<div class="series-status western central round-1 series-bottom">												<?php $Query = "SELECT PlayoffFarm.*, TeamInfoHome.Abbre as HomeTeamName, TeamInfoVisitor.Abbre as VisitorTeamName FROM (PlayoffFarm INNER JOIN TeamFarmInfo AS TeamInfoHome ON PlayoffFarm.HomeTeam = TeamInfoHome.Number) LEFT JOIN TeamFarmInfo AS TeamInfoVisitor ON PlayoffFarm.VisitorTeam = TeamInfoVisitor.Number WHERE PlayoffFarm.Number = 6";$PlayoffFarm = $db->querySingle($Query,true);
 											if ($PlayoffFarm['HomeWin'] > $PlayoffFarm['VisitorWin'] AND $PlayoffFarm['HomeWin'] == 4 ){echo "<span>" . $PlayoffFarm['HomeTeamName'] . " wins " . $PlayoffFarm['HomeWin'] . "-" . $PlayoffFarm['VisitorWin'] ."</span>";}
 											elseif ($PlayoffFarm['HomeWin'] > $PlayoffFarm['VisitorWin']){echo "<span>" . $PlayoffFarm['HomeTeamName'] . " leads " . $PlayoffFarm['HomeWin'] . "-" . $PlayoffFarm['VisitorWin'] ."</span>";}
    										elseif ($PlayoffFarm['VisitorWin'] === $PlayoffFarm['HomeWin']){echo "<span>" .  "Series tied " . $PlayoffFarm['VisitorWin'] . "-" . $PlayoffFarm['HomeWin'] ."</span>";}
  											elseif ($PlayoffFarm['VisitorWin'] > $PlayoffFarm['HomeWin'] AND $PlayoffFarm['VisitorWin'] == 4 ){echo "<span>" . $PlayoffFarm['VisitorTeamName'] . " wins " . $PlayoffFarm['VisitorWin'] . "-" . $PlayoffFarm['HomeWin'] ."</span>";}
											elseif ($PlayoffFarm['VisitorWin'] > $PlayoffFarm['HomeWin']){echo "<span>" . $PlayoffFarm['VisitorTeamName'] . " leads " . $PlayoffFarm['VisitorWin'] . "-" . $PlayoffFarm['HomeWin'] ."</span>";}else {echo "";}?></div>
											
											
											<div class="series-status western pacific round-1 series-top">												<?php $Query = "SELECT PlayoffFarm.*, TeamInfoHome.Abbre as HomeTeamName, TeamInfoVisitor.Abbre as VisitorTeamName FROM (PlayoffFarm INNER JOIN TeamFarmInfo AS TeamInfoHome ON PlayoffFarm.HomeTeam = TeamInfoHome.Number) LEFT JOIN TeamFarmInfo AS TeamInfoVisitor ON PlayoffFarm.VisitorTeam = TeamInfoVisitor.Number WHERE PlayoffFarm.Number = 7";$PlayoffFarm = $db->querySingle($Query,true);
 											if ($PlayoffFarm['HomeWin'] > $PlayoffFarm['VisitorWin'] AND $PlayoffFarm['HomeWin'] == 4 ){echo "<span>" . $PlayoffFarm['HomeTeamName'] . " wins " . $PlayoffFarm['HomeWin'] . "-" . $PlayoffFarm['VisitorWin'] ."</span>";}
 											elseif ($PlayoffFarm['HomeWin'] > $PlayoffFarm['VisitorWin']){echo "<span>" . $PlayoffFarm['HomeTeamName'] . " leads " . $PlayoffFarm['HomeWin'] . "-" . $PlayoffFarm['VisitorWin'] ."</span>";}
    										elseif ($PlayoffFarm['VisitorWin'] === $PlayoffFarm['HomeWin']){echo "<span>" .  "Series tied " . $PlayoffFarm['VisitorWin'] . "-" . $PlayoffFarm['HomeWin'] ."</span>";}
  											elseif ($PlayoffFarm['VisitorWin'] > $PlayoffFarm['HomeWin'] AND $PlayoffFarm['VisitorWin'] == 4 ){echo "<span>" . $PlayoffFarm['VisitorTeamName'] . " wins " . $PlayoffFarm['VisitorWin'] . "-" . $PlayoffFarm['HomeWin'] ."</span>";}
											elseif ($PlayoffFarm['VisitorWin'] > $PlayoffFarm['HomeWin']){echo "<span>" . $PlayoffFarm['VisitorTeamName'] . " leads " . $PlayoffFarm['VisitorWin'] . "-" . $PlayoffFarm['HomeWin'] ."</span>";}else {echo "";}?></div>
											
											
											<div class="series-status western pacific round-1 series-bottom">												<?php $Query = "SELECT PlayoffFarm.*, TeamInfoHome.Abbre as HomeTeamName, TeamInfoVisitor.Abbre as VisitorTeamName FROM (PlayoffFarm INNER JOIN TeamFarmInfo AS TeamInfoHome ON PlayoffFarm.HomeTeam = TeamInfoHome.Number) LEFT JOIN TeamFarmInfo AS TeamInfoVisitor ON PlayoffFarm.VisitorTeam = TeamInfoVisitor.Number WHERE PlayoffFarm.Number = 8";$PlayoffFarm = $db->querySingle($Query,true);
 											if ($PlayoffFarm['HomeWin'] > $PlayoffFarm['VisitorWin'] AND $PlayoffFarm['HomeWin'] == 4 ){echo "<span>" . $PlayoffFarm['HomeTeamName'] . " wins " . $PlayoffFarm['HomeWin'] . "-" . $PlayoffFarm['VisitorWin'] ."</span>";}
 											elseif ($PlayoffFarm['HomeWin'] > $PlayoffFarm['VisitorWin']){echo "<span>" . $PlayoffFarm['HomeTeamName'] . " leads " . $PlayoffFarm['HomeWin'] . "-" . $PlayoffFarm['VisitorWin'] ."</span>";}
     										elseif ($PlayoffFarm['VisitorWin'] === $PlayoffFarm['HomeWin']){echo "<span>" .  "Series tied " . $PlayoffFarm['VisitorWin'] . "-" . $PlayoffFarm['HomeWin'] ."</span>";}
 											elseif ($PlayoffFarm['VisitorWin'] > $PlayoffFarm['HomeWin'] AND $PlayoffFarm['VisitorWin'] == 4 ){echo "<span>" . $PlayoffFarm['VisitorTeamName'] . " wins " . $PlayoffFarm['VisitorWin'] . "-" . $PlayoffFarm['HomeWin'] ."</span>";}
											elseif ($PlayoffFarm['VisitorWin'] > $PlayoffFarm['HomeWin']){echo "<span>" . $PlayoffFarm['VisitorTeamName'] . " leads " . $PlayoffFarm['VisitorWin'] . "-" . $PlayoffFarm['HomeWin'] ."</span>";}else {echo "";}?></div>
											
											
											<div class="series-status eastern atlantic round-2">											<?php $Query = "SELECT PlayoffFarm.*, TeamInfoHome.Abbre as HomeTeamName, TeamInfoVisitor.Abbre as VisitorTeamName FROM (PlayoffFarm INNER JOIN TeamFarmInfo AS TeamInfoHome ON PlayoffFarm.HomeTeam = TeamInfoHome.Number) LEFT JOIN TeamFarmInfo AS TeamInfoVisitor ON PlayoffFarm.VisitorTeam = TeamInfoVisitor.Number WHERE PlayoffFarm.Number = 9";$PlayoffFarm = $db->querySingle($Query,true);
 											if ($PlayoffFarm['HomeWin'] > $PlayoffFarm['VisitorWin'] AND $PlayoffFarm['HomeWin'] == 4 ){echo "<span>" . $PlayoffFarm['HomeTeamName'] . " wins " . $PlayoffFarm['HomeWin'] . "-" . $PlayoffFarm['VisitorWin'] ."</span>";}
 											elseif ($PlayoffFarm['HomeWin'] > $PlayoffFarm['VisitorWin']){echo "<span>" . $PlayoffFarm['HomeTeamName'] . " leads " . $PlayoffFarm['HomeWin'] . "-" . $PlayoffFarm['VisitorWin'] ."</span>";}
      										elseif ($PlayoffFarm['VisitorWin'] === $PlayoffFarm['HomeWin']){echo "<span>" .  "Series tied " . $PlayoffFarm['VisitorWin'] . "-" . $PlayoffFarm['HomeWin'] ."</span>";}
											elseif ($PlayoffFarm['VisitorWin'] > $PlayoffFarm['HomeWin'] AND $PlayoffFarm['VisitorWin'] == 4 ){echo "<span>" . $PlayoffFarm['VisitorTeamName'] . " wins " . $PlayoffFarm['VisitorWin'] . "-" . $PlayoffFarm['HomeWin'] ."</span>";}
											elseif ($PlayoffFarm['VisitorWin'] > $PlayoffFarm['HomeWin']){echo "<span>" . $PlayoffFarm['VisitorTeamName'] . " leads " . $PlayoffFarm['VisitorWin'] . "-" . $PlayoffFarm['HomeWin'] ."</span>";}else {echo "";}?></div>
											
											
											<div class="series-status eastern metropolitan round-2">											<?php $Query = "SELECT PlayoffFarm.*, TeamInfoHome.Abbre as HomeTeamName, TeamInfoVisitor.Abbre as VisitorTeamName FROM (PlayoffFarm INNER JOIN TeamFarmInfo AS TeamInfoHome ON PlayoffFarm.HomeTeam = TeamInfoHome.Number) LEFT JOIN TeamFarmInfo AS TeamInfoVisitor ON PlayoffFarm.VisitorTeam = TeamInfoVisitor.Number WHERE PlayoffFarm.Number = 10";$PlayoffFarm = $db->querySingle($Query,true);
 											if ($PlayoffFarm['HomeWin'] > $PlayoffFarm['VisitorWin'] AND $PlayoffFarm['HomeWin'] == 4 ){echo "<span>" . $PlayoffFarm['HomeTeamName'] . " wins " . $PlayoffFarm['HomeWin'] . "-" . $PlayoffFarm['VisitorWin'] ."</span>";}
 											elseif ($PlayoffFarm['HomeWin'] > $PlayoffFarm['VisitorWin']){echo "<span>" . $PlayoffFarm['HomeTeamName'] . " leads " . $PlayoffFarm['HomeWin'] . "-" . $PlayoffFarm['VisitorWin'] ."</span>";}
      										elseif ($PlayoffFarm['VisitorWin'] === $PlayoffFarm['HomeWin']){echo "<span>" .  "Series tied " . $PlayoffFarm['VisitorWin'] . "-" . $PlayoffFarm['HomeWin'] ."</span>";}
											elseif ($PlayoffFarm['VisitorWin'] > $PlayoffFarm['HomeWin'] AND $PlayoffFarm['VisitorWin'] == 4 ){echo "<span>" . $PlayoffFarm['VisitorTeamName'] . " wins " . $PlayoffFarm['VisitorWin'] . "-" . $PlayoffFarm['HomeWin'] ."</span>";}
											elseif ($PlayoffFarm['VisitorWin'] > $PlayoffFarm['HomeWin']){echo "<span>" . $PlayoffFarm['VisitorTeamName'] . " leads " . $PlayoffFarm['VisitorWin'] . "-" . $PlayoffFarm['HomeWin'] ."</span>";}else {echo "";}?></div>
											
											
											<div class="series-status western central round-2">											<?php $Query = "SELECT PlayoffFarm.*, TeamInfoHome.Abbre as HomeTeamName, TeamInfoVisitor.Abbre as VisitorTeamName FROM (PlayoffFarm INNER JOIN TeamFarmInfo AS TeamInfoHome ON PlayoffFarm.HomeTeam = TeamInfoHome.Number) LEFT JOIN TeamFarmInfo AS TeamInfoVisitor ON PlayoffFarm.VisitorTeam = TeamInfoVisitor.Number WHERE PlayoffFarm.Number = 11";$PlayoffFarm = $db->querySingle($Query,true);
 											if ($PlayoffFarm['HomeWin'] > $PlayoffFarm['VisitorWin'] AND $PlayoffFarm['HomeWin'] == 4 ){echo "<span>" . $PlayoffFarm['HomeTeamName'] . " wins " . $PlayoffFarm['HomeWin'] . "-" . $PlayoffFarm['VisitorWin'] ."</span>";}
 											elseif ($PlayoffFarm['HomeWin'] > $PlayoffFarm['VisitorWin']){echo "<span>" . $PlayoffFarm['HomeTeamName'] . " leads " . $PlayoffFarm['HomeWin'] . "-" . $PlayoffFarm['VisitorWin'] ."</span>";}
      										elseif ($PlayoffFarm['VisitorWin'] === $PlayoffFarm['HomeWin']){echo "<span>" .  "Series tied " . $PlayoffFarm['VisitorWin'] . "-" . $PlayoffFarm['HomeWin'] ."</span>";}
											elseif ($PlayoffFarm['VisitorWin'] > $PlayoffFarm['HomeWin'] AND $PlayoffFarm['VisitorWin'] == 4 ){echo "<span>" . $PlayoffFarm['VisitorTeamName'] . " wins " . $PlayoffFarm['VisitorWin'] . "-" . $PlayoffFarm['HomeWin'] ."</span>";}
											elseif ($PlayoffFarm['VisitorWin'] > $PlayoffFarm['HomeWin']){echo "<span>" . $PlayoffFarm['VisitorTeamName'] . " leads " . $PlayoffFarm['VisitorWin'] . "-" . $PlayoffFarm['HomeWin'] ."</span>";}else {echo "";}?></div>
											
											
											<div class="series-status western pacific round-2">											<?php $Query = "SELECT PlayoffFarm.*, TeamInfoHome.Abbre as HomeTeamName, TeamInfoVisitor.Abbre as VisitorTeamName FROM (PlayoffFarm INNER JOIN TeamFarmInfo AS TeamInfoHome ON PlayoffFarm.HomeTeam = TeamInfoHome.Number) LEFT JOIN TeamFarmInfo AS TeamInfoVisitor ON PlayoffFarm.VisitorTeam = TeamInfoVisitor.Number WHERE PlayoffFarm.Number = 12";$PlayoffFarm = $db->querySingle($Query,true);
 											if ($PlayoffFarm['HomeWin'] > $PlayoffFarm['VisitorWin'] AND $PlayoffFarm['HomeWin'] == 4 ){echo "<span>" . $PlayoffFarm['HomeTeamName'] . " wins " . $PlayoffFarm['HomeWin'] . "-" . $PlayoffFarm['VisitorWin'] ."</span>";}
 											elseif ($PlayoffFarm['HomeWin'] > $PlayoffFarm['VisitorWin']){echo "<span>" . $PlayoffFarm['HomeTeamName'] . " leads " . $PlayoffFarm['HomeWin'] . "-" . $PlayoffFarm['VisitorWin'] ."</span>";}
     										elseif ($PlayoffFarm['VisitorWin'] === $PlayoffFarm['HomeWin']){echo "<span>" .  "Series tied " . $PlayoffFarm['VisitorWin'] . "-" . $PlayoffFarm['HomeWin'] ."</span>";}
 											elseif ($PlayoffFarm['VisitorWin'] > $PlayoffFarm['HomeWin'] AND $PlayoffFarm['VisitorWin'] == 4 ){echo "<span>" . $PlayoffFarm['VisitorTeamName'] . " wins " . $PlayoffFarm['VisitorWin'] . "-" . $PlayoffFarm['HomeWin'] ."</span>";}
											elseif ($PlayoffFarm['VisitorWin'] > $PlayoffFarm['HomeWin']){echo "<span>" . $PlayoffFarm['VisitorTeamName'] . " leads " . $PlayoffFarm['VisitorWin'] . "-" . $PlayoffFarm['HomeWin'] ."</span>";}else {echo "";}?></div>
											
											
											<div class="series-status eastern round-3">											<?php $Query = "SELECT PlayoffFarm.*, TeamInfoHome.Abbre as HomeTeamName, TeamInfoVisitor.Abbre as VisitorTeamName FROM (PlayoffFarm INNER JOIN TeamFarmInfo AS TeamInfoHome ON PlayoffFarm.HomeTeam = TeamInfoHome.Number) LEFT JOIN TeamFarmInfo AS TeamInfoVisitor ON PlayoffFarm.VisitorTeam = TeamInfoVisitor.Number WHERE PlayoffFarm.Number = 13";$PlayoffFarm = $db->querySingle($Query,true);
 											if ($PlayoffFarm['HomeWin'] > $PlayoffFarm['VisitorWin'] AND $PlayoffFarm['HomeWin'] == 4 ){echo "<span>" . $PlayoffFarm['HomeTeamName'] . " wins " . $PlayoffFarm['HomeWin'] . "-" . $PlayoffFarm['VisitorWin'] ."</span>";}
 											elseif ($PlayoffFarm['HomeWin'] > $PlayoffFarm['VisitorWin']){echo "<span>" . $PlayoffFarm['HomeTeamName'] . " leads " . $PlayoffFarm['HomeWin'] . "-" . $PlayoffFarm['VisitorWin'] ."</span>";}
     										elseif ($PlayoffFarm['VisitorWin'] === $PlayoffFarm['HomeWin']){echo "<span>" .  "Series tied " . $PlayoffFarm['VisitorWin'] . "-" . $PlayoffFarm['HomeWin'] ."</span>";}
 											elseif ($PlayoffFarm['VisitorWin'] > $PlayoffFarm['HomeWin'] AND $PlayoffFarm['VisitorWin'] == 4 ){echo "<span>" . $PlayoffFarm['VisitorTeamName'] . " wins " . $PlayoffFarm['VisitorWin'] . "-" . $PlayoffFarm['HomeWin'] ."</span>";}
											elseif ($PlayoffFarm['VisitorWin'] > $PlayoffFarm['HomeWin']){echo "<span>" . $PlayoffFarm['VisitorTeamName'] . " leads " . $PlayoffFarm['VisitorWin'] . "-" . $PlayoffFarm['HomeWin'] ."</span>";}else {echo "";}?></div>
											
											
											<div class="series-status western round-3">											<?php $Query = "SELECT PlayoffFarm.*, TeamInfoHome.Abbre as HomeTeamName, TeamInfoVisitor.Abbre as VisitorTeamName FROM (PlayoffFarm INNER JOIN TeamFarmInfo AS TeamInfoHome ON PlayoffFarm.HomeTeam = TeamInfoHome.Number) LEFT JOIN TeamFarmInfo AS TeamInfoVisitor ON PlayoffFarm.VisitorTeam = TeamInfoVisitor.Number WHERE PlayoffFarm.Number = 14";$PlayoffFarm = $db->querySingle($Query,true);
 											if ($PlayoffFarm['HomeWin'] > $PlayoffFarm['VisitorWin'] AND $PlayoffFarm['HomeWin'] == 4 ){echo "<span>" . $PlayoffFarm['HomeTeamName'] . " wins " . $PlayoffFarm['HomeWin'] . "-" . $PlayoffFarm['VisitorWin'] ."</span>";}
 											elseif ($PlayoffFarm['HomeWin'] > $PlayoffFarm['VisitorWin']){echo "<span>" . $PlayoffFarm['HomeTeamName'] . " leads " . $PlayoffFarm['HomeWin'] . "-" . $PlayoffFarm['VisitorWin'] ."</span>";}
     										elseif ($PlayoffFarm['VisitorWin'] === $PlayoffFarm['HomeWin']){echo "<span>" .  "Series tied " . $PlayoffFarm['VisitorWin'] . "-" . $PlayoffFarm['HomeWin'] ."</span>";}
 											elseif ($PlayoffFarm['VisitorWin'] > $PlayoffFarm['HomeWin'] AND $PlayoffFarm['VisitorWin'] == 4 ){echo "<span>" . $PlayoffFarm['VisitorTeamName'] . " wins " . $PlayoffFarm['VisitorWin'] . "-" . $PlayoffFarm['HomeWin'] ."</span>";}
											elseif ($PlayoffFarm['VisitorWin'] > $PlayoffFarm['HomeWin']){echo "<span>" . $PlayoffFarm['VisitorTeamName'] . " leads " . $PlayoffFarm['VisitorWin'] . "-" . $PlayoffFarm['HomeWin'] ."</span>";}else {echo "";}?></div>
											
											
											<div class="series-status round-4">
																				<?php $Query = "SELECT PlayoffFarm.*, TeamInfoHome.City as HomeTeamName, TeamInfoVisitor.City as VisitorTeamName FROM (PlayoffFarm INNER JOIN TeamFarmInfo AS TeamInfoHome ON PlayoffFarm.HomeTeam = TeamInfoHome.Number) LEFT JOIN TeamFarmInfo AS TeamInfoVisitor ON PlayoffFarm.VisitorTeam = TeamInfoVisitor.Number WHERE PlayoffFarm.Number = 15";$PlayoffFarm = $db->querySingle($Query,true);
 											if ($PlayoffFarm['HomeWin'] > $PlayoffFarm['VisitorWin'] AND $PlayoffFarm['HomeWin'] == 4 ){echo "<span>" . $PlayoffFarm['HomeTeamName'] . " wins Calder Cup " . $PlayoffFarm['HomeWin'] . "-" . $PlayoffFarm['VisitorWin'] ."</span>";}
 											elseif ($PlayoffFarm['HomeWin'] > $PlayoffFarm['VisitorWin']){echo "<span>" . $PlayoffFarm['HomeTeamName'] . " leads " . $PlayoffFarm['HomeWin'] . "-" . $PlayoffFarm['VisitorWin'] ."</span>";}
     										elseif ($PlayoffFarm['VisitorWin'] === $PlayoffFarm['HomeWin']){echo "<span>" .  "Series tied " . $PlayoffFarm['VisitorWin'] . "-" . $PlayoffFarm['HomeWin'] ."</span>";}
 											elseif ($PlayoffFarm['VisitorWin'] > $PlayoffFarm['HomeWin'] AND $PlayoffFarm['VisitorWin'] == 4 ){echo "<span>" . $PlayoffFarm['VisitorTeamName'] . " wins Calder Cup " . $PlayoffFarm['VisitorWin'] . "-" . $PlayoffFarm['HomeWin'] ."</span>";}
											elseif ($PlayoffFarm['VisitorWin'] > $PlayoffFarm['HomeWin']){echo "<span>" . $PlayoffFarm['VisitorTeamName'] . " leads " . $PlayoffFarm['VisitorWin'] . "-" . $PlayoffFarm['HomeWin'] ."</span>";}else {echo "";}?></div>
											

											<div class="bracket-rank eastern atlantic rank-1">(1)</div>
											<div class="bracket-rank eastern atlantic rank-wc">(4)</div>
											<div class="bracket-rank eastern atlantic rank-2">(2)</div>
											<div class="bracket-rank eastern atlantic rank-3">(3)</div>
											<div class="bracket-rank eastern metropolitan rank-1">(1)</div>
											<div class="bracket-rank eastern metropolitan rank-wc">(4)</div>
											<div class="bracket-rank eastern metropolitan rank-2">(2)</div>
											<div class="bracket-rank eastern metropolitan rank-3">(3)</div>
											<div class="bracket-rank western central rank-1">(1)</div>
											<div class="bracket-rank western central rank-wc">(4)</div>
											<div class="bracket-rank western central rank-2">(2)</div>
											<div class="bracket-rank western central rank-3">(3)</div>
											<div class="bracket-rank western pacific rank-1">(1)</div>
											<div class="bracket-rank western pacific rank-wc">(4)</div>
											<div class="bracket-rank western pacific rank-2">(2)</div>
											<div class="bracket-rank western pacific rank-3">(3)</div>
										</div>
									</td>
								</tr>
							</tbody></table>
						</div>
					</div>
								</div></div>





</div>

</div>
</div>



<script type="text/javascript">
$(function(){
  $(".STHSPHPStanding_Table").tablesorter({widgets:['staticRow']});
});
</script>

</div></div>

<br /><br />



<?php
include "Footer.php";
?>


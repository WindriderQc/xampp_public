<?php If (isset($SearchLang) == False){include 'LanguageEN.php';} if (isset($Year) == False){$Year=-1;$Playoff=False;$Team=0;$OrderByInput=array();$TeamStatPossibleOrderField=array();$HistoryFarm=False;$lang="en";$DESCQuery=False;}?> 
<form action="TeamsStat.php" method="get">
<table class="STHSTable">
<tr>	
	<td class="STHSW200 STHSPHPSearch_Field"><?php echo $SearchLang['Year'];?></td><td class="STHSW250">
	<select name="Year" class="STHSSelect STHSW250">
	<?php 
	echo "<option";if($Year == 0){echo " selected=\"selected\"";} echo " value=\"\">" .  $SearchLang['ThisSeason'] . "</option>";
	if (empty($HistoryYear) == false){while ($Row = $HistoryYear ->fetchArray()) { 
		echo "<option";if($Row['Year'] == $Year){echo " selected=\"selected\"";} echo " value=\"" . $Row['Year'] . "\">" . $Row['Year'] . "</option>"; 
	}} 
	echo "<option";if($Year == 9999){echo " selected=\"selected\"";} echo " value=\"9999\">" .  $SearchLang['AllSeasonPerYear'] . "</option>";
	echo "<option";if($Year == 9998){echo " selected=\"selected\"";} echo " value=\"9998\">" .  $SearchLang['AllSeasonMerge'] . "</option>";?>
	</select></td>	
</tr>
<tr>
	<td class="STHSW200 STHSPHPSearch_Field"><?php echo $SearchLang['Team'];?></td><td class="STHSW250">
	<select name="Team" class="STHSSelect STHSW250">
	<?php
	echo "<option";	if($Team == 0){echo " selected=\"selected\"";}echo" value=\"\">" . $SearchLang['AllTeam'] . "</option>";
	if (empty($HistoryTeam) == false){while ($Row = $HistoryTeam->fetchArray()) {
		echo "<option value=\"" . $Row['Number'] . "\""; 
		if ($Row['Number'] == $Team){echo " selected=\"selected\"";}
		echo ">" . $Row['Name'] . "</option>"; 
	}}
	?>
	</select></td>
</tr>
<tr>
	<td class="STHSW200 STHSPHPSearch_Field"><?php echo $SearchLang['Playoff'];?></td><td class="STHSW250">
	<input type="checkbox" name="Playoff"<?php if($Playoff == "True"){echo " checked";}?>></td>
</tr>
<tr>
	<td class="STHSW200 STHSPHPSearch_Field"><?php echo $SearchLang['OrderField'];?></td><td class="STHSW250">
	<select name="Order" class="STHSSelect STHSW250">
	<?php 
	echo "<option";if($OrderByInput == ""){echo " selected=\"selected\"";} echo " value=\"\">" . $SearchLang['Select'] . "</option>";
	foreach ($TeamStatPossibleOrderField as $Value) {
		echo "<option";if($OrderByInput == $Value[0]){echo " selected=\"selected\"";} echo " value=\"" . $Value[0] . "\">" . $Value[1] . "</option>"; 
	} ?>
	</select></td>
</tr>
<?php If ($HistoryFarm == True){echo "<tr><td class=\"STHSW200\">" . $SearchLang['Farm'] . "</td><td class=\"STHSW250\"><input type=\"checkbox\" name=\"Farm\"";if($TypeText == "Farm"){echo " checked";}echo "></td></tr>";}?>
<tr>
	<td class="STHSW200 STHSPHPSearch_Field"><?php echo $SearchLang['DecendingOrder'];?></td><td class="STHSW250">
	<?php If ($lang == "fr"){echo "<input type=\"hidden\" name=\"Lang\" value=\"fr\">";}?>
	<input type="checkbox" name="DESC"<?php if($DESCQuery == True){echo " checked";}?>></td>
</tr>
<tr>
	<td colspan="2" class="STHSCenter"><input type="submit" class="SubmitButton" value="<?php echo $SearchLang['Submit'];?>"></td>
</tr>
</table></form>





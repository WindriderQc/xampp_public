<?php
	$lang = "en"; 	require_once("LanguageEN.php");	$LeagueName = Null;	session_start();	mb_internal_encoding("UTF-8");	$PerformanceMonitorStart = microtime(true); 
	require_once("STHSSetting.php");
	require_once("WebClientAPI.php");
	
	$exempt = array();
	load_apis($exempt);// Call the required APIs
		
    // Make a connection variable to pass to API
	$db = api_sqlite_connect($DatabaseFile);
    if ($db){

		$Query = "Select ShowWebClientInDymanicWebsite FROM LeagueOutputOption";
		$LeagueOutputOption = $db->querySingle($Query,true);
		
		// Look for a team ID in the URL, if non exists use 0
        $t = (isset($_REQUEST["TeamID"])) ? filter_var($_REQUEST["TeamID"], FILTER_SANITIZE_NUMBER_INT): 0;
        $row = array();
        if($t > 0 AND $t <= 100){
            $rs = api_dbresult_teamsbyname($db,"Pro",$t);
            $row = $rs->fetchArray();
        }
		

        // LHSQC
        $WebClientHeadCode = "<link href=\"https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css\" rel=\"stylesheet\" integrity=\"sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH\" crossorigin=\"anonymous\">
                        <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js\"></script>
                        <script src=\"https://code.jquery.com/ui/1.14.0/jquery-ui.min.js\" integrity=\"sha256-Fb0zP4jE3JHqu+IBB9YktLcSjI1Zc6J2b6gTjB0LpoM=\" crossorigin=\"anonymous\"></script>
                        <script src=\"https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js\"></script>
                        <link href=\"css/lhsqc.css\" rel=\"stylesheet\" type=\"text/css\" /> 
                        <script src=\"js/lhsqc_new.js\"    type=\"text/javascript\"></script>"; //  <script src=\"LHSQC.js\"    type=\"text/javascript\"></script>";  
       
		// Make a default header 
		// 5 Paramaters. PageID, database, teamid, League = Pro/Farm, $headcode (custom headercode can be added. DEFAULT "")
        api_layout_header("rostereditor",$db,$t,false,$WebClientHeadCode);
    } else { echo "Error with DB. :("; }
?>

<header>
<?php include "Menu.php";


if ($CookieTeamNumber == 102){$DoNotRequiredLoginDynamicWebsite = TRUE;} 
		
if(($CookieTeamNumber == $t OR $DoNotRequiredLoginDynamicWebsite == TRUE) AND $t > 0 AND $t <= 100){
	if($t > 0){
        $teamid = $t;
    ?>
    <div class="container">


    <?php include "components/RosterEditor.php";  ?>

    </div>
    <?php   
    }
		}else{
			echo "<div class=\"STHSDivInformationMessage\">" . $NoUserLogin . "<br /><br /></div>";
		}

		// Close the db connection
		$db->close();
        ?>

</header> 
        
<script>
    function deactivateBanner() {
        const banner = document.querySelector('.confirm');
        if (banner) banner.style.display = 'none'; // Hides the banner
    }
   
    setTimeout(deactivateBanner, 5000);                    // Hide the confirm banner after 5 seconds
    document.addEventListener('click', deactivateBanner);  // Hide the confirm banner on user interaction
</script>
        
<?php include ("Footer.php"); ?>
</body></html>

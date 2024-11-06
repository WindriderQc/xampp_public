<?php
    require_once("STHSSetting.php");
	error_reporting(E_ALL);
ini_set('display_errors', 1);
    // Make a connection variable to pass to API
	//$db = api_sqlite_connect($DatabaseFile);
    $db = new SQLite3($DatabaseFile);
    
    if ($db){

		// Look for a team ID in the URL, if non exists use 0
        $t = (isset($_REQUEST["TeamID"])) ? filter_var($_REQUEST["TeamID"], FILTER_SANITIZE_NUMBER_INT): 0;
 
		

        // LHSQC
       
		// Make a default header 
		// 5 Paramaters. PageID, database, teamid, League = Pro/Farm, $headcode (custom headercode can be added. DEFAULT "")
         ?><!DOCTYPE html>
			<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
			<head>
				<meta name="author" content="Yanik Beaulieu" />
				<meta name="description" content="Tools for the STHS Simulator" />
				<meta name="keywords" content="STHS, Fantasy, Hockey, Simulator" />
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<meta name="viewport" content="width=device-width" />
				<meta http-equiv="cache-control" content="max-age=0" />
				<meta http-equiv="cache-control" content="no-cache" />
				<meta http-equiv="expires" content="0" />
				<meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
				<title>LHSQC WebEditor </title>
          
				<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">                

                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
                <script src="https://code.jquery.com/ui/1.14.0/jquery-ui.min.js" integrity="sha256-Fb0zP4jE3JHqu+IBB9YktLcSjI1Zc6J2b6gTjB0LpoM=" crossorigin="anonymous"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>
                <link href="css/lhsqc.css" rel="stylesheet" type="text/css" /> 
                <script src="js/lhsqc_new.js"    type="text/javascript"></script>
				               
			
			</head>
		<?php
		// Start the Body, add an onload function if set above. 
		?><body<?= (isset($onload)) ? $onload : "";?>><?php
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

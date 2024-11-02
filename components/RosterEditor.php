
<?php 

if (isset($_COOKIE[$Cookie_Name])) {
   /* $cookie_value = $_COOKIE[$Cookie_Name];

    //echo "Raw Cookie Value: " . htmlspecialchars($cookie_value) . "<br>";

    // Decode the cookie from Base64
    $decoded_cookie_value = base64_decode($cookie_value);

    if ($decoded_cookie_value === false) {
        //echo "Base64 decoding failed.<br>";
        exit;
    } else {

        //echo "Decoded Cookie Value: " . htmlspecialchars($decoded_cookie_value) . "<br>";
        
        $encryption_key = base64_decode($CookieTeamNumberKey);
        list($encrypted_data, $iv) = explode('::', base64_decode($_COOKIE[$Cookie_Name]), 2);
        $CookieArray = unserialize(openssl_decrypt($encrypted_data, 'aes-256-cbc', $encryption_key, 0, $iv));
        $CookieTeamNumber = $CookieArray['TeamNumber'] ?? 0;
        $CookieTeamName = $CookieArray['TeamName'] ?? "";
        
        $teamID = $CookieArray['TeamNumber'] ?? 0; // Adjust as necessary
        echo "<script>var teamID = $teamID; console.log('cookie team', teamID);</script>";

    }*/
} else {
   // echo "Cookie is missing. Name: " . htmlspecialchars($Cookie_Name) . "<br>";
}
 ?>

<div class="container" style=" overflow-x: hidden;">

    <div class="row ">


        <div class="col-9 m-0 p-0" id="Lines">
            <div class="card h-100 mt-1 mx-1">
                <div class="card-header">Lines</div>
                <div class="card-body">
                    
                    <div class="row m-0 p-0" id="divF1">
                        <div class="col m-1 p-0"> <div class="card roster-container" id="Line15vs5ForwardLeftWing" data-line-pos="LW1"> LW1 </div></div>
                        <div class="col m-1 p-0"> <div class="card roster-container" id="Line15vs5ForwardCenter" data-line-pos="C1">   C1 </div></div>
                        <div class="col m-1 p-0"> <div class="card roster-container" id="Line15vs5ForwardRightWing" data-line-pos="RW1"> RW1 </div></div>
                    </div> 

                    <div class="row m-0 p-0" id="divF2">
                        <div class="col m-1 p-0"> <div class="card roster-container" id="Line25vs5ForwardLeftWing" data-line-pos="LW2"> LW2 </div></div>
                        <div class="col m-1 p-0"> <div class="card roster-container" id="Line25vs5ForwardCenter" data-line-pos="C2">   C2 </div></div>
                        <div class="col m-1 p-0"> <div class="card roster-container" id="Line25vs5ForwardRightWing" data-line-pos="RW2"> RW2 </div></div>
                    </div>

                    <div class="row m-0 p-0" id="divF3">
                        <div class="col m-1 p-0"> <div class="card roster-container" id="Line35vs5ForwardLeftWing" data-line-pos="LW3"> LW3 </div></div>
                        <div class="col m-1 p-0"> <div class="card roster-container" id="Line35vs5ForwardCenter" data-line-pos="C3">   C3 </div></div>
                        <div class="col m-1 p-0"> <div class="card roster-container" id="Line35vs5ForwardRightWing" data-line-pos="RW3"> RW3 </div></div>
                    </div>

                    <div class="row m-0 p-0" id="divF4">
                        <div class="col m-1 p-0"> <div class="card roster-container" id="Line45vs5ForwardLeftWing" data-line-pos="LW4"> LW4 </div></div>
                        <div class="col m-1 p-0"> <div class="card roster-container" id="Line45vs5ForwardCenter" data-line-pos="C4">   C4 </div></div>
                        <div class="col m-1 p-0"> <div class="card roster-container" id="Line45vs5ForwardRightWing" data-line-pos="RW4"> RW4 </div></div>
                    </div>


                    <div class="row m-0 p-0" id="divD1">
                        <div class="col-1 m-1 p-0"></div> 
                        <div class="col m-1 p-0"> <div class="card roster-container" id="Line15vs5DefenseDefense1" data-line-pos="DG1"> DG1 </div></div>
                        <div class="col m-1 p-0"> <div class="card roster-container" id="Line15vs5DefenseDefense2" data-line-pos="DD1"> DD1 </div></div>
                        <div class="col-1 m-1 p-0"></div> 
                    </div>
                    <div class="row m-0 p-0" id="divD2">
                        <div class="col-1 m-1 p-0"></div> 
                        <div class="col m-1 p-0"> <div class="card roster-container" id="Line25vs5DefenseDefense1" data-line-pos="DG2"> DG2 </div></div>
                        <div class="col m-1 p-0"> <div class="card roster-container" id="Line25vs5DefenseDefense2" data-line-pos="DD2"> DD2 </div></div>
                        <div class="col-1 m-1 p-0"></div> 
                    </div>
                    <div class="row m-0 p-0" id="divD3">
                        <div class="col-1 m-1 p-0"> </div> 
                        <div class="col m-1 p-0"> <div class="card roster-container" id="Line35vs5DefenseDefense1" data-line-pos="DG3"> DG3 </div></div>
                        <div class="col m-1 p-0"> <div class="card roster-container" id="Line5vs5DefenseDefense2" data-line-pos="DD3"> DD3 </div></div>
                        <div class="col-1 m-1 p-0"> </div> 
                    </div>
                
                </div>
            </div>
        </div>



        <div class="col-3 m-0 p-0">
            <div class="card text-center h-75 mb-1 mx-0 mt-1 ">
                <div class="card-header">Healthy</div>
                <div class="card-body m-0 p-1 Roster" id="Roster">
                    <!--     list created from JS-->
                </div>
            </div>
            <div class="card text-center ">
                <div class="card-header">Scratch</div>
                <div class="card-body m-0 p-1 Scratched" style="min-height:50px;" id="Scratched"></div>
            </div>
        </div>

    </div>


    <div class="row text-center">
                   
        <div class ="col-12">
            <div id="saveBtn"></div>
        </div>

    </div>
    

</div>



<script src="js/rosterEditor.js"></script>

<script>
//var teamID = 21   //   TODO    DEBUG Hardcoded....    teamID is not set...
</script>

<div id="player-list"></div>





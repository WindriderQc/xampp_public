

<footer class="clearfix">

		<div class="row">
			<div class="col">
				<div class="module-content">
					<h4>Legacy</h4>
					<ul>	
                        <li><a href="old/index.php"> Old Website </a></li>				
                        <li><?php echo "<a href=\"" . $LeagueGeneralMenu['OutputName'] . ".stc\">"  . $TopMenuLang['STHSClientLeagueFile'] . "</a>"; ?></li>
				    </ul>
				</div>
			</div>

			<div class="col">

				<div class="module-content">

					<div class=""><img id="MenuProLeagueImage" src="images/proleague.png" width="90" height="90" alt="Pro League Menu"></div>
                    <div class=""><img id="MenuFarmLeagueImage" src="images/farmleague.png" width="90" height="90" alt="Farm League Menu"></div>

					<ul>

                       

					</ul>

				</div>

			</div>

           

			<div class="col-4 bg-orange">

				<div class="module-content">

                    <h5>Ligue de Hockey Simulé</h5>

                    <h5>Quebec City</h5>

					<ul >

						<li>

                            <div class="logo "><a href="index.php"> <img src="images/lhsqc_logo_2.png" alt="LHSQC" class="footer-logo"></a> </div>

                        </li>

					</ul>

                </div>

			</div>

		</div>

	</footer>



<!-- Copyright -->

<div class="text-center p-1" style="background-color: rgba(0, 0, 0, 0.2);">
    
    <i class="fa-regular fa-hand-peace" id="tripleClickElement"></i>

    <div class="mt-1">

        <?php 

            echo $Footer . $LeagueOwner;

            If (file_exists($DatabaseFile) == True){
                try{
                    echo " - " . $DatabaseCreate;
                    If (isset($LeagueGeneralMenu) == True){
                        echo	$LeagueGeneralMenu['DatabaseCreationDate'];
                    }
                } catch (Exception $e) {}
            }
       

        If (isset($PerformanceMonitorStart)){
            echo "<script>  console.log(\"STHS Page PHP Performance : " . (microtime(true)-$PerformanceMonitorStart) . " - Peak Memory Usage : " . round(memory_get_peak_usage() / 1024) . "KB  - Peak Memory Usage : " . round(memory_get_peak_usage(true) / 1024) . "KB \");  </script>";}
        ?> 
          
           
                
    </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/1.10.0/p5.min.js"></script>



<script>
    let clickCount = 0;
    let clickTimeout;

    const clickTimeWindow = 650; // Time window in milliseconds for triple-click detection (e.g., 500ms)

    document.getElementById('tripleClickElement').addEventListener('click', function() {
        clickCount++;
        clearTimeout(clickTimeout);  // Reset the click count after the defined time window (e.g., 500ms)
        clickTimeout = setTimeout(function() { clickCount = 0;  }, clickTimeWindow);// Reset click count if time window passes

        if (clickCount === 3) {
            clickCount = 0;  // Reset click count after triple-click
            window.location.href = "/tools";  // Trigger action for triple-click
           }   
    });
</script>

</body>
</html> 
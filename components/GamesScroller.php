<?php    
error_reporting(E_ALL);
ini_set('display_errors', 1);


if (isset($db) && $db) {  
    $Query = "SELECT * FROM LeagueGeneral";
    $LeagueGeneral = $db->querySingle($Query,true);	

    $query = "SELECT *,'Pro' as Type FROM SchedulePro WHERE Day >= " . ($LeagueGeneral['ScheduleNextDay'] - $LeagueGeneral['DefaultSimulationPerDay']) . " AND PLAY = 'True' ORDER BY GameNumber "; //  TODO  :    set le 365 / 10 JRS back sur la DB, param pour la query et param pour la longueur du gameScroller....
    $scrollerScore = $db->query($query);

    $query = "SELECT SchedulePro.*, 'Pro' AS Type, TeamProStatVisitor.Last10W AS VLast10W, TeamProStatVisitor.Last10L AS VLast10L, TeamProStatVisitor.Last10T AS VLast10T, TeamProStatVisitor.Last10OTW AS VLast10OTW, TeamProStatVisitor.Last10OTL AS VLast10OTL, TeamProStatVisitor.Last10SOW AS VLast10SOW, TeamProStatVisitor.Last10SOL AS VLast10SOL, TeamProStatVisitor.GP AS VGP, TeamProStatVisitor.W AS VW, TeamProStatVisitor.L AS VL, TeamProStatVisitor.T AS VT, TeamProStatVisitor.OTW AS VOTW, TeamProStatVisitor.OTL AS VOTL, TeamProStatVisitor.SOW AS VSOW, TeamProStatVisitor.SOL AS VSOL, TeamProStatVisitor.Points AS VPoints, TeamProStatVisitor.Streak AS VStreak, TeamProStatHome.Last10W AS HLast10W, TeamProStatHome.Last10L AS HLast10L, TeamProStatHome.Last10T AS HLast10T, TeamProStatHome.Last10OTW AS HLast10OTW, TeamProStatHome.Last10OTL AS HLast10OTL, TeamProStatHome.Last10SOW AS HLast10SOW, TeamProStatHome.Last10SOL AS HLast10SOL, TeamProStatHome.GP AS HGP, TeamProStatHome.W AS HW, TeamProStatHome.L AS HL, TeamProStatHome.T AS HT, TeamProStatHome.OTW AS HOTW, TeamProStatHome.OTL AS HOTL, TeamProStatHome.SOW AS HSOW, TeamProStatHome.SOL AS HSOL, TeamProStatHome.Points AS HPoints, TeamProStatHome.Streak AS HStreak FROM (SchedulePRO LEFT JOIN TeamProStat AS TeamProStatHome ON SchedulePRO.HomeTeam = TeamProStatHome.Number) LEFT JOIN TeamProStat AS TeamProStatVisitor ON SchedulePRO.VisitorTeam = TeamProStatVisitor.Number WHERE DAY >= " . $LeagueGeneral['ScheduleNextDay'] . " AND DAY <= " . ($LeagueGeneral['ScheduleNextDay'] + 31 -1) . " ORDER BY Day, GameNumber";
    $scrollerSchedule = $db->query($query);
} 
?>


<div class="gamesScroller mx-0 px-0 ">
    <div class="row  mx-0 px-0">

        <div class="scrollButtons ">
            <div class="scrollDivTop  ">
                <button class="scrollBtn scrollBtnLeft" id="left-button"><img src="/images/arrow-left-yellow.png" ></button>
            </div>
            <div class=" scrollDivBot  ">
                <button class="scrollBtn scrollBtnRight " id="right-button"><img src="images/arrow-right-yellow.png" ></button>
            </div>
        </div>
           
            <div class="scroll-container" id="boxscore">
                <table class="table py-0 my-0">
                        <td style="background:white;width:43px;height:84px;display:block"><br></td>
                        
                    

                        <?php
                        // Add Latest Games with scores to gameScroller.
                        $i = 0;
                        
                        if (empty($scrollerScore) == false) { 
                            while ($row = $scrollerScore->fetchArray()) {  ?>
                          
                                <td class="GameDayTable pastGame">
                                    <table class="" style="margin-left:4px;">
                                        <tr style="font-size:10px;color:#383732;font-weight:bold;line-height:15px; padding:5px;"> <td><?php echo "Day" . $row['Day'] . " - #" . $row['GameNumber']; ?></td></tr>
                                        <tr style="line-height:20px;color:#2a2a2a;font-weight:bold;margin:0px;font-size:14px;">
                                            <td>
                                                <span><img src= <?php echo "images/" . $row['VisitorTeamThemeID'] . ".png"; ?> alt="" style="width:24px;vertical-align:middle;padding-right:4px;padding-bottom:0px;"></span>
                                                <?php echo $row['VisitorTeamAbbre']; ?> 
                                            </td>
                                            <td style="font-size:20px;text-align:center;font-weight:bold;"><?php echo $row['VisitorScore']; ?></td>
                                        </tr>
                                        <tr style="line-height:20px;color:#2a2a2a;font-weight:bold;margin:0px;font-size:14px;">
                                            <td>
                                                <span><img src= <?php echo "images/" . $row['HomeTeamThemeID']    . ".png"; ?> alt="" style="width:24px;vertical-align:middle;padding-right:4px;"></span>
                                                <?php echo $row['HomeTeamAbbre']; ?>
                                            </td>
                                            <td style="font-size:20px;text-align:center;font-weight:bold;"> <?php echo $row['HomeScore']; ?></td>
                                        </tr>
                                        <tr>
                                            <td  class="scrollerBoxScore">
                                                <?php echo "<a href=\"" . $row['Link'] ."\">" . $IndexLang['BoxScore'] .  "</a>"; ?>
                                            </td>
                                        </tr>
                                    </table>
                                </td>

                                
                                <?php
                               
                                $i = $i+1;
                            }
                        }
                       
                        //  Add next games schedule to gameScroller.
                        if (empty($scrollerSchedule) == false) {
                            while ($row = $scrollerSchedule->fetchArray()) {   ?>
                           
                           <script>
                            var phpVar = <?php echo json_encode($row); ?>;
                            //console.log(JSON.stringify(phpVar, null, 2)); 
                            </script>

                                <td class=" GameDayTable upcomingGame">
                                    
                                    <div class="" style="margin-left:4px;" style="line-height:20px;color:#2a2a2a;font-weight:bold;font-size:14px;">

                                        <div class="row" style="font-size:10px;color:#383732;font-weight:bold;line-height:15px; padding-left:20px;"> <?php echo "Day" . $row['Day'] . " - #" . $row['GameNumber']; ?> </div>
                                        
                                        <div class="row" >
                                            <div class="col">
                                            <img src= <?php echo $ImagesCDNPath . "/images/" . $row['VisitorTeamThemeID'] . ".png"; ?> alt="" style="width:24px;"> </div>
                                            <div class="col"> <?php echo $row['VisitorTeamAbbre'];  ?> </div>
                                            <div class="col"> - </div>
                                        </div>
                                        
                                        <div class="row"> 
                                            <div class="col"> <img src= <?php echo $ImagesCDNPath . "/images/" . $row['HomeTeamThemeID'] . ".png"; ?> alt="" style="width:24px;"> </div>
                                            <div class="col"> <?php echo $row['HomeTeamAbbre']; ?> </div>
                                            <div class="col"> - </div>
                                        </div>

                                    </div>


                                    
                                </td>
                                <?php  
                                $i = $i+1;
                            }
                        }
                       
                        //  There are no game in Database...  display generic message.
                        if ($i == 0) {
                            ?>
                            <td class="STHSTodayGame_GameOverall GameDayTable">
                                <table class="STHSTodayGame_GameData" style="margin-left:4px">
                                    <tr style="font-size:10px;color:#383732;font-weight:bold;line-height:15px;">
                                        <td><div class="noscore ">Schedule not rdy! Stay tuned! </div></td>
                                    </tr>
                                </table>
                            </td>
                            <?php  
                        }
                        ?>

                </table>
            </div>   
        
    </div>
</div>  
    

   
<script>
    const SCROLL_SPD = 2  // Adjust the multiplier for faster/slower scrolling


    var boxscore = document.getElementById('boxscore');
    var startX, scrollLeft, isDown = false;

    // Button click functionality
    $('#right-button').click(function(event) {
        event.preventDefault();
        $('#boxscore').animate({ scrollLeft: '+=145px' }, 'fast');
    });

    $('#left-button').click(function(event) {
        event.preventDefault();
        $('#boxscore').animate({ scrollLeft: '-=145px' }, 'fast');
    });

    // Touch event functionality
    boxscore.addEventListener('touchstart', function(e) {
        startX = e.touches[0].pageX - boxscore.offsetLeft;
        scrollLeft = boxscore.scrollLeft;
       
    });

    boxscore.addEventListener('touchmove', function(e) {
        if (!isDown) return;
        e.preventDefault();
        var x = e.touches[0].pageX - boxscore.offsetLeft;
        var walk = (x - startX) * SCROLL_SPD; 
        boxscore.scrollLeft = scrollLeft - walk;
    });

    boxscore.addEventListener('touchend', function() {
       
    });

    // Mouse grab functionality
    boxscore.addEventListener('mousedown', function(e) {
        isDown = true;
        startX = e.pageX - boxscore.offsetLeft;
        scrollLeft = boxscore.scrollLeft;
        boxscore.classList.add('active');
    });

    boxscore.addEventListener('mouseleave', function() {
        isDown = false;
        boxscore.classList.remove('active');
    });

    boxscore.addEventListener('mouseup', function() {
        isDown = false;
        boxscore.classList.remove('active');
    });

    boxscore.addEventListener('mousemove', function(e) {
        if (!isDown) return;
        e.preventDefault();
        var x = e.pageX - boxscore.offsetLeft;
        var walk = (x - startX) * SCROLL_SPD; 
        boxscore.scrollLeft = scrollLeft - walk;
    });
   
</script>
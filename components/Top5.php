<div class="card shadow-0 mb-3 frontpage-card top5Card" >
    <div class="card-header">Top Stars</div>
    <div class="card-body mt-0 pt-0 text-primary">                                
        <table class="StarTable">
                       
            <tr><th colspan="2" class="STHSIndex_3StarNameHeader"> <?= $IndexLang['ProGamesDaysStar'] ?> </th></tr>
            <tr><td colspan="2"><img src="images/Star.png" alt="Star1" style="width:25px;vertical-align:middle;padding-right:4px" /><span id="starPro1"></span></td></tr>
            <tr><td colspan="2"><img src="images/Star.png" alt="Star2" style="width:25px;vertical-align:middle;padding-right:4px" /><span id="starPro2"></span></td></tr>
            <tr><td colspan="2"><img src="images/Star.png" alt="Star3" style="width:25px;vertical-align:middle;padding-right:4px" /><span id="starPro3"></span></td></tr>
            
            <tr><th colspan="2" class="STHSTop5"><?php echo $IndexLang['Top5Point'];?></th></tr>
            <tr><td class="STHSIndex_Top5PointNameHeader"><?php echo $PlayersLang['PlayerName'];?></td><td class="STHSIndex_Top5PointResultHeader">G-A-P</td></tr>
            <tbody id="leaders"></tbody>
                 
            <tr><th colspan="2" class="STHSTop5"><?php echo $IndexLang['Top5Goal'];?></th></tr>
            <tr><td class="STHSIndex_Top5PointNameHeader"><?php echo $PlayersLang['PlayerName'];?></td><td class="STHSIndex_Top5PointResultHeader">GP-G</td></tr>
            <tbody id="top5Goals"></tbody>

            <tr><th colspan="2" class="STHSTop5"><?php echo $IndexLang['Top5Goalies'];?></th></tr>
            <tr><td class="STHSIndex_Top5PointNameHeader"><?php echo $PlayersLang['GoalieName'];?></td><td class="STHSIndex_Top5PointResultHeader">W-PCT</td></tr>                
            <tbody id="top5Goalies"></tbody>      
              
            <tr><th colspan="2" class="STHSTop5"><?php echo $IndexLang['Top5Defenseman'];?></th></tr>
            <tr><td class="STHSIndex_Top5PointNameHeader"><?php echo $PlayersLang['PlayerName'];?></td><td class="STHSIndex_Top5PointResultHeader">G-A-P</td></tr>            
            <tbody id="top5Defenses"></tbody>

            <tr><th colspan="2" class="STHSTop5"><?php echo $IndexLang['Top5Rookies'];?></th></tr>
            <tr><td class="STHSIndex_Top5PointNameHeader"><?php echo $PlayersLang['PlayerName'];?></td><td class="STHSIndex_Top5PointResultHeader">G-A-P</td></tr>
            <tbody id="top5Rookies"></tbody>
           
                 
            <?php if(isset($LeagueGeneral)){
            if (strlen($LeagueGeneral['Days73StarPro']) > 20){echo "<tr><th colspan=\"2\" class=\"STHSTop5\"><br /><br />" . $IndexLang['7DaysStar'] . "</th></tr><tr><td colspan=\"2\">" . str_replace("/", "<br />",$LeagueGeneral['Days73StarPro']) . "</td></tr>";}
            if (strlen($LeagueGeneral['Days303StarPro']) > 20){echo "<tr><th colspan=\"2\" class=\"STHSTop5\"><br /><br />" . $IndexLang['30DaysStar'] . "</th></tr><tr><td colspan=\"2\">" . str_replace("/", "<br />",$LeagueGeneral['Days303StarPro']) . "</td></tr>";}
            }?> 

        </table>
              
    </div>
</div>




<script>


function genLeaderLine( player,isScorer=false, isGoalie=false, headshot=false ) 
{
    let htmlOutput = "";
    htmlOutput += "<tr><td>";
    if(player.TeamThemeID != "N/A") htmlOutput += `<img src="/images/${player.TeamThemeID}.png" alt="" class="STHSPHPIndividualLeadersTeamImage" />`;
    htmlOutput += `<a href="PlayerReport.php?Player=${player.Number}">${player.Name} (${player.Abbre})</a>`;
    if (headshot) htmlOutput += `<div class="Headshot"><img loading="lazy" src="https://assets.nhle.com/mugs/nhl/latest/${player.NHLID}.png}" alt="" class="STHSPHPIndexLeadersHeadshot" /></div>`;
    if(isScorer)        htmlOutput += `</td><td>${player.GP}-${player.G}</td></tr>`; 
    else if (isGoalie)  htmlOutput += `</td><td>${player.W}-${player.PCT}</td></tr>`; 
    else              htmlOutput += `</td><td>${player.G}-${player.A}-${player.P}</td></tr>`; 

    return htmlOutput;
}

function updateSection(divID, players, isScorer=false, isGoalie=false) {
    let isFirst = true;
    let inhtml = "";
    players.forEach(player => {  inhtml += genLeaderLine(player, isScorer, isGoalie, isFirst);   isFirst = false;    });
    document.getElementById(divID).innerHTML = inhtml;
}


function actualizeData()
{
    let LoopCount = 0; 
    let htmlOutput = "";


    document.getElementById('starPro1').innerHTML = leagueGeneral[0].Today3StarPro1;  //  TODO   !?!?  devrait pas ete un array
    document.getElementById('starPro2').innerHTML = leagueGeneral[0].Today3StarPro2;
    document.getElementById('starPro3').innerHTML = leagueGeneral[0].Today3StarPro3;

   


    const leaders = getLeaders();
    console.log(leaders)
    leaders.forEach(player => { 
                    LoopCount++; 
                    htmlOutput += "<tr><td>"; 
                    if(player.TeamThemeID != "N/A") htmlOutput += `<img src="/images/${player.TeamThemeID}.png" alt="" class="STHSPHPIndividualLeadersTeamImage" /><a href="PlayerReport.php?Player=${player.Number}">${player.Name} (${player.Abbre})</a>`; 
                    if (LoopCount === 1) { 
                        htmlOutput += `<div class="Headshot"><img loading="lazy" src="/images/${player.NHLID}.png" alt="" class="STHSPHPIndexLeadersHeadshot" /></div>` ; 
                    } 
                    htmlOutput += `</td><td>${player.G}-${player.A}-${player.P}</td></tr>`;
    })

    document.getElementById('leaders').innerHTML = htmlOutput


    const top5Goals = getTop5Scorer()
    updateSection('top5Goals', top5Goals, true)


    const goalerLeaders = getGoalerLeaders()
    updateSection('top5Goalies', goalerLeaders, false, true)
    
 
    const top5Defenses = getTop5Defenses()
    updateSection('top5Defenses', top5Defenses)
    
    const top5Rookies = getTop5Rookies()
    updateSection('top5Rookies', top5Rookies)
}



document.addEventListener('DOMContentLoaded', function() {
    updateInfos(actualizeData)
})








</script>
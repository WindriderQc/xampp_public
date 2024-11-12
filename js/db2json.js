

let allPlayersInfo = [];
let allPlayersStats = [];
let allProTeamInfo = [];
let allProTeamStats = [];
let allProTeamLines = [];

let leagueGeneral = [];


async function fetch_players_info() { 
    try { 
        const response = await fetch('../../components/sql/fetch_player_info.php'); 
        const data = await response.json(); 
        if (data.error) { console.error(data.error); } 
        else { 
            allPlayersInfo = data; console.log("PlayersInfo", allPlayersInfo); 
           // displayPlayersInfo(allPlayersInfo, 'dataDisplay'); // Display initial info if needed 
            } 
    } 
    catch (error) { console.error('Error fetching player info:', error);
    }
}

async function fetch_players_stats() { 
    try { 
        const response = await fetch('../../components/sql/fetch_player_pro_stats.php'); 
        const data = await response.json(); 
        if (data.error) { console.error(data.error); } 
        else { 
            allPlayersStats = data; console.log("PlayersStats", allPlayersStats); 
           // displayPlayersInfo(allPlayersInfo, 'dataDisplay'); // Display initial info if needed 
            } 
    } 
    catch (error) { console.error('Error fetching player info:', error);
    }
}


async function fetch_teams_info() {
    const response = await fetch('../../components/sql/fetch_team_info.php');
    const data = await response.json(); 
    if (data.error) { 
        console.error(data.error); 
    } 
    else { 
        allProTeamInfo = data; 
        console.log("ProTeamInfo", allProTeamInfo);
        //displayPlayersInfo(allPlayersInfo); // Display initial info if needed 
        }
}

async function fetch_teams_stats() {
    const response = await fetch('../../components/sql/fetch_team_stats.php');
    const data = await response.json(); 
    if (data.error) { 
        console.error(data.error); 
    } 
    else { 
        allProTeamStats = data; 
        console.log("ProStats", allProTeamStats);
        }
}

async function fetch_teams_lines() {
    const response = await fetch('../../components/sql/fetch_team_lines.php');
    const data = await response.json(); 
    if (data.error) { 
        console.error(data.error); 
    } 
    else { 
        allProTeamLines = data; 
        console.log("ProLines", allProTeamLines);
        
        }
}


async function fetch_leagueGeneral() {
    const response = await fetch('../../components/sql/fetch_leagueGeneral.php');
    const data = await response.json(); 
    if (data.error) { 
        console.error(data.error); 
    } 
    else { 
        leagueGeneral = data; 
        console.log("leagueGeneral", leagueGeneral);
       
        }
}




//  Initiatizing global variable with DB data.
async function getAllInfos() 
{
    await fetch_leagueGeneral();
    await fetch_teams_info();
    await fetch_teams_lines(); 
    await fetch_teams_stats();
    await fetch_players_info(); // Call filterPlayers with the desired ID to filter and display data
    await fetch_players_stats();
}


getAllInfos();



//helper functions

function displayPlayersInfo(players, displayDivID) {
    // Assuming you have some container to display the player info
    const container = document.getElementById(displayDivID); // document.getElementById('playerInfoContainer');
    container.innerHTML = ''; // Clear current content


    //container.innerHTML = allPlayersInfo.Position     //   ou whatever data specifique désiré :)

    players.forEach(player => {
        const listItem = document.createElement('li');
        listItem.textContent = JSON.stringify(player);
        container.appendChild(listItem);
    });
}


function filterPlayers(uniqueID) {
    const filteredPlayer = allPlayersInfo.filter(player => player.Number == uniqueID);
   // displayPlayersInfo(filteredPlayers, 'playerInfoContainer');
   console.log("Filtered player", filteredPlayer[0]);
    return filteredPlayer[0];
}



function displayField(playerID, displayDivID) 
{
    const container = document.getElementById(displayDivID); 
    const container2 = document.getElementById("specificField2"); 


    const filteredPlayer = filterPlayers(playerID);

    console.log("ID", playerID, "data", filteredPlayer);

    container.innerHTML = filteredPlayer.Name;
    container2.innerHTML = filteredPlayer.Weight
}



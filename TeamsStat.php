<?php include "Header.php"; ?>


<!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css">
</head>
<body>
<?php include "Menu.php";?>

<div style="width:99%;margin:auto;">
    
    <div id="title" class="m-4 mb-1"><h1> Team Stats </h1></div>
   

    <div id="ReQueryDiv" style="display:block;">
        <?php /*include "SearchTeamsStat.php";*/ ?>
    </div>

    <div>
        Toggle column: <a class="toggle-vis" data-column="0">Name</a> - <a class="toggle-vis" data-column="1">Position</a> - <a class="toggle-vis" data-column="2">Office</a> - <a class="toggle-vis" data-column="3">Age</a> - <a class="toggle-vis" data-column="4">Start date</a> - <a class="toggle-vis" data-column="5">Salary</a>
    </div>

    <table id="teamStatsTable" class="display m-4 p-1"></table>

    </div>

</div>

<script>

let teamsInfo



function initTable() {


    // Dynamically generate columns array 
    const columns = Object.keys(teamsInfo[0]).map(key => ({ title: key, data: key }));



    const table = $('#teamStatsTable').DataTable({
        paging: false,
        scrollY: '200px',
        data: teamsInfo,
        columns: columns,
        /*columns: [
            { title: "Number", data: "Number" },
            { title: "Name", data: "Name" },
            { title: "OrderName", data: "OrderName" },
            { title: "GP", data: "GP" },
            { title: "W", data: "W" },
            { title: "L", data: "L" },
            { title: "T", data: "T" },
            { title: "OTW", data: "OTW" },
            { title: "OTL", data: "OTL" },
            { title: "SOW", data: "SOW" },
            { title: "SOL", data: "SOL" },
            { title: "Points", data: "Points" },
            { title: "GF", data: "GF" },
            { title: "GA", data: "GA" },
            { title: "HomeGP", data: "HomeGP" },
            { title: "HomeW", data: "HomeW" },
            { title: "HomeL", data: "HomeL" },
            { title: "HomeT", data: "HomeT" },
            { title: "HomeOTW", data: "HomeOTW" },
            { title: "HomeOTL", data: "HomeOTL" },
            { title: "HomeSOW", data: "HomeSOW" },
            { title: "HomeSOL", data: "HomeSOL" },
            { title: "HomeGF", data: "HomeGF" },
            { title: "HomeGA", data: "HomeGA" },
            { title: "PPAttemp", data: "PPAttemp" },
            { title: "PPGoal", data: "PPGoal" },
            { title: "PKAttemp", data: "PKAttemp" },
            { title: "PKGoalGA", data: "PKGoalGA" },
            { title: "PKGoalGF", data: "PKGoalGF" },
            { title: "ShotsFor", data: "ShotsFor" },
            { title: "ShotsAga", data: "ShotsAga" },
            { title: "ShotsBlock", data: "ShotsBlock" },
            { title: "ShotsPerPeriod1", data: "ShotsPerPeriod1" },
            { title: "ShotsPerPeriod2", data: "ShotsPerPeriod2" },
            { title: "ShotsPerPeriod3", data: "ShotsPerPeriod3" },
            { title: "ShotsPerPeriod4", data: "ShotsPerPeriod4" },
            { title: "GoalsPerPeriod1", data: "GoalsPerPeriod1" },
            { title: "GoalsPerPeriod2", data: "GoalsPerPeriod2" },
            { title: "GoalsPerPeriod3", data: "GoalsPerPeriod3" },
            { title: "GoalsPerPeriod4", data: "GoalsPerPeriod4" },
            { title: "PuckTimeInZoneDF", data: "PuckTimeInZoneDF" },
            { title: "PuckTimeInZoneOF", data: "PuckTimeInZoneOF" },
            { title: "PuckTimeInZoneNT", data: "PuckTimeInZoneNT" },
            { title: "PuckTimeControlinZoneDF", data: "PuckTimeControlinZoneDF" },
            { title: "PuckTimeControlinZoneOF", data: "PuckTimeControlinZoneOF" },
            { title: "PuckTimeControlinZoneNT", data: "PuckTimeControlinZoneNT" },
            { title: "Shutouts", data: "Shutouts" },
            { title: "TotalGoal", data: "TotalGoal" },
            { title: "TotalAssist", data: "TotalAssist" },
            { title: "TotalPoint", data: "TotalPoint" },
            { title: "Pim", data: "Pim" },
            { title: "Hits", data: "Hits" },
            { title: "FaceOffWonDefensifZone", data: "FaceOffWonDefensifZone" },
            { title: "FaceOffTotalDefensifZone", data: "FaceOffTotalDefensifZone" },
            { title: "FaceOffWonOffensifZone", data: "FaceOffWonOffensifZone" },
            { title: "FaceOffTotalOffensifZone", data: "FaceOffTotalOffensifZone" },
            { title: "FaceOffWonNeutralZone", data: "FaceOffWonNeutralZone" },
            { title: "FaceOffTotalNeutralZone", data: "FaceOffTotalNeutralZone" },
            { title: "EmptyNetGoal", data: "EmptyNetGoal" }
        ]*/
    });

    document.querySelectorAll('a.toggle-vis').forEach((el) => {
        el.addEventListener('click', function (e) {
            e.preventDefault();

            let columnIdx = e.target.getAttribute('data-column');
            let column = table.column(columnIdx);

            // Toggle the visibility
            column.visible(!column.visible());
        });
    });
}


async function fetch_teamStats() { 

    const response = await fetch('TeamsInfo_fetch.php'); 
    const data = await response.json(); 
    if (data.error) { console.error(data.error); } 
    else { 
        teamsInfo = data; 
        console.log("teamsInfo", teamsInfo);  
        initTable();
    } 
}
fetch_teamStats();


</script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.js"></script>

<?php include "Footer.php"; ?>




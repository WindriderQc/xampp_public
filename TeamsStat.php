<?php include "Header.php"; ?>

<!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css">
</head>
<body>
<?php include "Menu.php";?>

<div class="dataTables_wrapper">
    
    <div id="title" class="m-4 mb-1"><h1> Team Stats </h1></div>

    <div id="ReQueryDiv" style="display:block;">
        <?php /*include "SearchTeamsStat.php";*/ ?>
    </div>
    
    <div id="toggleColumns" class="dropdown mx-4">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="toggleColumnsButton" data-bs-toggle="dropdown" aria-expanded="false">
            Toggle Columns
        </button>
        <ul class="dropdown-menu" aria-labelledby="toggleColumnsButton">
            <!-- Checkboxes will be dynamically added here -->
        </ul>
    </div>


    <table id="teamStatsTable" class="display m-4 p-1"> </table>
</div>

<script>
$(document).ready(function() {

    let teamsInfo;

    function initTable() {

    // Dynamically generate columns array with default visibility
    const defaultVisibleKeys = [ "OrderName", "GP", "W", "L", "OTW", "SOW", "SOL","Points", "GF", "GA", ]; // Default visible columns

    const columns = Object.keys(teamsInfo[0]).map((key) => {
        const isVisible = defaultVisibleKeys.includes(key);
        return {
            title: key,
            data: key,
            visible: isVisible, // Set initial visibility based on defaults
            render: key === "OrderName" ? function (data, type, row) {
                const iconFilename = row["TeamThemeID"];
                const iconUrl = `images/${iconFilename}.png`;
                return `<img src="${iconUrl}" alt="${iconFilename}" style="width:20px; height:20px; margin-right:8px;"> ${data}`;
            } : undefined,
        };
    });





    // Initialize the DataTable
    const table = $('#teamStatsTable').DataTable({
        paging: false,
        data: teamsInfo,
        columns: columns,
        autoWidth: false, // Disable automatic column width expansion
       
    });





   // Dynamically generate toggle checkboxes
    const toggleColumnsDiv = document.getElementById("toggleColumns");
    const dropdownMenu = toggleColumnsDiv.querySelector(".dropdown-menu"); 

    columns.forEach((col, idx) => {
       
        const listItem = document.createElement("li");

        const checkbox = document.createElement("input");
        checkbox.type = "checkbox";
        checkbox.className = "form-check-input";
        checkbox.id = `toggle-column-${idx}`;
        checkbox.dataset.column = idx; // Set column index
        checkbox.checked = col.visible; // Sync with column visibility

        const label = document.createElement("label");
        label.className = "form-check-label";
        label.htmlFor = `toggle-column-${idx}`;
        label.textContent = col.title;

        listItem.appendChild(checkbox);
        listItem.appendChild(label);
        dropdownMenu.appendChild(listItem);

        // Add event listener for toggling column visibility
        checkbox.addEventListener("change", function () {
            const column = table.column(idx);
            column.visible(this.checked); // Sync visibility with checkbox state
        });
    });

}

    // Add click event for column visibility toggle
    document.querySelectorAll('a.toggle-vis').forEach((el) => {
        el.addEventListener('click', function (e) {
            e.preventDefault();

            const columnIdx = e.target.getAttribute('data-column');
            const column = table.column(columnIdx);

            column.visible(!column.visible());
        });
    });



    async function fetch_teamStats(successCallback=null) { 
        const response = await fetch('TeamsInfo_fetch.php'); 
        const data = await response.json(); 
        if (data.error) { console.error(data.error); } 
        else { 
            teamsInfo = data; 
            console.log("teamsInfo", teamsInfo);  
            if(successCallback) successCallback();
        } 
    }

    fetch_teamStats(initTable);

});
</script>

<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.js"></script>

<?php include "Footer.php"; ?>


<script >
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

<script/>
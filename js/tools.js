 // Function to load the navbar from the external file
 async function loadNavbar() {
    const response = await fetch('/tools/menu.html');
    const navbarHtml = await response.text();
    document.getElementById('navbar-placeholder').innerHTML = navbarHtml;
}

//  Function to test a request to the database via a PHP request
async function testDB() {
    const selectedTable = 'TeamInfo';  
    const selectedField = 'Number';  
    const selectedValue = '21';  

    const testResp = await fetch(`/components/sql/fetch_db.php?table=${selectedTable}&field=${selectedField}&value=${selectedValue}`);
    console.log('Testing db - team 21:', testResp)
}


// Function to fetch and populate the table dropdown
async function fetchTableList() {
    try {
        const response = await fetch('/components/sql/fetch_db_table_names.php'); // Replace with the correct PHP path
        const data = await response.json();

        const tableSelector = document.getElementById('tableSelector');
        data.forEach(table => {
            const option = document.createElement('option');
            option.value = table;
            option.textContent = table;
            tableSelector.appendChild(option);
        });
    } catch (error) {
        console.warn('Error fetching table list:', error);
    }
}




// Display the selected table's first row on page load
async function displaySelectedTable() {
    const selectedTable = document.getElementById('tableSelector').value;

    if (selectedTable) {
        try {
            const response = await fetch(`/components/sql/fetch_db.php?table=${selectedTable}`);
            if (!response.ok) throw new Error('Network response was not ok');

            // Log the response to inspect its structure
            const data = await response.json();
            console.log('Fetched Data:', data, "Selected Table", selectedTable);

            // Check if we are handling multiple tables or a single table's data
            if (data[selectedTable]) {
                // If data for a single table is returned
                const tableData = data[selectedTable];
                if (tableData && tableData.columns && tableData.firstRow) {
                    displayTableData(tableData.columns, tableData.firstRow);
                } else {
                    console.warn('Invalid data structure for table:', selectedTable);
                    //alert('Error: Invalid data structure received.');
                    // Dump raw data if structure is invalid
                    dumpRawData(data);
                }
            } else {
                console.error('Data for selected table not found:', selectedTable);
                alert('Error: Data for the selected table was not found.');
            }
        } catch (error) {
            console.error('Error fetching table data:', error);
        }
    } else {
        document.getElementById('tableDisplay').innerHTML = '';
    }
}


// Display data in single-column format
function displayTableData(columns, rowData) {
    const container = document.getElementById('tableDisplay');
    container.innerHTML = ''; // Clear previous data

    // Ensure columns and rowData are properly passed
    if (Array.isArray(columns) && typeof rowData === 'object') {
        columns.forEach(column => {
            const row = document.createElement('div');
            row.classList.add('row');

            const columnDiv = document.createElement('div');
            columnDiv.classList.add('col-6');
            columnDiv.textContent = column;

            const valueDiv = document.createElement('div');
            valueDiv.classList.add('col-6');
            valueDiv.textContent = rowData[column] || 'N/A';

            row.appendChild(columnDiv);
            row.appendChild(valueDiv);
            container.appendChild(row);
        });
    } else {
        console.error('Invalid columns or rowData format', columns, rowData);
        alert('Error: Invalid columns or row data format.');
    }
}

// Function to dump raw data when the structure is invalid
function dumpRawData(data) {
    const container = document.getElementById('tableDisplay');
    container.innerHTML = ''; // Clear any previous content

    // Check if the raw data is an array or object and display it
    if (Array.isArray(data)) {
        // If it's an array, display each item
        data.forEach(item => {
            const row = document.createElement('div');
            row.classList.add('row');
            row.textContent = JSON.stringify(item);  // Stringify to display raw data
            container.appendChild(row);
        });
    } else if (typeof data === 'object') {
        // If it's an object, display key-value pairs
        Object.keys(data).forEach(key => {
            const row = document.createElement('div');
            row.classList.add('row');
            row.textContent = `${key}: ${JSON.stringify(data[key])}`;  // Stringify values
            container.appendChild(row);
        });
    } else {
        // For any other type (e.g., string or number), just display it
        const row = document.createElement('div');
        row.classList.add('row');
        row.textContent = JSON.stringify(data);
        container.appendChild(row);
    }
}




//*************** 

//  Page Configuration and Execution

//****************


async function loadStart() {
    
    await loadNavbar();
    
    await testDB();
    
    await fetchTableList();

}
window.onload = loadStart;


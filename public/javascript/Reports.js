//new records go into this table
const table = document.getElementById('task');

const namesMapDetailed = {
    'title' : 'Title',
    'projectName' : 'Project name',
    'clientName' : 'Client name',
    'wage' : 'Wage',
    'startTime' : 'Started',
    'stopTime' : 'Ended',
    'totalTime' : 'Duration',
    'totalPayout' : 'Payout'
};

const namesMapAggregated = {
    'projectName' : 'Project name',
    'clientName' : 'Client name',
    'wage' : 'Wage',
    'startTime' : 'Started',
    'stopTime' : 'Ended',
    'totalTime' : 'Total time',
    'totalPayout' : 'Total payout'
};

function getResults() {
    const form = new FormData(document.getElementById('form'));
    fetch('index.php?action=reports-filter', {
        method: 'POST',
        mode: "same-origin",
        credentials: "same-origin",
        body: form
    }).then(response => response.text())
        .then(text => {
            try {

                const data = JSON.parse(text);
                fillTable(data);
                //console.log(data);
                // Do your JSON handling here
            } catch(err) {
                // It is text, do you text handling here
            }
        });
}

//convert every JSON object to a table record and insert it into the main table
function fillTable(data) {
    console.log(table);
    table.innerHTML = '';
    let keys = Object.keys(data[0]);
    let map = keys.includes('title') ? namesMapDetailed : namesMapAggregated;
    let thead = document.createElement('thead');
    let tr = document.createElement('tr');
    for (let key of keys) {
        let th = document.createElement('th');
        th.innerText = map[key];
        tr.appendChild(th);
    }
    thead.appendChild(tr);

    //tutaj tworzysz tbody
    for (let row of data) {
        //tutaj tworzysz tr
        console.log(row);
        for (let key in row) {
            //tutaj tworzysz td i ustawiasz mu innerText
            console.log(key);
            console.log(row[key]);
            //tutaj dołączas td do tr
        }
        //tutaj dołączasz tr do tbody
    }
    table.appendChild(thead);
    //tutaj dołączasz tbody do table
}
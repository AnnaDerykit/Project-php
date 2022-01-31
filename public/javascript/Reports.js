//new records go into this table
const table = document.getElementById('task');

const namesMapDetailed = {
    'title': 'Title',
    'projectName': 'Project name',
    'clientName': 'Client name',
    'wage': 'Wage',
    'startTime': 'Started',
    'stopTime': 'Ended',
    'totalTime': 'Duration',
    'totalPayout': 'Payout'
};

const namesMapAggregated = {
    'projectName': 'Project name',
    'clientName': 'Client name',
    'wage': 'Wage',
    'startTime': 'Started',
    'stopTime': 'Ended',
    'totalTime': 'Total time',
    'totalPayout': 'Total payout'
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
            } catch(err) {}
        });
}

function generateFiles() {
    const form = new FormData(document.getElementById('form'));
    fetch('index.php?action=reports-generate', {
        method: 'POST',
        mode: "same-origin",
        credentials: "same-origin",
        body: form
    }).then(response => response.text())
        .then(text => {
            try {
                const data = JSON.parse(text);
                console.log(data);
                fillTable(data);
            } catch (err) {
            }
        });
}



function fillTable(data) {
    table.innerHTML = '';

    if (data.length > 0) {
        let keys = Object.keys(data[0]);
        let collective = ! keys.includes('title');
        let map = collective ? namesMapAggregated : namesMapDetailed;

        let thead = document.createElement('thead');
        let tr = document.createElement('tr');
        for (let key of keys) {
            let th = document.createElement('th');
            th.innerText = map[key];
            tr.appendChild(th);
        }
        thead.appendChild(tr);

        let tbody = document.createElement('tbody');
        for (let row of data) {
            let tr = document.createElement('tr');

            for (let key in row) {
                let td = document.createElement('td');
                if (key === 'projectName' && collective && !row[key]) {
                    td.innerText = '\[undefined\]';
                    td.classList.add('rep-undefined');
                } else {
                    td.innerText = row[key];
                }
                tr.appendChild(td);
            }
            tbody.appendChild(tr);
        }
        table.appendChild(thead);
        table.appendChild(tbody);
    } else {
        let message = document.createElement('div');
        message.classList.add('f-header');
        message.innerText = 'No matches found.';
        table.appendChild(message);
    }
}

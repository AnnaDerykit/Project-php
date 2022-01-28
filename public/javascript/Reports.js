function getResults() {
    const form = new FormData(document.getElementById('form'));
    console.log(...form);
    fetch('index.php?action=reports-filter', {
        method: 'POST',
        mode: "same-origin",
        credentials: "same-origin",
        body: form
    }).then(response => response.text())
        .then(text => {
            try {

                const data = JSON.parse(text);
                console.log(data);
                // Do your JSON handling here
            } catch(err) {
                // It is text, do you text handling here
            }
        });
}

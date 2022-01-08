function onFocusOut(ID) {
    let modifiedRow = document.getElementById(ID);
    let id = modifiedRow.id;
    let username = modifiedRow.getElementsByClassName('user_usr')[0].innerText;
    let email = modifiedRow.getElementsByClassName('email_usr')[0].innerText;
    let password = modifiedRow.getElementsByClassName('passw_usr')[0].innerText;
    let select = modifiedRow.getElementsByClassName('role_select')[0];
    let role = select.options[select.selectedIndex].text;
    let message = new FormData();
    message.append('id', id);
    message.append('username', username);
    message.append('email', email);
    message.append('password', password);
    message.append('role', role);
    fetch('index.php?action=edit-user', {
        method: 'POST',
        mode: "same-origin",
        credentials: "same-origin",
        body: message
    }).then(r => {});
}
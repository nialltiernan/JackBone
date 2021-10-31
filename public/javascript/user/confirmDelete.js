const deleteButtons = document.getElementsByClassName('btn-danger');

for (let button of deleteButtons) {
    button.onclick = () => {
        return confirm('Do you really want to delete this user?');
    }
}

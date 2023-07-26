const editContainer = document.querySelector('#edit-container');

editContainer.addEventListener('click', function (e) {
    const target = e.target.closest('.prop-editable');

    if (!target) return;

    const input = document.createElement('input');
    if (target.dataset.editable === 'title') {
        input.type = 'text';
        input.value = target.textContent.trim();
    } else {
        return;
    }

    target.innerText = "";
    target.appendChild(input);
    target.classList.remove('prop-editable');
});
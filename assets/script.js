function openModal(id) {
    document.getElementById("modal-" + id).classList.add("is-active");
}

function closeModal(id) {
    document.getElementById("modal-" + id).classList.remove("is-active");
}
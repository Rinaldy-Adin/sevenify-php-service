function toggleOptionsMenu() {
    console.log('toggleOptionsMenu() dijalankan');
    var optionsMenu = document.getElementById('optionsMenu');
    if (optionsMenu.style.display === 'block') {
        optionsMenu.style.display = 'none';
    } else {
        optionsMenu.style.display = 'block';
    }
}


// Tambahkan event listener untuk tombol options-icon
var optionsIcon = document.querySelector('.options-icon');
optionsIcon.addEventListener('click', toggleOptionsMenu);

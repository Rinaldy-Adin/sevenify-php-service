
    // Fungsi untuk menampilkan nama akun yang telah diatur
    function showAccountName() {
        // Ganti "John Doe" dengan nama akun yang sesuai
        var accountName = "John Doe"; // Ganti dengan nama akun yang sesuai dari pengaturan akun
        document.getElementById("account-name").textContent = accountName;
    }

    // Tambahkan event listener untuk tombol "View Account"
    document.getElementById("view-account-button").addEventListener("click", function () {
        // Ganti URL berikut dengan URL halaman akun yang sesuai
        window.location.href = "account.html"; // Ganti dengan URL halaman akun
    });

    // Panggil fungsi untuk menampilkan nama akun saat halaman dimuat
    showAccountName();

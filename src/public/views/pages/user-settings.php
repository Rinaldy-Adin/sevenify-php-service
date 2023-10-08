<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/styles/global.css">
    <link rel="stylesheet" href="public/styles/artist.css">
    <link rel="stylesheet" href="public/styles/user-settings.css">
    <title>Sevenify</title>
</head>

<body>
    <header>
        <div class="profile">
            <img src="/public/assets/placeholders/music-placeholder.jpg" alt="Profile Image" class="profile-image">
            <div class="profile-details">
                <div>
                    <span id="user-account-name">Nama Pemilik</span></p>
                    <span id="user-account-gmail">akun@gmail.com</span></p>
                </div>
                <button id="view-account-button" class="view-account-button">View Account</button>
            
            </div>
        </div>
    </header>

    <main>
        <section class="settings">
            <h2>User Account Settings</h2>
            <div class="language-setting">
                <h3>Language</h3>
                <select>
                    <option value="english">English</option>
                    <option value="spanish">Spanish</option>
                    <option value="french">French</option>
                    <!-- Tambahkan pilihan bahasa lainnya -->
                </select>
            </div>
            <div class="autoplay-setting">
                <h3>Auto Play</h3>
                <label class="switch">
                    <input type="checkbox">
                    <span class="slider"></span>
                </label>
            </div>
            <div class="audio-quality-setting">
                <h3>Audio Quality</h3>
                <select>
                    <option value="high">High</option>
                    <option value="medium">Medium</option>
                    <option value="low">Low</option>
                    <!-- Tambahkan pilihan kualitas audio lainnya -->
                </select>
            </div>
            <div class="download-quality-setting">
                <h3>Download Quality</h3>
                <select>
                    <option value="high">High</option>
                    <option value="medium">Medium</option>
                    <option value="low">Low</option>
                    <!-- Tambahkan pilihan kualitas download lainnya -->
                </select>
            </div>
        </section>
    </main>
    <script src="public/javascript/user-setting.js"></script>
</body>
</html>

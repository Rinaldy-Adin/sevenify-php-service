<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/public/styles/global.css">
    <link rel="stylesheet" href="/public/styles/search.css">
    <link rel="stylesheet" href="/public/styles/music-bar.css">
    <link rel="stylesheet" href="/public/styles/nav-bar.css">
    <title>Sevenify</title>
</head>

<body>
    <?php require ROOT_DIR . 'public/views/components/nav-bar.php'; ?>
    
    <div class="container">
        <div class="search-container hard-shadow">
            <h1>Search</h1>
            <input id="search-input" type="text" name="search" placeholder="Search music or artists">
        </div>
        <div class="content">
            <div class="search-options-container">
                <div class="search-options">
                    <h2>Filter Results</h2>
                    <div class="search-option-container">
                        <div class="search-option">
                            <div class="search-criteria">By Upload Date</div>
                            <select id="filter-by-date-dropdown">
                                <option value="all-time" selected>All time</option>
                                <option value="today">Today</option>
                                <option value="last-week">Last week</option>
                                <option value="last-month">Last month</option>
                                <option value="last-year">Last year</option>
                            </select>
                        </div>
                        <div class="search-option">
                            <div class="search-criteria">By Genre</div>
                            <select id="filter-by-genre-dropdown">
                                <option value="all" selected>All Genres</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="search-options">
                    <h2>Sort Results</h2>
                    <div class="search-option-container">
                        <div class="search-option">
                            <div class="search-criteria">By Upload Date</div>
                            <select id="sort-by-date-dropdown">
                                <option value="unsorted" selected>Unsorted</option>
                                <option value="descending">Descending</option>
                                <option value="ascending">Ascending</option>
                            </select>
                        </div>
                        <div class="search-option">
                            <div class="search-criteria">By Genre (Alphabetical)</div>
                            <select id="sort-by-genre-dropdown">
                                <option value="unsorted" selected>Unsorted</option>
                                <option value="descending">Descending</option>
                                <option value="ascending">Ascending</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="vertical-divider"></div>
            <div class="search-results-container">
                <h2>Music List</h2>
                <div class="search-results">
                    <div id="search-page-results">
                    </div>
                    <div id="pagination">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require ROOT_DIR . 'public/views/components/music-bar.php'; ?>

    <script src="public/javascript/adios.js"></script>
    <script src="public/javascript/music-bar.js"></script>
    <script src="public/javascript/search.js"></script>
</body>

</html>
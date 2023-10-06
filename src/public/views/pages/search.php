<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="public/styles/global.css">
    <link rel="stylesheet" href="public/styles/search.css">
    <link rel="stylesheet" href="public/styles/music-bar.css">
    <title>Sevenify</title>
</head>

<body>
    <div class="container">
        <div class="search-container">
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
                            <select id="filter-by-upload-dropdown">
                                <option value="all-time" selected>All time</option>
                                <option value="today">Today</option>
                                <option value="this-week">Last week</option>
                                <option value="this-month">This month</option>
                                <option value="this-year">This year</option>
                            </select>
                        </div>
                        <div class="search-option">
                            <div class="search-criteria">By Genre</div>
                            <select id="filter-by-genre-dropdown">
                                <option value="all-time" selected>All time</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="search-options">
                    <h2>Sort Results</h2>
                    <div class="search-option-container">
                        <div class="search-option clickable">
                            <div class="search-criteria">By Upload Date</div>
                            <!-- Down caret -->
                            <div hidden class="icon-container">
                                <svg id="sort-by-upload-down-caret" width="16" height="10" viewBox="0 0 16 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1.88 -0.000117278L8 6.10655L14.12 -0.000117278L16 1.87988L8 9.87988L0 1.87988L1.88 -0.000117278Z" fill="currentColor" />
                                </svg>
                            </div>
                            <!-- Dash -->
                            <div class="icon-container">
                                <svg id="sort-by-upload-dash" width="16" height="3" viewBox="0 0 16 3" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M0 2.66667H8H16V0H8H0V2.66667Z" fill="currentColor" />
                                </svg>
                            </div>
                            <!-- Up caret -->
                            <div hidden class="icon-container">
                                <svg id="sort-by-upload-up-caret" width="16" height="10" viewBox="0 0 16 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1.88 9.88L8 3.77333L14.12 9.88L16 8L8 0L0 8L1.88 9.88Z" fill="currentColor" />
                                </svg>
                            </div>
                        </div>
                        <div class="search-option clickable">
                            <div class="search-criteria">By Genre</div>
                            <!-- Down caret -->
                            <div hidden class="icon-container">
                                <svg id="sort-by-upload-down-caret" width="16" height="10" viewBox="0 0 16 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1.88 -0.000117278L8 6.10655L14.12 -0.000117278L16 1.87988L8 9.87988L0 1.87988L1.88 -0.000117278Z" fill="currentColor" />
                                </svg>
                            </div>
                            <!-- Dash -->
                            <div class="icon-container">
                                <svg id="sort-by-upload-dash" width="16" height="3" viewBox="0 0 16 3" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M0 2.66667H8H16V0H8H0V2.66667Z" fill="currentColor" />
                                </svg>
                            </div>
                            <!-- Up caret -->
                            <div hidden class="icon-container">
                                <svg id="sort-by-upload-up-caret" width="16" height="10" viewBox="0 0 16 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1.88 9.88L8 3.77333L14.12 9.88L16 8L8 0L0 8L1.88 9.88Z" fill="currentColor" />
                                </svg>
                            </div>
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
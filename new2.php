<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
        <title>Channels</title>
        <script src="https://unpkg.com/feather-icons"></script>
        <script src="sorttable.js"></script>
    </head>
    <body>
        <header class="navbar navbar-dark sticky-top flex-md-nowrap p-2 shadow" style="background-color: #222222">
            <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#">Straming Mirror</a>
            <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <ul class="navbar-nav px-3">
                <li class="nav-item text-nowrap">
                    <a class="nav-link" href="#">Sign out</a>
                </li>
            </ul>
        </header>
        <div class="container-fluid">
            <div class="row">
                <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar collapse" style="background-color: #333333">
                    <div class="position-fixed pt-3">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <span data-feather="tv"></span>
                                    Channel list
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#"></span>
                                    <span data-feather="bar-chart-2"></span>
                                    Analysis
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
                <main class="col-md-9 ms-sm-auto col-lg-10 px-md-0">
                    <table class="table table-hover table-borderless table-striped table-sm sortable" style="text-align: center">
                        <thead class="align-middle">
                            <tr>
                                <th>#</th>
                                <th>Site</th>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Official</th>
                                <th>Count</th>
                                <th>Main owner</th>
                                <th>Last updated<br/>(UTC+0)</th>
	                        </tr>
	                    </thead>
	                    <tbody class="align-middle">
                            <?php
                                require 'connect.php';
                                $query_total = "SELECT * FROM `channel_info`";
                                $cursor_total = $connect->prepare($query_total);
                                $cursor_total->execute();
                                $total = $cursor_total->rowCount();
                                $result_all = $cursor_total->fetchAll();
                                for ($i=0; $i<$total; $i++) {
                                    $id = $result_all[$i]['id'];
                                    $site = $result_all[$i]['site'];
                                    if (preg_match('/\YT/i', $site)) {
                                        $site_full = 'YouTube';
                                    } elseif (preg_match('/\BI/i', $site)) {
                                        $site_full = 'bilibili';
                                    } elseif (preg_match('/\NC/i', $site)) {
                                        $site_full = 'niconico';
                                    } elseif (preg_match('/\TW/i', $site)) {
                                        $site_full = 'Twitter';
                                    } else {
                                        $site_full = $site;
                                    }
                                    $channel_id = $result_all[$i]['channel_id'];
                                    $channel_title = $result_all[$i]['channel_title'];
                                    $is_official = $result_all[$i]['is_official'];
                                    if ($is_official == 1) {
                                        $is_official_parse = 'Yes';
                                    } else {
                                        $is_official_parse = 'No';
                                    }
                                    $query_count = "SELECT COUNT(channel_id) FROM `video_info` WHERE `channel_id` = '$channel_id'";
                                    $cursor_count = $connect->prepare($query_count);
                                    $cursor_count->execute();
                                    $result_count = $cursor_count->fetchColumn();
                                    $owner = $result_all[$i]['user'];
                                    $query_updated = "SELECT `created_at` FROM `video_info` WHERE `channel_id` = '$channel_id' ORDER BY `created_at` DESC LIMIT 1";
                                    $cursor_updated = $connect->prepare($query_updated);
                                    $cursor_updated->execute();
                                    $result_updated = $cursor_updated->fetch()['created_at'];
                                    echo '<tr>';
                                    echo '<td>' . $id . '</td>';
                                    echo '<td>' . $site_full . '</td>';
                                    echo '<td>' . $channel_id . '</td>';
                                    echo '<td style="text-align: left">' . $channel_title . '</td>';
                                    echo '<td>' . $is_official_parse . '</td>';
                                    echo '<td style="text-align: right">' . $result_count . '</td>';
                                    echo '<td>' . $owner . '</td>';
                                    echo '<td>' . $result_updated . '</td>';
                                    echo '</tr>';
                                }
                            ?>
                        </tbody>
                    </table>
                </main>
            </div>
        </div>
        <script>feather.replace()</script>
        <!-- Optional JavaScript; choose one of the two! -->
        <!-- Option 1: Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
        <!-- Option 2: Separate Popper and Bootstrap JS -->
        <!--
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js" integrity="sha384-KsvD1yqQ1/1+IA7gi3P0tyJcT3vR+NdBTt13hSJ2lnve8agRGXTTyNaBYmCR/Nwi" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js" integrity="sha384-nsg8ua9HAw1y0W1btsyWgBklPnCUAFLuTMS2G72MMONqmOymq585AcH49TLBQObG" crossorigin="anonymous"></script>
        -->
    </body>
</html>
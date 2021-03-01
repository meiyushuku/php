<!doctype html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>ふうちゃんマジ天使</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <script src="sorttable.js"></script>
        <style type="text/css">
            /* Sortable tables */
            table.sortable thead {
                background-color:#333333;
                color:#DDDDDD;
                font-weight: bold;
                cursor: default;
            }
        </style>
    </head>
    <body class="text-center" style="background-color: #222222">
        <h1 style="margin-top: 1rem; color: #C9D4D4">Channel Information</h1>
        <table class="sortable" width="75%" style="margin: 0 auto; text-align: center; color: #DDDDDD">
            <h6>
                <tr id="tr1" onmouseover="changeColor('tr1', 'over')" onmouseover="changeColor('tr1', 'out')">
                    <th>#</th>
                    <th>Site</th>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Official</th>
                    <th>Count</th>
                    <th>Main owner</th>
                    <th>Last updated<br>(UTC+0)</th>
                </tr>
            </h6>
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
                    echo '<td>' . $channel_title . '</td>';
                    echo '<td>' . $is_official_parse . '</td>';
                    echo '<td>' . $result_count . '</td>';
                    echo '<td>' . $owner . '</td>';
                    echo '<td>' . $result_updated . '</td>';
                    echo '</tr>';
                }
            ?>
        </table>
    </body>
</html>
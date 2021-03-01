<!doctype html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>ふうちゃんマジ天使</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <style>
            body {
                background-color: #1E1E1E
            }
        </style>
    </head>
    <body class="text-center">
        <h1 style="margin-top: 1rem; color: #C9D4D4">Channel Information</h1>
        <div style="background-color: #1E1E1E">
        <table rules="rows" width="80%" style="margin: 0 auto; text-align: center; color: #C9D4D4">
            <tr>
                <th>Site</th>
                <th>ID</th>
                <th>Title</th>
                <th>Count</th>
            </tr>
            <?php
                require 'connect.php';
                $query = "SELECT * FROM `channel_info`";
                $cursor = $connect->prepare($query);
                $cursor->execute();
                $count = $cursor->rowCount();
                $result = $cursor->fetchAll();
                for ($i=0; $i<$count; $i++) {
                    $site = $result[$i]['site'];
                    if (preg_match('/\YT/i', $site)) {
                        $site_full = 'YouTube';
                    } elseif (preg_match('/\BI/i', $site)) {
                        $site_full = 'bilibili';
                    } elseif (preg_match('/\NC/i', $site)) {
                        $site_full = 'niconico';
                    } else {
                        $site_full = $site;
                    }
                    $channel_id = $result[$i]['channel_id'];
                    $channel_title = $result[$i]['channel_title'];
                    $query2 = "SELECT COUNT(channel_id) FROM `video_info` WHERE `channel_id` = '$channel_id'";
                    $cursor2 = $connect->prepare($query2);
                    $cursor2->execute();
                    $result2 = $cursor2->fetchColumn();
                    echo '<tr>';
                        echo '<td>';
                        echo $site_full;
                        echo '</td>'; 
                        echo '<td>';
                        echo $channel_id;
                        echo '</td>';                   
                        echo '<td>';
                        echo $channel_title;
                        echo '</td>';
                        echo '<td>';
                        echo $result2;
                        echo '</td>';
                    echo '</tr>';
                }
            ?>
        </table>
        </div>
    </body>
</html>
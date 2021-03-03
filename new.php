<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
        <title>Dashboard</title>
    </head>
    <body>

    <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
  <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#">Channel Information</a>
  <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
  <ul class="navbar-nav px-3">
    <li class="nav-item text-nowrap">
      <a class="nav-link" href="#">Sign out</a>
    </li>
  </ul>
</header>

<div class="container-fluid">
  <div class="row">
    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
      <div class="position-sticky pt-3">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">
              <span data-feather="home"></span>
              Dashboard
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span data-feather="file"></span>
              Orders
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span data-feather="shopping-cart"></span>
              Products
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span data-feather="users"></span>
              Customers
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span data-feather="bar-chart-2"></span>
              Reports
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span data-feather="layers"></span>
              Integrations
            </a>
          </li>
        </ul>

        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
          <span>Saved reports</span>
          <a class="link-secondary" href="#" aria-label="Add a new report">
            <span data-feather="plus-circle"></span>
          </a>
        </h6>
        <ul class="nav flex-column mb-2">
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span data-feather="file-text"></span>
              Current month
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span data-feather="file-text"></span>
              Last quarter
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span data-feather="file-text"></span>
              Social engagement
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span data-feather="file-text"></span>
              Year-end sale
            </a>
          </li>
        </ul>
      </div>
    </nav>


    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <h1 style="margin-top: 1rem; color: #C9D4D4">Channel Information</h1>
        <style>
	.demo th {
        text-align:center;
		padding:5px;
	}
	.demo td {
		text-align:center;
		padding:5px;
	}
</style>
<table class="demo">
    <thead>
    <tr>
	    <th>#</th>
		<th>Site<br></th>
		<th>ID</th>
		<th>Title</th>
		<th>Official<br></th>
		<th>Count<br></th>
		<th>Main owner<br></th>
		<th>Last updated</th>
	</tr>
	</thead>
	<tbody>
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



<script src='//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js'></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.9.0/css/theme.bootstrap.css" integrity="sha512-nIqLzEsUK9UwyfbpstULSTZBaIFdyzU0NIKZwrJ0hOhxMAfNL6OsG0OYhNy948cq7pjXi6DVyO1yuMCZ5cLeDg==" crossorigin="anonymous" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.9.1/jquery.tablesorter.min.js" integrity="sha512-mWSVYmb/NacNAK7kGkdlVNE4OZbJsSUw8LiJSgGOxkb4chglRnVfqrukfVd9Q2EOWxFp4NfbqE3nDQMxszCCvw==" crossorigin="anonymous"></script>
<script>
$(".demo").tablesorter({
theme: "bootstrap",
widgets: ['zebra']
});
</script>








        <table class="sortable" width="100%" style="margin: 0 auto; text-align: center">
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

        </main>
  </div>
</div>
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
<?php
include('connect-db.php');
$filename = 'exportedEngines.html';
header('Content-disposition: attachment; filename=' . $filename);
header('Content-type: text/html');
?>

<!--
This downloaded file has all the engines from the database you exported.
Click on an engine button to add it to your new installation
-->
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Export Engines</title>
</head>

<body>
    <div class="container">
        <h1>All Engines exported from: <a
                href="http://<?=$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']?>"><?=$_SERVER['SERVER_NAME']?></a></h1>
        <a href="index.php">Go back to home page</a>
        <hr>
        <h3>SFW Engines</h3>
        <?php

        $query = "SELECT * FROM `searcher_engines` WHERE nsfw=0";
        $result = mysqli_query($link, $query);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {
                if ($row ['hidden'] == 1) {
                    // if hidden, use the old identifier value and notify that it was hidden
                    echo '<button class="btn btn-warning my-1 newEngineMake" data-sitename="'.$row['site name'].'" data-identifier="'.$row['old-identifier'].'" data-urlprefix="'.$row['url-prefix'].'" data-urlsuffix="'.$row['url-suffix'].'"                 data-baseurl="'.$row['baseurl'].'" data-nsfw="'.$row['nsfw'].'">'.$row['site name'].' (Hidden)</button>';
                } else {
                    echo '<button class="btn btn-primary my-1 newEngineMake" data-sitename="'.$row['site name'].'" data-identifier="'.$row['identifier'].'" data-urlprefix="'.$row['url-prefix'].'" data-urlsuffix="'.$row['url-suffix'].'" data-baseurl="'.$row['baseurl'].'" data-nsfw="'.$row['nsfw'].'">'.$row['site name'].'</button>';
                }
                echo '
                
                ';
            }
        }
        ?>

        <h3>NSFW Engines</h3>
        <?php
        $query = "SELECT * FROM `searcher_engines` WHERE nsfw=1";
        $result = mysqli_query($link, $query);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {
                if ($row ['hidden'] == 1) {
                    // if hidden, use the old identifier value and notify that it was hidden
                    echo '<button class="btn btn-warning my-1 newEngineMake" data-sitename="'.$row['site name'].'" data-identifier="'.$row['old-identifier'].'" data-urlprefix="'.$row['url-prefix'].'" data-urlsuffix="'.$row['url-suffix'].'"                 data-baseurl="'.$row['baseurl'].'" data-nsfw="'.$row['nsfw'].'">'.$row['site name'].' (Hidden)</button>';
                } else {
                    echo '<button class="btn btn-primary my-1 newEngineMake" data-sitename="'.$row['site name'].'" data-identifier="'.$row['identifier'].'" data-urlprefix="'.$row['url-prefix'].'" data-urlsuffix="'.$row['url-suffix'].'" data-baseurl="'.$row['baseurl'].'" data-nsfw="'.$row['nsfw'].'">'.$row['site name'].'</button>';
                }
                echo '
                
                ';
            }
        }
        ?>
        <hr />
        <div class="card" style="width: 100%;">
            <div class="card-body">
                <h5 class="card-title">Template Button</h5>
                <p class="card-text">&lt;button class=&quot;btn btn-primary my-1 newEngineMake&quot;
                    data-sitename=&quot;&quot; data-identifier=&quot;&quot; data-urlcardfix=&quot;&quot;
                    data-urlsuffix=&quot;&quot; data-baseurl=&quot;https://&quot;
                    data-nsfw=&quot;&quot;&gt;&lt;/button&gt;
                </p>
            </div>
        </div>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <script>
    // make new search engine
    $(".newEngineMake").click(function(e) {
        e.preventDefault();

        trigger = e.target;
        dataGroup = trigger.dataset;

        var sitename = dataGroup.sitename;
        var identifier = dataGroup.identifier;
        var urlprefix = dataGroup.urlprefix;
        var urlsuffix = dataGroup.urlsuffix;
        var baseurl = dataGroup.baseurl;
        var nsfw = dataGroup.nsfw;

        if ((sitename != '' && identifier != '' && urlprefix != '') || identifier == 'pureURL' ||
            identifier == 'pureURL NSFW') {
            $.ajax({
                type: "POST",
                url: "searchdb.php",
                data: {
                    sitename: sitename,
                    identifier: identifier,
                    urlprefix: urlprefix,
                    urlsuffix: urlsuffix,
                    baseurl: baseurl,
                    nsfw: nsfw
                },
                success: function(data) {
                    if (data == 'engine inserted') {
                        alert('Success')
                    } else {
                        console.log(data)
                        alert(data)
                    }
                }
            });
        } else {
            alert('The button is broken')
        }
    });
    </script>
</body>

</html>
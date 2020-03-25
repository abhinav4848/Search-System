<?php
// a database based universal searcher that keeps track of all your searches
// Allows export and import of search engines
// allows editing and deletion of search engines
// has pure url search option
// can hide NSFW results from home page
// has get url parameter auto generated as you type
// suggest searches as you type, based on old searches
include('connect-db.php');

/** AJAX SCRIPTS */

// Insert search term into database
if (array_key_exists('searchTerm', $_POST) and $_POST['searchTerm']!='' and array_key_exists('submit', $_POST)) {
    $query = "INSERT INTO `searcher_searches` (`searchTerm`, `engine`, `datetime`, `searcher`)
        VALUES (
        '".mysqli_real_escape_string($link, $_POST['searchTerm'])."',
        '".mysqli_real_escape_string($link, $_POST['engine'])."',
        '".date('Y-m-d H:i:s')."',
        '1');";

    if (mysqli_query($link, $query)) {
        echo 'data inserted';
    } else {
        echo 'failed to enter into database. Query was: <b>'.$query.'</b>';
    }
    die();
}

// Search term in database
if (array_key_exists('searchTerm', $_POST)) {
    if ($_POST['searchTerm']!='') {
        $query = "SELECT * FROM `searcher_searches` WHERE `searchTerm` LIKE '%".mysqli_real_escape_string($link, $_POST['searchTerm'])."%' LIMIT 10";

        $result = mysqli_query($link, $query);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {
                //insert the search term into box, focus the box, simulate a keyup() on the box
                $onclickattribute = "document.getElementById('searchField').value ='".$row['searchTerm']."'; document.getElementById('searchField').focus(); searchField();";
                echo '<li><label class="historyList" onclick="'.$onclickattribute.'"><span class="text-primary">'.$row['searchTerm'].'</span> <small><code>('.$row['engine'].')</code> (Date: '. date("d-M-Y h:i:s a", strtotime($row['datetime'])).')</small></label></li>';
            }
        }
    }
    die();
}

// add new engine
if ((array_key_exists('sitename', $_POST) and $_POST['sitename']!='' and
array_key_exists('identifier', $_POST) and $_POST['identifier']!='' and
array_key_exists('urlprefix', $_POST) and $_POST['urlprefix']!='') or
(array_key_exists('sitename', $_POST) and $_POST['sitename']!='' and
array_key_exists('identifier', $_POST) and
($_POST['identifier']=='pureURL' or
$_POST['identifier']=='pureURL NSFW'))) {
    // either all 3 parameters are present
    // or sitename is present and identifier is one of the two options
    $query_CheckUnique = "SELECT * FROM `searcher_engines` WHERE identifier='".mysqli_real_escape_string($link, $_POST['identifier'])."' LIMIT 1";
    $result_CheckUnique = mysqli_query($link, $query_CheckUnique);

    if (mysqli_num_rows($result_CheckUnique) > 0) {
        echo 'That engine already exists';
    } else {
        $query_insertEngine = "INSERT INTO `searcher_engines` (`site name`, `identifier`, `url-prefix`, `url-suffix`, `baseurl`, `nsfw`)
        VALUES (
        '".mysqli_real_escape_string($link, $_POST['sitename'])."',
        '".mysqli_real_escape_string($link, $_POST['identifier'])."',
        '".mysqli_real_escape_string($link, $_POST['urlprefix'])."',
        '".mysqli_real_escape_string($link, $_POST['urlsuffix'])."',
        '".mysqli_real_escape_string($link, $_POST['baseurl'])."',
        '".mysqli_real_escape_string($link, $_POST['nsfw'])."');";

        if (mysqli_query($link, $query_insertEngine)) {
            echo 'engine inserted';
        } else {
            echo 'failed to enter into database. Query was: <b>'.$query_insertEngine.'</b>';
        }
    }
    die();
}

// delete a history entry
if (array_key_exists('delete_history', $_POST) and array_key_exists('id', $_POST) and $_POST['id']!='') {
    $query_delete_history = "DELETE FROM `searcher_searches` WHERE `searcher_searches`.`id` = ".mysqli_real_escape_string($link, $_POST['id'])." LIMIT 1";
    if (mysqli_query($link, $query_delete_history)) {
        echo 'history deleted.';
    } else {
        echo 'failed to delete. Query was: <b>'.$query_delete_history.'</b>';
    }
    die();
}

// change Engine
if (array_key_exists('changeEngine', $_POST)) {
    if ($_POST['changeEngine'] == 'changeEngine') {
        // find all details about the engine as requested
        $query = "SELECT * FROM `searcher_engines` WHERE identifier='".mysqli_real_escape_string($link, $_POST['engine'])."' LIMIT 1";
    
        $result = mysqli_query($link, $query);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            echo json_encode($row);
        } else {
            echo 'failed to find. Query was: <b>'.$query.'</b>';
        }
    }
    if ($_POST['changeEngine'] == 'update') {
        // update engine info
        $query = "UPDATE `searcher_engines` 
        SET `site name` = '".mysqli_real_escape_string($link, $_POST['sitename'])."',
        `url-prefix` = '".mysqli_real_escape_string($link, $_POST['urlprefix'])."',
        `url-suffix` = '".mysqli_real_escape_string($link, $_POST['urlsuffix'])."',
        `baseurl` = '".mysqli_real_escape_string($link, $_POST['baseurl'])."',
        `nsfw` = ".mysqli_real_escape_string($link, $_POST['nsfw'])."
        WHERE id = ".mysqli_real_escape_string($link, $_POST['id'])." LIMIT 1";

        if (mysqli_query($link, $query)) {
            echo 'success';
        } else {
            echo 'failed to update. Query was: <b>'.$query.'</b>';
        }
    }
    if ($_POST['changeEngine'] == 'delete') {
        // get the identifier column from selected engine
        $query = "SELECT `identifier` FROM `searcher_engines` WHERE id='".mysqli_real_escape_string($link, $_POST['id'])."' LIMIT 1";
        $result = mysqli_query($link, $query);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);

            // set the engine to hidden, and free up the identifier column (by inserting a random string), but remember it as old-identifier
            $query = "UPDATE `searcher_engines` SET
            `hidden` = 1,
            `old-identifier` = '".mysqli_real_escape_string($link, $row['identifier'])."',
            `identifier` = '".bin2hex(random_bytes('15'))."'
            WHERE id = ".mysqli_real_escape_string($link, $_POST['id'])." LIMIT 1";

            if (mysqli_query($link, $query)) {
                echo 'success';
            } else {
                echo 'failed to Delete. Query was: <b>'.$query.'</b>';
            }
        } else {
            echo 'failed. Could not extract details of the engine';
        }
    }
    die();
}

?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/9c2d6b042e.js"></script>

    <style type="text/css">
    #results {
        display: none;
    }

    .select2-container .select2-selection--single {
        height: 34px !important;
        margin-bottom: 0px;
    }

    .historyList {
        cursor: pointer;
    }

    .historyList:hover {
        background-color: pink;
    }

    .delete_history {
        transition: font-size 0.2s;
        margin-left: 10px;
    }

    .delete_history:hover {
        font-size: 1.2em;
        color: red;
    }

    /*restore the cancel button on searchbox that bootstrap breas*/
    input[type="search"]::-webkit-search-cancel-button {
        -webkit-appearance: searchfield-cancel-button;
    }

    #error,
    #success {
        display: none;
    }

    .card-text li:nth-child(odd) {
        /* Bootstrap table colour*/
        background-color: rgba(0, 0, 0, .05)
    }

    li {
        /* These are technically the same, but use both */
        overflow-wrap: break-word;
        word-wrap: break-word;

        -ms-word-break: break-all;
        /* This is the dangerous one in WebKit, as it breaks things wherever */
        word-break: break-all;
        /* Instead use this non-standard one: */
        word-break: break-word;

        /* Adds a hyphen where the word breaks, if supported (No Blink) */
        -ms-hyphens: auto;
        -moz-hyphens: auto;
        -webkit-hyphens: auto;
        hyphens: auto;
    }

    @media only screen and (max-width: 600px) {
        ol {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        #openurl {
            margin-top: 2px;
        }
    }
    </style>

    <title>Search Stuff</title>
</head>

<body>
    <div class="container">

        <h1>Smart Search</h1>
        <a href="defaultEngines.php">Install default Engines</a> |
        <a href="exportEngines.php" onclick="alert('upload the html file to home directory and visit it')">Export all
            engines</a> |
        <a href="exportedEngines.html">Visit exported file</a>

        <div class="card my-1" style="width: 100%;">
            <div class="card-body">
                <h5 class="card-title">Search</h5>
                <form class="form-inline" method="get" id="searchForm">

                    <div class="form-group">
                        <select name="engine" class="form-control" id="engine">
                            <?php
                                $query_engines = "SELECT * FROM `searcher_engines` WHERE `hidden`=0";
                                $result_engines = mysqli_query($link, $query_engines);
                                while ($row_engines = mysqli_fetch_array($result_engines)) {
                                    $identifier=$row_engines['identifier'];
                                    $sitename = $row_engines['site name'];
                                    $baseurl = $row_engines['baseurl'];
                                    echo "<option value='".$identifier."' data-url='".$baseurl."'>".$sitename." (".$identifier.")</option>";
                                }
                            ?>
                        </select>
                    </div>

                    <div class="form-group mx-sm-3">
                        <input autofocus type="search" size="50" name="searchTerm" class="form-control" id="searchField"
                            autocomplete="off" wid placeholder="Enter search term here" <?php
                            if (array_key_exists('searchTerm', $_GET)) {
                                echo 'value="'.$_GET['searchTerm'].'"';
                            }
                            ?>>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary mx-1">Submit</button>
                        <span class="btn btn-primary mx-1" id="edit-engine"><i class="fas fa-edit"></i> Edit
                            Engine</span>
                        <span class="btn btn-primary mx-1" id="openurl"
                            onclick="window.open(document.getElementById('engine').options[document.getElementById('engine').selectedIndex].getAttribute('data-url'))"><i
                                class="fas fa-globe"></i></span>
                    </div>
                </form>

                <ol class="card-text" id="results">
                    <!-- Search results are displayed by ajax here-->
                </ol>
            </div> <!-- /.card-body -->
        </div> <!-- /.card -->

        <div class="alert alert-danger fade show mt-2" id="error"> </div>
        <div class="alert alert-success fade show mt-2" id="success"> </div>

        <div class="card" id="newengine" style="width: 100%;">
            <div class="card-body">
                <h5 class="card-title">New Engine Maker</h5>
                <form class="form-inline" id="newEngineMake">
                    <div class="form-group mr-sm-3 mb-2">
                        <input type="text" name="sitename" id="sitename" class="form-control" placeholder="Site Name">
                    </div>

                    <div class="form-group mr-sm-3 mb-2">
                        <input type="text" name="identifier" id="identifier" class="form-control"
                            placeholder="Unique Identifier">
                    </div>

                    <div class="form-group mr-sm-3 mb-2">
                        <input type="text" name="urlprefix" id="urlprefix" class="form-control"
                            placeholder="URL Prefix">
                    </div>

                    <div class="form-group mr-sm-3 mb-2">
                        <input type="text" name="urlsuffix" id="urlsuffix" class="form-control"
                            placeholder="URL Suffix">
                    </div>

                    <div class="form-group mr-sm-3 mb-2">
                        <input type="text" name="baseurl" id="baseurl" class="form-control" placeholder="Base URL">
                    </div>

                    <div class="form-group mr-sm-3 mb-2">
                        <select name="nsfw" id="nsfw" class="form-control">
                            <option value="0" hidden>NSFW?</option>
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary mb-2">Submit</button>
                </form>

            </div><!-- /.card-body -->
        </div><!-- /.card -->

        <pre>to-do:
- Change the engine as well when clicking on link</pre>
        <!-- - <s>Store a search url in pure form into the history, without searching for it in an engine</s>
        - <s>Export and import engines</s>
        - <s>Delete Engine</s>
        - <s>Include search term in address bar to allow direct links</s>
        - <s>Add ability to hide nsfw results</s>
        - <s>Add ability to edit engines</s> -->

        <div class="card my-1" style="width: 100%;">
            <div class="card-body">
                <h5 class="card-title">History</h5>
                <p class="small">
                    <a href="?filter=sfw-only">SFW</a> |
                    <a href="?filter=nsfw-only">NSFW</a> |
                    <a href="?filter=all">All</a>
                </p>
                <ol class="card-text">
                    <?php
                        $query = "SELECT *, searcher_searches.id AS searchID FROM `searcher_searches` INNER JOIN `searcher_engines` ON searcher_searches.engine = searcher_engines.identifier";
                        
                        if (array_key_exists('filter', $_GET)) {
                            if ($_GET['filter'] == 'sfw-only') {
                                $query.= " AND searcher_engines.nsfw='0'";
                            }
                            if ($_GET['filter'] == 'nsfw-only') {
                                $query.= " AND searcher_engines.nsfw='1'";
                            }
                            if ($_GET['filter'] == 'all') {
                                $query.= "";
                            }
                        } else {
                            $query.= " AND searcher_engines.nsfw='0'";
                        }
                        
                        $query.=" ORDER BY searcher_searches.id DESC LIMIT 100";
                        $result = mysqli_query($link, $query);
                        while ($row = mysqli_fetch_assoc($result)) {
                            // echo '<pre>';
                            // echo $query.'<br />';
                            // print_r($row);
                            // echo '</pre>';
                            $onclickattribute = "document.getElementById('searchField').value ='".$row['searchTerm']."'; document.getElementById('searchField').focus(); searchField();";
                            
                            echo '<li data-id="'.$row['searchID'].'">
                            <label class="historyList" onclick="'.$onclickattribute.'">
                            <span class="text-primary">'.$row['searchTerm'].'</span>
                            <small> <code>('.$row['engine'].')</code> (Date: '. date("d-M-Y h:i:s a", strtotime($row['datetime'])).')</small>
                            </label> 
                            <a href="#" class="delete_history" data-id="'.$row['searchID'].'">
                            <i class="far fa-trash-alt"></i>
                            </a>
                            </li>';
                        }
                    ?>
                </ol>
            </div> <!-- /.card-body -->
        </div> <!-- /.card -->

        <h3></h3>


    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>

    <script type="text/javascript">
    window.onload = function() {
        //making script select2
        $('#engine').select2();

        var url_string = window.location.href
        //The URL() constructor returns a newly created URL object representing the URL defined by the parameters.
        var url = new URL(url_string);
        var c = url.searchParams.get("search");
        document.getElementById('searchField').value = c;
        searchField();
    };

    // Searches with instant database results
    // if any key is entered, fire searchField()
    document.querySelector('#searchField').addEventListener('keyup', searchField, false);
    // if the "x" button is clicked on search box, fire searchField()
    document.querySelector('#searchField').addEventListener("search", searchField, false);

    function searchField() {
        var searchTerm = $("#searchField").val();

        if (searchTerm != '') {
            var engine = $("#engine").val();
            document.title = 'SearchStuff: (' + engine + ')  ' + searchTerm;
            window.history.replaceState('', '', window.location.pathname + '?search=' + searchTerm);
        } else {
            document.title = 'SearchStuff!';
            window.history.pushState('', '', window.location.pathname);
        }

        $.ajax({
            type: "POST",
            url: "searchdb.php",
            data: {
                searchTerm: searchTerm
            },
            success: function(result) {
                if (result != '') {
                    $("#results").show();
                    $("#results").html("<b>Results</b>:<br/>" + result);
                } else {
                    $("#results").hide();
                }
            }
        })
    }

    // make new search engine
    $("#newEngineMake").submit(function(e) {
        e.preventDefault();

        var sitename = $("#sitename").val();
        var identifier = $("#identifier").val();
        var urlprefix = $("#urlprefix").val();
        var urlsuffix = $("#urlsuffix").val();
        var baseurl = $("#baseurl").val();
        var nsfw = $("#nsfw").val();

        if (sitename != '' && identifier != '' && urlprefix != '') {
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
                        document.getElementById('success').style.display = 'block';
                        $("#success").html(data);
                        window.setTimeout(() => {
                                document.getElementById('success').style.display = 'none';
                            },
                            3000);
                    } else {
                        document.getElementById('error').style.display = 'block';
                        $("#error").html(data);
                        window.setTimeout(() => {
                                document.getElementById('error').style.display = 'none';
                            },
                            3000);
                    }
                }
            });
        } else {
            document.getElementById('error').style.display = 'block';
            $("#error").html('Please fill at least first 3 boxes');
            $("#sitename").focus();
            window.setTimeout(() => {
                    document.getElementById('error').style.display = 'none';
                },
                3000);
        }
    });

    // save search to db
    $("#searchForm").submit(function(e) {
        e.preventDefault();

        var searchTerm = $("#searchField").val();
        var engine = $("#engine").val();

        if (searchTerm != '') {
            $.ajax({
                type: "POST",
                url: "searchdb.php",
                data: {
                    searchTerm: searchTerm,
                    engine: engine,
                    submit: 'submit'
                },
                success: function(data) {
                    openup(engine, searchTerm);
                }
            });
        } else {
            document.getElementById('error').style.display = 'block';
            $("#error").html('Please Enter a Term');
            window.setTimeout(() => {
                    document.getElementById('error').style.display = 'none';
                },
                3000);
            $("#searchTerm").focus();
        }

    });

    // delete history
    $(".delete_history").click(function(e) {
        e.preventDefault();

        var id = $(this).attr("data-id");

        if (confirm("Sure you want to delete this entry?")) {
            $.ajax({
                type: "POST",
                url: "searchdb.php",
                data: {
                    delete_history: 'yes',
                    id: this.dataset.id
                },
                success: function(data) {
                    // show the flash msg
                    document.getElementById('success').style.display = 'block';
                    // fill data into the flash msg
                    $("#success").html(data);
                    // hide the flash message
                    window.setTimeout(() => {
                            document.getElementById('success').style.display = 'none';
                        },
                        3000);
                    // remove the entry from the list as well
                    document.querySelector('li[data-id="' + id + '"]').style.display =
                        "none";
                }
            });
        }
    });

    // edit engine
    $("#edit-engine").click(function(e) {
        //e.preventDefault();

        var engine = $("#engine").val();

        $.ajax({
            type: "POST",
            url: "searchdb.php",
            data: {
                changeEngine: 'changeEngine',
                engine: engine
            },
            success: function(data) {
                var modal = $('#changeSearchEngineDetails')
                modal.modal('show')

                data = JSON.parse(data)

                modal.find('#modal-id').val(data.id)
                modal.find('#modal-identifier').val(data.identifier)
                modal.find('.modal-body #sitename').val(data["site name"])
                modal.find('.modal-body #url-prefix').val(data["url-prefix"])
                modal.find('.modal-body #url-suffix').val(data["url-suffix"])
                modal.find('.modal-body #baseurl').val(data["baseurl"])
                modal.find('.modal-body #nsfw').val(data.nsfw)
                modal.find('#updateEngineButton').val('Update ' + data.identifier)
                modal.find('.modal-footer #deleteEngine')[0].setAttribute('data-identifier', data[
                    "identifier"]);
            }
        });
    })

    // actually update the engine
    $(document).on('click', '#updateEngineButton', function(e) {
        e.preventDefault();

        var modal = $('#changeSearchEngineDetails')

        $.ajax({
            type: "POST",
            url: "searchdb.php",
            data: {
                changeEngine: 'update',
                id: modal.find('#modal-id').val(),
                sitename: modal.find('.modal-body #sitename').val(),
                urlprefix: modal.find('.modal-body #url-prefix').val(),
                urlsuffix: modal.find('.modal-body #url-suffix').val(),
                baseurl: modal.find('.modal-body #baseurl').val(),
                nsfw: modal.find('.modal-body #nsfw').val()
            },
            success: function(data) {
                console.log(data)
                if (data == 'success') {
                    modal.modal('hide')
                } else {
                    document.getElementById('error').style.display = 'block';
                    $("#error").html(data)
                    window.setTimeout(() => {
                            document.getElementById('error').style.display = 'none';
                        },
                        3000);
                }
            }
        });
    })

    // delete engine. Doesn't actually delete. Just hides the engine and frees up the identifier
    $(document).on('click', '#deleteEngine', function(e) {
        e.preventDefault();

        var modal = $('#changeSearchEngineDetails')

        $.ajax({
            type: "POST",
            url: "searchdb.php",
            data: {
                changeEngine: 'delete',
                id: modal.find('#modal-id').val()
            },
            success: function(data) {
                console.log(data)
                if (data == 'success') {
                    modal.modal('hide');

                    document.getElementById('success').style.display = 'block';
                    $("#success").html(data + '...Reloading Page');

                    window.setTimeout(() => {
                            //hide the success box
                            document.getElementById('success').style.display = 'none';
                            // to prevent attempt at re-deleting an engine, 
                            // which might cause overwriting of old-identifier
                            window.location.reload();
                        },
                        3000);
                } else {
                    document.getElementById('error').style.display = 'block';
                    $("#error").html(data)
                    window.setTimeout(() => {
                            document.getElementById('error').style.display = 'none';
                        },
                        3000);
                }
            }
        });
    })
    </script>

    <div class="modal fade" id="changeSearchEngineDetails" tabindex="-1" role="dialog"
        aria-labelledby="changeSearchEngine_Label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changeSearchEngine_Label">Edit Engine</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="modal-id" class="col-form-label">ID</label>
                            <input type="text" class="form-control" id="modal-id" disabled>
                        </div>
                        <div class="form-group">
                            <label for="modal-identifier" class="col-form-label">Identifier</label>
                            <input type="text" class="form-control" id="modal-identifier" disabled>
                        </div>
                        <div class="form-group">
                            <label for="sitename" class="col-form-label">Site Name:</label>
                            <input type="text" class="form-control" id="sitename">
                        </div>
                        <div class="form-group">
                            <label for="url-prefix" class="col-form-label">URL Prefix:</label>
                            <input type="text" class="form-control" id="url-prefix">
                        </div>
                        <div class="form-group">
                            <label for="url-suffix" class="col-form-label">URL Suffix:</label>
                            <input type="text" class="form-control" id="url-suffix">
                        </div>
                        <div class="form-group">
                            <label for="baseurl" class="col-form-label">Base URL:</label>
                            <input type="text" class="form-control" id="baseurl">
                        </div>
                        <div class="form-group">
                            <label for="nsfw" class="col-form-label">NSFW</label>
                            <input type="text" class="form-control" id="nsfw">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <a href="#" class="text-danger" id="deleteEngine">Delete Engine</a>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="updateEngineButton">Update Engine</button>
                </div>
            </div>
        </div>
    </div> <!-- End modal -->
    <?php
        // generate javascript for every search engine
        echo '<script>';
        echo 'function openup(engine, search) {
            ';

        mysqli_data_seek($result_engines, 0);
        while ($row_engines = mysqli_fetch_array($result_engines)) {
            $identifier=$row_engines['identifier'];
            $prefix = $row_engines['url-prefix'];
            $suffix = $row_engines['url-suffix'];

            echo 'if (engine == "'.$identifier.'"){
                open("'.$prefix.'"+search+"'.$suffix.'")
            }
            ';
        }
        
        echo '}';
        echo '</script>';
    ?>
</body>

</html>
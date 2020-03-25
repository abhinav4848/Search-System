<html>

<head>
    <!--
         Developed by Abhinav Kumar :) , 2014
         Search Suggest feature thanx to https://shreyaschand.com/blog/2013/01/03/google-autocomplete-api/ , 2017
      -->
    <meta name="theme-color" content="#474e5d">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="http://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <!--Puts the search results in a dropdown box below search bar-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <!--Autosugegst driving part of search-->
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <title>The Invincible Searcher</title>
    <style type="text/css">
    a:link {
        color: #FF0000;
        text-decoration: none;
    }

    a:visited {
        color: #FF0000;
        text-decoration: underline;
    }

    a:hover {
        color: #0000FF;
        text-decoration: none;
    }

    a:active {
        color: #FF0000;
    }

    .pointermaker {
        cursor: pointer;
    }

    #inputbox:focus {
        outline: none;
    }

    .censored {
        display: none;
    }
    </style>
    <script>
    var suggestCallBack; // global var for autocomplete jsonp

    $(document).ready(function() {
        $("#inputBox").autocomplete({
            source: function(request, response) {
                $.getJSON("http://suggestqueries.google.com/complete/search?callback=?", {
                        "hl": "en", // Language
                        "jsonp": "suggestCallBack", // jsonp callback function name
                        "q": request.term, // query term
                        "client": "youtube" // force youtube style response, i.e. jsonp
                    }
                    /**"ds":"yt", Restrict lookup to youtube*/
                );
                suggestCallBack = function(data) {
                    var suggestions = [];
                    $.each(data[1], function(key, val) {
                        suggestions.push({
                            "value": val[0]
                        });
                    });
                    suggestions.length = 5; // prune suggestions list to only 5 items
                    response(suggestions);
                };
            },
        });
    });
    </script>
    <script>
    function notEmpty(elem, helperMsg) {
        if (elem.value.length == 0) {
            alert(helperMsg);
            elem.focus();
            return false;
        } else {
            openup();
            return true;
        }
    }

    function openup() {
        var engine;
        engine = document.myform.engine.value;
        var search;
        search = document.myform.query.value;
        if (engine == "google")
            open("http://www.google.com/search?q=" + search + "");
        if (engine == "googleimg")
            open("http://www.images.google.com/images?ie=utf-8&oe=utf-8&aq=t&q=" + search + "");
        if (engine == "bing")
            open("http://www.bing.com/search?q=" + search + "");
        if (engine == "wikipedia")
            open("http://en.wikipedia.org/wiki/Special:Search?search=" + search + "");
        if (engine == "archive.is")
            window.open("https://archive.today/?run=1&url=" + search + "");
        if (engine == "torrentz2.eu")
            open("https://torrentz2.eu/search?f=" + search + "");
        if (engine == "piratebay")
            open("https://thepiratebay.org/search/" + search + "/0/99/0");
        if (engine == "youtube")
            open("http://www.youtube.com/results?search_query=" + search + "");
        if (engine == "webarchivesave")
            open("http://web.archive.org/save/" + search + "");
        if (engine == "webarchiveview")
            open("http://web.archive.org/web/*/" + search + "");
        if (engine == "gfycat")
            open("http://www.gfycat.com/fetch/" + search + "");
        if (engine == "keepvid")
            open("http://www.keepvid.com/?url=" + search + "");
        if (engine == "1")
            window.open();
        if (engine == "2")
            window.open();
    }

    var foo = true;
    $(document).ready(function() {
        $(".showHide").click(function() {
            $(".censored").toggle();
            if (foo) {
                $(".showHide").text("Hide Censored Stuff?");
                foo = false;
            } else {
                $(".showHide").text("Show Stuff!");
                foo = true;
            }
        });
    });

    function highlight() {
        $("#inputBox").focus();
    }
    </script>
</head>

<body onclick="highlight()" style="background-color:#FEFEFE;">
    <center>
        <h2><span style="background-color: #FFFF9B; color: #FF0000;"><a href="search.php" title="Reload">Multiple Search
                    for you:</a></span></h2>
        <div class="col-sm-4"></div>
        <div class="col-sm-4">
            <form action="#" id="myform" name="myform" method="post">
                <div class="table-responsive">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td><label class="pointermaker"><input name="engine" onchange="highlight()" type="radio"
                                            value="google" />Google</label></td>
                                <td><label class="pointermaker"><input name="engine" onchange="highlight()" type="radio"
                                            value="googleimg" />Google Images</label></td>
                            </tr>
                            <tr>
                                <td><label class="pointermaker"><input name="engine" onchange="highlight()" type="radio"
                                            value="bing" />Bing</label></td>
                                <td><label class="pointermaker"><input name="engine" onchange="highlight()" type="radio"
                                            value="wikipedia" />Wikipedia</label></td>
                            </tr>
                            <tr>
                                <td><label class="pointermaker"><input name="engine" onchange="highlight()" type="radio"
                                            value="archive.is" />Archive.is</label></td>
                                <td><label class="pointermaker"><input name="engine" onchange="highlight()" type="radio"
                                            value="torrentz2.eu" />Torrentz2.eu</label></td>
                            </tr>
                            <tr>
                                <td><label class="pointermaker"><input name="engine" onchange="highlight()" type="radio"
                                            value="piratebay" />Piratebay</label></td>
                                <td><label class="pointermaker"><input name="engine" onchange="highlight()" type="radio"
                                            value="youtube" />YouTube</label></td>
                            </tr>
                            <tr>
                                <td><label class="pointermaker"><input name="engine" onchange="highlight()" type="radio"
                                            value="webarchivesave" />Save to Web Archive</label></td>
                                <td><label class="pointermaker"><input checked="checked" name="engine"
                                            onchange="highlight()" type="radio" value="webarchiveview" />View in Web
                                        Archive</label></td>
                            </tr>
                            <tr>
                                <td><label class="pointermaker"><input name="engine" onchange="highlight()" type="radio"
                                            value="keepvid" />Download Video</label></td>
                                <td><label class="pointermaker"><input name="engine" onchange="highlight()" type="radio"
                                            value="gfycat" />GFYcat</label></td>
                            </tr>
                            <tr>
                                <td><label class="pointermaker"><input name="engine" onchange="highlight()"
                                            type="hidden" value="" /></label></td>
                                <td><a class="showHide pointermaker"
                                        title="Click me to hide websites with crazy content">Show stuff!</a></td>
                            </tr>
                            <tr class="censored">
                                <td><label class="pointermaker"><input name="engine" onchange="highlight()" type="radio"
                                            value="1" />Empty 1</label></td>
                                <td><label class="pointermaker"><input name="engine" onchange="highlight()" type="radio"
                                            value="2" />Empty 2</label></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <p><input autofocus="" class="form-control input-lg" id="inputBox" name="query"
                        placeholder="Search Term" tabindex="2" title="Search" type="text" /></p>
                <p><button accesskey="a" onclick="notEmpty(document.getElementById('inputBox'), 'Please Enter a Value')"
                        class="btn btn-lg" name="submitsave" value="Save and Submit"><span
                            class="glyphicon glyphicon-search"></span> Search</button> <button type="reset"
                        accesskey="b" tabindex="3" title="Refresh.(alt+b)" class="btn btn-lg"><span
                            class="glyphicon glyphicon-remove"></span> Reset</button></p>
                <input type="hidden" name="filename" value="Search Values">
            </form>
            <hr />
            <h5>Copyleft 2014.<br />Cogia<sup><small><a href="Search Values.htm">TM</a></small></sup></h5>
        </div>
        <div class="col-sm-4"></div>
    </center>
    <?php
         if (isset($_POST)) {
             if ($_POST['submitsave'] == "Save and Submit"  && !empty($_POST['filename'])) {
                 if (!file_exists($_POST['filename'] . ".htm")) {
                     $file = tmpfile();
                 }
                 $file = fopen($_POST['filename'] . ".htm", "a+");
                 while (!feof($file)) {
                     $old = $old . fgets($file);
                 }
                 $text = date("d-m-Y") . ": " . $_POST["query"] . $_POST["engine"] . "<br />";
                 file_put_contents($_POST['filename'] . ".htm", $text . $old);
                 fclose($file);
             }
         }
         /*echo var_dump($_POST);

        Make a link

        if (substr('ab_123456789', 0, 3) === 'ab_')
        https://stackoverflow.com/questions/3282812/how-to-check-the-first-three-characters-in-a-variable*/
    ?>
</body>

</html>
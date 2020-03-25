<!--
Here is a sample set of search engines you might wanna install into your setup to make it usable out of the box
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

    <title>Auto Populate</title>
</head>

<body>
    <div class="container">
        <h1>Auto Populate fields</h1>
        <a href="index.php">Go back to home page</a>
        <hr>
        <h3>SFW Engines</h3>
        <button class="btn btn-primary my-1 newEngineMake" data-sitename="Google" data-identifier="google"
            data-urlprefix="http://www.google.com/search?q=" data-urlsuffix="" data-baseurl="https://google.com/"
            data-nsfw="0">Google</button>

        <button class="btn btn-primary my-1 newEngineMake" data-sitename="Google Images" data-identifier="googleimg"
            data-urlprefix="http://www.images.google.com/images?ie=utf-8&oe=utf-8&aq=t&q=" data-urlsuffix=""
            data-baseurl="https://google.com/imghp" data-nsfw="0">Google Images</button>

        <button class="btn btn-primary my-1 newEngineMake" data-sitename="Bing" data-identifier="bing"
            data-urlprefix="http://www.bing.com/search?q=" data-urlsuffix="" data-baseurl="https://bing.com/"
            data-nsfw="0">Bing</button>

        <button class="btn btn-primary my-1 newEngineMake" data-sitename="Wikipedia" data-identifier="wikipedia"
            data-urlprefix="http://en.wikipedia.org/wiki/Special:Search?search=" data-urlsuffix=""
            data-baseurl="https://en.wikipedia.org/" data-nsfw="0">Wikipedia</button>

        <button class="btn btn-primary my-1 newEngineMake" data-sitename="Archive.is" data-identifier="archive.is"
            data-urlprefix="https://archive.today/?run=1&url=" data-urlsuffix="" data-baseurl="https://archive.is"
            data-nsfw="0">Archive.is</button>

        <button class="btn btn-primary my-1 newEngineMake" data-sitename="Torrentz2.eu" data-identifier="torrentz2.eu"
            data-urlprefix="https://torrentz2.eu/search?f=" data-urlsuffix="" data-baseurl="https://torrentz2.eu"
            data-nsfw="0">Torrentz2.eu</button>

        <button class="btn btn-primary my-1 newEngineMake" data-sitename="PirateBay" data-identifier="piratebay"
            data-urlprefix="https://thepiratebay.org/search/" data-urlsuffix="/0/99/0"
            data-baseurl="https://thepiratebay.org" data-nsfw="0">PirateBay</button>

        <button class="btn btn-primary my-1 newEngineMake" data-sitename="YouTube" data-identifier="youtube"
            data-urlprefix="http://www.youtube.com/results?search_query=" data-urlsuffix=""
            data-baseurl="https://youtube.com" data-nsfw="0">YouTube</button>

        <button class="btn btn-primary my-1 newEngineMake" data-sitename="Save to WebArchive"
            data-identifier="webarchivesave" data-urlprefix="http://web.archive.org/save/" data-urlsuffix=""
            data-baseurl="http://web.archive.org/" data-nsfw="0">Save to WebArchive</button>

        <button class="btn btn-primary my-1 newEngineMake" data-sitename="View in Web Archive"
            data-identifier="webarchiveview" data-urlprefix="http://web.archive.org/web/*/" data-urlsuffix=""
            data-baseurl="http://web.archive.org/" data-nsfw="0">View in Web Archive</button>

        <button class="btn btn-primary my-1 newEngineMake" data-sitename="Library Genesis" data-identifier="libgen"
            data-urlprefix="https://libgen.is" data-urlsuffix="" data-baseurl="https://libgen.is/search.php?req="
            data-nsfw="0">Library Genesis</button>

        <button class="btn btn-danger my-1 newEngineMake" data-sitename="Pure Browse SFW" data-identifier="pureURL"
            data-urlprefix="" data-urlsuffix="" data-baseurl="" data-nsfw="0">Pure Browse SFW</button>

        <!-- <button class="btn btn-warning my-1 newEngineMake" data-sitename="Fake" data-identifier="fake"
    data-urlprefix="http://www.example.com/search?q=" data-urlsuffix="/fake/" data-baseurl="https://example.com/"
    data-nsfw="0">Fake Engine</button> -->

        <h3>NSFW Engines</h3>
        <button class="btn btn-primary my-1 newEngineMake" data-sitename="X-Videos" data-identifier="xvideos"
            data-urlprefix="https://www.xvideos.com/?k=" data-urlsuffix="" data-baseurl="https://xvideos.com"
            data-nsfw="1">X-Videos</button>

        <button class="btn btn-primary my-1 newEngineMake" data-sitename="PornHub" data-identifier="ph"
            data-urlprefix="https://www.pornhub.org/video/search?search=" data-urlsuffix=""
            data-baseurl="https://pornhub.com" data-nsfw="1">PornHub</button>

        <button class="btn btn-primary my-1 newEngineMake" data-sitename="HQporner" data-identifier="hqporner"
            data-urlprefix="https://hqporner.com/?q=" data-urlsuffix="" data-baseurl="https://hqporner.com"
            data-nsfw="1">HQporner</button>

        <button class="btn btn-danger my-1 newEngineMake" data-sitename="Pure Browse NSFW"
            data-identifier="pureURL NSFW" data-urlprefix="" data-urlsuffix="" data-baseurl="" data-nsfw="1">Pure Browse
            NSFW</button>

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
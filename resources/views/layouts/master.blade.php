<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8">
        <meta name="application" content="bernly">
        <meta name="author" content="Bernadine Computing">
        <meta name="description" content="A link (URL, web address) shortener.">
        <meta name="keywords" content="link, URL, web address, address, shorter, shorten, link shortener">

        <link rel="stylesheet"
              href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
              integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
              crossorigin="anonymous">
        <link rel="stylesheet"
              href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
              integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp"
              crossorigin="anonymous">
        <link rel="stylesheet"
              href="{{ Illuminate\Support\Facades\URL::asset( 'css/sticky-footer.css' ) }}">

        @yield( 'styles' )

        <title>{{ config('app.url_no_protocol') }} | Link Shorterner</title>
    </head>

    <body>
        <div class="navbar navbar-default" role="navigation">
            <div class="container" >
                <div class="navbar-header">
                    <button class="navbar-toggle"
                        type="button"
                        data-toggle="collapse"
                        data-target=".navbar-collapse"
                    >
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <a class="navbar-brand" href="/">
                        <img
                            src="{{ Illuminate\Support\Facades\URL::asset( 'img/bernly-logo.png') }}"
                            width="41.11"
                            height="20"
                        >
                    </a>
                </div>

                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li><a href="/">Home</a></li>
                    </ul>

                @if ( Auth::check() )

                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                My Account<b class="caret"></b>
                            </a>

                            <ul class="dropdown-menu">
                                <li><a href="/user/view">Profile</a></li>
                                <li><a href="/user/links">Links</a></li>
                                <li class="divider"></li>
                                <li><a href="/log/out">Log out</a></li>
                            </ul>
                        </li>
                    </ul>

                @else

                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="/log/in">Login</a></li>
                        <li><a href="/user/add">Register</a></li>
                    </ul>

                @endif

                </div><!--/.nav-collapse -->
            </div>
        </div>

        @yield( 'content' )

        <div id="footer">
            <div class="container">
                <p class="text-muted">&copy; Bernadine Computing (Pty) Ltd. 2014</p>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.1.0.min.js"
                integrity="sha256-cCueBR6CsyA4/9szpPfrX3s49M9vUU5BgtiJj06wt/s="
                crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
                integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
                crossorigin="anonymous"></script>

        @yield( 'scripts' )

    </body>
</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Vietnamese Student Association at The University of Alabama at Birmingham</title>
    <meta name="description" content="Vietnamese Student Association at The University of Alabama at Birmingham">
    <meta name="author" content="UABVSA">

    <meta property="og:title" content="Vietnamese Student Association at The University of Alabama at Birmingham">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ config('app.url') }}">
    <meta property="og:description" content="Vietnamese Student Association at The University of Alabama at Birmingham">
    <meta property="og:image" content="/logo.png">

    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#e9dcc0">
    <meta name="msapplication-TileColor" content="#e9dcc0">
    <meta name="theme-color" content="#e9dcc0">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        html, body {
            margin: 0;
        }

        body {
            font-family: 'Rubik', sans-serif;
            background: #131313;
        }

        #app {
            width: 100vw;
            height: 100%;
        }

        .background-video {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 100vw;
            z-index: -1;
        }

        .background-video::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background-color: rgba(0, 0, 0, 0.90);
        }

        .background-video video {
            height: 100%;
            width: 100%;
            object-fit: cover;
            transform: scale(1.12);
        }

        .landing-text {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            text-align: center;
            color: white;
            height: 100vh;
            width: 100vw;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Rubik', sans-serif;
            text-transform: uppercase;
            margin: 10px 0;
        }

        .text-chonky {
            letter-spacing: 10px;
            font-size: 36px;
        }

        h1 {
            font-size: 72px;
        }

        a.hidden {
            color: unset;
            text-decoration: none;
            position: relative;
            transition: color 150ms ease-in-out;
        }

        a.hidden::after {
            content: '';
            position: absolute;
            bottom: -3px;
            left: 0;
            height: 3px;
            width: 100%;
            background-color: #0984e3;
            opacity: 0;
            transform: translateY(-6px);
            transition: opacity, transform 150ms cubic-bezier(0.39, 0.58, 0.57, 1);
        }

        a.hidden:hover {
            color: #0984e3;
        }

        a.hidden:hover::after {
            opacity: 1;
            transform: none;
        }

        .socials {
            margin-top: 50px;
        }

        .socials .socials__link {
            color: transparent;
            text-decoration: none;
            margin: 0 15px;
        }

        .socials .socials__link svg path {
            fill: #fff;
            transition: fill 150ms ease-in-out;
        }

        .socials .socials__link--youtube:hover svg path {
            fill: #FF0000;
        }

        .socials .socials__link--instagram:hover svg path {
            fill: #E4405F;
        }

        a.login-text {
            position: absolute;
            display: block;
            top: 0;
            right: 0;
            padding: 25px 50px;
            text-transform: uppercase;
            font-family: 'Rubik', sans-serif;
            color: rgba(255, 255, 255, 0.09);
            text-decoration: none;
        }
    </style>
</head>
<body>
<div id="app">
    @if(Auth::user()?->isAdmin())
        <a href="{{ route('nova.login') }}" class="login-text">admin</a>
    @endif
    @guest
        <a href="{{ route('auth.redirect') }}" class="login-text">login</a>
    @endguest
    <div class="background-video">
{{--        <video autoplay muted loop src="/media/background_video.mp4"></video>--}}
    </div>
    <div class="landing-text">
        <h1 class="text-chonky">The</h1>
        <h1>Vietnamese</h1>
        <h1>Student Association</h1>
        <h4><a href="https://www.uab.edu/" target="_blank" class="hidden">at The University of Alabama at Birmingham</a>
        </h4>
        <div class="socials">
            {{-- https://simpleicons.org/ --}}
            <a href="https://www.instagram.com/uabvsa/" class="socials__link socials__link--instagram">
                <svg height="50px" width="50px" viewBox="0 0 24 24">
                    <path
                        d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z" />
                </svg>
            </a>
            <a href="https://www.youtube.com/channel/UCH3-smIlbsWm9xsadJkee7g" class="socials__link socials__link--youtube">
                <svg height="50px" width="50px" viewBox="0 0 24 24">
                    <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
                </svg>
            </a>
        </div>
    </div>
</div>
</body>
</html>

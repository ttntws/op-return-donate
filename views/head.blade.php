<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="referrer" content="origin">
    <meta name="robots" content="max-snippet:-1, max-image-preview:large, max-video-preview:-1"/>

    <link rel="preload" href="views/src/dist/fonts/poppins/poppins-regular.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="views/src/dist/fonts/poppins/poppins-700.woff2" as="font" type="font/woff2" crossorigin>

    <link href="views/src/dist/images/favicon.ico" rel="icon" type="image/x-icon" />

    <title>@yield('title')</title>
    <meta name="description" content="@yield('description')"/>
    <link rel="canonical" href="https://op-return.timtoews.de/@yield('canonical')" />
    <meta property="og:locale" content="de_DE" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="@yield('title')" />
    <meta property="og:description" content="@yield('description')" />
    <meta property="og:url" content="https://op-return.timtoews.de" />
    <meta property="og:image" content="https://op-return.timtoews.de/@yield('image')" />
    <meta property="og:image:secure_url" content="https://op-return.timtoews.de/@yield('image')" />
    <meta property="og:image:width" content="@yield('image_width')" />
    <meta property="og:image:height" content="@yield('image_height')" />
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:description" content="@yield('description')" />
    <meta name="twitter:title" content="@yield('title')" />
    <meta name="twitter:site" content="@timtoews" />
    <meta name="twitter:image" content="https://op-return.timtoews.de/@yield('image')" />
    <meta name="twitter:creator" content="@timtoews" />

    <link rel="stylesheet" href="views/src/dist/app.css?=<?php echo filemtime('views/src/dist/app.css'); ?>" />

    <?php echo partial('favicon'); ?>
</head>
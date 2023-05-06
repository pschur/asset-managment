<?php

require __DIR__.'/config.php';

$asset = \Pschur\Assets\Asset::cache();
?>

<!doctype html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Assets</title>

    <link rel="stylesheet" href="<?= $asset['css'] ?>">
</head>
<body class="container">
<h1>Demo</h1>

<article>
    <header>Demo</header>

    <p>
        this is a demo

        <a href="/assets.php?regenerate&back=/" role="button">Regenerate</a>

        <span id="demo"></span>
    </p>

    <script src="<?= $asset['js'] ?>"></script>
</article>
</body>
</html>

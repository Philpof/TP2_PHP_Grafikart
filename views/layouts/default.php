<!DOCTYPE html>
<html lang="fr" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Mon site' ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
</head>
<body class="d-flex flex-column h-100">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <a href="#" class="navbar-brand">Mon site</a>
    </nav>

    <div class="container mt-4">
        <?= $content ?>
    </div>

    <footer class="bg-light py-4 footer mt-auto">
        <div class="container">
        
            Page générée en <?= round(1000 * (microtime(true) - DEBUG_TIME), 2) ?> ms par PhilPof.
        </div>
    </footer>
</body>
</html>

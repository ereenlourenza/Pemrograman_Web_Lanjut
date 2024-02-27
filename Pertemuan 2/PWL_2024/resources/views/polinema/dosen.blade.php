<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Dosen</title>
    </head>
    <body>
        <h1>Daftar Dosen</h1>
        <ol>
            <?php
                foreach ($dosen as $nama) {
                    echo "<li> $nama </li>";
                }
            ?>
        </ol>
    </body>
</html>
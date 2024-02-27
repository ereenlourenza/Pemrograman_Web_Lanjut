<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>PWL 2024</title>
    </head>
    <style>
        th {
            background-color: #04AA6D;
            color: white;
        }
        tr:hover {
            background-color: coral;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
    </style>
    <body class="antialiased">
        <h2>Pemrograman Web Lanjut 2024</h2>
        <h3>Semangat Belajar Laravel 10</h3>
        <p>Dibawah ini merupakan tabel company</p>
        <table>
            <tr>
              <th>Company</th>
              <th>Contact</th>
              <th>Country</th>
            </tr>
            <tr>
              <td>Alfreds Futterkiste</td>
              <td>Maria Anders</td>
              <td>Germany</td>
            </tr>
            <tr>
              <td>Centro comercial Moctezuma</td>
              <td>Francisco Chang</td>
              <td>Mexico</td>
            </tr>
            <tr>
              <td>Frans Hamilton</td>
              <td>William Shain</td>
              <td>Brazil</td>
            </tr>
          </table>
    </body>
</html>
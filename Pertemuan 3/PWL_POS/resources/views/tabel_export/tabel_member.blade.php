<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>Tabel</title>
  <style>
      table{
        width: 100%;
        border-collapse: collapse;
        font-family: arial, sans-serif;
      }
      td {
        border: 1px solid #999999dd;
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
      thead {
        background-color: #04AA6D;
        color: white;
      }
  </style>
</head>

<body>
  <div class="title-wrapper">
    @isset($title)
    <h3 style="text-align: center">{{$title}}</h3>
    @endisset
  </div>
  <table>
    <thead>
      <tr>
        <th><strong>No</strong></th>
        <th><strong>Username</strong></th>
        <th><strong>Nama</strong></th>
        <th><strong>Level</strong></th>
        <th><strong>Status</strong></th>
      </tr>
    </thead>
    <tbody>
      @foreach ($members as $member)
        <tr>
          <td> {{ $loop->iteration }} </td>
          <td> {{ $member->username }} </td>
          <td> {{ $member->nama }} </td>
          <td> {{ $member->level->level_nama }} </td>
          <td> {{ ($member->status) == 1 ? 'Validate' : 'Unvalidate' }} </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</body>

</html>
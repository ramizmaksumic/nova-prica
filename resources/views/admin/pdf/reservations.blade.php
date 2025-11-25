<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 6px;
            text-align: left;
        }

        th {
            background: #f2f2f2;
        }

        h2 {
            margin-bottom: 10px;
        }
    </style>
</head>

<body>

    <h2>Lista rezervacija</h2>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Korisnik</th>
                <th>Događaj</th>
                <th>Sto</th>
                <th>Status</th>
                <th>Datum</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reservations as $r)
            <tr>
                <td>{{ $r->id }}</td>
                <td>{{ $r->user->name }}</td>
                <td>{{ $r->event->name }}</td>
                <td>{{ $r->table->name }}</td>
                <td>{{ $r->status }}</td>
                <td>{{ $r->event->date->format('d.m.Y H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
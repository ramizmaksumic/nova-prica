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
            padding: 3px;
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

                <th>Ime</th>
                <th>Prezime</th>
                <th>Email</th>
                <th>Telefon</th>
                <th>Datum</th>
                <th>Događaj</th>
                <th>Sto</th>
                <th>Napomena</th>
                <th>Broj osoba</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reservations as $r)
            <tr>

                <td>{{ $r->user->name }}</td>
                <td>{{ $r->user->surname }}</td>
                <td>{{ $r->user->email }}</td>
                <td>{{ $r->user->phone }}</td>
                <td>{{ $r->event->date->format('d.m.Y') }}</td>
                <td>{{ $r->event->name }}</td>
                <td>{{ $r->table->name }}</td>
                <td>{{ $r->notes }}</td>
                <td>{{ $r->num_people }}</td>
                <td>{{ $r->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
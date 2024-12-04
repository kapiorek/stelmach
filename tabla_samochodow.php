<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista Samochodów</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #03142E;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <h1>Lista Samochodów</h1>
    <p>Sprawdź dostępne samochody w naszej bazie danych:</p>

    <?php
 
    $mysqli = new mysqli("localhost", "root", "", "wypozyczalnia_samochodow");

    if ($mysqli->connect_error) {
        die("<p style='color: red;'>Błąd połączenia z bazą danych: " . $mysqli->connect_error . "</p>");
    }

    
    $query = "SELECT * FROM samochody";
    $result = $mysqli->query($query);

    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr>
                <th>ID Samochodu</th>
                <th>Marka</th>
                <th>Model</th>
                <th>Rok Produkcji</th>
                <th>Cena za Dzień (PLN)</th>
              </tr>";

        
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . htmlspecialchars($row['ID_Samochodu']) . "</td>
                    <td>" . htmlspecialchars($row['Marka']) . "</td>
                    <td>" . htmlspecialchars($row['Model']) . "</td>
                    <td>" . htmlspecialchars($row['Rok_Produkcji']) . "</td>
                    <td>" . htmlspecialchars($row['CenaZaDzien']) . "</td>
                  </tr>";
        }

        echo "</table>";
    } else {
        echo "<p>Brak danych w tabeli samochody.</p>";
    }

    $mysqli->close();
    ?>
</body>
</html>

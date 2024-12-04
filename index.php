<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Budda-wypożyczalnia samochodów</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <img src="baner1.jpg" alt="baner">
    </header>
    <main>
        <div class="lewy">
			<h1>STWORZ Z NAMI HISTORIE!</h1>
            <h2>Chcesz wypożyczyć? Sprawdź dostępne modele</h2><br>

            <?php
            $mysqli = new mysqli("localhost", "root", "", "wypozyczalnia_samochodow");
            if ($mysqli->connect_error) {
                die("Błąd połączenia z bazą danych: " . $mysqli->connect_error);
            }

            $resultMessage = "";

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $selectedBrand = $_POST['marka'];
                $selectedModel = $_POST['model'];

                $query = "SELECT * FROM samochody WHERE Marka = ? AND Model = ?";
                $stmt = $mysqli->prepare($query);
                $stmt->bind_param("ss", $selectedBrand, $selectedModel);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $car = $result->fetch_assoc();
                    $resultMessage = "Samochód <strong>dostępny</strong>!<br>Cena za dzień: " . number_format($car['CenaZaDzien'], 2) . " PLN";
                } else {
                    $resultMessage = "Wybrany model <em>$selectedModel</em> nie istnieje dla marki <em>$selectedBrand</em>.";
                }
            }
            ?>









            <form method="POST">
                <label for="marka">Wybierz Markę:</label><br>
                <select name="marka" id="marka" required>
                    <option value="" disabled selected>Wybierz markę</option>
                    <?php
                    $brandsQuery = "SELECT DISTINCT Marka FROM samochody";
                    $brandsResult = $mysqli->query($brandsQuery);

                    while ($row = $brandsResult->fetch_assoc()) {
                        $selected = (isset($_POST['marka']) && $_POST['marka'] == $row['Marka']) ? "selected" : "";
                        echo "<option value='" . $row['Marka'] . "' $selected>" . $row['Marka'] . "</option>";
                    }
                    ?>
                </select>
                <br><br>

                <label for="model">Wybierz Model:</label><br>
                <select name="model" id="model" required>
                    <option value="" disabled selected>Wybierz model</option>
                    <?php
                    $modelsQuery = "SELECT DISTINCT Model FROM samochody";
                    $modelsResult = $mysqli->query($modelsQuery);

                    while ($row = $modelsResult->fetch_assoc()) {
                        $selected = (isset($_POST['model']) && $_POST['model'] == $row['Model']) ? "selected" : "";
                        echo "<option value='" . $row['Model'] . "' $selected>" . $row['Model'] . "</option>";
                    }
                    ?>
                </select>
                <br><br>
                <input type="submit" value="Wybieram!">
            </form>

            <div class="wynik">
                <p><?php echo $resultMessage; ?></p>
            </div>
        </div>
        <div class="prawy">
            <nav>
                <ul>
                    <li><a href="kontakt.php">Kontakt</a></li>
                    <li><a href="tabla_samochodow.php">Nasze samochody</a></li>
                    <li><a href="gps.php">Jak do nas dotrzeć</a></li>
                </ul>
            </nav>
            <h2>O naszej firmie</h2>
            <p>
                Wypożyczalnia samochodów u Buddy to miejsce, gdzie każdy znajdzie pojazd idealnie dopasowany do swoich potrzeb.
                Firma oferuje szeroki wybór samochodów osobowych, dostawczych i terenowych.
                Dzięki atrakcyjnym cenom i elastycznym warunkom wynajmu, u Buddy możesz wynająć auto zarówno na kilka godzin, jak i na dłuższy okres.
                Wypożyczalnia słynie z doskonałej obsługi klienta i indywidualnego podejścia do każdego wynajmu.
                Każdy samochód jest regularnie serwisowany i dokładnie sprawdzany przed przekazaniem klientowi.
                Możesz zarezerwować pojazd online, telefonicznie lub bezpośrednio w biurze.
                U Buddy znajdziesz również opcję wynajmu z kierowcą, co jest idealne na specjalne okazje.
                Klienci cenią wypożyczalnię za przejrzyste warunki umowy i brak ukrytych opłat.
                W ofercie znajdują się zarówno ekonomiczne auta miejskie, jak i luksusowe modele premium.
                Wypożyczalnia u Buddy to idealne rozwiązanie dla osób potrzebujących niezawodnego samochodu w przystępnej cenie.
            </p>
        </div>
    </main>
    <footer>
        <p>Copyright by BUDDA</p>
    </footer>
</body>
</html>

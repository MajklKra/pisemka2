<?php
require_once('Books.php');
include('DbConnect.php');

$conn = new DbConnect();
$dbConnection = $conn->connect();
$instanceBooks = new Books($dbConnection);

// Inicializace proměnné pro výsledky
$selBooks = [];

// Kontrola, zda jsou vyplněny parametry vyhledávání
if ((isset($_GET['surname']) && $_GET['surname'] != "") ||
    (isset($_GET['firstname']) && $_GET['firstname'] != "") ||
    (isset($_GET['title']) && $_GET['title'] != "") ||
    (isset($_GET['isbn']) && $_GET['isbn'] != "")
) {
    // Načtení hodnot z GET parametrů
    $selLastname = $_GET['surname'];
    $selFirstname = $_GET['firstname'];
    $selTitle = $_GET['title'];
    $selIsbn = $_GET['isbn'];

    // Zavolání metody pro filtrování knih na základě parametrů
    $selBooks = $instanceBooks->filterBooks($selLastname, $selFirstname, $selTitle, $selIsbn);
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vyhledávání</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            background-image: url('images/book.jpg');
            background-size: cover;
            background-position: center;
            color: white; /* Barva textu na celém pozadí */
        }

        .navbar {
            background-color: rgba(255, 255, 255, 0.8); /* Poloprůhledné pozadí pro navbar */
        }

        .container {
            background-color: rgba(0, 0, 0, 0.7); /* Poloprůhledné pozadí pro obsah */
            padding: 20px;
            border-radius: 10px;
            margin-top: 5rem;
            position: relative; /* Zajišťuje, že z-index bude mít efekt */
            z-index: 1; /* Vyšší než pozadí */
        }

        h2, h3 {
            color: #40E0D0; /* Kontrastní barva pro nadpisy */
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg" style="padding-top: 0px">
        <div class="container-fluid">
            <a class="navbar-brand" href="#" style="color:#40E0D0"><b><i>Majkl K&copy</i></b></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav" style="margin: 0px auto">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php" style="color:Brown; margin-right: 1rem"><b>Seznam knih</b></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="vyhledani.php" style="color:Brown; margin-right: 1rem"><b>Vyhledávání</b></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="add.php" style="color:Brown; margin-right: 1rem"><b>Přidej knihu</b></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container" style="width: 50%;">
        <h2 class="h1" style="margin-top: 5rem; margin-bottom: 5rem; color:#40E0D0; margin-left: 1rem"><b>Vyhledávání knih</b></h2>
        <form action="vyhledani.php" method="get">
            <input class="form-control my-4" name="surname" type="text" placeholder="Zadejte příjmení autora" style="margin-left:1rem; margin-right: 1rem; width: 95%;" />
            <input class="form-control my-4" name="firstname" type="text" placeholder="Zadejte jméno autora" style="margin-left:1rem; margin-right: 1rem; width: 95%;" />
            <input class="form-control my-4" name="title" type="text" placeholder="Zadejte název knihy" style="margin-left:1rem; margin-right: 1rem; width: 95%;" />
            <input class="form-control my-4" name="isbn" type="text" placeholder="Zadejte ISBN" style="margin-left:1rem; margin-right: 1rem; width: 95%;" />
            <input class="btn btn-primary" type="submit" value="Vyhledat" style="margin: 0px auto; text-align:center"/>
        </form>

        <!-- Zobrazení výsledků pouze pokud proběhlo vyhledávání -->
        <?php if (!empty($selBooks)) : ?>
            <h3>Výsledky hledání</h3>
            <table class="table">
                <tr>
                    <th>ID</th>
                    <th>ISBN</th>
                    <th>Jméno</th>
                    <th>Příjmení</th>
                    <th>Název knihy</th>
                    <th>Popis</th>
                </tr>
                <?php foreach ($selBooks as $book) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($book['id']); ?></td>
                        <td><?php echo htmlspecialchars($book['isbn']); ?></td>
                        <td><?php echo htmlspecialchars($book['firstname']); ?></td>
                        <td><?php echo htmlspecialchars($book['surname']); ?></td>
                        <td><?php echo htmlspecialchars($book['title']); ?></td>
                        <td><?php echo htmlspecialchars($book['description']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php elseif ($_SERVER['REQUEST_METHOD'] == 'GET' && (isset($_GET['surname']) || isset($_GET['firstname']) || isset($_GET['title']) || isset($_GET['isbn']))) : ?>
            <p>Žádné knihy nebyly nalezeny.</p>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>

<?php
    // výpis aut
    include('DbConnect.php');
    require_once('Books.php');

    // vytvoření instance pro připojení do db a volání metody, která vytvoří připojení
    $conn = new DbConnect();
    $dbConnection = $conn->connect();

    // vytvoření instance Cars, jako parametr kontruktoru předáme připojení do db
    $instanceBooks = new Books($dbConnection);
    $books = $instanceBooks->getBooks();

    if (isset($_GET['surname']) || isset($_GET['firstname']) || isset($_GET['title']) || isset($_GET['isbn'])){
        $selSurname = $_GET['surname'];
        $selFirstname = $_GET['firstname'];
        $selTitle = $_GET['title'];
        $selIsbn = $_GET['isbn'];

        $selBooks = $instanceBooks->filterBooks($selSurname, $selFirstname, $selTitle, $selIsbn);
    // pokud jsme nic neodeslali, pak tabulka vypisuje všechny auta
    } else {
        $selBooks = $books;
    }

?>

<!-- HTML -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Seznam knih</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Knihy</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
            <a class="nav-link" href="index.php">Vyhledávání</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="add.php">Přidej Knihu</a>
            </li>
        </ul>
        </div>
    </div>
    </nav>
    <div class="container">
        <h2 class="h2">Vyhledávání</h2>
        <form action="index.php" method="get">
            <input type="text" name="surname" class="form-control my-2" placeholder="Prijmeni autora">
            <input type="text" name="firstname" class="form-control my-2" placeholder="Zadejte krestni jmeno">
            <input type="text" name="title" class="form-control my-2" placeholder="Zadejte nazev knihy">
            <input type="text" name="isbn" class="form-control my-2" placeholder="Zadejte ISBN">
            <input class="btn btn-primary my-2" type="submit" value="Odešli">
        </form>
        
        <table class="table">
            <tr>
                <th>ID</th>
                <th>Prijmeni</th>
                <th>Jmeno</th>
                <th>Nazev</th>
                <th>ISBN</th>
                <th>Popis</th>
            </tr>
            <?php 
                foreach ($selBooks as $book):
            ?>
                <tr>
                    <td><?php echo $book['id']?></td>
                    <td><?php echo $book['surname']?></td>
                    <td><?php echo $book['firstname']?></td>
                    <td><?php echo $book['title']?></td>
                    <td><?php echo $book['isbn']?></td>
                    <td><?php echo $book['description']?></td>
                </tr>
            <?php 
                endforeach;
            ?>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>


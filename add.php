
<?php
    // výpis aut
    include('DbConnect.php');
    require_once('Books.php');

    // vytvoření instance pro připojení do db a volání metody, která vytvoří připojení
    $conn = new DbConnect();
    $dbConnection = $conn->connect();

    // vytvoření instance Books, jako parametr kontruktoru předáme připojení do db
    $instanceBooks = new Books($dbConnection);

    // hlidame zda je v glob. poli klic add - pokud ano, zavola se metoda addBook
    if (isset($_POST['add'])) { // Zde chyběla uzavírací závorka
        $ISBN = $_POST['isbn'];
        $firstname = $_POST['firstname']; 
        $surname = $_POST['surname'];
        $title = $_POST['title']; 
        $description = $_POST['description'];
        $instanceBooks->addBook($ISBN, $firstname, $surname, $title, $description);
        header("Location: index.php"); 
        exit();
    }
?>


<!-- HTML -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Eidtace vozidla</title>
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
            <a class="nav-link" href="index.php">Seznam knih</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="vyhledani.php">Vyhledavani knih</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="add.php">Přidej knihu</a>
            </li>
        </ul>
        </div>
    </div>
    </nav>
    <div class="container">
        <h2 class="h2">Pridani knihy</h2>
       
        <form action="add.php" method="post">
            <input type="text" name="isbn" value="" class="form-control my-2" required placeholder = "ISBN">
            <input type="text" name="firstname" value=""  class="form-control my-2" required placeholder = "jmeno">
            <input type="text" name="surname" value=""  class="form-control my-2" required placeholder = "prijmeni">
            <input type="text" name="title" value=""  class="form-control my-2" required placeholder = "nazev">
            <input type="text" name="description" value=""  class="form-control my-2" required placeholder = "Popis">
            <input type="submit" value="Vloz knihu" class="btn btn-primary my-2" name="add">
        </form>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
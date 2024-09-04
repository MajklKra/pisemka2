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
    <link rel="stylesheet" type="text/css" href="./index.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Seznam knih</title>
</head>
<body style="background-image: url('images/library.jpg'); background-size: cover; background-position: center;">
    <nav class="navbar navbar-expand-lg" style="padding-top: 0px">
    <div class="container-fluid" style="background-color:Gainsboro; border-bottom-left-radius: 15px; border-bottom-right-radius: 15px; opacity: 0.9">
        <a class="navbar-brand" href="#" style="color:	#40E0D0"><b><i>Majkl K&copy</i></b> </a>
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
    <div class="container">
        <br>
        <h2 class="h1" style="margin-top:5rem; margin-bottom: 5rem; Color: White"><b>Seznam knih</b></h2> <br>

        <table class="table" style="border-radius: 15px; border-collapse: separate; border-spacing: 0; overflow: hidden; opacity: 0.9;">
            <tr>
                <th style="background-color: AliceBlue; color:#40E0D0">ID</th>
                <th style="background-color: AliceBlue;color:#40E0D0">Přijmení</th>
                <th style="background-color: AliceBlue;color:#40E0D0">Jméno</th>
                <th style="background-color: AliceBlue;color:#40E0D0">Název</th>
                <th style="background-color: AliceBlue;color:#40E0D0">ISBN</th>
                <th style="background-color: AliceBlue;color:#40E0D0">Popis</th>
            </tr>
            <?php 
                foreach ($selBooks as $book):
            ?>
                <tr>
                    <td style="color:LightSlateGray"><?php echo $book['id']?></td>
                    <td style="color:LightSlateGray"><b><?php echo $book['surname']?></b></td>
                    <td style="color:LightSlateGray"><?php echo $book['firstname']?></td>
                    <td style="color:LightSlateGray"><b><?php echo $book['title']?></b></td>
                    <td style="color:LightSlateGray"><?php echo $book['isbn']?></td>
                    <td style="color:LightSlateGray"><?php echo $book['description']?></td>
                </tr>
            <?php 
                endforeach;
            ?>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>


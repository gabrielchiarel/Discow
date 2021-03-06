<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
        <link rel="stylesheet" href="Css/main.css">
        <link rel="stylesheet" href="Css/breakpoints.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
        <title>discow - Vendas de discos é aqui!</title>
    </head>
    <body>
        <header>
            <div class="row" style="padding-top: 1rem;">
                <div class="col-3 d-flex justify-content-center">
                    <h1><a href="index.php">discow</a></h1>
                </div>
                <div class="col-6 d-flex justify-content-center">
                <input type="text" id='search' name="search" style="width: 70%;"><input type="button" onclick="SearchOnClick()" value="procurar">
                </div>
                <div class="col-3 d-flex justify-content-center">
                    <div class="row" style="border: 1px solid white; width: 90%;color:white">
                        <?php
                            if(!empty($_SESSION['user']) && $_SESSION['user'] != (object)[])
                            {
                                echo '<div class="col-6 justify-content-center">
                                        <span>Usuário Logado:<br> '. $_SESSION['user']['Login'] .'</span>
                                    </div>
                                    <div class="col-6 justify-content-center">
                                        <a class="btn btn-light" onclick="Logout()">Sair</a>
                                    </div>';
                            }
                            else{
                                echo '<div class="col-6 justify-content-center">
                                        <a class="btn btn-light" href="login.php">Logue-se</a>
                                    </div>';
                            }
                        ?>
                    </div>
                </div>
            </div>
        </header>
        <nav class="navbar navbar-expand" id="navHorizontal">
            <div class="col 6">
                <div class="container-fluid">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDarkDropdown" aria-controls="navbarNavDarkDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNavDarkDropdown">
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Gêneros
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink">
                            <li><a class="dropdown-item" href="#">Rock</a></li>
                            <li><a class="dropdown-item" href="#">Indie Rock</a></li>
                            <li><a class="dropdown-item" href="#">Hip Hop</a></li>
                            <li><a class="dropdown-item" href="#">Indie Pop</a></li>
                        </ul>
                        </li>
                    </ul>
                    </div>
                </div>
            </div>
            <div class="col 6">
                <a class="nav-link" href="shoppingCart.php">Meu Carrinho<img src="Local/shopping-cart.png" alt="shopping-cart"></a>
            </div>
        </nav>
        <div class="row">
            <div class="col-3" style="margin-bottom: 2rem;">
                <nav id="navVertical">
                    <div id="navEstilo">
                        <h4>Gêneros</h4>
                    </div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="#">Rock</a>
                            <a class="nav-link" href="#">Indie Rock</a>
                            <a class="nav-link" href="#">Hip Hop</a>
                            <a class="nav-link" href="#">Indie Pop</a>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="col-9" style="margin-bottom: 2rem;">
                <main id="inicio" style="min-height: 400px; padding: 0.5rem;">
                    <div class="row" style="width: 100%;">
                        <?php
                        if(empty(filter_var($_GET['id'], FILTER_SANITIZE_STRING)))
                        {
                            $id = 0;
                        }
                        else
                        {
                            $id = filter_var($_GET['id'], FILTER_SANITIZE_STRING);
                        }

                        $con = new PDO('mysql:host=localhost;dbname=discow', 'root', '');

                        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        
                        $con->beginTransaction();
                        $query = $con->prepare(
                            "SELECT pro.Id as Id,
                            pro.Name as Name, 
                            pro.Gender as Gender, 
                            pro.CategoryId as CategoryId, 
                            pro.ArtistId as ArtistId, 
                            pro.Top as Top, 
                            pro.Price as Price,
                            pro.Price `Type`, 
                            art.Name as ArtistName,
                            cat.Name as CategoryName, 
                            pho.Name as PhotoName FROM product as pro
                            INNER JOIN category as cat ON cat.Id = pro.CategoryId
                            INNER JOIN artist as art ON art.Id = pro.ArtistId
                            INNER JOIN photo as pho ON pro.Id = pho.ProductId
                            WHERE pro.Id = $id");
                        $query->execute([]);
                        while($row = $query->fetch(PDO::FETCH_ASSOC))
                        {
                            echo '<div class="col-12 d-flex justify-content-center">
                                    <h3>'. strtoupper($row['Name']) .', '. strtoupper($row['ArtistName']) .'</h3>
                                </div>';
                            echo '<div class="col-8 col-sm-8 col-md-8 col-lg-8 col-xl-8 d-flex justify-content-center" style="padding:0.5rem;height:250px;">
                                            <img class="card-img-top" src="Local/'. $row['PhotoName'] .'" alt="álbum" style="width:60%;height:100%;">
                                    </div>
                                    <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4 d-flex justify-content-center" style="padding:0.5rem;height:100px;">
                                        <div class="card" style="height: 10rem !important;">
                                            <div class="card-body text-center">
                                                <div class="card-title">'. $row['Name'] .'</div>
                                                <p class="card-text">R$'. $row['Price'] .'<br>Produto:'. $row['CategoryName'] .'<br>
                                                    <a class="btn btn-outline-secondary btn-sm" onclick="AddProduct('. $row['Id'] .',1)"><img src="Local/shopping-cart.png" alt="shopping-cart"></a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>';
                        }
                        ?>
                    </div>
                </main>
            </div>
            <div class="col-12">
                <footer id="footerInicio">
                    <div class="row">
                        <div class="col-6 d-flex justify-content-start">
                            <a class="btn btn-outline-secondary btn-sm" href="sendEmail.php">Fale conosco</a><br>
                        </div>
                        <div class="col-6 d-flex justify-content-end">
                            <span>Made by: Gabriel Chiarel</span>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </body>
    <script>
        function SearchOnClick(){
            location.href = `search.php?search=${$("#search").val()}`;
        }

        function AddProduct(id, amount){
            $.post("sessionShop.php", {id: id, amount: amount},
                function(data){
                    alert('Produto adicionado ao Carrinho!');
                }, "json"
            );
        }
        
        function Logout(){
            $.post("logout.php",
                function(data){
                    location.reload();
                }, "json"
            );
        }
    </script>
</html>
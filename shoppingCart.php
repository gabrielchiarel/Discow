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
        <div class="row" style="margin-left: 0.5rem">
            <div class="col-12" style="margin-bottom: 2rem;">
                <main id="inicio" style="min-height: 400px; padding: 0.5rem;">
                    <div class="row" style="width: 100%;min-height:370px;">
                        <div class="col-12 d-flex justify-content-center">
                            <h2>Seu Carrinho</h2>
                        </div>
                        <?php
                            if(empty($_SESSION['shop']) && $_SESSION['shop'] != (object)[])
                            {
                                @$_SESSION['shop'] = array();
                            }
                            
                            $productIds = array();
                            
                            if(count($_SESSION['shop']) > 0)
                            {
                                for($i = 0; $i < count($_SESSION['shop']); $i++)
                                {
                                    array_push($productIds, $_SESSION['shop'][$i][0]);
                                }
                            }
                            else
                            {
                                array_push($productIds, 0);
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
                                WHERE pro.Id IN (" . implode(",", $productIds) . ")");
                            $query->execute([]);
                             
                            $total = 0;

                            while($row = $query->fetch(PDO::FETCH_ASSOC))
                            {
                                $amount = 0;
                                
                                for($i = 0; $i < count($_SESSION['shop']); $i++)
                                {
                                    if($row['Id'] == $_SESSION['shop'][$i][0])
                                    {
                                        $amount = $_SESSION['shop'][$i][1];
                                    }
                                }
                                
                                $total = $total + ($row['Price'] * $amount);

                                echo '<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-flex justify-content-center" style="margin-bottom:0.5rem;">
                                            <div class="row" style="width:100%;border: 0.5px solid rgb(94, 93, 104);border-radius: 4px;background-color: rgb(40, 40, 44);height: 102px;">
                                                <div class="col-4 d-flex justify-content-center" style="height:100px;">
                                                    <img src="Local/'. $row['PhotoName'] .'" alt="álbum" style="width:40%;height:100%;">
                                                </div>
                                                <div class="col-4 d-flex justify-content-start align-items-center">
                                                    <p>
                                                        ' . strtoupper($row['Name']) .', '. strtoupper($row['ArtistName']) .'<br>
                                                        Preço: '. $row['Price'] .'<br>
                                                        Produto:' . $row['CategoryName'] .'
                                                    </p>
                                                </div>
                                                <div class="col-3 d-flex justify-content-end align-items-center">
                                                    <a class="btn btn-light" onclick="ControlAmount('. $row['Id'] .','. $amount .', 0)" style="margin-right: 0.5rem;">-</a>
                                                    ' . $amount .'
                                                    <a class="btn btn-light" onclick="ControlAmount('. $row['Id'] .','. $amount .', 1)" style="margin-left: 0.5rem;">+</a>
                                                    <div>
                                                        <button type="button" class="btn btn-danger" onclick="Delete('. $row['Id'] .')" style="margin-left: 0.5rem;">Excluir</button> 
                                                    </div>
                                                </div>
                                            </div>
                                        </div>';
                            }
                        ?>
                    </div>
                    <div class="row">
                        <?php
                            echo '<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-flex justify-content-end" style="padding-right:10%;margin-bottom:0.5rem">
                                    <span style="color: white;">Total: R$ '. $total .'</span>
                                </div>'
                        ?>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-flex justify-content-end align-items-end" id="botoes">
                                <a class="btn btn-light" 
                                onclick="FinishBuy(<?php if(!empty($_SESSION['user']) && $_SESSION['user'] != (object)[]){ echo $_SESSION['user']['Id']. ',' . $amount; }else{ echo 0 . ',' . $amount; } ?>)" 
                                style="margin-right: 0.5rem;">Finalizar Compra</a>
                                <a href="index.php" class="btn btn-light">Voltar</a>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <footer>
            <p>Made by: Gabriel Chiarel</p>
        </footer>
    </body>
    <script>
        function ControlAmount(id, amount, operator)
        {
            $.post("controlAmount.php", {id: id, amount: amount, operator: operator},
                function(data){
                    location.reload();
                }, "json"
            );
        }

        function Delete(id)
        {
            $.post("delete.php", {id: id},
                function(data){
                    location.reload();
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

        function FinishBuy(id, amount)
        {
            if(id != 0)
            {
                $.post("finishBuy.php",
                    {id: id, amount},
                    function(data){
                        alert('oi');
                        if(data.ok == true)
                        {
                            alert(data.message);
                            DeleteAllShop();
                        }
                    }, "json"
                );
            }
            else
            {
                alert('Faça o login para finalizar a compra');
                window.location.replace('login.php');
            }
        }

        function DeleteAllShop()
        {
            $.post("deleteAllShop.php"); 
        }
    </script>
</html>
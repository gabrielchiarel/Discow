<?php
    session_start();
?>
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
        <title>Login</title>
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
                <main id="inicio" style="min-height: 400px; padding: 1rem;">
                    <div class="row">
                        <div class="col-2" style="margin-bottom: 0.5rem;">
                            <label for="name">Nome:</label>
                        </div>
                        <div class="col-10" style="margin-bottom: 0.5rem;">
                            <input type="text" name="name" id="name" maxlength="100" style="width: 100%;">
                        </div>
                        <div class="col-2" style="margin-bottom: 0.5rem;">
                            <label for="birthdate">Idade:</label>
                        </div>
                        <div class="col-10" style="margin-bottom: 0.5rem;">
                            <input type="date" name="birthdate" id="birthdate" style="width: 100%;">
                        </div>
                        <div class="col-2" style="margin-bottom: 0.5rem;">
                            <label for="email">E-mail:</label>
                        </div>
                        <div class="col-10" style="margin-bottom: 0.5rem;">
                            <input type="email" name="email" id="email" style="width: 100%;">
                        </div>
                        <div class="col-2" style="margin-bottom: 0.5rem;">
                            <label for="login">Login:</label>
                        </div>
                        <div class="col-10" style="margin-bottom: 0.5rem;">
                            <input type="text" name="login" id="login" maxlength="20" style="width: 100%;">
                        </div>
                        <div class="col-2" style="margin-bottom: 0.5rem;">
                            <label for="password">Senha:</label>
                        </div>
                        <div class="col-10" style="margin-bottom: 0.5rem;">
                            <input type="password" name="password" id="password" maxlength="20" style="width: 100%;">
                        </div>
                        <div class="col-12 d-flex justify-content-center" style="margin-bottom: 0.5rem;">
                            <input type="button" onclick="TemplateOnSubmit()" value="Cadastrar">
                        </div>
                    </div>
                </main>
            </div>
            <div class="col-12">
                <footer id="footerInicio">
                    <p>Made by: Gabriel Chiarel</p>
                </footer>
            </div>
        </div>
    </body>
    <script>
        function TemplateOnSubmit()
        {
            let name = $("#name").val();
            let birthdate = $("#birthdate").val();
            let email = $("#email").val();
            let login = $("#login").val();
            let password = $("#password").val();

            if(name === '')
            {
                $("#name").focus();
                return;
            }
            if(birthdate === '')
            {
                $("#birthdate").focus();
                return;
            }
            if(email === '')
            {
                $("#email").focus();
                return;
            }
            if(login === '')
            {
                $("#login").focus();
                return;
            }
            if(password === '')
            {
                $("#password").focus();
                return;
            }

            alert(password);
            
            $.post("register.php", 
            {   
                name: name, 
                birthdate: birthdate,
                email: email,
                login: login, 
                password: password
            },
                function(data){
                    alert(data.ok);
                }, "json"
            );
        }
        function SearchOnClick(){
            location.href = `search.php?search=${$("#search").val()}`;
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
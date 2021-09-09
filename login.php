<?php
    if (empty($_REQUEST['login']) || empty($_REQUEST['password']))
    {
        header("Location: login.html");
    }

    $con = new PDO('mysql:host=localhost;dbname=discow', 'root', '');

    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $login = filter_var($_REQUEST['login'], FILTER_SANITIZE_STRING);
    $password = filter_var($_REQUEST['password'], FILTER_SANITIZE_STRING);

    $user;

    $con->beginTransaction();
    $query = $con->prepare("SELECT Id, `Login`, `Type` FROM user WHERE `Login` = '". $login ."' AND Password = '" . $password . "' LIMIT 1");
    $query->execute([]);

    while($row = $query->fetch(PDO::FETCH_ASSOC))
    {
        $user = $row;
    }

    if($user != null)
    {
        echo json_encode(array("login"=>$user['Login'],"id"=>$user['Id'],"type"=>$user['Type']));
    }
    else{
        echo json_encode(array("login"=>null,"id"=>null,"type"=>null));
    }
?>

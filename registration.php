<?php
    if (empty($_REQUEST['login']) 
        || empty($_REQUEST['password'])
        || empty($_REQUEST['name'])
        || empty($_REQUEST['email'])
        || empty($_REQUEST['birthdate'])
    )
    {
        header("Location: registration.html");
    }

    $con = new PDO('mysql:host=localhost;dbname=discow', 'root', '');

    $name = filter_var($_REQUEST['name'], FILTER_SANITIZE_STRING);
    $email = filter_var($_REQUEST['email'], FILTER_SANITIZE_STRING);
    $date = new DateTime(filter_var($_REQUEST['birthdate'], FILTER_SANITIZE_STRING));
    $birthdate = $date->format('Y-m-d');
    $login = filter_var($_REQUEST['login'], FILTER_SANITIZE_STRING);
    $password = filter_var($_REQUEST['password'], FILTER_SANITIZE_STRING);

    try{
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $con->beginTransaction();
        

        $query = $con->prepare("INSERT INTO person (`Name`, `Email`, `Birthdate`) VALUES (:name, :email, :birthdate)");
        $query->execute([':name'=>$name, ':email'=>$email, ':birthdate'=>$birthdate]);

        $query = $con->prepare("SELECT max(Id) as id FROM Person");
        $query->execute([]);

        $id;
        
        if($_id = $query->fetch(PDO::FETCH_ASSOC))
        {
            $id = $_id['id'];
        }

        $query = $con->prepare("INSERT INTO user (`Login`, `Password`, `Type`, `PersonId`) VALUES (:login, :password, '0', :id)");
        $query->execute(['login'=>$login, 'password'=>$password, 'id'=>$id]);
        $con->commit();

        echo json_encode(["ok"=>true]);
    }
    catch(Exception $e)
    {
        echo $e->getMessage();
        $con->rollBack();
    }
?>

<?php
    session_start();
    
    if(empty($_SESSION['shop']) && $_SESSION['shop'] != (object)[])
    {
        @$_SESSION['shop'] = array();
    }

    $id = $_REQUEST['id'];
    
    $amount = $_REQUEST['amount'];

    $con = new PDO('mysql:host=localhost;dbname=discow', 'root', '');

    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $con->beginTransaction();
    
    $query = $con->prepare(
        "SELECT pro.Id as Id
        FROM product as pro
        WHERE pro.Id = $id");
    
    $query->execute([]);
    
    if($row = $query->fetch(PDO::FETCH_ASSOC))
    {
        $ok = false;

        if(!empty($_SESSION['shop']))
        {
            for($i = 0; $i < count($_SESSION['shop']); $i++)
            {
                if($_SESSION['shop'][$i][0] == $id)
                {
                    $_SESSION['shop'][$i][1] += $amount;
                    
                    $ok = true;
                }
            }
        }

        if(!$ok)
        {
            array_push($_SESSION['shop'], array($id, $amount));
        }

        echo json_encode(["ok"=>true]);
    }
?>
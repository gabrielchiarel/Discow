<?php
    $id = $_REQUEST['id'];

    $id = 1;

    $amount = $_REQUEST['amount'];

    if (!empty($id)) 
    {
        $con = new PDO('mysql:host=localhost;dbname=discow', 'root', '');

        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $con->beginTransaction();

        $query = $con->prepare(
            "SELECT usr.Id as Id,
            per.Name as Name,
            per.Email as Email
            FROM user as usr
            INNER JOIN person as per ON per.Id = usr.PersonId
            WHERE usr.Id = ". $id ." LIMIT 1");

        $query->execute([]);
        
        if($row = $query->fetch(PDO::FETCH_ASSOC))
        {
            if (mail($row['Email'], 'Recibo','Total da compra foi'. $amount, 'From: discow <gabchiarel@hotmail.com>')) 
            {
                echo json_encode(array("message"=>'Email Enviado', "ok"=>true));
            }
            else 
            {
                echo json_encode(array("message"=>'Email não enviado mas compra realizada com sucesso.', "ok"=>true));
            }
        }
     }
?>
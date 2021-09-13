<?php
    $name = filter_var($_REQUEST['name'], FILTER_SANITIZE_STRING);

    $email = filter_var($_REQUEST['email'], FILTER_SANITIZE_STRING);

    $topic = filter_var($_REQUEST['topic'], FILTER_SANITIZE_STRING);

    if (!empty($name) && !empty($email) && !empty($topic)) 
    {
        if($row = $query->fetch(PDO::FETCH_ASSOC))
        {
            if (mail($email, 'Fale Conosco', $topic, 'From: discow <gabchiarel@hotmail.com>')) 
            {
                echo json_encode(array("message"=>'Email enviado.', "ok"=>"true"));
            }
            else 
            {
                echo json_encode(array("message"=>'Email não enviado.', "ok"=>"true"));
            }
        }
     }
?>
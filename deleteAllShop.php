<?php
    session_start();
    
    if(empty($_SESSION['shop']) && $_SESSION['shop'] != (object)[]) && $_SESSION['shop'] != (object)[])
    {
        @$_SESSION['shop'] = array();
    }

    if(!empty($_SESSION['shop']))
    {
        $id = $_REQUEST['id'];
        
        for($i = 0; $i < count($_SESSION['shop']); $i++)
        {
            if($_SESSION['shop'][$i][0] == $id)
            {
                array_splice($_SESSION['shop'], $i, 1); 
            }
        }
        
    }
    
    echo json_encode(["ok"=>true]);
?>
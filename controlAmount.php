<?php
    session_start();
    
    if(empty($_SESSION['shop']) && $_SESSION['shop'] != (object)[])
    {
        @$_SESSION['shop'] = array();
    }

    if(!empty($_SESSION['shop']))
    {
        $id = $_REQUEST['id'];
        $amount = $_REQUEST['amount'];
        $operator = $_REQUEST['operator'];

        for($i = 0; $i < count($_SESSION['shop']); $i++)
        {
            if($_SESSION['shop'][$i][0] == $id)
            {
                // 0 = -;
                if($operator == 0)
                {
                    if($amount == 1)
                    {
                        array_splice($_SESSION['shop'], $i, 1);
                    }
                    else
                    {
                        $_SESSION['shop'][$i][1]--;
                    }
                    break;
                }
                else{
                    $_SESSION['shop'][$i][1]++;
                    break;
                } 
            }
        }
    }
    
    echo json_encode(["ok"=>true]);
?>
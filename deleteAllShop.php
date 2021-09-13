<?php
    session_start();
    
    $_SESSION['shop'] = array();

    echo json_encode(["ok"=>"true"]);
?>
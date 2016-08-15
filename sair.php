<?php
    include('verificasecao.php');
    
    unset($_SESSION["id_peladeiro"]);
    unset($_SESSION["nivel"]);
    unset($_SESSION["nome_peladeiro"]);
    session_destroy();

    header("Location: index.php");
?>
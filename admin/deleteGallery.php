<?php
    require_once 'adminFunction.php';
    if(isset($_GET['pic'])){
        $conn = connect();
        $conn->query("DELETE FROM gallery WHERE id = '{$_GET['pic']}'");
        $conn->close();
        header("location: admin_panel.php?page=gallery");
    }
?>
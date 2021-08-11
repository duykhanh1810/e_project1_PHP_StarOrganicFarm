<?php
session_start();
$currentID = $user['userID']; //the id of current logged in user
require 'adminFunction.php';
$conn = connect();
if (isset($_REQUEST['ctg'])) {
    $id = $_REQUEST['ctg'];
    $sql = "SELECT * FROM category WHERE categoryID = $id";
    $data = '';
    $ctg = $conn->query($sql);
    $data = '';
    foreach ($ctg as $value) {
        $data .= "
        <div class='input-group mb-3'>
            <input type='hidden' name='cid' value='{$value['categoryID']}'>
            <span class='input-group-text' style='max-width:25%'>Category:</span>
            <input type='text' id='name' class='form-control' name='name' value='{$value['categoryName']}' aria-label='name'>
            <span class='input-group-text' style='max-width:25%'>Unit:</span>
            <input type='text' id='unit' class='form-control' name='unit' value='{$value['unit']}' aria-label='unit'>
        </div>
        <div class='input-group mb-3'>
            <span class='input-group-text' style='max-width:25%'>Description:</span>
            <textarea type='text' id='detail' class='form-control' name='detail' aria-label='detail'>{$value['categoryDetail']}</textarea>
        </div>
        ";
    }
    $conn->close();
    echo $data;
}

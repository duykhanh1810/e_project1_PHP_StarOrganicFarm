<?php
session_start();
require 'admin/adminFunction.php';
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array(); //declare cart array if not exist
}
if (isset($_POST['itemId'])) {
    $count = count($_POST['itemId']); //count items sent by POST
    $cart = count($_SESSION['cart']); //count current items in cart
    for ($j = 0; $j < $cart; $j++) { //loop through cart array and check if any item send by POST is exist in cart
        $index = array_search($_SESSION['cart'][$j]['id'], $_POST['itemId']); //search on item id, return it index key
        if ($index !== FALSE) {
            $duplicate[] = $index; //if found duplicate item, return all the index key into an array.
        }
    }
    $_SESSION['total'] = 0; //declare session variable to hold the total price of the cart.
    
    for ($i = 0; $i < $count; $i++) { //update cart array with items sent by POST
        /*if an item send by POST has marked as duplicated in cart, it's index will be found in the duplicate array,
         update it quantity and reset the loop (continue) */
        if (isset($duplicate)) {
            if (in_array($i, $duplicate)) { 
                $_SESSION['cart'][$i]['qtt'] = $_POST['itemQuantity'][$i];
                continue;
            }
        }
        //update the next item in cart with item sent by POST
        $_SESSION['cart'][$i + $cart]['id'] = $_POST['itemId'][$i];
        $_SESSION['cart'][$i + $cart]['name'] = $_POST['itemName'][$i];
        $_SESSION['cart'][$i + $cart]['price'] = $_POST['itemPrice'][$i];
        $_SESSION['cart'][$i + $cart]['qtt'] = $_POST['itemQuantity'][$i];
    }
}

$_SESSION['cart'] = array_values($_SESSION['cart']); //reindex the cart array
$_SESSION['count'] = count($_SESSION['cart']); //recount the cart array

//remove item from cart:
if (isset($_GET['remove'])) {
    $find = $_GET['remove']; //the $_GET variable hold the id of the item in cart
    /* loop through cart array and find the index key of the item that match the id sent by GET
    if found, unset it from the cart array and reindex the cart array */
    foreach ($_SESSION['cart'] as $key => $val) {
        if ($val['id'] == $find) {
            $remove = $key;
            unset($_SESSION['cart'][$remove]);
            $_SESSION['cart'] = array_values($_SESSION['cart']); //reindex array
        }
    }
}
//print the cart item to the website
$data = "<table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                </tr>
    ";
$total = 0;
foreach ($_SESSION['cart'] as $item) {
    $subtotal = floatval($item['price']) * intval($item['qtt']); //caculate subtotal of each item
    $data .= "
                <tr>
                    <td>{$item['id']}</td>
                    <td>{$item['name']}</td>
                    <td>{$item['price']}</td>
                    <td>{$item['qtt']}</td>
                    <td>{$subtotal}</td>
                </tr>
            ";
    $total += $subtotal; //calculate total price
}

$data .= "<tr>
        <td colspan='4'><b>TOTAL = {$total}</b></td>
    </tr>
    </table>";
echo $data;
$_SESSION['total'] = $total;
// print_r($_SESSION['cart']);
header("location: ". $_SERVER['HTTP_REFERER']."#cart");
// session_unset();

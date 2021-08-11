<?php
session_start();
require 'admin/adminFunction.php';
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array(); //delcare session array if not exist
}
if (isset($_POST['itemId'])) {
    $count = count($_POST['itemId']);
    $cart = count($_SESSION['cart']);
    print_r($_SESSION['cart']);
    echo "<br>";
    print_r($_POST['itemId']);
    echo "<br>";
    for ($j = 0; $j < $cart; $j++) {
        $check = array_search($_SESSION['cart'][$j]['id'], $_POST['itemId']);
        if ($check !== FALSE) {
            echo "duplicate at item: [$check] in POST <br>";
            $duplicate[] = $check;
        }
    }
    echo "<br>";
    // print_r($duplicate);
    // exit();
    echo "session = $cart <br>post = $count<br>";
    $_SESSION['total'] = 0;
    for ($i = 0; $i < $count; $i++) {
        if (isset($duplicate)) {
            if (in_array($i, $duplicate)) {
                $_SESSION['cart'][$i]['qtt'] = $_POST['itemQuantity'][$i];
                continue;
            }
        }
        $_SESSION['cart'][$i + $cart]['id'] = $_POST['itemId'][$i];
        $_SESSION['cart'][$i + $cart]['name'] = $_POST['itemName'][$i];
        $_SESSION['cart'][$i + $cart]['price'] = $_POST['itemPrice'][$i];
        $_SESSION['cart'][$i + $cart]['qtt'] = $_POST['itemQuantity'][$i];
    }
}

$_SESSION['cart'] = array_values($_SESSION['cart']); //reindex array
$_SESSION['count'] = count($_SESSION['cart']);
if (isset($_GET['remove'])) {
    $find = $_GET['remove'];
    foreach ($_SESSION['cart'] as $key => $val) {
        if ($val['id'] == $find) {
            $remove = $key;
            unset($_SESSION['cart'][$remove]);
            $_SESSION['cart'] = array_values($_SESSION['cart']); //reindex array
        }
    }
}
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
foreach ($_SESSION['cart'] as $array) {
    $subtotal = floatval($array['price']) * intval($array['qtt']);
    $data .= "
                <tr>
                    <td>{$array['id']}</td>
                    <td>{$array['name']}</td>
                    <td>{$array['price']}</td>
                    <td>{$array['qtt']}</td>
                    <td>{$subtotal}</td>
                </tr>
            ";
    $total += $subtotal;
}

$data .= "<tr>
        <td colspan='4'><b>TOTAL = {$total}</b></td>
    </tr>
    </table>";
echo $data;
$_SESSION['total'] = $total;

print_r($_SESSION['cart']);
header("location: ". $_SERVER['HTTP_REFERER']."#cart");
// session_unset();

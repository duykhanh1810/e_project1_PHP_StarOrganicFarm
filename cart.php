<?php
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $value) { ?>
        <tr class="cart-row">
            <td class="item-img">
                <img src="<?= admin_findImg($value['id']) ?>" alt="">
                <span class="item-name"><?= $value['name'] ?></span>
                <input type="hidden" name='itemName[]' value="<?= $value['name'] ?>">
                <input type="hidden" name='itemId[]' value="<?= $value['id'] ?>">
            </td>
            <td class="price-col">
                <span class="item-price"><?= $value['price'] ?></span>
                <input type="hidden" name='itemPrice[]' value="<?= $value['price'] ?>">
            </td>
            <td class="quantity-col">
                <input name='itemQuantity[]' type="number" min="1" step="1" value="<?= $value['qtt'] ?>" class="quantity-input">
                <a href="addcart.php?remove=<?= $value['id'] ?>" class="remove btn btn-danger">Remove</a>
            </td>
        </tr>
<?php
    };
}
?>
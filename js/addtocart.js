$(document).ready(function () {
    countCart(); //count the number of product in cart everytime the document is loaded to display the badge icon

    //event driven by click each "add to cart" button, 
    //the 'data' attribute of the button contain the data to be sent
    $(document).on('click', '.2cart', function (e) {
        e.preventDefault();
        var productID = $(this).attr('data-id'); //we send the product ID store in 'data-id' attribute of the button
        var productName = $(this).attr('data-name');

        //Check if product is already added:
        items = document.querySelectorAll('.item-name');
        for (item of items) {
            if (item.innerText == productName) {
                alert('This item is already in your cart!');
                return;
            }
        }
        //Send request:
        $.ajax({
            url: "cart1.php",
            method: "get",
            data: {
                id: productID,
                name: productName,
            },
            success: function (data) {
                $('.cart-items').append(data);
                updateCart();
                countCart();
            }
        });

    });

    //change item quantity in the cart array:
    $(document).on('input', '.quantity-input', function () {
        updateCart();
        var productID = $(this).attr('data-id');
        var qtt = $(this).val();
        var sum = parseFloat($('#sum').text());

        $.ajax({
            url: 'changeCart.php',
            method: 'get',
            data: {
                id: productID,
                qtt: qtt,
                sum: sum
            },
        })
    })

    //remove item from cart array
    $('.cart-items').on('click', '.remove', function () {
        var removeID = $(this).attr('data-id');
        $.ajax({
            url: 'changeCart.php',
            method: 'get',
            data: {
                removeID: removeID
            },
            success: function () {
                updateCart();
                countCart();
            }
        })
        $(this).closest('tr').remove();
    })

    //function to udate total
    function updateCart() {
        var sum = 0;
        var quantity;
        $('#cart-product > tbody > tr').each(function () {
            quantity = $(this).find('.quantity-input').val();
            var price = parseFloat($(this).find('.price').val());
            var subtotal = quantity * price;
            if (!isNaN(subtotal)) {
                sum += subtotal;
            }
            $(this).find('.subtotal').val(Number(subtotal).toFixed(2));
            $(this).find('.visible-subtotal').text(Number(subtotal).toFixed(2));
        })
        console.log(sum);
        $('#sum').text(Number(sum).toFixed(2));
    }

    //Prevent 'go to cart' if nothing in cart
    $('.gocart').on('click', function (e) {
        var cartItem = document.querySelectorAll('.cart-row');
        if (cartItem.length == 0) {
            e.preventDefault();
            alert('Please add something to your cart first.');
            return;
        }
    })
    //Prevent 'check out' if nothing in cart
    $('#checkout').on('click', function (e) {
        var cartItem = document.querySelectorAll('.cart-row');
        if (cartItem.length == 0) {
            e.preventDefault();
            alert('Please add something to your cart first.');
            return;
        }
    })
    
    function countCart(){
        var cartItem = document.querySelectorAll('.cart-row');
        var count = cartItem.length;
        $('#badge').text(count);
        if(count == 0) {
            $('#badge').text('');
        }
    }
});
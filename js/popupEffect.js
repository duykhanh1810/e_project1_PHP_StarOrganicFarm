function toggle(n) {
    var productContainer = document.getElementById('product-container');
    productContainer.classList.toggle('active');
    
    var popup = document.getElementById('popup-'+n);
    popup.classList.toggle("active");
};
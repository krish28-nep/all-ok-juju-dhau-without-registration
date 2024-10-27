// Select the "Add to Cart" button and cart number element
let addToCartButton = document.getElementById('addToCart');
let cartNo = document.querySelector('.cart-no sup');

// Initialize cart count
let cartCount = 0;

// Add click event listener to the "Add to Cart" button
addToCartButton.addEventListener('click', function () {
    cartCount += 1; // Increment cart count
    alert("Your product is added to the cart");

    // Update the cart number display
    cartNo.innerText = cartCount;
});

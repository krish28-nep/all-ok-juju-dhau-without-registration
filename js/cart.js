// document.addEventListener("DOMContentLoaded", function() {
//     // Attach event listeners to all "Add to Cart" buttons
//     const addToCartButtons = document.querySelectorAll('.productButton');

//     addToCartButtons.forEach(button => {
//         button.addEventListener('click', function(event) {
//             event.preventDefault();  // Prevent form submission

//             // Get the form element
//             const form = button.closest('form');
//             const product_id = form.querySelector('input[name="product_id"]').value;
//             const selectedOption = form.querySelector('input[type="radio"]:checked');
//             const option = selectedOption ? selectedOption.value : null;

//             if (!option) {
//                 alert("Please select a product option.");
//                 return;
//             }

//             // Prepare data to send via AJAX
//             const formData = new FormData();
//             formData.append('product_id', product_id);
//             formData.append('option', option);

//             // Send AJAX request to update_cart.php
//             fetch('update_cart.php', {
//                 method: 'POST',
//                 body: formData
//             })
//             .then(response => response.json())  // Parse JSON response
//             .then(data => {
//                 if (data.status === 'success') {
//                     // If the request was successful, show success message
//                     alert("Item added to cart successfully!");
//                     location.reload();  // Reload the page to update cart count
//                 } else {
//                     // If there's an error (e.g., item already in cart or DB issues)
//                     alert(`Error: ${data.message}`);  // Display the error message sent from PHP
//                 }
//             })
//             .catch(error => {
//                 console.error('Error:', error);  // Log the error in case of failure
//                 alert('An error occurred while adding the item to the cart. Please try again.');
//             });
//         });
//     });
// });

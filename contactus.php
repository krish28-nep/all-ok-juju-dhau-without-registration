<?php
include("header.php"); // Include header for navigation

// Contact Us Section
echo "<section class='contact-us-section padding-top-section'>
        <div class='container'>
            <h2 class='heading underline'>Contact Us</h2>
            <p class='lead'>We would love to hear from you! Please fill out the form below or contact us via the provided information.</p>
            
            <div class='contact-details'>
                <h3>Our Office</h3>
                <p><strong>Address:</strong> 1234 Street Name, City, Country</p>
                <p><strong>Phone:</strong> +123 456 7890</p>
                <p><strong>Email:</strong> contact@website.com</p>
            </div>

            <h3>Contact Form</h3>
            <form action='process_contact.php' method='POST'>
                <div class='form-group'>
                    <label for='name'>Name</label>
                    <input type='text' id='name' name='name' class='form-control' required>
                </div>
                <div class='form-group'>
                    <label for='email'>Email</label>
                    <input type='email' id='email' name='email' class='form-control' required>
                </div>
                <div class='form-group'>
                    <label for='message'>Message</label>
                    <textarea id='message' name='message' class='form-control' rows='4' required></textarea>
                </div>
                <button type='submit' class='btn btn-primary'>Submit</button>
            </form>
        </div>
      </section>";

include("footer.php"); // Include footer for the page
?>

<div class="form-box">
    <span class="close">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="feather feather-x">
            <line x1="18" y1="6" x2="6" y2="18"></line>
            <line x1="6" y1="6" x2="18" y2="18"></line>
        </svg>
    </span>
    <div class="btn-field">
        <button type="button" name="sign_up" id="signUpBtn">Sign Up</button>
        <button type="button" name="sign_in" class="disable" id="signInBtn">Sign In</button>
    </div>
    <h2 id="title">Sign Up</h2>
    <form id="userForm" action="login-register.php" method="post">
        <div class="input-group">
            <div class="input-field" id="nameField">
                <i class="fa-solid fa-user"></i>
                <input type="text" name="userName" placeholder="Name" />
                <div class="error-message" id="nameError"></div>
            </div>
            <div class="input-field">
                <i class="fa-solid fa-envelope"></i>
                <input type="email" name="userEmail" placeholder="Email" />
                <div class="error-message" id="emailError"></div>
            </div>
            <div class="input-field">
                <i class="fa-solid fa-key"></i>
                <input type="password" name="userPassword" placeholder="Password" />
                <div class="error-message" id="passwordError"></div>
            </div>
            <div class="input-field" id="contactField">
                <i class="fa-solid fa-phone"></i>
                <input type="tel" name="userContact" placeholder="Phone Number" />
                <div class="error-message" id="contactError"></div>
            </div>
            <div class="input-field" id="addressField">
                <i class="fa-solid fa-location-dot"></i>
                <input type="text" name="userAddress" placeholder="Address" />
                <div class="error-message" id="addressError"></div>
            </div>
            <p id="forgetPw">Forget password? <a href="#">Click Here</a></p>
            <button type="submit" id="form-submit" name="sign_up" >Submit</button>
        </div>
    </form>
</div>
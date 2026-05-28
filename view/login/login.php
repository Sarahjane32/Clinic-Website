<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clinic Login</title>
    <link rel="stylesheet" href="../css/index.css">
</head>

<body>

<div class="login-box">

    <div class="login-header">
        <h2>CLINIC LOGIN</h2>
    </div>

    <form action="../../controller/LoginController.php" method="POST">

        <!-- USER TYPE -->

        <div class="form-group">

            <label>User Type</label>

            <select
                name="userType"
                id="userType"
                required
                onchange="changeLoginField()"
            >

                <option value="" disabled selected>
                    Select User Type
                </option>

                <option value="admin">
                    Admin
                </option>

                <option value="doctor">
                    Doctor
                </option>

            </select>

        </div>

        <!-- LOGIN INPUT -->

        <div class="form-group">

            <label id="loginLabel">
                Username
            </label>

            <input
                type="text"
                name="loginInput"
                id="loginInput"
                required
                placeholder="Enter Username"
            >

        </div>

        <!-- PASSWORD -->

        <div class="form-group">

            <label>Password</label>

            <input
                type="password"
                name="password"
                required
            >

        </div>

        <!-- FORGOT PASSWORD -->

        <div class="forgot-password">
            <a href="forgotPassword.php">
                Forgot Password?
            </a>
        </div>

        <!-- ERROR -->

        <div id="errorMsg" class="error"></div>

        <!-- LOGIN BUTTON -->

        <button class="login-btn" type="submit">
            LOGIN
        </button>

        <!-- SIGN UP -->

        <a href="../login/register.php" class="signup-btn">
            SIGN UP
        </a>

    </form>

</div>

<script>

function changeLoginField(){

    let userType = document.getElementById("userType").value;

    let loginLabel = document.getElementById("loginLabel");
    let loginInput = document.getElementById("loginInput");

    if(userType === "admin"){

        loginLabel.innerText = "Username";

        loginInput.placeholder = "Enter Username";
    }

    else if(userType === "doctor"){

        loginLabel.innerText = "License Number";

        loginInput.placeholder = "Enter License Number";
    }
}

</script>

</body>
</html>
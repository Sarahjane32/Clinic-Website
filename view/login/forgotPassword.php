<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="../css/index.css">
</head>

<body>

<div class="login-box">

    <div class="login-header">
        <h2>FORGOT PASSWORD</h2>
    </div>

    <form action="../../controller/forgotPasswordController.php" method="POST">

        <div class="form-group">
            <label>User Type</label>

            <select name="userType" required>
                <option value="" disabled selected>Select User Type</option>
                <option value="admin">Admin</option>
                <option value="doctor">Doctor</option>
            </select>
        </div>

        <div class="form-group">
            <label>Email Address</label>
            <input type="email" name="email" placeholder="Enter your registered email" required>
        </div>

        <div class="form-group">
            <label>Username / Employee No. / License No.</label>
            <input type="text" name="username" placeholder="Enter your username" required>
        </div>

        <div class="form-group">
            <label>New Password</label>
            <input type="password" name="newPassword" placeholder="Enter new password" required>
        </div>

        <div class="form-group">
            <label>Confirm Password</label>
            <input type="password" name="confirmPassword" placeholder="Confirm new password" required>
        </div>

        <div id="errorMsg" class="error"></div>

        <button type="submit" class="login-btn">
            RESET PASSWORD
        </button>

        <a href="../login/login.php" class="signup-btn">
            BACK TO LOGIN
        </a>

    </form>

</div>

</body>
</html>
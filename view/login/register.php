<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Account</title>
    <link rel="stylesheet" href="../css/index.css">
</head>

<body>

<div class="login-box">

    <div class="login-header">
        <h2>REGISTER ACCOUNT</h2>
    </div>

    <form action="RegisterController.php" method="POST" enctype="multipart/form-data">

        <!-- USER TYPE -->

        <div class="form-group">

            <label>User Type</label>

            <select
                name="registerType"
                id="userType"
                required
                onchange="toggleFields()"
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

        <!-- FIRST NAME -->

        <div class="form-group">
            <label>First Name</label>
            <input type="text" name="firstname" required>
        </div>

        <!-- LAST NAME -->

        <div class="form-group">
            <label>Last Name</label>
            <input type="text" name="lastname" required>
        </div>

        <!-- EMAIL -->

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" required>
        </div>

        <!-- USERNAME -->

        <div class="form-group">

            <label>Username (Admin Only)</label>

            <input
                type="text"
                name="username"
                id="usernameField"
                disabled
            >

        </div>

        <!-- LICENSE NUMBER -->

        <div class="form-group">

            <label>License Number (Doctor Only)</label>

            <input
                type="text"
                name="license_number"
                id="licenseField"
                disabled
            >

        </div>

        <!-- SPECIALIZATION -->

        <div class="form-group">

            <label>Specialization (Doctor Only)</label>

            <select
                name="specialization"
                id="specializationField"
                disabled
            >

                <option value="" disabled selected>
                    Select Specialization
                </option>

                <option value="General Medicine">
                    General Medicine
                </option>

                <option value="Diabetology">
                    Diabetology
                </option>

                <option value="Cardiology">
                    Cardiology
                </option>

                <option value="Pediatrics">
                    Pediatrics
                </option>

                <option value="Dermatology">
                    Dermatology
                </option>

                <option value="Neurology">
                    Neurology
                </option>

            </select>

        </div>

        <!-- CONTACT NUMBER -->

        <div class="form-group">
            <label>Contact Number</label>
            <input type="text" name="contact_number" required>
        </div>

        <!-- PASSWORD -->

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" required>
        </div>

        <!-- PICTURE -->
        <div class="form-group">
            <label>Profile Picture</label>
            <input type="file" name="profile_picture" accept="image/*" required>
        </div>

        <!-- BUTTON -->

        <button type="submit" class="login-btn">
            CREATE ACCOUNT
        </button>

    </form>

</div>

<script>

function toggleFields(){

    let userType = document.getElementById("userType").value;

    let usernameField = document.getElementById("usernameField");

    let licenseField = document.getElementById("licenseField");

    let specializationField =
        document.getElementById("specializationField");

    /* =========================
       ADMIN
    ========================= */

    if(userType === "admin"){

        usernameField.disabled = false;
        usernameField.required = true;

        licenseField.disabled = true;
        licenseField.required = false;
        licenseField.value = "";

        specializationField.disabled = true;
        specializationField.required = false;
        specializationField.value = "";
    }

    /* =========================
       DOCTOR
    ========================= */

    else if(userType === "doctor"){

        usernameField.disabled = true;
        usernameField.required = false;
        usernameField.value = "";

        licenseField.disabled = false;
        licenseField.required = true;

        specializationField.disabled = false;
        specializationField.required = true;
    }
}

</script>

</body>
</html>
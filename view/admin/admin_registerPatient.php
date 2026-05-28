<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Register Patient</title>

<link rel="stylesheet" href="../css/admin_registerPatient.css">
</head>

<body>

<div class="container">
     
    <div class="form-box">

        <a href="../admin/admin_dashboard.php" class="back-btn">
            ← Back to Dashboard
        </a>

        <h1>Register Patient</h1>

        <form id="patientForm" action="RegisterPatientController.php" method="POST">

            <div class="form-group">
                <label>Full Name</label>
                <input id="name" name="name" type="text">
            </div>

            <div class="form-group">
                <label>Gender</label>
                <select id="gender" name="gender">
                    <option value="">Select</option>
                    <option>Male</option>
                    <option>Female</option>
                </select>
            </div>

            <div class="form-group">
                <label>Birthdate</label>
                <input id="birthdate" name="birthdate" type="date">
            </div>

            <div class="form-group">
                <label>Contact Number</label>
                <input id="phone" name="phone" type="text" maxlength="11">
                <small id="phoneError" style="color:red;"></small>
            </div>

            <div class="form-group">
                <label>Address</label>
                <input id="address" name="address" type="text">
            </div>

            <div class="form-group">
                <label>Emergency Contact</label>
                <input id="emergency" name="emergency" type="text">
            </div>

            <div class="form-group">
                <label>Allergies</label>
                <input id="allergies" name="allergies" type="text">
            </div>

            <div class="form-group">
                <label>Medical History</label>
                <textarea id="history" name="history"></textarea>
            </div>

            <div class="button-group">

                <button 
                    type="submit"
                    id="saveBtn"
                    class="save-btn"
                    disabled>

                    Save Patient

                </button>

                <button type="reset" class="clear-btn">
                    Clear
                </button>

            </div>

        </form>

    </div>

</div>

<script>

const form = document.getElementById("patientForm");
const saveBtn = document.getElementById("saveBtn");
const phone = document.getElementById("phone");
const phoneError = document.getElementById("phoneError");

/* numbers only + 11 digits */
phone.addEventListener("input", () => {

    phone.value = phone.value.replace(/\D/g, "").slice(0, 11);

    if (phone.value.length > 0 && phone.value.length < 11) {
        phoneError.textContent = "11 digits required";
    } else {
        phoneError.textContent = "";
    }

    toggleButton();
});

/* check if all fields are filled */
function toggleButton() {

    const inputs = form.querySelectorAll("input, select, textarea");

    let filled = true;

    inputs.forEach(input => {

        if (input.value.trim() === "") {
            filled = false;
        }

    });

    saveBtn.disabled = !(filled && phone.value.length === 11);
}

/* monitor all inputs */
form.addEventListener("input", toggleButton);


</script>

</body>
</html>
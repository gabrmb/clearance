function validateForm() {
    const name = document.forms[0]["name"].value;
    const dept = document.forms[0]["dept"].value;
    const desig = document.forms[0]["desig"].value;
    const email = document.forms[0]["email"].value;
    const phoneNo = document.forms[0]["phoneNo"].value;
    const password = document.forms[0]["password"].value;
    const confirmPassword = document.forms[0]["ConfirmPassword"].value;

    // Radio buttons for gender
    const genderMale = document.forms[0]["gender"][0].checked;
    const genderFemale = document.forms[0]["gender"][1].checked;
    const genderOther = document.forms[0]["gender"][2].checked;

    const nameRegex = /^[A-Za-z\s]+$/;
    const deptRegex = /^[A-Za-z\s]+$/;
    const desigRegex = /^[A-Za-z\s]+$/;
    const phoneRegex = /^[0-9]+$/;
    // This regex ensures the email has a valid format and includes a top-level domain
    const emailRegex = /^[^\s@]+@[^\s@]+\.[A-Za-z]{2,}$/;

    if (!name.match(nameRegex)) {
        alert("Full Name should not contain numbers");
        return false;
    }

    if (!dept.match(deptRegex)) {
        alert("Department should not contain numbers");
        return false;
    }

    if (!desig.match(desigRegex)) {
        alert("Designation should not contain numbers");
        return false;
    }

    if (!email.match(emailRegex)) {
        alert("Please enter a valid email address with a correct top-level domain (e.g., .com, .org, .ac.ke)");
        return false;
    }

    if (!phoneNo.match(phoneRegex)) {
        alert("Phone Number should not contain letters");
        return false;
    }

    if (password !== confirmPassword) {
        alert("Passwords do not match");
        return false;
    }

    if (!genderMale && !genderFemale && !genderOther) {
        alert("Please select a gender");
        return false;
    }

    return true; // Allow form submission if all checks pass
}

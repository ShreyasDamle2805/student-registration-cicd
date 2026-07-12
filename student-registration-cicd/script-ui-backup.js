function showMessage(text, type) {
    const container = document.getElementById("message");
    if (!container) return;

    container.className = `alert ${type}`;
    container.textContent = text;
}

const registerForm = document.getElementById("registerForm");

if (registerForm) {
    registerForm.addEventListener("submit", function (event) {
        event.preventDefault();

        const fullName = document.getElementById("fullName").value.trim();
        const email = document.getElementById("email").value.trim().toLowerCase();
        const usn = document.getElementById("usn").value.trim().toUpperCase();
        const department = document.getElementById("department").value;
        const password = document.getElementById("password").value;
        const confirmPassword = document.getElementById("confirmPassword").value;

        if (password !== confirmPassword) {
            showMessage("Passwords do not match.", "error");
            return;
        }

        const student = {
            fullName,
            email,
            usn,
            department,
            password
        };

        localStorage.setItem("demoStudent", JSON.stringify(student));
        sessionStorage.removeItem("demoLoggedIn");
        showMessage("Registration successful. Redirecting to login...", "success");

        setTimeout(() => {
            window.location.href = "login.html";
        }, 900);
    });
}

const loginForm = document.getElementById("loginForm");

if (loginForm) {
    loginForm.addEventListener("submit", function (event) {
        event.preventDefault();

        const email = document.getElementById("loginEmail").value.trim().toLowerCase();
        const password = document.getElementById("loginPassword").value;
        const storedStudent = JSON.parse(localStorage.getItem("demoStudent") || "null");

        if (!storedStudent) {
            showMessage("Please register first.", "error");
            return;
        }

        if (storedStudent.email === email && storedStudent.password === password) {
            sessionStorage.setItem("demoLoggedIn", "true");
            showMessage("Login successful. Opening dashboard...", "success");

            setTimeout(() => {
                window.location.href = "dashboard.html";
            }, 700);
        } else {
            showMessage("Invalid email or password.", "error");
        }
    });
}

if (window.location.pathname.endsWith("dashboard.html")) {
    const loggedIn = sessionStorage.getItem("demoLoggedIn") === "true";
    const student = JSON.parse(localStorage.getItem("demoStudent") || "null");

    if (!loggedIn || !student) {
        window.location.href = "login.html";
    } else {
        document.getElementById("welcomeName").textContent = `Welcome, ${student.fullName}`;
        document.getElementById("studentName").textContent = student.fullName;
        document.getElementById("studentEmail").textContent = student.email;
        document.getElementById("studentUsn").textContent = student.usn;
        document.getElementById("studentDepartment").textContent = student.department;
    }
}

const logoutButton = document.getElementById("logoutButton");

if (logoutButton) {
    logoutButton.addEventListener("click", function () {
        sessionStorage.removeItem("demoLoggedIn");
        window.location.href = "login.html";
    });
}

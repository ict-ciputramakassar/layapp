// API endpoints are now defined in user-roles.blade.php with blade syntax
// const API_USERS, API_ROLES, API_USERS_STORE, API_USERS_UPDATE_ROLE, API_USERS_DELETE

// Define permissions as constants (sidebar menu items)
const PERMISSIONS = {
    dashboard: "Dashboard",
    reports: "Reports",
    event_list: "Event List",
    create_event: "Add Event",
    schedule_list: "Schedule List",
    create_schedule: "Create Schedule",
    score_list: "Score List",
    user_roles: "User Roles",
    docs: "Docs",
    changelog: "Changelog",
    team_members: "Team Members",
    add_team_members: "Create Members",
};

let allUsers = [];
let allRoles = [];
let usersDataTable = null;

document.addEventListener("DOMContentLoaded", function () {
    loadUsers();
    loadRoles();
});

// Load all users from database
function loadUsers() {
    fetch(API_USERS, {
        headers: {
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
            Accept: "application/json",
        },
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                allUsers = data.data;
                renderUsersTable();
            }
        })
        .catch((error) => console.error("Error loading users:", error));
}

// Load all available roles
function loadRoles() {
    fetch(API_ROLES, {
        headers: {
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
            Accept: "application/json",
        },
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                allRoles = data.data;
                renderRolesList();
                updateRoleSelect();
            }
        })
        .catch((error) => console.error("Error loading roles:", error));
}

// Render users table
function renderUsersTable() {
    if (usersDataTable) {
        usersDataTable.destroy();
    }

    const tbody = document.getElementById("userTable");
    tbody.innerHTML = "";

    allUsers.forEach((user) => {
        const row = document.createElement("tr");
        const roleName =
            user.user_type && user.user_type.name
                ? user.user_type.name
                : "Unknown";

        row.innerHTML = `
            <td>${user.full_name}</td>
            <td class="text-muted">${user.email}</td>
            <td class="align-middle"><span class="badge bg-light text-dark">${roleName}</span></td>
            <td class="text-end">
                <button class="btn btn-sm text-primary" data-bs-toggle="modal" data-bs-target="#userModal" onclick="editUser('${user.id}')">
                    edit
                </button>
                <button class="btn btn-sm text-danger" onclick="deleteUser('${user.id}')">
                    delete
                </button>
            </td>
        `;
        tbody.appendChild(row);
    });

    // Initialize DataTables
    usersDataTable = new DataTable("#usersDataTable", {
        lengthMenu: [5, 10, 25, 50],
        pageLength: 10,
        responsive: true,
        language: {
            search: "",
            searchPlaceholder: "Search...",
        },
        dom:
            "<'row mb-3'<'col-md-6'l><'col-md-6 d-flex flex-row-reverse'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row mt-3'<'col-md-5'i><'col-md-7 d-flex justify-content-end'p>>",
    });
}

// Render roles list
function renderRolesList() {
    const rolesList = document.getElementById("rolesList");
    rolesList.innerHTML = "";

    allRoles.forEach((role) => {
        const roleDiv = document.createElement("div");
        roleDiv.className = "p-3 bg-light rounded-2 border mb-2";

        let permissionBadges = "";

        // Get allowed permissions from database
        let allowedPerms = [];
        if (role.permissions) {
            try {
                allowedPerms = JSON.parse(role.permissions);
            } catch (e) {
                // Ignore if not valid JSON
            }
        }

        allowedPerms.forEach((key) => {
            if (PERMISSIONS[key]) {
                // Use the readable name from PERMISSIONS object
                permissionBadges += `<span class="badge bg-white border rounded-pill text-dark fw-normal me-2 mb-2">${PERMISSIONS[key]}</span>`;
            }
        });

        roleDiv.innerHTML = `
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <h6 class="mb-4">${role.name}</h6>
                    <div class="d-flex flex-wrap flex-grow-1">
                        ${permissionBadges}
                    </div>
                </div>
                <div class="d-flex gap-1">
                    <button class="btn btn-outline-dark btn-sm" data-bs-toggle="modal" data-bs-target="#roleModal" onclick="editRole('${role.id}')">Edit</button>
                    <button class="btn btn-outline-danger btn-sm" onclick="deleteRole('${role.id}')">Delete</button>
                </div>
            </div>
        `;
        rolesList.appendChild(roleDiv);
    });
}

// Update role select in modal
function updateRoleSelect() {
    const roleSelect = document.getElementById("role");
    // Reset and add the default option back
    roleSelect.innerHTML =
        '<option value="" disabled selected>Select a role...</option>';

    allRoles.forEach((role) => {
        const option = document.createElement("option");
        option.value = role.id;
        option.textContent = role.name + " (" + role.code + ")";
        roleSelect.appendChild(option);
    });
}

// Edit user
function editUser(userId) {
    // Clear all previous error states
    document
        .querySelectorAll(".is-invalid")
        .forEach((el) => el.classList.remove("is-invalid"));
    document.querySelectorAll(".invalid-feedback").forEach((el) => el.remove());

    const user = allUsers.find((u) => u.id === userId);
    if (!user) return;

    document.getElementById("userModalTitle").textContent = "Edit User";
    document.getElementById("name").value = user.full_name;
    document.getElementById("email").value = user.email;
    document.getElementById("phone").value = user.phone_number;
    document.getElementById("role").value = user.user_type_id;

    // Clear password fields so they don't carry over from other actions
    document.getElementById("password").value = "";
    document.getElementById("confirm_password").value = "";

    // Remove existing editing input if present, then create new one
    let existingInput = document.getElementById("editingUserId");
    if (existingInput) {
        existingInput.remove();
    }

    // Adjust password fields for editing
    document.querySelectorAll(".password-field").forEach((field) => {
        field.style.display = "block";

        // Hide the red asterisk
        const asterisk = field.querySelector("label span.text-danger");
        if (asterisk) asterisk.style.display = "none";

        // Modify input placeholders and remove required attribute
        const input = field.querySelector("input");
        if (input) {
            input.required = false;
            if (input.id === "password") {
                input.placeholder =
                    "New Password (leave blank to keep current)";
            } else if (input.id === "confirm_password") {
                input.placeholder = "Repeat New Password";
            }
        }
    });

    const editingInput = Object.assign(document.createElement("input"), {
        type: "hidden",
        id: "editingUserId",
        value: userId,
    });
    document.getElementById("name").parentElement.appendChild(editingInput);
}

// Save user (create or update)
function saveUser() {
    const editingUserInput = document.getElementById("editingUserId");
    const isEditing = editingUserInput && editingUserInput.value;
    const name = document.getElementById("name").value;
    const email = document.getElementById("email").value;
    const phone = document.getElementById("phone").value;
    const role = document.getElementById("role").value;
    const password = document.getElementById("password");
    const confirmPassword = document.getElementById("confirm_password");

    // Clear all previous error states for all fields
    document
        .querySelectorAll(".is-invalid")
        .forEach((el) => el.classList.remove("is-invalid"));
    document.querySelectorAll(".invalid-feedback").forEach((el) => el.remove());

    if (!name) {
        let inputEl = document.getElementById("name");
        inputEl.classList.add("is-invalid");
        inputEl.insertAdjacentHTML(
            "afterend",
            '<div id="name-error" class="invalid-feedback">Name is required</div>',
        );
        return;
    }

    if (!email) {
        let inputEl = document.getElementById("email");
        inputEl.classList.add("is-invalid");
        inputEl.insertAdjacentHTML(
            "afterend",
            '<div id="email-error" class="invalid-feedback">Email is required</div>',
        );
        return;
    }

    if (email && !/^\S+@\S+\.\S+$/.test(email)) {
        let inputEl = document.getElementById("email");
        inputEl.classList.add("is-invalid");
        inputEl.insertAdjacentHTML(
            "afterend",
            '<div id="email-error" class="invalid-feedback">Please enter a valid email address</div>',
        );
        return;
    }

    if (!phone) {
        let inputEl = document.getElementById("phone");
        inputEl.classList.add("is-invalid");
        inputEl.insertAdjacentHTML(
            "afterend",
            '<div id="phone-error" class="invalid-feedback">Phone is required</div>',
        );
        return;
    }

    if (phone && !/^\+?[0-9\s\-()]+$/.test(phone)) {
        let inputEl = document.getElementById("phone");
        inputEl.classList.add("is-invalid");
        inputEl.insertAdjacentHTML(
            "afterend",
            '<div id="phone-error" class="invalid-feedback">Please enter a valid phone number</div>',
        );
        return;
    }

    if (!isEditing || password.value) {
        if (!password || !password.value) {
            let inputEl = document.getElementById("password");
            inputEl.classList.add("is-invalid");
            inputEl.parentElement.insertAdjacentHTML(
                "afterend",
                '<div id="password-error" class="invalid-feedback d-block">Password is required</div>',
            );
            return;
        }

        if (password && password.value.length < 6) {
            let inputEl = document.getElementById("password");
            inputEl.classList.add("is-invalid");
            inputEl.parentElement.insertAdjacentHTML(
                "afterend",
                '<div id="password-error" class="invalid-feedback d-block">Password must be at least 6 characters</div>',
            );
            return;
        }

        if (!confirmPassword || !confirmPassword.value) {
            let inputEl = document.getElementById("confirm_password");
            inputEl.classList.add("is-invalid");
            inputEl.parentElement.insertAdjacentHTML(
                "afterend",
                '<div id="confirm-password-error" class="invalid-feedback d-block">Please confirm the password</div>',
            );
            return;
        }

        if (password.value !== confirmPassword.value) {
            let inputEl = document.getElementById("confirm_password");
            inputEl.classList.add("is-invalid");
            inputEl.parentElement.insertAdjacentHTML(
                "afterend",
                '<div id="confirm-password-match-error" class="invalid-feedback d-block">Passwords do not match</div>',
            );
            return;
        }
    }

    if (!role) {
        let inputEl = document.getElementById("role");
        inputEl.classList.add("is-invalid");
        inputEl.insertAdjacentHTML(
            "afterend",
            '<div id="role-error" class="invalid-feedback">Role is required</div>',
        );
        return;
    }

    // For editing
    if (isEditing) {
        updateUser(
            editingUserInput.value,
            name,
            email,
            phone,
            password.value,
            role,
        );
        document.querySelector("#userModal .btn-close").click();
        return;
    }

    const data = {
        full_name: name,
        email: email,
        phone_number: phone,
        user_type_id: role,
        password: password.value,
    };

    fetch(API_USERS_STORE, {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
            "Content-Type": "application/json",
            Accept: "application/json",
        },
        body: JSON.stringify(data),
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                alert(data.message);
                loadUsers();
                document.querySelector("#userModal .btn-close").click();
                resetUserForm();
            } else {
                alert("Error: " + data.message);
            }
        })
        .catch((error) => {
            console.error("Error:", error);
            alert("Failed to create user");
        });
}

// Update user role
function updateUser(userId, fullName, email, phone, password, roleId) {
    const data = {
        full_name: fullName,
        email: email,
        phone_number: phone,
        password: password,
        user_type_id: roleId,
    };

    fetch(API_USERS_UPDATE.replace(":userId", userId), {
        method: "PUT",
        headers: {
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
            "Content-Type": "application/json",
            Accept: "application/json",
        },
        body: JSON.stringify(data),
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                alert(data.message);
                loadUsers();
            } else {
                alert("Error: " + data.message);
            }
        })
        .catch((error) => {
            console.error("Error:", error);
            alert("Failed to update user");
        });
}

function updateUserRole(userId, roleId) {
    const data = { user_type_id: roleId };

    fetch(API_USERS_UPDATE_ROLE.replace(":userId", userId), {
        method: "PUT",
        headers: {
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
            "Content-Type": "application/json",
            Accept: "application/json",
        },
        body: JSON.stringify(data),
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                alert(data.message);
                loadUsers();
            } else {
                alert("Error: " + data.message);
            }
        })
        .catch((error) => {
            console.error("Error:", error);
            alert("Failed to update user role");
        });
}

// Delete user
function deleteUser(userId) {
    if (!confirm("Are you sure you want to delete this user?")) {
        return;
    }

    fetch(API_USERS_DELETE.replace(":userId", userId), {
        method: "DELETE",
        headers: {
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
            Accept: "application/json",
        },
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                alert(data.message);
                loadUsers();
            } else {
                alert("Error: " + data.message);
            }
        })
        .catch((error) => {
            console.error("Error:", error);
            alert("Failed to delete user");
        });
}

// Reset user form
function resetUserForm() {
    // Clear all previous error states
    document
        .querySelectorAll(".is-invalid")
        .forEach((el) => el.classList.remove("is-invalid"));
    document.querySelectorAll(".invalid-feedback").forEach((el) => el.remove());

    document.getElementById("userModalTitle").textContent = "Add User";
    document.getElementById("name").value = "";
    document.getElementById("email").value = "";
    document.getElementById("phone").value = "";
    document.getElementById("role").value = "";

    const editingInput = document.getElementById("editingUserId");
    if (editingInput) {
        editingInput.remove();
    }

    // Show phone field when creating new user
    const phoneField = document.querySelector(".phone-field");
    if (phoneField) {
        phoneField.style.display = "block";
    }

    // Clear password values when resetting form
    const password = document.getElementById("password");
    const confirmPassword = document.getElementById("confirm_password");
    if (password) password.value = "";
    if (confirmPassword) confirmPassword.value = "";

    // Show and reset all password fields when creating new user
    document.querySelectorAll(".password-field").forEach((field) => {
        field.style.display = "block";

        // Show the red asterisk again
        const asterisk = field.querySelector("label span.text-danger");
        if (asterisk) asterisk.style.display = "inline";

        // Revert input placeholders and add required attribute back
        const input = field.querySelector("input");
        if (input) {
            input.required = true;
            if (input.id === "password") {
                input.placeholder = "Password";
            } else if (input.id === "confirm_password") {
                input.placeholder = "Repeat Password";
            }
        }
    });
}

// Save role
function saveRole() {
    const editingRoleId = document.getElementById("editingRoleId");
    const name = document.getElementById("roleName").value;
    const code = document.getElementById("roleCode").value;

    if (!name || !code) {
        alert("Please fill in role name and code");
        return;
    }

    // Store selected permissions for current role
    let selectedPerms = [];
    Object.keys(PERMISSIONS).forEach((key) => {
        const checkbox = document.getElementById("perm_" + key);
        if (checkbox && checkbox.checked) {
            selectedPerms.push(key);
        }
    });

    const data = {
        name: name,
        code: code,
        permissions: JSON.stringify(selectedPerms),
    };

    // If editing existing role
    if (editingRoleId && editingRoleId.value) {
        const roleId = editingRoleId.value;
        fetch(API_ROLES_UPDATE.replace(":roleId", roleId), {
            method: "PUT",
            headers: {
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
                "Content-Type": "application/json",
                Accept: "application/json",
            },
            body: JSON.stringify(data),
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    alert(data.message);
                    loadRoles();
                    document.querySelector("#roleModal .btn-close").click();
                    resetRoleForm();
                } else {
                    alert("Error: " + data.message);
                }
            })
            .catch((error) => {
                console.error("Error:", error);
                alert("Failed to update role");
            });
        return;
    }

    // If creating new role
    fetch(API_ROLES_STORE, {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
            "Content-Type": "application/json",
            Accept: "application/json",
        },
        body: JSON.stringify(data),
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                alert(data.message);
                loadRoles();
                document.querySelector("#roleModal .btn-close").click();
                resetRoleForm();
            } else {
                alert("Error: " + data.message);
            }
        })
        .catch((error) => {
            console.error("Error:", error);
            alert("Failed to create role");
        });
}

// Reset role form
function resetRoleForm() {
    document.getElementById("roleModalTitle").textContent = "Add Role";
    document.getElementById("roleName").value = "";
    document.getElementById("roleCode").value = "";
    document.querySelectorAll(".form-check-input").forEach((checkbox) => {
        checkbox.checked = false;
    });

    const editingInput = document.getElementById("editingRoleId");
    if (editingInput) {
        editingInput.remove();
    }
}

// Edit role (populate modal)
function editRole(roleId) {
    const role = allRoles.find((r) => r.id === roleId);
    if (!role) return;

    document.getElementById("roleModalTitle").textContent = "Edit Role";
    document.getElementById("roleName").value = role.name;
    document.getElementById("roleCode").value = role.code;

    // Retrieve dynamically saved permissions from the database
    let allowedPerms = [];
    if (role.permissions) {
        try {
            allowedPerms = JSON.parse(role.permissions);
        } catch (e) {
            // Ignore if not valid JSON
        }
    }

    // Reset all permission checkboxes and check only allowed ones
    Object.keys(PERMISSIONS).forEach((key) => {
        const checkbox = document.getElementById("perm_" + key);
        if (checkbox) {
            checkbox.checked = allowedPerms.includes(key);
        }
    });

    // Add hidden input for editing
    let editingInput = document.getElementById("editingRoleId");
    if (editingInput) {
        editingInput.remove();
    }
    editingInput = Object.assign(document.createElement("input"), {
        type: "hidden",
        id: "editingRoleId",
        value: roleId,
    });
    document.getElementById("roleName").parentElement.appendChild(editingInput);
}

// Delete role
function deleteRole(roleId) {
    if (!confirm("Are you sure you want to delete this role?")) {
        return;
    }

    fetch(API_ROLES_DELETE.replace(":roleId", roleId), {
        method: "DELETE",
        headers: {
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
            Accept: "application/json",
        },
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                alert(data.message);
                loadRoles();
            } else {
                alert("Error: " + data.message);
            }
        })
        .catch((error) => {
            console.error("Error:", error);
            alert("Failed to delete role");
        });
}

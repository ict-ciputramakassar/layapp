// API endpoints are now defined in user-roles.blade.php with blade syntax
// const API_USERS, API_ROLES, API_USERS_STORE, API_USERS_UPDATE_ROLE, API_USERS_DELETE

// Define permissions as constants (sidebar menu items)
const PERMISSIONS = {
    dashboard: 'Dashboard',
    inventory: 'Inventory',
    reports: 'Reports',
    create_event: 'Add Event',
    edit_product: 'Edit Product',
    product_details: 'Product Details',
    categories: 'Categories',
    brands: 'Brands',
    variants: 'Variants',
    stock_overview: 'Stock Overview',
    stock_in: 'Stock In',
    stock_out: 'Stock Out',
    low_stock: 'Low Stock Products',
    expired_stock: 'Expired Stock',
    warehouse: 'Warehouse Location',
    order_list: 'Order List',
    order_details: 'Order Details',
    create_order: 'Create Order',
    invoice: 'Invoice',
    returns: 'Returns / Refunds',
    pos: 'POS',
    user_roles: 'User Roles',
    docs: 'Docs',
    changelog: 'Changelog'
};

// Store selected permissions for current role
let currentRolePermissions = {};
let allUsers = [];
let allRoles = [];

document.addEventListener('DOMContentLoaded', function () {
    loadUsers();
    loadRoles();
});

// Load all users from database
function loadUsers() {
    fetch(API_USERS, {
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            allUsers = data.data;
            renderUsersTable();
        }
    })
    .catch(error => console.error('Error loading users:', error));
}

// Load all available roles
function loadRoles() {
    fetch(API_ROLES, {
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            allRoles = data.data;
            renderRolesList();
            updateRoleSelect();
        }
    })
    .catch(error => console.error('Error loading roles:', error));
}

// Render s table
function renderUsersTable() {
    const tbody = document.getElementById('userTable');
    tbody.innerHTML = '';

    allUsers.forEach(user => {
        const row = document.createElement('tr');
        const roleName = user.user_type && user.user_type.name ? user.user_type.name : 'Unknown';

        row.innerHTML = `
            <td>${user.full_name}</td>
            <td class="text-muted">${user.email}</td>
            <td class="align-middle"><span class="badge bg-light text-dark">${roleName}</span></td>
            <td class="text-end">
                <button class="btn btn-sm" onclick="editUser('${user.id}')">
                    <span class="text-primary">edit</span>
                </button>
                <button class="btn btn-sm" onclick="deleteUser('${user.id}')">
                    <span class="text-danger">delete</span>
                </button>
            </td>
        `;
        tbody.appendChild(row);
    });
}

// Render roles list
function renderRolesList() {
    const rolesList = document.getElementById('rolesList');
    rolesList.innerHTML = '';

    allRoles.forEach(role => {
        const roleDiv = document.createElement('div');
        roleDiv.className = 'p-3 bg-light rounded-2 border mb-2';

        let permissionBadges = '';
        Object.keys(PERMISSIONS).forEach(key => {
            permissionBadges += `<span class="badge bg-white border rounded-pill text-dark fw-normal me-2 mb-2">${key.replace(/_/g, ' ')}</span>`;
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
                    <button class="btn btn-outline-dark btn-sm" onclick="editRole('${role.id}')">Edit</button>
                    <button class="btn btn-outline-danger btn-sm" onclick="deleteRole('${role.id}')">Delete</button>
                </div>
            </div>
        `;
        rolesList.appendChild(roleDiv);
    });
}

// Update role select in modal
function updateRoleSelect() {
    const roleSelect = document.getElementById('role');
    roleSelect.innerHTML = '';

    allRoles.forEach(role => {
        const option = document.createElement('option');
        option.value = role.id;
        option.textContent = role.name + ' (' + role.code + ')';
        roleSelect.appendChild(option);
    });
}

// Edit user (populate modal)
function editUser(userId) {
    const user = allUsers.find(u => u.id === userId);
    if (!user) return;

    document.getElementById('userModalTitle').textContent = 'Edit User';
    document.getElementById('name').value = user.full_name;
    document.getElementById('email').value = user.email;
    document.getElementById('role').value = user.user_type_id;

    // Hide phone field when editing
    const phoneField = document.querySelector('.phone-field');
    if (phoneField) {
        phoneField.style.display = 'none';
    }

    // Hide password field when editing
    const passwordField = document.querySelector('.password-field');
    if (passwordField) {
        passwordField.style.display = 'none';
    }

    // Remove existing editing input if present, then create new one
    let existingInput = document.getElementById('editingUserId');
    if (existingInput) {
        existingInput.remove();
    }

    const editingInput = Object.assign(document.createElement('input'), {
        type: 'hidden',
        id: 'editingUserId',
        value: userId
    });
    document.getElementById('name').parentElement.appendChild(editingInput);

    const modal = new bootstrap.Modal(document.getElementById('userModal'));
    modal.show();
}

// Save user (create or update)
function saveUser() {
    const editingUserInput = document.getElementById('editingUserId');
    const isEditing = editingUserInput && editingUserInput.value;
    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const phone = document.getElementById('phone').value;
    const role = document.getElementById('role').value;

    if (!name || !email || !role) {
        alert('Please fill in all fields');
        return;
    }

    // If editing existing user
    if (isEditing) {
        updateUser(editingUserInput.value, name, email, role);
        bootstrap.Modal.getInstance(document.getElementById('userModal')).hide();
        return;
    }

    // If creating new user - phone is required
    if (!phone) {
        alert('Please enter phone number');
        return;
    }

    // If creating new user
    const password = document.getElementById('password');
    if (!password || !password.value) {
        alert('Please enter a password for the new user');
        return;
    }

    const data = {
        full_name: name,
        email: email,
        phone_number: phone,
        user_type_id: role,
        password: password.value
    };

    fetch(API_USERS_STORE, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            loadUsers();
            bootstrap.Modal.getInstance(document.getElementById('userModal')).hide();
            resetUserForm();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Failed to create user');
    });
}

// Update user role
function updateUser(userId, fullName, email, roleId) {
    const data = {
        full_name: fullName,
        email: email,
        user_type_id: roleId
    };

    fetch(API_USERS_UPDATE.replace(':userId', userId), {
        method: 'PUT',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            loadUsers();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Failed to update user');
    });
}

function updateUserRole(userId, roleId) {
    const data = { user_type_id: roleId };

    fetch(API_USERS_UPDATE_ROLE.replace(':userId', userId), {
        method: 'PUT',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            loadUsers();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Failed to update user role');
    });
}

// Delete user
function deleteUser(userId) {
    if (!confirm('Are you sure you want to delete this user?')) {
        return;
    }

    fetch(API_USERS_DELETE.replace(':userId', userId), {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            loadUsers();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Failed to delete user');
    });
}

// Reset user form
function resetUserForm() {
    document.getElementById('userModalTitle').textContent = 'Add User';
    document.getElementById('name').value = '';
    document.getElementById('email').value = '';
    document.getElementById('phone').value = '';
    document.getElementById('role').value = '';

    const editingInput = document.getElementById('editingUserId');
    if (editingInput) {
        editingInput.remove();
    }

    // Show phone field when creating new user
    const phoneField = document.querySelector('.phone-field');
    if (phoneField) {
        phoneField.style.display = 'block';
    }

    // Show password field when creating new user
    const passwordField = document.querySelector('.password-field');
    if (passwordField) {
        passwordField.style.display = 'block';
    }
}

// Save role
function saveRole() {
    const editingRoleId = document.getElementById('editingRoleId');
    const name = document.getElementById('roleName').value;
    const code = document.getElementById('roleCode').value;

    if (!name || !code) {
        alert('Please fill in role name and code');
        return;
    }

    // Store selected permissions in memory (not saved to database)
    currentRolePermissions = {};
    Object.keys(PERMISSIONS).forEach(key => {
        const checkbox = document.getElementById('perm_' + key);
        if (checkbox) {
            currentRolePermissions[key] = checkbox.checked;
        }
    });

    const data = {
        name: name,
        code: code
    };

    // If editing existing role
    if (editingRoleId && editingRoleId.value) {
        const roleId = editingRoleId.value;
        fetch(API_ROLES_UPDATE.replace(':roleId', roleId), {
            method: 'PUT',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                loadRoles();
                bootstrap.Modal.getInstance(document.getElementById('roleModal')).hide();
                resetRoleForm();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to update role');
        });
        return;
    }

    // If creating new role
    fetch(API_ROLES_STORE, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            loadRoles();
            bootstrap.Modal.getInstance(document.getElementById('roleModal')).hide();
            resetRoleForm();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Failed to create role');
    });
}

// Reset role form
function resetRoleForm() {
    document.getElementById('roleModalTitle').textContent = 'Add Role';
    document.getElementById('roleName').value = '';
    document.getElementById('roleCode').value = '';
    document.querySelectorAll('.form-check-input').forEach(checkbox => {
        checkbox.checked = false;
    });

    const editingInput = document.getElementById('editingRoleId');
    if (editingInput) {
        editingInput.remove();
    }
}

// Edit role (populate modal)
function editRole(roleId) {
    const role = allRoles.find(r => r.id === roleId);
    if (!role) return;

    document.getElementById('roleModalTitle').textContent = 'Edit Role';
    document.getElementById('roleName').value = role.name;
    document.getElementById('roleCode').value = role.code;

    // Reset all permission checkboxes (permissions are not stored in database)
    Object.keys(PERMISSIONS).forEach(key => {
        const checkbox = document.getElementById('perm_' + key);
        if (checkbox) {
            checkbox.checked = false;
        }
    });

    // Add hidden input for editing
    let editingInput = document.getElementById('editingRoleId');
    if (editingInput) {
        editingInput.remove();
    }
    editingInput = Object.assign(document.createElement('input'), {
        type: 'hidden',
        id: 'editingRoleId',
        value: roleId
    });
    document.getElementById('roleName').parentElement.appendChild(editingInput);

    const modal = new bootstrap.Modal(document.getElementById('roleModal'));
    modal.show();
}

// Delete role
function deleteRole(roleId) {
    if (!confirm('Are you sure you want to delete this role?')) {
        return;
    }

    fetch(API_ROLES_DELETE.replace(':roleId', roleId), {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            loadRoles();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Failed to delete role');
    });
}

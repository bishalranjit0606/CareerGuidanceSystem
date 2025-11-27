<?php
// admin/manage_users.php
session_start();
require_once '../config/config.php'; // Include your database configuration file

// Check if user is logged in and is an administrator
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../admin_login.php'); // Redirect to admin login if not authorized
    exit();
}

$message = '';
$message_type = ''; // 'success' or 'error'

// Initialize edit user variable
$edit_user = null;

// Handle Edit User Fetch
if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
    $sql_fetch_edit = "SELECT * FROM users WHERE id = ?";
    if ($stmt = mysqli_prepare($conn, $sql_fetch_edit)) {
        mysqli_stmt_bind_param($stmt, "i", $edit_id);
        mysqli_stmt_execute($stmt);
        $result_edit = mysqli_stmt_get_result($stmt);
        if ($row = mysqli_fetch_assoc($result_edit)) {
            $edit_user = $row;
        }
        mysqli_stmt_close($stmt);
    }
}

// Handle Add User
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_user'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $role = $_POST['role'];

    if (empty($name) || empty($email) || empty($password) || empty($role)) {
        $message = "All fields are required.";
        $message_type = "error";
    } else {
        // Check if email already exists
        $sql_check = "SELECT id FROM users WHERE email = ?";
        if ($stmt = mysqli_prepare($conn, $sql_check)) {
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            if (mysqli_stmt_num_rows($stmt) > 0) {
                $message = "Email already exists.";
                $message_type = "error";
            } else {
                // Insert new user
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $sql_insert = "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)";
                if ($stmt_insert = mysqli_prepare($conn, $sql_insert)) {
                    mysqli_stmt_bind_param($stmt_insert, "ssss", $name, $email, $hashed_password, $role);
                    if (mysqli_stmt_execute($stmt_insert)) {
                        $message = "User added successfully!";
                        $message_type = "success";
                    } else {
                        $message = "Error adding user: " . mysqli_error($conn);
                        $message_type = "error";
                    }
                    mysqli_stmt_close($stmt_insert);
                }
            }
            mysqli_stmt_close($stmt);
        }
    }
}

// Handle Update User
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_user'])) {
    $user_id = $_POST['user_id'];
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $role = $_POST['role'];
    $password = $_POST['password']; // Optional

    if (empty($name) || empty($email) || empty($role)) {
        $message = "Name, Email, and Role are required.";
        $message_type = "error";
    } else {
        // Check if email exists for OTHER users
        $sql_check = "SELECT id FROM users WHERE email = ? AND id != ?";
        if ($stmt = mysqli_prepare($conn, $sql_check)) {
            mysqli_stmt_bind_param($stmt, "si", $email, $user_id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            if (mysqli_stmt_num_rows($stmt) > 0) {
                $message = "Email already exists for another user.";
                $message_type = "error";
            } else {
                // Update user
                if (!empty($password)) {
                    // Update with password
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    $sql_update = "UPDATE users SET name = ?, email = ?, role = ?, password = ? WHERE id = ?";
                    if ($stmt_update = mysqli_prepare($conn, $sql_update)) {
                        mysqli_stmt_bind_param($stmt_update, "ssssi", $name, $email, $role, $hashed_password, $user_id);
                        if (mysqli_stmt_execute($stmt_update)) {
                            $message = "User updated successfully!";
                            $message_type = "success";
                            $edit_user = null; // Clear edit mode
                        } else {
                            $message = "Error updating user: " . mysqli_error($conn);
                            $message_type = "error";
                        }
                        mysqli_stmt_close($stmt_update);
                    }
                } else {
                    // Update without password
                    $sql_update = "UPDATE users SET name = ?, email = ?, role = ? WHERE id = ?";
                    if ($stmt_update = mysqli_prepare($conn, $sql_update)) {
                        mysqli_stmt_bind_param($stmt_update, "sssi", $name, $email, $role, $user_id);
                        if (mysqli_stmt_execute($stmt_update)) {
                            $message = "User updated successfully!";
                            $message_type = "success";
                            $edit_user = null; // Clear edit mode
                        } else {
                            $message = "Error updating user: " . mysqli_error($conn);
                            $message_type = "error";
                        }
                        mysqli_stmt_close($stmt_update);
                    }
                }
            }
            mysqli_stmt_close($stmt);
        }
    }
}

// Handle user deletion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_user'])) {
    $user_id_to_delete = $_POST['user_id'];

    if (!empty($user_id_to_delete)) {
        // Prevent admin from deleting themselves
        if ($user_id_to_delete == $_SESSION['user_id']) {
            $message = "You cannot delete your own admin account.";
            $message_type = "error";
        } else {
            // Start a transaction: Disable autocommit
            mysqli_autocommit($conn, FALSE);
            $success = true;
            $error_detail = ''; // To store specific error messages

            // 1. Delete from user_skills table
            $sql_delete_user_skills = "DELETE FROM user_skills WHERE user_id = ?";
            if ($stmt = mysqli_prepare($conn, $sql_delete_user_skills)) {
                mysqli_stmt_bind_param($stmt, "i", $user_id_to_delete);
                if (!mysqli_stmt_execute($stmt)) {
                    $success = false;
                    $error_detail = "Failed to delete user skills: " . mysqli_stmt_error($stmt);
                }
                mysqli_stmt_close($stmt);
            } else {
                $success = false;
                $error_detail = "Failed to prepare user_skills delete statement: " . mysqli_error($conn);
            }

            // 2. Delete from user_answers table (only if previous step was successful)
            if ($success) {
                $sql_delete_user_answers = "DELETE FROM user_answers WHERE user_id = ?";
                if ($stmt = mysqli_prepare($conn, $sql_delete_user_answers)) {
                    mysqli_stmt_bind_param($stmt, "i", $user_id_to_delete);
                    if (!mysqli_stmt_execute($stmt)) {
                        $success = false;
                        $error_detail = "Failed to delete user answers: " . mysqli_stmt_error($stmt);
                    }
                    mysqli_stmt_close($stmt);
                } else {
                    $success = false;
                    $error_detail = "Failed to prepare user_answers delete statement: " . mysqli_error($conn);
                }
            }

            // 3. Delete from recommendations table (only if previous steps were successful)
            if ($success) {
                $sql_delete_recommendations = "DELETE FROM recommendations WHERE user_id = ?";
                if ($stmt = mysqli_prepare($conn, $sql_delete_recommendations)) {
                    mysqli_stmt_bind_param($stmt, "i", $user_id_to_delete);
                    if (!mysqli_stmt_execute($stmt)) {
                        $success = false;
                        $error_detail = "Failed to delete recommendations: " . mysqli_stmt_error($stmt);
                    }
                    mysqli_stmt_close($stmt);
                } else {
                    $success = false;
                    $error_detail = "Failed to prepare recommendations delete statement: " . mysqli_error($conn);
                }
            }

            // 4. Finally, delete from users table (only if all previous steps were successful)
            if ($success) {
                $sql_delete_user = "DELETE FROM users WHERE id = ?";
                if ($stmt = mysqli_prepare($conn, $sql_delete_user)) {
                    mysqli_stmt_bind_param($stmt, "i", $user_id_to_delete);
                    if (mysqli_stmt_execute($stmt)) {
                        mysqli_commit($conn); // Commit the transaction if all operations succeed
                        $message = "User and associated data deleted successfully!";
                        $message_type = "success";
                    } else {
                        mysqli_rollback($conn); // Rollback on user delete failure
                        $message = "Error deleting user: " . mysqli_stmt_error($stmt);
                        $message_type = "error";
                    }
                    mysqli_stmt_close($stmt);
                } else {
                    mysqli_rollback($conn); // Rollback if user delete statement fails to prepare
                    $message = "Error preparing user delete statement: " . mysqli_error($conn);
                    $message_type = "error";
                }
            } else {
                mysqli_rollback($conn); // Rollback if any of the related data deletion steps failed
                $message = "Error deleting user's associated data. User not deleted. Detail: " . $error_detail;
                $message_type = "error";
            }

            // Re-enable autocommit
            mysqli_autocommit($conn, TRUE);
        }
    } else {
        $message = "User ID not provided for deletion.";
        $message_type = "error";
    }
}

// Fetch all users for display
$users = [];
$sql_fetch_users = "SELECT id, name, email, role, created_at FROM users ORDER BY created_at DESC";
$result_users = mysqli_query($conn, $sql_fetch_users);
if ($result_users) {
    while ($row = mysqli_fetch_assoc($result_users)) {
        $users[] = $row;
    }
} else {
    $message = "Error fetching users: " . mysqli_error($conn);
    $message_type = "error";
}

mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users - Admin Panel</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .admin-container { max-width: 1000px; margin: 50px auto; padding: 30px; background-color: #fff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .admin-container h1 { color: #dc3545; margin-bottom: 20px; text-align: center; }
        .message { padding: 10px; margin-bottom: 20px; border-radius: 5px; text-align: center; }
        .message.success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .message.error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }

        .user-list-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .user-list-table th, .user-list-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        .user-list-table th {
            background-color: #f2f2f2;
            color: #555;
            font-weight: bold;
        }
        .user-list-table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .user-list-table .action-buttons {
            display: flex;
            gap: 5px;
            justify-content: center; /* Center buttons within cell */
        }
        .btn-delete {
            background-color: #dc3545;
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.9em;
            transition: background-color 0.3s ease;
        }
        .btn-delete:hover {
            background-color: #c82333;
        }
        .current-admin-row {
            background-color: #fff3cd !important; /* Highlight current admin */
            color: #856404;
        }
        .current-admin-row .btn-delete {
            opacity: 0.5;
            cursor: not-allowed;
        }
        
        /* Form Styles */
        .user-form {
            background-color: #f9f9f9;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 30px;
        }
        .user-form h2 {
            margin-top: 0;
            font-size: 1.2em;
            color: #333;
            margin-bottom: 15px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .btn-submit {
            background-color: #28a745;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1em;
        }
        .btn-submit:hover {
            background-color: #218838;
        }
        .btn-cancel {
            background-color: #6c757d;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1em;
            text-decoration: none;
            display: inline-block;
        }
        .btn-cancel:hover {
            background-color: #5a6268;
        }
        .btn-edit {
            background-color: #007bff;
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.9em;
            text-decoration: none;
            display: inline-block;
        }
        .btn-edit:hover {
            background-color: #0069d9;
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <h1>Manage Users</h1>

        <?php if ($message): ?>
            <div class="message <?php echo $message_type; ?>"><?php echo $message; ?></div>
        <?php endif; ?>

        <!-- Add/Edit User Form -->
        <div class="user-form">
            <h2><?php echo $edit_user ? 'Edit User' : 'Add New User'; ?></h2>
            <form action="manage_users.php" method="POST">
                <?php if ($edit_user): ?>
                    <input type="hidden" name="user_id" value="<?php echo $edit_user['id']; ?>">
                <?php endif; ?>
                
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" value="<?php echo $edit_user ? htmlspecialchars($edit_user['name']) : ''; ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo $edit_user ? htmlspecialchars($edit_user['email']) : ''; ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Password: <?php echo $edit_user ? '<small>(Leave blank to keep current)</small>' : ''; ?></label>
                    <input type="password" id="password" name="password" <?php echo $edit_user ? '' : 'required'; ?>>
                </div>
                
                <div class="form-group">
                    <label for="role">Role:</label>
                    <select id="role" name="role" required>
                        <option value="user" <?php echo ($edit_user && $edit_user['role'] == 'user') ? 'selected' : ''; ?>>User</option>
                        <option value="admin" <?php echo ($edit_user && $edit_user['role'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
                    </select>
                </div>
                
                <button type="submit" name="<?php echo $edit_user ? 'update_user' : 'add_user'; ?>" class="btn-submit">
                    <?php echo $edit_user ? 'Update User' : 'Add User'; ?>
                </button>
                
                <?php if ($edit_user): ?>
                    <a href="manage_users.php" class="btn-cancel">Cancel</a>
                <?php endif; ?>
            </form>
        </div>

        <?php if (!empty($users)): ?>
            <table class="user-list-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Registered On</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr <?php echo ($user['id'] == $_SESSION['user_id'] && $user['role'] == 'admin') ? 'class="current-admin-row"' : ''; ?>>
                            <td><?php echo htmlspecialchars($user['id']); ?></td>
                            <td><?php echo htmlspecialchars($user['name']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td><?php echo htmlspecialchars($user['role']); ?></td>
                            <td><?php echo htmlspecialchars(date('Y-m-d H:i', strtotime($user['created_at']))); ?></td>
                            <td>
                                <div class="action-buttons">
                                    <a href="manage_users.php?edit_id=<?php echo $user['id']; ?>" class="btn-edit">Edit</a>
                                    <?php if ($user['id'] != $_SESSION['user_id']): // Prevent admin from deleting themselves ?>
                                        <form action="manage_users.php" method="POST" onsubmit="return confirm('WARNING: Are you sure you want to delete user <?php echo htmlspecialchars(addslashes($user['name'])); ?>? This will delete ALL associated data (skills, answers, recommendations) and cannot be undone!');" style="display:inline;">
                                            <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                            <button type="submit" name="delete_user" class="btn-delete">Delete</button>
                                        </form>
                                    <?php else: ?>
                                        <button class="btn-delete" disabled title="You cannot delete your own account">Delete</button>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No users registered yet.</p>
        <?php endif; ?>

        <div class="back-link" style="text-align: center; margin-top: 30px;">
            <p><a href="dashboard.php" class="btn-action">Back to Admin Dashboard</a></p>
        </div>
    </div>
</body>
</html>
<?php
// admin/manage_users.php
session_start();
require_once '../config/config.php'; // Include your database configuration file

// Check if user is logged in and is an administrator
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit(); // Always exit after a header redirect
}

$message = '';
$message_type = ''; // 'success' or 'error'

// Handle user deletion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_user'])) {
    $user_id_to_delete = $_POST['user_id'];

    if (!empty($user_id_to_delete)) {
        // Prevent admin from deleting themselves
        if ($user_id_to_delete == $_SESSION['user_id']) {
            $message = "You cannot delete your own admin account.";
            $message_type = "error";
        } else {
            // Start a transaction: Disable autocommit
            // This ensures that if any delete operation fails, all previous ones are rolled back.
            mysqli_autocommit($conn, FALSE);
            $success = true;
            $error_detail = ''; // To store specific error messages

            // 1. Delete from user_skills table
            $sql_delete_user_skills = "DELETE FROM user_skills WHERE user_id = ?";
            if ($stmt = mysqli_prepare($conn, $sql_delete_user_skills)) {
                mysqli_stmt_bind_param($stmt, "i", $user_id_to_delete);
                if (!mysqli_stmt_execute($stmt)) {
                    $success = false;
                    $error_detail = "Failed to delete user skills: " . mysqli_stmt_error($stmt);
                }
                mysqli_stmt_close($stmt);
            } else {
                $success = false;
                $error_detail = "Failed to prepare user_skills delete statement: " . mysqli_error($conn);
            }

            // 2. Delete from user_answers table (only if previous step was successful)
            if ($success) {
                $sql_delete_user_answers = "DELETE FROM user_answers WHERE user_id = ?";
                if ($stmt = mysqli_prepare($conn, $sql_delete_user_answers)) {
                    mysqli_stmt_bind_param($stmt, "i", $user_id_to_delete);
                    if (!mysqli_stmt_execute($stmt)) {
                        $success = false;
                        $error_detail = "Failed to delete user answers: " . mysqli_stmt_error($stmt);
                    }
                    mysqli_stmt_close($stmt);
                } else {
                    $success = false;
                    $error_detail = "Failed to prepare user_answers delete statement: " . mysqli_error($conn);
                }
            }

            // 3. Delete from recommendations table (only if previous steps were successful)
            if ($success) {
                $sql_delete_recommendations = "DELETE FROM recommendations WHERE user_id = ?";
                if ($stmt = mysqli_prepare($conn, $sql_delete_recommendations)) {
                    mysqli_stmt_bind_param($stmt, "i", $user_id_to_delete);
                    if (!mysqli_stmt_execute($stmt)) {
                        $success = false;
                        $error_detail = "Failed to delete recommendations: " . mysqli_stmt_error($stmt);
                    }
                    mysqli_stmt_close($stmt);
                } else {
                    $success = false;
                    $error_detail = "Failed to prepare recommendations delete statement: " . mysqli_error($conn);
                }
            }

            // 4. Finally, delete from users table (only if all previous steps were successful)
            if ($success) {
                $sql_delete_user = "DELETE FROM users WHERE id = ?";
                if ($stmt = mysqli_prepare($conn, $sql_delete_user)) {
                    mysqli_stmt_bind_param($stmt, "i", $user_id_to_delete);
                    if (mysqli_stmt_execute($stmt)) {
                        mysqli_commit($conn); // Commit the transaction if all operations succeed
                        $message = "User and associated data deleted successfully!";
                        $message_type = "success";
                    } else {
                        mysqli_rollback($conn); // Rollback on user delete failure
                        $message = "Error deleting user: " . mysqli_stmt_error($stmt);
                        $message_type = "error";
                    }
                    mysqli_stmt_close($stmt);
                } else {
                    mysqli_rollback($conn); // Rollback if user delete statement fails to prepare
                    $message = "Error preparing user delete statement: " . mysqli_error($conn);
                    $message_type = "error";
                }
            } else {
                mysqli_rollback($conn); // Rollback if any of the related data deletion steps failed
                $message = "Error deleting user's associated data. User not deleted. Detail: " . $error_detail;
                $message_type = "error";
            }

            // Re-enable autocommit
            mysqli_autocommit($conn, TRUE);
        }
    } else {
        $message = "User ID not provided for deletion.";
        $message_type = "error";
    }
}

// Fetch all users for display
$users = [];
$sql_fetch_users = "SELECT id, name, email, role, created_at FROM users ORDER BY created_at DESC";
$result_users = mysqli_query($conn, $sql_fetch_users);
if ($result_users) {
    while ($row = mysqli_fetch_assoc($result_users)) {
        $users[] = $row;
    }
}

mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users - Admin Panel</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .admin-container { max-width: 1000px; margin: 50px auto; padding: 30px; background-color: #fff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .admin-container h1 { color: #dc3545; margin-bottom: 20px; text-align: center; }
        .message { padding: 10px; margin-bottom: 20px; border-radius: 5px; text-align: center; }
        .message.success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .message.error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }

        .user-list-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .user-list-table th, .user-list-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        .user-list-table th {
            background-color: #f2f2f2;
            color: #555;
            font-weight: bold;
        }
        .user-list-table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .user-list-table .action-buttons {
            display: flex;
            gap: 5px;
            justify-content: center; /* Center buttons within cell */
        }
        .btn-delete {
            background-color: #dc3545;
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.9em;
            transition: background-color 0.3s ease;
        }
        .btn-delete:hover {
            background-color: #c82333;
        }
        .current-admin-row {
            background-color: #fff3cd !important; /* Highlight current admin */
            color: #856404;
        }
        .current-admin-row .btn-delete {
            opacity: 0.5;
            cursor: not-allowed;
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <h1>Manage Users</h1>

        <?php if ($message): ?>
            <div class="message <?php echo $message_type; ?>"><?php echo $message; ?></div>
        <?php endif; ?>

        <?php if (!empty($users)): ?>
            <table class="user-list-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Registered On</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr <?php echo ($user['id'] == $_SESSION['user_id'] && $user['role'] == 'admin') ? 'class="current-admin-row"' : ''; ?>>
                            <td><?php echo htmlspecialchars($user['id']); ?></td>
                            <td><?php echo htmlspecialchars($user['name']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td><?php echo htmlspecialchars($user['role']); ?></td>
                            <td><?php echo htmlspecialchars(date('Y-m-d H:i', strtotime($user['created_at']))); ?></td>
                            <td>
                                <div class="action-buttons">
                                    <?php if ($user['id'] != $_SESSION['user_id']): // Prevent admin from deleting themselves ?>
                                        <form action="manage_users.php" method="POST" onsubmit="return confirm('WARNING: Are you sure you want to delete user <?php echo htmlspecialchars(addslashes($user['name'])); ?>? This will delete ALL associated data (skills, answers, recommendations) and cannot be undone!');">
                                            <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                            <button type="submit" name="delete_user" class="btn-delete">Delete</button>
                                        </form>
                                    <?php else: ?>
                                        <button class="btn-delete" disabled title="You cannot delete your own account">Delete</button>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No users registered yet.</p>
        <?php endif; ?>

        <div class="back-link" style="text-align: center; margin-top: 30px;">
            <p><a href="dashboard.php" class="btn-action">Back to Admin Dashboard</a></p>
        </div>
    </div>
</body>
</html>


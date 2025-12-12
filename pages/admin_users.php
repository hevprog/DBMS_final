<?php
session_start();
require_once __DIR__."/../config/database.php";
require_once __DIR__."/../admin/manage.php";
require_once __DIR__."/../includes/functions.php";
checkAdmin();

$manage = new manage();
$message = '';
$messageType = '';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_mode = $_POST['user_mode'] ?? '';
    
    switch($user_mode) {
        case 'INSERT':
            $username = sanitizeInput($_POST['username'] ?? '');
            $email = sanitizeInput($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $status = sanitizeInput($_POST['status'] ?? 'customer');
            
            if (empty($username) || empty($email) || empty($password)) {
                $message = "All fields are required for user creation.";
                $messageType = 'error';
            } elseif (strlen($password) < 8) {
                $message = "Password must be at least 8 characters.";
                $messageType = 'error';
            } elseif (!isValidEmail($email)) {
                $message = "Invalid email format.";
                $messageType = 'error';
            } else {
                $result = $manage->insert_user($username, $email, $password, $status);
                if ($result) {
                    $message = "User created successfully!";
                    $messageType = 'success';
                } else {
                    $message = "Failed to create user. Username or email may already exist.";
                    $messageType = 'error';
                }
            }
            break;
            
        case 'UPDATE':
            $user_id = (int)($_POST['user_id'] ?? 0);
            $status = sanitizeInput($_POST['status'] ?? '');
            
            if ($user_id <= 0 || empty($status)) {
                $message = "User ID and status are required.";
                $messageType = 'error';
            } else {
                $result = $manage->update_user_status($user_id, $status);
                if ($result) {
                    $message = "User status updated successfully!";
                    $messageType = 'success';
                } else {
                    $message = "Failed to update user status.";
                    $messageType = 'error';
                }
            }
            break;
            
        case 'DELETE':
            $user_id = (int)($_POST['user_id'] ?? 0);
            
            if ($user_id <= 0) {
                $message = "Valid User ID is required.";
                $messageType = 'error';
            } elseif ($user_id == $_SESSION['user_id']) {
                $message = "You cannot delete your own account!";
                $messageType = 'error';
            } else {
                $result = $manage->delete_user($user_id);
                if ($result) {
                    $message = "User deleted successfully!";
                    $messageType = 'success';
                } else {
                    $message = "Failed to delete user.";
                    $messageType = 'error';
                }
            }
            break;
            
        case 'SEARCH':
            $search_term = sanitizeInput($_POST['search_term'] ?? '');
            $search_type = $_POST['search_type'] ?? 'id';
            
            if (empty($search_term)) {
                $message = "Please enter a search term.";
                $messageType = 'error';
            } else {
                $isIdSearch = ($search_type === 'id');
                $getusers = $manage->selective_usersearch($search_term, $isIdSearch);
                if (empty($getusers)) {
                    $message = "No users found matching your search.";
                    $messageType = 'error';
                }
            }
            break;
    }
}

if (!isset($getusers)) {
    $getusers = $manage->get_all_users();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Users Management</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
        header img { width: 100%; max-height: 250px; object-fit: cover; border-radius: 10px; }
        .panel { border: 1px solid #ccc; padding: 15px; border-radius: 10px; margin-bottom: 25px; background: #fff; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .panel h3 { margin-top: 0; color: #333; border-bottom: 2px solid #ff0000ff; padding-bottom: 10px; }
        form { margin-bottom: 15px; }
        form label { font-weight: bold; display: block; margin-top: 8px; color: #555; }
        input[type="text"], input[type="email"], input[type="password"], input[type="number"] {
            width: 100%; padding: 8px; margin-top: 3px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box;
        }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; background: #fff; }
        table th, table td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        table th { background: #af0303ff; color: white; font-weight: bold; }
        table tr:nth-child(even) { background: #f9f9f9; }
        table tr:hover { background: #f0f0f0; }
        input[type="submit"], button { 
            padding: 8px 16px; cursor: pointer; margin-top: 10px; margin-right: 5px;
            border: none; border-radius: 4px; font-weight: bold; transition: background 0.3s;
        }
        button[type="submit"] { background: #a10606ff; color: white; }
        button[type="submit"]:hover { background: #aa07079c; }
        .btn-danger { background: #dc3545; color: white; }
        .btn-danger:hover { background: #c82333; }
        .btn-secondary { background: #6c757d; color: white; }
        .btn-secondary:hover { background: #5a6268; }
        .radio-group { display: flex; gap: 15px; flex-wrap: wrap; margin-top: 5px; }
        .radio-group label { display: inline; font-weight: normal; margin-left: 5px; }
        .message { padding: 12px; border-radius: 5px; margin-bottom: 15px; font-weight: bold; }
        .success-message { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .error-message { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        @media (max-width: 768px) { .grid-2 { grid-template-columns: 1fr; } }
        .action-buttons { display: flex; gap: 10px; margin-top: 10px; }
        .search-container { display: flex; gap: 10px; align-items: flex-end; flex-wrap: wrap; }
        .search-container > div { flex: 1; min-width: 200px; }
    </style>
</head>
<body>
<header>
    <img src="../assets/images/Admin Img.jpg" loading="lazy" alt="Admin Banner">
</header>

<div class="panel">
    <div class="action-buttons">
        <form method="post" action="../auth/logout.php" style="margin: 0;">
            <input type="hidden" name="log-out" value="1">
            <button type="submit" class="btn-secondary">Logout</button>
        </form>
        <form action="admin.php" style="margin: 0;">
            <button type="submit" class="btn-secondary">Back to Manage Page</button>
        </form>
    </div>
</div>

<?php if ($message): ?>
    <div class="panel">
        <div class="message <?= $messageType === 'success' ? 'success-message' : 'error-message' ?>">
            <?= htmlspecialchars($message) ?>
        </div>
    </div>
<?php endif; ?>

<div class="grid-2">
    <div class="panel">
        <h3>Create New User</h3>
        <form action="" method="post">
            <input type="hidden" name="user_mode" value="INSERT">
            
            <label for="new_username">Username:</label>
            <input type="text" id="new_username" name="username" required>
            
            <label for="new_email">Email:</label>
            <input type="email" id="new_email" name="email" required>
            
            <label for="new_password">Password:</label>
            <input type="password" id="new_password" name="password" required minlength="8">
            
            <label>User Status:</label>
            <div class="radio-group">
                <input type="radio" name="status" value="customer" id="new_customer" checked>
                <label for="new_customer">Customer</label>
                <input type="radio" name="status" value="admin" id="new_admin">
                <label for="new_admin">Admin</label>
            </div>
            
            <button type="submit">Create User</button>
        </form>
    </div>

    <div class="panel">
        <h3>Update User Status</h3>
        <form action="" method="post">
            <input type="hidden" name="user_mode" value="UPDATE">
            
            <label for="update_user_id">User ID:</label>
            <input type="number" id="update_user_id" name="user_id" required min="1">
            
            <label>New Status:</label>
            <div class="radio-group">
                <input type="radio" name="status" value="customer" id="update_customer" required>
                <label for="update_customer">Customer</label>
                <input type="radio" name="status" value="admin" id="update_admin">
                <label for="update_admin">Admin</label>
            </div>
            
            <button type="submit">Update Status</button>
        </form>
    </div>
</div>

<div class="panel">
    <h3>Delete User</h3>
    <form action="" method="post" onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.');">
        <input type="hidden" name="user_mode" value="DELETE">
        
        <label for="delete_user_id">User ID to Delete:</label>
        <input type="number" id="delete_user_id" name="user_id" required min="1">
        
        <button type="submit" class="btn-danger">Delete User</button>
    </form>
    <p style="color: #dc3545; font-weight: bold;">Warning: Deleting a user is permanent and cannot be undone!</p>
</div>

<div class="panel">
    <h3>Search Users</h3>
    <form action="" method="post">
        <input type="hidden" name="user_mode" value="SEARCH">
        <div class="search-container">
            <div>
                <label for="search_term">Search Term:</label>
                <input type="text" id="search_term" name="search_term" required>
            </div>
            <div>
                <label>Search By:</label>
                <div class="radio-group">
                    <input type="radio" name="search_type" value="id" id="search_id" checked>
                    <label for="search_id">User ID</label>
                    <input type="radio" name="search_type" value="username" id="search_username">
                    <label for="search_username">Username</label>
                </div>
            </div>
            <div>
                <button type="submit">Search</button>
            </div>
        </div>
    </form>
    <?php if (isset($_POST['user_mode']) && $_POST['user_mode'] === 'SEARCH'): ?>
        <form action="" method="get" style="margin-top: 10px;">
            <button type="submit" class="btn-secondary">Show All Users</button>
        </form>
    <?php endif; ?>
</div>

<div class="panel">
    <h3>All Users (<?= count($getusers) ?> total)</h3>
    <table>
        <thead>
            <tr>
                <th>User ID</th>
                <th>Username</th>
                <th>Status</th>
                <th>Password Hash</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($getusers)): ?>
                <tr>
                    <td colspan="4" style="text-align: center; color: #999;">No users found</td>
                </tr>
            <?php else: ?>
                <?php foreach($getusers as $user): ?>
                    <tr>
                        <td><?= htmlspecialchars($user["user_id"]) ?></td>
                        <td><?= htmlspecialchars($user["username"]) ?></td>
                        <td>
                            <span style="background: <?= $user['status'] === 'admin' ? '#d4edda' : '#e7f3ff' ?>; padding: 3px 8px; border-radius: 3px; font-weight: bold;">
                                <?= htmlspecialchars($user["status"]) ?>
                            </span>
                        </td>
                        <td style="font-family: monospace; font-size: 0.9em; word-break: break-all;"><?= htmlspecialchars($user["password_hash"]) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>
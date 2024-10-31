<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

include 'db.php';

if (isset($_GET['delete'])) {
    // Validate and sanitize the ID
    $id = intval($_GET['delete']);
    
    // Prepare SQL statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT file_path, image_path FROM apks WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $apk = $stmt->get_result()->fetch_assoc();

    if ($apk) {
        // Delete the APK file and image file from the filesystem if they exist
        if (file_exists($apk['file_path'])) {
            unlink($apk['file_path']);
        }
        if (file_exists($apk['image_path'])) {
            unlink($apk['image_path']);
        }
        
        // Delete the record from the database
        $stmt = $conn->prepare("DELETE FROM apks WHERE id = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $success = "APK and associated image deleted successfully";
        } else {
            $error = "Error: " . $conn->error;
        }
    }
}

$apks = $conn->query("SELECT * FROM apks");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage APKs</title>
    <!-- AdminLTE CSS -->
    <link href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.1/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f2f5;
        }
        .main-sidebar {
            background-color: #343a40;
            min-height: 100vh;
        }
        .sidebar .nav-link {
            color: #adb5bd;
        }
        .sidebar .nav-link:hover {
            color: #ffffff;
            background-color: #495057;
        }
        .content-wrapper {
            padding: 20px;
        }
        .card {
            border-radius: 0.5rem;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card-header {
            background: #007bff;
            color: #ffffff;
        }
        .card-body {
            padding: 20px;
        }
        .btn-primary {
            border-radius: 0.5rem;
        }
        .img-thumbnail {
            max-width: 100px; /* Adjust this size as needed */
            max-height: 100px; /* Adjust this size as needed */
            object-fit: cover;
        }
    </style>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    
    <?php include 'sidebar.php'; ?>

    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <h1 class="">Manage APKs</h1>
                <?php if (isset($success)): ?>
                    <div class="alert alert-success" role="alert"><?php echo $success; ?></div>
                <?php endif; ?>
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger" role="alert"><?php echo $error; ?></div>
                <?php endif; ?>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">APK List</h3>
                    </div>
                    <div class="card-body">
                        <table id="apkTable" class="display">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>File Path</th>
                                    <th>Image</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($apk = $apks->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo $apk['id']; ?></td>
                                        <td><?php echo $apk['name']; ?></td>
                                        <td><?php echo $apk['file_path']; ?></td>
                                        <td>
                                            <?php if (!empty($apk['image_path']) && file_exists($apk['image_path'])): ?>
                                                <img src="<?php echo $apk['image_path']; ?>" alt="Image" class="img-thumbnail">
                                            <?php else: ?>
                                                <span>No image</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="?delete=<?php echo $apk['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap JS Bundle with Popper -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.1/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE JS -->
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

<!-- Custom JavaScript for DataTables -->
<script>
$(document).ready(function() {
    $('#apkTable').DataTable();
});
</script>
</body>
</html>

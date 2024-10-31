<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}
include 'db.php';

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    // Prepare and execute SQL query to fetch image path
    $stmt = $conn->prepare("SELECT image_path FROM blogs WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $blog = $result->fetch_assoc();
    if ($blog) {
        // Delete the image file if it exists
        if (file_exists($blog['image_path'])) {
            unlink($blog['image_path']);
        }
        // Delete the blog entry from the database
        $stmt = $conn->prepare("DELETE FROM blogs WHERE id = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $success = "Blog deleted successfully";
        } else {
            $error = "Error: " . $conn->error;
        }
    }
}

$blogs = $conn->query("SELECT * FROM blogs");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Blogs</title>
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
                <h1 class="mt-4 mb-3">Manage Blogs</h1>
                <?php if (isset($success)): ?>
                    <div class="alert alert-success"><?php echo $success; ?></div>
                <?php endif; ?>
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Blogs List</h3>
                    </div>
                    <div class="card-body">
                        <table id="blogsTable" class="display">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Image</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($blog = $blogs->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo $blog['id']; ?></td>
                                        <td><?php echo $blog['title']; ?></td>
                                        <td>
                                            <?php if (!empty($blog['image']) && file_exists($blog['image'])): ?>
                                                <img src="<?php echo $blog['image']; ?>" alt="Image" class="img-thumbnail">
                                            <?php else: ?>
                                                <span>No image</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="edit_blog.php?id=<?php echo $blog['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                            <a href="?delete=<?php echo $blog['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
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

<!-- DataTables Initialization -->
<script>
    $(document).ready(function() {
        $('#blogsTable').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false
        });
    });
</script>
</body>
</html>

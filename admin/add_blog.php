<?php



session_start();

// Check if the user is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

// Include database connection
include 'db.php';

// Initialize variables for messages
$success = '';
$error = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $image = $_FILES['image'];

    // Basic validation
    if (empty($title) || empty($content)) {
        $error = "Title and content are required.";
    } else {
       // Assuming $conn is your mysqli connection and $image is the uploaded file array
        if ($image['error'] === UPLOAD_ERR_OK) {
            $upload_dir = 'uploads/blogimg/';
            $image_path = $upload_dir . basename($image['name']);
            if (move_uploaded_file($image['tmp_name'], $image_path)) {
                // Prepare the SQL statement
                $stmt = $conn->prepare("INSERT INTO blogs (title, content, image) VALUES (?, ?, ?)");
                
                // Check if prepare succeeded
                if ($stmt === false) {
                    $error = "Failed to prepare the SQL statement: " . $conn->error;
                } else {
                    // Bind parameters
                    $stmt->bind_param('sss', $title, $content, $image_path);
                    
                    // Execute the statement
                    if ($stmt->execute()) {
                        $success = "Blog added successfully!";
                    } else {
                        $error = "Failed to add blog. Please try again. Error: " . $stmt->error;
                    }
                    $stmt->close();
                }
            } else {
                $error = "Failed to upload image. Please try again.";
            }
        } else {
            $error = "No image uploaded or upload error. Error code: " . $image['error'];
        }
    }
}

// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Blog</title>
    <!-- AdminLTE CSS -->
    <link href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.1/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- TinyMCE -->
    <script src="https://cdn.jsdelivr.net/npm/tinymce@6/tinymce.min.js"></script>
    <!-- Custom CSS -->
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
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .form-control {
            border-radius: 0.5rem;
        }
        .btn-primary {
            border-radius: 0.5rem;
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
                <h1 class="mt-4 mb-3">Add New Blog</h1>
                <div class="row">
                    <div class="col-lg-12 col-12 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Add New Blog</h3>
                            </div>
                                <?php if (!empty($success)): ?>
                                    <div class="alert alert-success"><?php echo $success; ?></div>
                                <?php endif; ?>
                                <?php if (!empty($error)): ?>
                                    <div class="alert alert-danger"><?php echo $error; ?></div>
                                <?php endif; ?>
                            <div class="card-body">
                                <form id="blogForm" method="post" enctype="multipart/form-data">
                                    <div class="mb-3">
                                        <label for="title" class="form-label">Blog Title</label>
                                        <input type="text" class="form-control" id="title" name="title" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="content" class="form-label">Blog Content</label>
                                        <textarea id="content" name="content" class="form-control" rows="10" required></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="image" class="form-label">Blog Image</label>
                                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Add Blog</button>
                                </form>
                            </div>
                        </div>
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

<!-- TinyMCE Initialization -->
<script>
    tinymce.init({
        selector: '#content',
        plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table paste help wordcount',
        toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
        height: 400,
        setup: function (editor) {
            editor.on('change', function () {
                editor.save(); // Update the <textarea> with the content of the editor
            });
        }
    });
</script>
</body>
</html>

<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}
include 'db.php';

$success = '';
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = intval($_POST['id']);
    $title = $conn->real_escape_string($_POST['title']);
    $content = $conn->real_escape_string($_POST['content']);
    $image = $_FILES['image'];

    // Default image path
    $imagePath = $_POST['existing_image'];

    if ($image['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/blogimg/';
        $imagePath = $upload_dir . basename($image['name']);
        
        if (move_uploaded_file($image['tmp_name'], $imagePath)) {
            // Delete old image if a new one is uploaded
            if ($_POST['existing_image'] && file_exists($_POST['existing_image'])) {
                unlink($_POST['existing_image']);
            }
        } else {
            $error = "Failed to upload image. Please try again.";
        }
    }

    if (empty($error)) {
        $sql = "UPDATE blogs SET title='$title', content='$content', image='$imagePath' WHERE id=$id";

        if ($conn->query($sql) === TRUE) {
            $success = "Blog updated successfully";
        } else {
            $error = "Error: " . $conn->error;
        }
    }
}

$id = intval($_GET['id']);
$result = $conn->query("SELECT * FROM blogs WHERE id=$id");
$blog = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Blog</title>
    <!-- AdminLTE CSS -->
    <link href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.1/css/bootstrap.min.css" rel="stylesheet">
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
            padding: 20px;
        }
        .form-control {
            border-radius: 0.5rem;
        }
        .btn-primary {
            border-radius: 0.5rem;
        }
        .img-preview {
            max-width: 200px;
            margin-top: 10px;
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
                <h1 class="mt-4 mb-3">Edit Blog</h1>
                <?php if (!empty($success)): ?>
                    <div class="alert alert-success"><?php echo $success; ?></div>
                <?php endif; ?>
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Edit Blog</h3>
                    </div>
                    <div class="card-body">
                        <form method="post" action="" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?php echo $blog['id']; ?>">
                            <input type="hidden" name="existing_image" value="<?php echo $blog['image']; ?>">
                            <div class="mb-3">
                                <label for="title" class="form-label">Title:</label>
                                <input type="text" id="title" name="title" class="form-control" value="<?php echo $blog['title']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="content" class="form-label">Content:</label>
                                <textarea id="content" name="content" class="form-control" rows="10" required><?php echo htmlspecialchars($blog['content']); ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="image" class="form-label">Upload New Image (optional):</label>
                                <input type="file" id="image" name="image" class="form-control" accept="image/*">
                                <?php if (!empty($blog['image'])): ?>
                                    <img src="<?php echo $blog['image']; ?>" alt="Current Image" class="img-preview">
                                <?php endif; ?>
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
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

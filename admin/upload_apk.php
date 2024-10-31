<?php

session_start();

// Check if the user is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

// Include database connection
include 'db.php';

$success = '';
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $description = $conn->real_escape_string($_POST['description']);
    $apkFile = $_FILES['apk_file'];
    $imageFile = $_FILES['image_file'];

    // Function to generate a unique file name
    function generateUniqueFileName($fileName) {
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $uniqueName = uniqid() . '.' . $fileExtension;
        return $uniqueName;
    }

    // Handling APK file
    $apkTargetDir = "uploads/apk/";
    $apkFileName = generateUniqueFileName($apkFile["name"]);
    $apkTargetFile = $apkTargetDir . $apkFileName;
    $uploadOk = 1;
    $apkFileType = strtolower(pathinfo($apkTargetFile, PATHINFO_EXTENSION));

    if ($apkFileType != "apk") {
        $error .= "<div class='alert alert-danger' role='alert'>Sorry, only APK files are allowed.</div>";
        $uploadOk = 0;
    }

    if (file_exists($apkTargetFile)) {
        $error .= "<div class='alert alert-danger' role='alert'>Sorry, file already exists.</div>";
        $uploadOk = 0;
    }

    if ($apkFile["size"] > 50000000) {
        $error .= "<div class='alert alert-danger' role='alert'>Sorry, your APK file is too large.</div>";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        $error .= "<div class='alert alert-danger' role='alert'>Sorry, your APK file was not uploaded.</div>";
    } else {
        if (move_uploaded_file($apkFile["tmp_name"], $apkTargetFile)) {
            // Handling Image file
            $imageTargetDir = "uploads/apkimg/";
            $imageFileName = generateUniqueFileName($imageFile["name"]);
            $imageTargetFile = $imageTargetDir . $imageFileName;
            $imageUploadOk = 1;
            $imageFileType = strtolower(pathinfo($imageTargetFile, PATHINFO_EXTENSION));

            if (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
                $error .= "<div class='alert alert-danger' role='alert'>Sorry, only image files are allowed.</div>";
                $imageUploadOk = 0;
            }

            if ($imageFile["size"] > 5000000) {
                $error .= "<div class='alert alert-danger' role='alert'>Sorry, your image file is too large.</div>";
                $imageUploadOk = 0;
            }

            if ($imageUploadOk == 0) {
                $error .= "<div class='alert alert-danger' role='alert'>Sorry, your image file was not uploaded.</div>";
            } else {
                if (move_uploaded_file($imageFile["tmp_name"], $imageTargetFile)) {
                    $sql = "INSERT INTO apks (name, description, file_path, image_path) VALUES ('$name', '$description', '$apkTargetFile', '$imageTargetFile')";

                    if ($conn->query($sql) === TRUE) {
                        $success = "The file " . htmlspecialchars($apkFileName) . " and image " . htmlspecialchars($imageFileName) . " have been uploaded.";
                    } else {
                        $error .= "<div class='alert alert-danger' role='alert'>Error: " . $conn->error . "</div>";
                    }
                } else {
                    $error .= "<div class='alert alert-danger' role='alert'>Sorry, there was an error uploading your image file.</div>";
                }
            }
        } else {
            $error .= "<div class='alert alert-danger' role='alert'>Sorry, there was an error uploading your APK file.</div>";
        }
    }

    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload APK and Image</title>
    <!-- AdminLTE CSS -->
    <link href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.1/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f2f5;
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
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <h1 class="mt-4">Upload APK and Image</h1>
                <?php if (!empty($success)): ?>
                    <div class="alert alert-success"><?php echo $success; ?></div>
                <?php endif; ?>
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Upload APK and Image</h3>
                    </div>
                    <div class="card-body">
                        <form method="post" action="" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name:</label>
                                <input type="text" id="name" name="name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="apk_file" class="form-label">Select APK file:</label>
                                <input type="file" id="apk_file" name="apk_file" class="form-control" accept=".apk" required>
                            </div>
                            <div class="mb-3">
                                <label for="image_file" class="form-label">Select Image file (optional):</label>
                                <input type="file" id="image_file" name="image_file" class="form-control" accept=".jpg, .jpeg, .png, .gif">
                                <img id="image_preview" class="img-preview" style="display: none;" />
                            </div>
                             <div class="mb-3">
                                <label for="description" class="form-label">Short Description:</label>
                                <textarea id="description" name="description" class="form-control" rows="3" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Upload</button>
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
<!-- Custom JavaScript for Image Preview -->
<script>
document.getElementById('image_file').addEventListener('change', function(event) {
    var input = event.target;
    var file = input.files[0];
    var preview = document.getElementById('image_preview');
    var reader = new FileReader();
    
    if (file) {
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    } else {
        preview.style.display = 'none';
    }
});
</script>
</body>
</html>

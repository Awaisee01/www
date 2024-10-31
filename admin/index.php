<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

include 'db.php';

// Fetch total number of blogs and APK files
$blogs_result = $conn->query("SELECT COUNT(*) as total_blogs FROM blogs");
$blogs_count = $blogs_result->fetch_assoc()['total_blogs'];

$apks_result = $conn->query("SELECT COUNT(*) as total_apks FROM apks");
$apks_count = $apks_result->fetch_assoc()['total_apks'];

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- AdminLTE CSS -->
    <link href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f2f5;
        }
        .sidebar {
            background-color: #343a40;
        }
        .sidebar a {
            color: #adb5bd;
        }
        .sidebar a:hover {
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
        .card:hover {
            transform: scale(1.02);
            box-shadow: 0 8px 12px rgba(0,0,0,0.2);
        }
        .card-header {
            background: #007bff;
            color: #ffffff;
            font-size: 1.2rem;
        }
        .card-body {
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
        }
        .icon {
            font-size: 3rem;
            color: #007bff;
            margin-right: 20px;
        }
        .counter {
            font-weight: bold;
        }
        .chart-container {
            position: relative;
            height: 400px;
            width: 100%;
        }
        .animated-bg {
            animation: backgroundAnimation 2s infinite;
        }
        @keyframes backgroundAnimation {
            0% { background-color: #e9ecef; }
            50% { background-color: #f8f9fa; }
            100% { background-color: #e9ecef; }
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
                <h1 class="mt-4 mb-3">Dashboard</h1>
                <div class="row">
                    <!-- Total Blogs Card -->
                    <div class="col-lg-4 col-12 mb-4">
                        <div class="card animated-bg">
                            <div class="card-header">
                                <h3 class="card-title">Total Blogs</h3>
                            </div>
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <i class="fas fa-blog icon"></i>
                                <div class="counter"><?php echo $blogs_count; ?></div>
                            </div>
                        </div>
                    </div>

                    <!-- Total APKs Card -->
                    <div class="col-lg-4 col-12 mb-4">
                        <div class="card animated-bg">
                            <div class="card-header">
                                <h3 class="card-title">Total APKs</h3>
                            </div>
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <i class="fas fa-android icon"></i>
                                <div class="counter"><?php echo $apks_count; ?></div>
                            </div>
                        </div>
                    </div>

                    <!-- Analytics Chart -->
                    <div class="col-lg-12 col-12 mb-4">
                        <div class="card animated-bg">
                            <div class="card-header">
                                <h3 class="card-title">Analytics Overview</h3>
                            </div>
                            <div class="card-body">
                                <div class="chart-container">
                                    <canvas id="analyticsChart"></canvas>
                                </div>
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
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE JS -->
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- Custom Script for Chart -->
<script>
    const ctx = document.getElementById('analyticsChart').getContext('2d');
    const analyticsChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Blogs', 'APKs'],
            datasets: [{
                label: 'Total',
                data: [<?php echo $blogs_count; ?>, <?php echo $apks_count; ?>],
                backgroundColor: ['#007bff', '#28a745'],
                borderColor: ['#0056b3', '#218838'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed.y !== null) {
                                label += context.parsed.y;
                            }
                            return label;
                        }
                    }
                }
            }
        }
    });
</script>

</body>
</html>

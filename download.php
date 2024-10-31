<?php



// Include the database connection file
include 'admin/db.php';

// Pagination settings
$limit = 12; // Number of apks per page
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$start = ($page - 1) * $limit;

// Fetch apk data with pagination
$sql = "SELECT * FROM apks ORDER BY id DESC LIMIT $start, $limit";
$result = $conn->query($sql);

// Count total number of apks for pagination
$total_result = $conn->query("SELECT COUNT(*) AS count FROM apks");
$total_apks = $total_result->fetch_assoc()['count'];
$total_pages = ceil($total_apks / $limit);

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>InstagramPro.su  Download all Instaram Apk Versions</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/icon.png" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500&family=Jost:wght@500;600;700&display=swap" rel="stylesheet"> 

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body data-bs-spy="scroll" data-bs-target=".navbar" data-bs-offset="51">
    <div class="container-xxl bg-white p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-grow text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Navbar & Hero Start -->
        <div class="container-xxl position-relative p-0" id="home">
            <nav class="navbar navbar-expand-lg navbar-light px-4 px-lg-5 py-3 py-lg-0">
                <a href="" class="navbar-brand p-0">
                    <a href="index.php"><h1 class="m-0">InstagramPro.su</h1></a>
                   <!--<img src="img/mlogo.png" alt="Logo"> -->
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav mx-auto py-0">
                       
                        <a href="download.php" class="nav-item nav-link">Download</a>
                        <a href="blog.php" class="nav-item nav-link">Blog</a>
                        
                    </div>
                    <a href="" class="btn btn-primary-gradient rounded-pill py-2 px-4 ms-3 d-none d-lg-block">Start Free Trial</a>
                </div>
            </nav>

            <div class="container-xxl bg-primary hero-header">
                <div class="container px-lg-5">
                    <div class="row g-5">
                        <div class="col-lg-8 text-center text-lg-start">
                            <h1 class="text-white mb-4 animated slideInDown">InstagramPro.su APK - Download All Instagram Versions for Free

                            </h1>
                            <p class="text-white pb-3 animated slideInDown">Welcome to InstagramPro.su, your go-to destination for downloading all versions of the Instagram app for free. </p>
                            
                        </div>
                        <div class="col-lg-4 d-flex justify-content-center justify-content-lg-end wow fadeInUp" data-wow-delay="0.3s">
                            <div class="owl-carousel screenshot-carousel">
                                <img class="img-fluid" src="img/ok.png" alt="">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Navbar & Hero End -->


        
        <!--apps -->
        <div id="main-container">
            <h1 class="page-heading">Download All Instagram Versions</h1>
            <div class="app-grid">
                
              <?php while ($apk = $result->fetch_assoc()): ?>
                    <div class="app-card">
                        <?php
                            // Default image file path
                            $imgfile = "img/image12.png";
                            // Check if the 'image_path' is not empty and update the image file path
                            if (!empty($apk['image_path'])) {
                                $imgfile = "admin/" . $apk['image_path'];
                            }
                        ?>
                        <!-- Display image -->
                        <img src="<?php echo htmlspecialchars($imgfile); ?>" alt="APK Image" class="app-image">
                        <!-- Display title (using 'name' as title) -->
                        <h3 class="app-title"><?php echo htmlspecialchars($apk['name']); ?></h3>
                        <!-- Display description (truncate to 100 characters if needed) -->
                        <p class="app-description"><?php echo htmlspecialchars(substr($apk['description'], 0, 100)) . (strlen($apk['description']) > 100 ? '...' : '...'); ?></p>
                        <!-- Download link -->
                        <a href="admin/<?php echo htmlspecialchars($apk['file_path']); ?>" class="download-button">Download</a>
                    </div>
                <?php endwhile; ?>

                
                <!--<div class="app-card">-->
                <!--    <img src="img/image12.png" alt="Instagram Version 2.0" class="app-image">-->
                <!--    <h2 class="app-title">Instagram Version 2.0</h2>-->
                <!--    <p class="app-description">Experience the improved version with added filters and enhanced performance.</p>-->
                <!--    <a href="download.html" class="download-button">Download</a>-->
                <!--</div>-->
                <!--<div class="app-card">-->
                <!--    <img src="img/image12.png" alt="Instagram Version 3.0" class="app-image">-->
                <!--    <h2 class="app-title">Instagram Version 3.0</h2>-->
                <!--    <p class="app-description">Access features like Stories and direct messaging with this version.</p>-->
                <!--    <a href="download.html" class="download-button">Download</a>-->
                <!--</div>-->
                <!--<div class="app-card">-->
                <!--    <img src="img/image12.png" alt="Instagram Version 4.0" class="app-image">-->
                <!--    <h2 class="app-title">Instagram Version 4.0</h2>-->
                <!--    <p class="app-description">Get the latest updates and improvements, including new privacy settings and more.</p>-->
                <!--    <a href="download.html" class="download-button">Download</a>-->
                <!--</div>-->
                <!--<div class="app-card">-->
                <!--    <img src="img/image12.png" alt="Instagram Version 5.0" class="app-image">-->
                <!--    <h2 class="app-title">Instagram Version 5.0</h2>-->
                <!--    <p class="app-description">Explore new features and enhancements with Instagram Version 5.0.</p>-->
                <!--    <a href="download.html" class="download-button">Download</a>-->
                <!--</div>-->
                <!--<div class="app-card">-->
                <!--    <img src="img/image12.png" alt="Instagram Version 6.0" class="app-image">-->
                <!--    <h2 class="app-title">Instagram Version 6.0</h2>-->
                <!--    <p class="app-description">Experience improved performance and additional features with Version 6.0.</p>-->
                <!--    <a href="download.html" class="download-button">Download</a>-->
                <!--</div>-->
                <!--<div class="app-card">-->
                <!--    <img src="img/image12.png" alt="Instagram Version 7.0" class="app-image">-->
                <!--    <h2 class="app-title">Instagram Version 7.0</h2>-->
                <!--    <p class="app-description">Enjoy the latest updates and user experience improvements with Version 7.0.</p>-->
                <!--    <a href="download.html" class="download-button">Download</a>-->
                <!--</div>-->
                <!--<div class="app-card">-->
                <!--    <img src="img/image12.png"alt="Instagram Version 8.0" class="app-image">-->
                <!--    <h2 class="app-title">Instagram Version 8.0</h2>-->
                <!--    <p class="app-description">Get access to new features and enhancements in Instagram Version 8.0.</p>-->
                <!--    <a href="download.html" class="download-button">Download</a>-->
                <!--</div>-->
               
                <!--<div class="app-card">-->
                <!--    <img src="img/image12.png" alt="Instagram Version 10.0" class="app-image">-->
                <!--    <h2 class="app-title">Instagram Version 10.0</h2>-->
                <!--    <p class="app-description">Discover the latest updates and enhancements with Version 10.0.</p>-->
                <!--    <a href="download.html" class="download-button">Download</a>-->
                <!--</div>-->
            </div>
        </div>
        

        
        <div class="container py-5">
            

            <!-- Pagination -->
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    <?php if ($page > 1): ?>
                        <li class="page-item"><a class="page-link" href="blog.php?page=<?php echo $page - 1; ?>">Previous</a></li>
                    <?php endif; ?>
                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>"><a class="page-link" href="blog.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                    <?php endfor; ?>
                    <?php if ($page < $total_pages): ?>
                        <li class="page-item"><a class="page-link" href="blog.php?page=<?php echo $page + 1; ?>">Next</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>


         <!-- Footer Start -->
         <div class="container-fluid bg-primary text-light footer wow fadeIn" data-wow-delay="0.1s">
            <div class="container py-5 px-lg-5">
                <div class="row g-5">
                    <div class="col-md-6 col-lg-3">
                        <h4 class="text-white mb-4">Address</h4>
                        <p><i class="fa fa-map-marker-alt me-3"></i>123 Street, New York, USA</p>
                        <p><i class="fa fa-phone-alt me-3"></i>+012 345 67890</p>
                        <p><i class="fa fa-envelope me-3"></i>info@instagrampro.su</p>
                        
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <h4 class="text-white mb-4">Quick Link</h4>
                        <a class="btn btn-link" href="">About Us</a>
                        <a class="btn btn-link" href="">Contact Us</a>
                        <a class="btn btn-link" href="">Privacy Policy</a>
                        <a class="btn btn-link" href="">Terms & Condition</a>
                    </div>
                    
                    <div class="col-md-6 col-lg-3">
                        <h4 class="text-white mb-4">Newsletter</h4>
                        <p>Stay updated with the latest news and exclusive offers from InstagramPro.su! 

                        </p>                        <div class="position-relative w-100 mt-3">
                            <input class="form-control border-0 rounded-pill w-100 ps-4 pe-5" type="text" placeholder="Your Email" style="height: 48px;">
                            <button type="button" class="btn shadow-none position-absolute top-0 end-0 mt-1 me-2"><i class="fa fa-paper-plane text-primary-gradient fs-4"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container px-lg-5">
                <div class="copyright">
                    <div class="row">
                        <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                            &copy; <a class="border-bottom" href="#">InstagramPro</a>, All Right Reserved. 
							
							<!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
							Designed By <a class="border-bottom" href="https://muhammadsaad.site/">Muhammad Saad</a>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-lg-square back-to-top pt-2"><i class="bi bi-arrow-up text-white"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>
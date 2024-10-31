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
    
    
   <script src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
    <script>
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'en',
                layout: google.translate.TranslateElement.InlineLayout.SIMPLE
            }, 'google_translate_element');
        }
    </script>
    <style>
         /* Custom styles for Google Translate dropdown */
        #google_translate_element {
            margin: 10px 0;
            padding: 5px;
            background-color: #ffffff; /* Match your background color */
            border: 1px solid #ddd;    /* Border to fit your design */
            border-radius: 4px;        /* Rounded corners */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Subtle shadow */
            display: inline-block;     /* Inline-block for better alignment */
        }

        body .goog-te-combo {
            font-family: Arial, sans-serif;
            font-size: 14px;
            border: 1px solid #ccc;    /* Border color */
            border-radius: 4px;       /* Rounded corners */
            padding: 5px;
            background-color: #f9f9f9; /* Background color */
            color: #333;              /* Text color */
            outline: none;
            width: 100%;              /* Full width */
        }

        /* Hide the default Google branding */
        body .goog-logo-link {
            display: none !important;
        }

        body .goog-te-banner-frame {
            display: none !important;
        }

        body .goog-te-gadget {
            margin: 0;
            padding: 0;
        }

        /* Ensure the dropdown has proper height and overflow */
        body .goog-te-combo {
            max-height: 200px;       /* Adjust height as needed */
            overflow-y: auto;        /* Scroll if content overflows */
        }
        
       
        body iframe.skiptranslate:nth-child(1),
        body .goog-te-gadget img{
            display: none !important;
            opacity: 0 !important;
            visibility: hidden !important;
        }
          #google_translate_element {
                margin: 0px 0;
                padding: 0px;
                background-color: #ffffff00;
                border: 1px solid #dddddd00;
                border-radius: 4px;
                box-shadow: 0 2px 4px rgb(0 0 0 / 7%);
                display: inline-block;
            }
        
        
        body{
            top : 0 !important;
        }

        
    </style>
    
    
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
                <a href="index.php" class="navbar-brand p-0">
                    <h1 class="m-0">InstagramPro.su</h1>
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
                    <div class="btn btn-primary-gradient rounded-pill py-2 px-4 ms-3 d-none d-lg-block"><div id="google_translate_element"></div></div>
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
                                <img class="img-fluid" src="img/sss.jpg" alt="">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Navbar & Hero End -->


        <!-- About Start -->
        <div class="container-xxl py-5" id="about">
            <div class="container py-5 px-lg-5">
                <div class="row g-5 align-items-center">
                    <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                        <h5 class="text-primary-gradient fw-medium">About App</h5>
                        <h1 class="mb-4">#1 Website For Download Free Insgtram Apk Versions</h1>
                        <p class="mb-4">Discover the #1 app for downloading Instagram APK versions. Easily access the latest and previous versions of Instagram with a user-friendly interface and secure download options.</p>
                        <div class="row g-4 mb-4">
                            <div class="col-sm-6 wow fadeIn" data-wow-delay="0.5s">
                                <div class="d-flex">
                                    <i class="fa fa-cogs fa-2x text-primary-gradient flex-shrink-0 mt-1"></i>
                                    <div class="ms-3">
                                        <h2 class="mb-0" data-toggle="counter-up">1234</h2>
                                        <p class="text-primary-gradient mb-0">Active Install</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 wow fadeIn" data-wow-delay="0.7s">
                                <div class="d-flex">
                                    <i class="fa fa-comments fa-2x text-secondary-gradient flex-shrink-0 mt-1"></i>
                                    <div class="ms-3">
                                        <h2 class="mb-0" data-toggle="counter-up">1234</h2>
                                        <p class="text-secondary-gradient mb-0">Clients Reviews</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a href="download.html" class="btn btn-primary-gradient py-sm-3 px-4 px-sm-5 rounded-pill mt-3">Download</a>
                    </div>
                    <div class="col-lg-6">
                        <img class="img-fluid wow fadeInUp" data-wow-delay="0.5s" src="img/image12.png">
                    </div>
                </div>
            </div>
        </div>
        <!-- About End -->


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
            <?php if ($total_pages > 1): // Show pagination only if there is more than one page ?>
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <?php if ($page > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="blog.php?page=<?php echo $page - 1; ?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                            <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                                <a class="page-link" href="blog.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                            </li>
                        <?php endfor; ?>
                        <?php if ($page < $total_pages): ?>
                            <li class="page-item">
                                <a class="page-link" href="blog.php?page=<?php echo $page + 1; ?>" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            <?php endif; ?>

        </div>
    

    <!--Artile -->
        <div class="blog-container">
            <img src="Instagram-apk.jpg" alt="Instagram APK Download" class="feature-image">
            <div class="content">
                <h1>How to Download Instagram APK Versions For Free</h1>
                <p class="para">Are you looking to download Instagram APK versions for free? Whether you want to access the latest features or need an older version, this guide will help you through the process. Follow these steps to download Instagram APK versions safely and effectively.</p>
    
                <h2>1. Understand What APK Files Are</h2>
                <p class="para">An APK (Android Package Kit) is the file format used by the Android operating system for distribution and installation of mobile apps. Downloading APK files allows you to install apps manually on your device, bypassing the Google Play Store. This can be useful for accessing updated features or older versions of apps.</p>
    
                <h2>2. Find a Reliable Source</h2>
                <p class="para">To ensure your safety and the integrity of the APK file, it's crucial to download from a trustworthy source. Popular sites like APKMirror, APKPure, and others are known for providing safe and verified APK files. Avoid downloading from unknown or suspicious sites, as these may contain malware or compromised versions of the app.</p>
    
                <h2>3. Download the APK File</h2>
                <p class="para">Once you've chosen a reliable source, navigate to the Instagram APK section and select the version you need. Click the download link, and the APK file will be saved to your device. Make sure to check the file size and version to confirm that you're downloading the correct file.</p>
    
                <h2>4. Enable Installation from Unknown Sources</h2>
                <p class="para">Before you can install the APK file, you'll need to allow installations from unknown sources on your Android device. Go to <strong>Settings</strong> > <strong>Security</strong> (or <strong>Apps & notifications</strong>) > <strong>Install unknown apps</strong>. Locate the app or browser you used to download the APK and enable the <strong>Allow from this source</strong> option.</p>
    
                <h2>5. Install the APK</h2>
                <p class="para">Open the file manager on your device and navigate to the location where you saved the APK file. Tap on the file, and you'll be prompted to confirm the installation. Follow the on-screen instructions, and the Instagram app will be installed on your device.</p>
    
                <h2>6. Enjoy Instagram!</h2>
                <p class="para">Once installed, open the Instagram app and log in with your credentials. You can now enjoy all the features of Instagram, including any new updates or fixes available in the APK version you downloaded. Remember to regularly check for updates to ensure you have the latest features and security patches.</p>
    
                <h2>Conclusion</h2>
                <p class="para">Downloading Instagram APK versions for free can be a great way to access the latest features or an older version of the app. By following the steps outlined in this guide, you can safely and effectively download and install Instagram APKs on your Android device. Always ensure you download from reputable sources and keep your device secure.</p>
    
                <a href="blog.html" class="read-more">Read More Blogs</a>
            </div>
        </div>


       

        <!-- Download Start -->
        <div class="container-xxl py-5">
            <div class="container py-5 px-lg-5">
                <div class="row g-5 align-items-center">
                    <div class="col-lg-6">
                        <img class="img-fluid wow fadeInUp" data-wow-delay="0.1s" src="img/jj.webp">
                    </div>
                    <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
                        <h5 class="text-primary-gradient fw-medium">Download</h5>
                        <h1 class="mb-4">Download The Latest Version Of Our App</h1>
                        <p class="mb-4">"Discover the #1 app for downloading Instagram APK versions. Easily access the latest and previous versions of Instagram with a user-friendly interface and secure download options."</p>
                        <div class="row g-4">
                            <div class="col-sm-6 wow fadeIn" data-wow-delay="0.5s">
                                <a href="" class="d-flex bg-primary-gradient rounded py-3 px-4">
                                    <i class="fab fa-apple fa-3x text-white flex-shrink-0"></i>
                                    <div class="ms-3">
                                        <p class="text-white mb-0">Available On</p>
                                        <h5 class="text-white mb-0">App Store</h5>
                                    </div>
                                </a>
                            </div>
                            <div class="col-sm-6 wow fadeIn" data-wow-delay="0.7s">
                                <a href="" class="d-flex bg-secondary-gradient rounded py-3 px-4">
                                    <i class="fab fa-android fa-3x text-white flex-shrink-0"></i>
                                    <div class="ms-3">
                                        <p class="text-white mb-0">Available On</p>
                                        <h5 class="text-white mb-0">Play Store</h5>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Download End -->


        

       
      
        

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
                    <!--<div class="col-md-6 col-lg-3">
                        <h4 class="text-white mb-4">Popular Link</h4>
                        <a class="btn btn-link" href="">About Us</a>
                        <a class="btn btn-link" href="">Contact Us</a>
                        <a class="btn btn-link" href="">Privacy Policy</a>
                        <a class="btn btn-link" href="">Terms & Condition</a>
                    </div>-->
                    <div class="col-md-6 col-lg-3">
                        <h4 class="text-white mb-4">Newsletter</h4>
                        <p>Stay updated with the latest news and exclusive offers from InstagramPro.su! 

                        </p>
                        <div class="position-relative w-100 mt-3">
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
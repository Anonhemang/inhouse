<?php
include 'conn.php'; // Include your database connection file

// Fetch all images from the database
$sql = "SELECT id, img1 FROM images WHERE type='Commercial'"; // Adjust the SQL query based on your actual table and columns
$result = mysqli_query($conn, $sql);

// Check for errors in the query
if (!$result) {
    die("Database query failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>iDESIGN - Interior Design HTML Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <!-- <link href="https://fonts.googleapis.com/css2?family=Montserrat&family=Oswald:wght@400;500;600&display=swap"
        rel="stylesheet"> -->

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Flaticon Font -->
    <link href="lib/flaticon/font/flaticon.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }

        .gallery-container {
            max-width: 1200px;
            /* margin: 0 auto;
            padding: 20px; */
        }



        .gallery {
            display: flex;
            flex-wrap: wrap;
        }

        .gallery-item {
            flex: 1 1 calc(33.333% - 10px);
            box-sizing: border-box;
            overflow: hidden;
            /* border: 2px solid #ccc; */
            /* border-radius: 5px; */
            max-width: 33.33%;
        }

        .gallery-item img {
            width: 100%;
            max-height: 200px;
            width: 450px;
            display: block;
            transition: transform 0.3s ease;
            margin: auto;
            filter: grayscale(70%);

        }

        .gallery-item img:hover {
            transform: scale(1.05);
            filter: grayscale(0%);

        }

        @media (max-width: 768px) {
            .gallery-item {
                flex: 1 1 calc(50% - 10px);
                max-width: 100%;
                margin-bottom: 3%;
            }
        }

        @media (max-width: 480px) {
            .gallery-item {
                flex: 1 1 100%;
            }
        }
    </style>
    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <?php
    include('header.php');
    ?>


    <!-- Page Header Start -->
    <div class="container-fluid bg-secondary py-5">
        <div class="container py-5">
            <div class="row align-items-center py-4">
                <div class="col-md-6 text-center text-md-left">
                    <h1 class="mb-4 mb-md-0 text-primary text-uppercase">Our Projects</h1>
                </div>
                <div class="col-md-6 text-center text-md-right">
                    <div class="d-inline-flex align-items-center">
                        <a class="btn btn-outline-primary" href="">Home</a>
                        <i class="fas fa-angle-double-right text-primary mx-2"></i>
                        <a class="btn btn-outline-primary disabled" href="">Our Projects</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page Header Start -->


    <!-- Projects Start -->
    <!-- Commercial Project -->
    <div class="container-fluid py-5">
        

        
        <div class="container py-5">
            <div class="row">
                <div class="col-12 text-center mb-2">
                    <ul class="list-inline mb-4" id="portfolio-flters">
                        <h1 class="text-light" style="text-decoration:underline;">Commercial Projects</h1>
                    </ul>
                </div>
            </div>
            <div class="row mx-1 portfolio-container">
            <?php
                        // Loop through the result set and display each image
                        while ($row = mysqli_fetch_assoc($result)) {
                            // Ensure the image path is valid
                            if (!empty($row['img1'])) {
                                echo '<div class="gallery-item">';
                                // Wrap the image in an anchor tag linking to view.php and passing the image ID
                                echo '<a href="view.php?id=' . urlencode($row['id']) . '">';
                                echo '<img src="Admin/img/' . htmlspecialchars($row['img1']) . '" alt="Image">';
                                echo '</a>';
                                echo '</div>';
                            }
                        }
                        ?>
            </div>
            <!-- <a style="text-decoration: underline; color:aquamarine; font-size:25px;">View More</a> -->
        </div>
        <!-- End Of Commercial -->
        <hr style="background-color:aliceblue">
        <!-- Residential Projects -->
        <?php
        include 'conn.php'; // Include your database connection file
        
        // Fetch all images from the database
        $sql = "SELECT id, img1 FROM images WHERE type='Residential'"; // Adjust the SQL query based on your actual table and columns
        $result = mysqli_query($conn, $sql);

        // Check for errors in the query
        if (!$result) {
            die("Database query failed: " . mysqli_error($conn));
        }
        ?>



        <div class="container py-5">
            <div class="row">
                <div class="col-12 text-center mb-2">
                    <ul class="list-inline mb-4" id="portfolio-flters">
                        <h1 class="text-light" style="text-decoration:underline;">Residential Projects</h1>
                    </ul>
                </div>
            </div>
            <div class="row mx-1 portfolio-container">
                <?php
                // Loop through the result set and display each image
                while ($row = mysqli_fetch_assoc($result)) {
                    // Ensure the image path is valid
                    if (!empty($row['img1'])) {
                        echo '<div class="gallery-item">';
                        // Wrap the image in an anchor tag linking to view.php and passing the image ID
                        echo '<a href="view.php?id=' . urlencode($row['id']) . '">';
                        echo '<img src="Admin/img/' . htmlspecialchars($row['img1']) . '" alt="Image">';
                        echo '</a>';
                        echo '</div>';
                    }
                }
                ?>
            </div>
            <!-- <a style="text-decoration: underline; color:aquamarine; font-size:25px;">View More</a> -->
        </div>
        <!-- End of Residential -->
    </div>
    <!-- Projects End -->


    <!-- Footer Start -->
    <?php
    include('foot.php');
    ?>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/isotope/isotope.pkgd.min.js"></script>
    <script src="lib/lightbox/js/lightbox.min.js"></script>

    <!-- Contact Javascript File -->
    <script src="mail/jqBootstrapValidation.min.js"></script>
    <script src="mail/contact.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>
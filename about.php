<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>INHouse Interio | About Us</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="keywords" content="Interior Design, Home Decor, Best Interior Designers, Interior Decorating">
    <meta name="description"
        content="Explore the top interior designers who can transform your space into a stylish and functional haven. Discover innovative designs, expert tips, and inspiring ideas for your home.">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <link href="lib/flaticon/font/flaticon.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet">
    <style>
        .inside {
            display: flex;
            flex-wrap: wrap;
        }

        .about {
            padding: 5%;
        }

        .img {
            padding: 3% 6%;
        }

        .o,
        .t {
            display: none;
        }

        .ima {
            width: 500px;
            height: 300px;
            border-radius: 12px;
        }

        @media screen and (max-width:767px) {
            .ima {
                width: 100%;
            }
        }
    </style>
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <?php
    include('header.php');
    ?>
    <div class="container-fluid bg-secondary py-5">
        <div class="container py-5">
            <div class="row align-items-center py-4">
                <div class="col-md-6 text-center text-md-left">
                    <h1 class="mb-4 mb-md-0 text-primary text-uppercase">About Us</h1>
                </div>
                <div class="col-md-6 text-center text-md-right">
                    <div class="d-inline-flex align-items-center">
                        <a class="btn btn-outline-primary" href="">Home</a>
                        <i class="fas fa-angle-double-right text-primary mx-2"></i>
                        <a class="btn btn-outline-primary disabled" href="">About Us</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="about">
        <div class="inside">
            <div class="img o" id="img">
                <center><img src="img/ExpertTeamofProfessionals.png" alt="Image" class="ima"></center>
                <center>
                    <h2 class="text-light">Expert Team of Professionals</h2>
                </center>
            </div>
            <div class="img t" id="img2">
                <center><img src="img/HighQualityService.jpg" alt="Image" class="ima"></center>
                <center>
                    <h2 class="text-light">High Quality Service</h2>
                </center>
            </div>
            <div class="img t" id="img">
                <center><img src="img/AffordablePricing.jpg" alt="Image" class="ima"></center>
                <center>
                    <h2 class="text-light">Affordable Pricing</h2>
                </center>
            </div>

            <div class="img t" id="img2">
                <center><img src="img/BestCustomerSupport.jpg" alt="Image" class="ima"></center>
                <center>
                    <h2 class="text-light">Best Customer Support</h2>
                </center>
            </div>

            <div class="img o" id="img">
                <center><img src="img/ReliableServicee.png" alt="Image" class="ima"></center>
                <center>
                    <h2 class="text-light">Reliable Service</h2>
                </center>
            </div>

            <div class="img o" id="img2">
                <center><img src="img/Customized-Solutions.jpeg" alt="Image" class="ima"></center>
                <center>
                    <h2 class="text-light">Customized Solutions</h2>
                </center>
            </div>
            <div class="img t" id="img">
                <center><img src="img/UseofAdvancedTechnologies.png" alt="Image" class="ima"></center>
                <center>
                    <h2 class="text-light">Use Of Advanced Technologies</h2>
                </center>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('.o').fadeIn(2000); // 2000ms = 2 seconds
            $('.t').fadeIn(8000); // 2000ms = 2 seconds
        });
    </script>
    <?php
    include('foot.php')
        ?>
    <a href="#" class="btn btn-lg btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/isotope/isotope.pkgd.min.js"></script>
    <script src="lib/lightbox/js/lightbox.min.js"></script>
    <script src="mail/jqBootstrapValidation.min.js"></script>
    <script src="mail/contact.js"></script>
    <script src="js/main.js"></script>
</body>

</html>
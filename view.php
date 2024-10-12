<?php
include 'conn.php'; // Include your database connection file
$id = $_GET['id'];
// Fetch images from the database
$sql = "SELECT img1, img2, img3, img4, img5, img6 FROM images where id='$id'"; // Adjust the query based on your table structure
$result = mysqli_query($conn, $sql);
$images = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        // Check if each image exists in the 'Admin/img/' directory before adding to the array
        if (!empty($row['img1']) && file_exists("Admin/img/" . $row['img1'])) {
            $images[] = $row['img1'];
        }
        if (!empty($row['img2']) && file_exists("Admin/img/" . $row['img2'])) {
            $images[] = $row['img2'];
        }
        if (!empty($row['img3']) && file_exists("Admin/img/" . $row['img3'])) {
            $images[] = $row['img3'];
        }
        if (!empty($row['img4']) && file_exists("Admin/img/" . $row['img4'])) {
            $images[] = $row['img4'];
        }
        if (!empty($row['img5']) && file_exists("Admin/img/" . $row['img5'])) {
            $images[] = $row['img5'];
        }
        if (!empty($row['img6']) && file_exists("Admin/img/" . $row['img6'])) {
            $images[] = $row['img6'];
        }
    }
} else {
    echo "Error fetching images: " . mysqli_error($conn);
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Flaticon Font -->
    <link href="lib/flaticon/font/flaticon.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Gallery</title>
    <style>
        .all {
            width: 100%;
            height: 100%;
        }

        .gallery-container {
            display: flex;
            align-items: flex-start;
            max-width: 80%;
            background-color: transparent;
            padding: 20px;
            margin: auto;
            height: 700px;
        }

        .thumbnails {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-right: 20px;
            height: 100%;
            width: 30%;
            overflow-y: scroll;
        }

        .thumbnails img {
            width: 90%;
            height: 250px;
            cursor: pointer;
            border: 2px solid transparent;
            border-radius: 4px;
            margin: 0 auto;
        }

        .thumbnails img:hover {
            border-color: #0073e6;
        }

        .main-image {
            flex-grow: 1;
            height: 100%;
            width: 100%;
        }

        .main-image img {
            max-width: 100%;
            height: 100%;
            border-radius: 8px;
            object-fit: cover;
            cursor: pointer;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }

        .modal img {
            max-width: 100%;
            max-height: 100%;
            border-radius: 8px;
        }

        .close-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 30px;
            color: white;
            cursor: pointer;
            background: rgba(0, 0, 0, 0.5);
            padding: 5px 10px;
            border-radius: 5px;
        }

        .arrow {
            position: absolute;
            top: 50%;
            font-size: 40px;
            color: white;
            background-color: rgba(0, 0, 0, 0.5);
            padding: 10px;
            border-radius: 50%;
            cursor: pointer;
            user-select: none;
        }

        .arrow-left {
            left: 10px;
        }

        .arrow-right {
            right: 10px;
        }

        @media screen and (max-width: 768px) {
            .gallery-container {
                flex-direction: column;
                max-width: 100%;
                height: auto;
            }

            .main-image {
                width: 100%;
                height: auto;
            }

            .main-image img {
                width: 100%;
                height: auto;
            }

            .thumbnails {
                flex-direction: row;
                justify-content: flex-start;
                margin-bottom: 20px;
                height: auto;
                overflow-x: auto;
                overflow-y: hidden;
                white-space: nowrap;
                width: 100%;
            }

            .thumbnails img {
                width: 80px;
                height: 80px;
                flex-shrink: 0;
            }
        }
    </style>
</head>

<body>
    <?php 
    include('header.php');
    ?>
    <div class="all">
        <div class="gallery-container">
            <!-- Thumbnails on the left side -->
            <div class="thumbnails">
                <?php foreach ($images as $index => $image): ?>
                    <?php if ($image): ?>
                        <img src="Admin/img/<?php echo $image; ?>" alt="Thumbnail <?php echo $index + 1; ?>" class="thumbnail"
                            onclick="changeImage(<?php echo $index; ?>)">
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>

            <!-- Main image on the right side -->
            <div class="main-image">
                <img id="mainImage" src="Admin/img/<?php echo $images[0]; ?>" alt="Select Image To View"
                    onclick="openModal()">
            </div>
        </div>

        <!-- Modal -->
        <div id="imageModal" class="modal">
            <span class="close-btn" onclick="closeModal()">&#10006;</span>
            <span class="arrow arrow-left" onclick="prevImage()">&#10094;</span>
            <img id="modalImage" src="">
            <span class="arrow arrow-right" onclick="nextImage()">&#10095;</span>
        </div>

        <script>
            const images = <?php echo json_encode($images); ?>;
            let currentIndex = 0;

            function changeImage(index) {
                currentIndex = index;
                document.getElementById('mainImage').src = 'Admin/img/' + images[index];
            }

            function openModal() {
                const modal = document.getElementById('imageModal');
                const modalImage = document.getElementById('modalImage');
                modal.style.display = 'flex';
                modalImage.src = 'Admin/img/' + images[currentIndex];
                document.body.style.overflow = 'hidden';
            }

            function closeModal() {
                document.getElementById('imageModal').style.display = 'none';
                document.body.style.overflow = '';
            }

            function nextImage() {
                currentIndex = (currentIndex + 1) % images.length;
                document.getElementById('modalImage').src = 'Admin/img/' + images[currentIndex];
            }

            function prevImage() {
                currentIndex = (currentIndex - 1 + images.length) % images.length;
                document.getElementById('modalImage').src = 'Admin/img/' + images[currentIndex];
            }

            window.onclick = function (event) {
                const modal = document.getElementById('imageModal');
                if (event.target === modal) {
                    closeModal();
                }
            };
        </script>
    </div>
    <?php 
    include('foot.php')
    ?>

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
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Images</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        .upload-form {
            margin: 20px 0;
        }

        input[type="file"],
        input[type="text"] {
            width: 80%;
            margin: 1% 0;
            font-size: 12px;
            border: 1px solid lightgrey;
            padding: 1%;
            border-radius: 15px;
        }
        .type{
            width: 80%;
            margin: 1% 0;
            font-size: 12px;
            border: 1px solid lightgrey;
            padding: 1%;
            border-radius: 15px;
        }

        button {
            background-color: lightgreen;
            font-size: 15px;
            border: 0;
            padding: 1%;
            border-radius: 15px;
        }
    </style>
</head>

<body>

    <?php
    include 'conn.php'; // Include your database connection file
    
    // Handle image upload
    if (isset($_POST['upload'])) {
        $client_name = mysqli_real_escape_string($conn, $_POST['client_name']); // Get the client name
        $type = mysqli_real_escape_string($conn, $_POST['type']); // Get the type
        $images = [];
        for ($i = 1; $i <= 6; $i++) {
            if (isset($_FILES["img$i"]) && $_FILES["img$i"]['error'] == 0) {
                $filename = $_FILES["img$i"]['name'];
                $target_dir = "img/"; // Path to the target directory
                $target_file = $target_dir . basename($filename);

                // Move the uploaded file to the target directory
                if (move_uploaded_file($_FILES["img$i"]['tmp_name'], $target_file)) {
                    $images[] = $filename; // Store the filename for database insertion
                } else {
                    echo "Error uploading image $i.<br>";
                }
            }
        }

        // Insert images, client name, and type into the database
        if (count($images) > 0) {
            $img1 = isset($images[0]) ? $images[0] : null;
            $img2 = isset($images[1]) ? $images[1] : null;
            $img3 = isset($images[2]) ? $images[2] : null;
            $img4 = isset($images[3]) ? $images[3] : null;
            $img5 = isset($images[4]) ? $images[4] : null;
            $img6 = isset($images[5]) ? $images[5] : null;

            $sql = "INSERT INTO images (client_name, type, img1, img2, img3, img4, img5, img6) 
                VALUES ('$client_name', '$type', '$img1', '$img2', '$img3', '$img4', '$img5', '$img6')";
            if (mysqli_query($conn, $sql)) {
                echo "Images uploaded successfully.<br>";
                header("Location: gallery.php"); // Redirect to gallery after upload
                exit();
            } else {
                echo "Error saving images to database: " . mysqli_error($conn) . "<br>";
            }
        }
    }
    ?>

    <h1>Upload New Images</h1>
    <form action="upload.php" method="POST" enctype="multipart/form-data" class="upload-form">
        <input type="text" name="client_name" placeholder="Enter Client Name" required>
        <!-- <input type="text" name="type" placeholder="Enter Image Type" required> -->
        <select name="type" id="" required class="type">
            <option value="Residential">Residential</option>
            <option value="Commercial">Commercial</option>
        </select>
        <?php for ($i = 1; $i <= 6; $i++): ?>
            <input type="file" name="img<?php echo $i; ?>">
        <?php endfor; ?>
        <br>
        <button type="submit" name="upload">Upload</button>
    </form>

</body>

</html>
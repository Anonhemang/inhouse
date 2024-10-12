<?php
include 'conn.php'; // Include your database connection file

// Check if an ID is provided in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the current image details from the database
    $sql = "SELECT * FROM images WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    if (!$row) {
        echo "Image not found.";
        exit;
    }
} else {
    echo "No ID provided.";
    exit;
}

// Handle form submission to update the image details
if (isset($_POST['update'])) {
    // Temporary array to hold image names
    $images = [];

    // Target directory for images
    $target_dir = "img/";

    // Check and move uploaded files to the target directory
    for ($i = 1; $i <= 6; $i++) {
        // If a new image is uploaded
        if (isset($_FILES["img$i"]) && $_FILES["img$i"]['name']) {
            // Delete the old image if it exists
            if ($row["img$i"]) {
                $oldImagePath = $target_dir . $row["img$i"];
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath); // Delete the old image from the server
                }
            }

            // Move the new file to the target directory
            move_uploaded_file($_FILES["img$i"]['tmp_name'], $target_dir . $_FILES["img$i"]['name']);
            $images[$i] = $_FILES["img$i"]['name']; // Store the new image name
        } else {
            $images[$i] = $row["img$i"]; // Keep existing image if not replaced
        }

        // Check if the user wants to delete any images
        if (isset($_POST["remove_img$i"])) {
            // Remove image from directory if it exists
            if ($row["img$i"]) {
                unlink($target_dir . $row["img$i"]); // Delete the file from the server
            }
            $images[$i] = NULL; // Set to NULL to indicate deletion
        }
    }

    // Prepare the SQL update statement
    $sql = "UPDATE images SET 
                img1 = '" . ($images[1] ?? NULL) . "', 
                img2 = '" . ($images[2] ?? NULL) . "', 
                img3 = '" . ($images[3] ?? NULL) . "', 
                img4 = '" . ($images[4] ?? NULL) . "', 
                img5 = '" . ($images[5] ?? NULL) . "', 
                img6 = '" . ($images[6] ?? NULL) . "',
                client_name = '" . mysqli_real_escape_string($conn, $_POST['client_name']) . "', 
                type = '" . mysqli_real_escape_string($conn, $_POST['type']) . "' 
            WHERE id = $id";

    if (mysqli_query($conn, $sql)) {
        echo "Images updated successfully.";
        header("Location: gallery.php"); // Redirect to gallery after updating
        exit;
    } else {
        echo "Error updating images: " . mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Image</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            padding: 20px;
            background-color: #f0f4f8;
            color: #333;
        }

        h1 {
            text-align: center;
            color: #007bff;
            margin-bottom: 20px;
        }

        form {
            width: 80%;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }

        label {
            font-weight: bold;
            margin-top: 15px;
            display: block;
            color: #555;
        }

        .image-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin: 20px 0;
        }

        img {
            border-radius: 8px;
            transition: transform 0.3s, box-shadow 0.3s;
            width: 200px;
            height: 200px;
        }

        img:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        input[type="file"] {
            margin: 10px 0;
            border: 2px solid #007bff;
            border-radius: 4px;
            padding: 10px;
            width: calc(100% - 20px);
            box-sizing: border-box;
            transition: border-color 0.3s;
        }

        input[type="file"]:hover {
            border-color: #0056b3;
        }

        .checkbox-container {
            display: flex;
            align-items: center;
            margin: 10px 0;
        }

        input[type="checkbox"] {
            appearance: none;
            width: 24px;
            height: 24px;
            border: 2px solid #007bff;
            border-radius: 4px;
            margin-right: 10px;
            cursor: pointer;
            transition: background-color 0.3s, border-color 0.3s;
        }

        input[type="checkbox"]:checked {
            background-color: #007bff;
            border-color: #007bff;
        }

        input[type="checkbox"]:checked::after {
            content: "✓";
            color: white;
            position: relative;
            left: 2px;
            top: -2px;
        }

        button {
            background-color: #007bff;
            border: none;
            padding: 12px 25px;
            border-radius: 5px;
            color: white;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s;
            display: block;
            margin: 20px auto;
            width: 100%;
        }

        button:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
        }
    </style>
</head>

<body>
    <h1>Edit Image Details</h1>
    <form action="edit.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data">
        <div class="image-container">
            <?php for ($i = 1; $i <= 6; $i++): ?>
                <div>
                    <?php if ($row["img$i"]): // Only show images that exist ?>
                        <label for="img<?php echo $i; ?>">Image <?php echo $i; ?>:</label><br>
                        <img src="img/<?php echo $row["img$i"]; ?>" alt="Image <?php echo $i; ?>">
                        <p><?php echo $row["img$i"] ?></p>
                        <input type="file" name="img<?php echo $i; ?>">
                        <div class="checkbox-container">
                            <input type="checkbox" name="remove_img<?php echo $i; ?>" value="1"> Remove Image <?php echo $i; ?>
                        </div>
                    <?php else: ?>
                        <label for="img<?php echo $i; ?>">Upload Image <?php echo $i; ?>:</label>
                        <input type="file" name="img<?php echo $i; ?>">
                    <?php endif; ?>
                </div>
            <?php endfor; ?>
        </div>

        <!-- Add Name and Type Fields -->
        <label for="client_name">Client Name:</label>
        <input type="text" name="client_name" value="<?php echo htmlspecialchars($row['client_name']); ?>" required>

        <label for="type">Type:</label>
        <!-- <input type="text" name="type" value="<?php echo htmlspecialchars($row['type']); ?>" required> -->
        <select name="type" required class="type">
    <option value="Residential" <?php echo ($row['type'] == 'Residential') ? 'selected' : ''; ?>>Residential</option>
    <option value="Commercial" <?php echo ($row['type'] == 'Commercial') ? 'selected' : ''; ?>>Commercial</option>
</select>
        <button type="submit" name="update">Update</button>
    </form>
</body>

</html>
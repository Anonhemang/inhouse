<!DOCTYPE html>
<html lang="en">
<?php
include("nav.php"); // Include your navigation file
include 'conn.php'; // Include your database connection file
error_reporting(0);

// Handle image deletion
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    // First, retrieve the image file name(s) from the database
    $sql = "SELECT img1, img2, img3, img4, img5, img6 FROM images WHERE id='$id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    // Check and delete image files from the server
    for ($i = 1; $i <= 6; $i++) {
        if (isset($row["img$i"])) {
            $filePath = 'img/' . $row["img$i"];
            if (file_exists($filePath)) {
                unlink($filePath); // Delete the image file from the folder
            }
        }
    }

    // Now delete the record from the database
    $sql = "DELETE FROM images WHERE id='$id'";
    mysqli_query($conn, $sql);
    header("Location: gallery.php"); // Redirect after deletion
}

// Fetch images and client names from the database
$sql = "SELECT * FROM images";
$result = mysqli_query($conn, $sql);
$images = mysqli_fetch_all($result, MYSQLI_ASSOC); // Store all images in an array for filtering
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery Images</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        html,body{
            background-color: #131516;
            color: aliceblue!important;
        }
        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
        }

        .delete {
            text-decoration: none;
            background-color: red;
            color: white;
            padding: 5%;
            font-weight: bold;
            border-radius: 12px;
        }

        .edit {
            text-decoration: none;
            background-color: #ffc107;
            color: white;
            font-weight: bold;
            padding: 5%;
            border-radius: 12px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        img.thumbnail {
            cursor: pointer;
            margin: 5px;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            padding-top: 10px;
            padding-bottom: 10px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.9);
        }

        .modal-content {
            margin: auto;
            display: block;
            max-width: 100%;
            max-height: 100%;
        }

        .close {
            position: absolute;
            top: 20px;
            right: 35px;
            color: white;
            font-size: 40px;
            font-weight: bold;
            cursor: pointer;
        }

        .arrow {
            cursor: pointer;
            position: absolute;
            top: 50%;
            width: auto;
            padding: 16px;
            color: white;
            font-weight: bold;
            font-size: 18px;
            transition: 0.6s ease;
            user-select: none;
        }

        .arrow:hover {
            background-color: rgba(255, 255, 255, 0.3);
        }

        .left {
            left: 0;
        }

        .right {
            right: 0;
        }

        .hidden {
            display: none;
        }

        .search-container {
            margin: 20px;
            text-align: center;
        }

        .search-input {
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
            width: 80%;
            max-width: 400px;
            background-color: transparent;
            color: #f2f2f2;
        }
    </style>
</head>

<body>
    <center>
        <h1>Client Gallery</h1>
    </center>

    <h2>
        <a href="upload.php"
            style="text-decoration: none; background-color: lightblue; color: black; padding: 10px; border-radius: 5px;">
            Upload New Images
        </a>
    </h2>

    <!-- Search Bar -->
    <div class="search-container">
        <input type="text" id="searchInput" class="search-input" placeholder="Search by Client Name or Type..."
            onkeyup="filterImages()">
    </div>

    <table id="imageTable">
        <tr>
            <th>Client Name</th>
            <th>Image Type</th> <!-- New column for image type -->
            <th>Images</th>
            <th>Action</th>
        </tr>
        <?php foreach ($images as $row): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['client_name']); ?></td>
                <td><?php echo htmlspecialchars($row['type']); ?></td> <!-- Displaying image type -->
                <td>
                    <?php for ($i = 1; $i <= 6; $i++): ?>
                        <?php if ($row["img$i"]): ?>
                            <img src="img/<?php echo htmlspecialchars($row["img$i"]); ?>" width="100" height="100" class="thumbnail"
                                onclick="openModal('<?php echo htmlspecialchars($row["img$i"]); ?>', <?php echo $row['id']; ?>)">
                        <?php endif; ?>
                    <?php endfor; ?>
                </td>
                <td>
                    <a href="edit.php?id=<?php echo $row['id']; ?>" class="edit">Edit</a> |
                    <a href="?delete=<?php echo $row['id']; ?>" onclick="return del()" class="delete">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <!-- Modal for Viewing Images -->
    <div id="imageModal" class="modal">
        <span class="close" onclick="closeModal()">&times;</span>
        <span class="arrow left" onclick="changeImage(-1)">&#10094;</span>
        <img class="modal-content" id="modalImage">
        <span class="arrow right" onclick="changeImage(1)">&#10095;</span>
    </div>

    <script>
        let currentIndex = 0;

        function openModal(image, id) {
            currentIndex = id; // Store current image ID or index
            document.getElementById("modalImage").src = "img/" + image;
            document.getElementById("imageModal").style.display = "block";
        }

        function closeModal() {
            document.getElementById("imageModal").style.display = "none";
        }

        function changeImage(direction) {
            const currentImages = document.querySelectorAll('img.thumbnail');
            currentIndex = (currentIndex + direction + currentImages.length) % currentImages.length;
            document.getElementById("modalImage").src = "img/" + currentImages[currentIndex].src.split('/').pop();
        }

        function del() {
            return confirm("Want to Delete This Row?");
        }

        function filterImages() {
            const input = document.getElementById("searchInput");
            const filter = input.value.toLowerCase();
            const table = document.getElementById("imageTable");
            const tr = table.getElementsByTagName("tr");

            for (let i = 1; i < tr.length; i++) { // Start from 1 to skip the header
                const tdName = tr[i].getElementsByTagName("td")[0]; // Client Name column
                const tdType = tr[i].getElementsByTagName("td")[1]; // Image Type column
                if (tdName || tdType) {
                    const txtValueName = tdName.textContent || tdName.innerText;
                    const txtValueType = tdType.textContent || tdType.innerText;
                    tr[i].style.display = txtValueName.toLowerCase().includes(filter) || txtValueType.toLowerCase().includes(filter) ? "" : "none";
                }
            }
        }

        // Close the modal when clicking outside of the modal content
        window.onclick = function (event) {
            if (event.target === document.getElementById("imageModal")) {
                closeModal();
            }
        };
    </script>
</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toggle Sidebar Navbar</title>
    <link rel="stylesheet" href="style.css">
    <style>
        html,body{
            background-color: #131516;
        }
        /* Styling the sidebar */
        .sidebar {
            height: 100%;
            width: 0;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #111;
            overflow-x: hidden;
            transition: 0.5s;
            padding-top: 60px;
        }

        /* Sidebar links */
        .sidebar a {
            padding: 8px 8px 8px 32px;
            text-decoration: none;
            font-size: 25px;
            color: #818181;
            display: block;
            transition: 0.3s;
        }

        .sidebar a:hover {
            color: #f1f1f1;
        }

        /* Main content area */
        .main-content {
            padding-left: 20px;
            transition: margin-left 0.5s;
            padding: 16px;
        }

        /* Toggle button */
        .toggle-btn {
            font-size: 30px;
            cursor: pointer;
            background-color: #111;
            color: white;
            border: none;
            padding: 10px;
        }

        /* When sidebar is visible */
        .sidebar.active {
            width: 250px;
        }

        .main-content.active {
            margin-left: 250px;
        }
    </style>
</head>

<body>

    <div id="sidebar" class="sidebar">
        <a href="index.php">Home</a>
        <a href="gallery.php">Gallery</a>
    </div>

    <div class="main-content">
        <button class="toggle-btn" onclick="toggleSidebar()">☰ </button>

    </div>

    <script>function toggleSidebar() {
            let sidebar = document.getElementById("sidebar");
            let mainContent = document.querySelector(".main-content");

            sidebar.classList.toggle("active");
            mainContent.classList.toggle("active");
        }
    </script>
</body>

</html>
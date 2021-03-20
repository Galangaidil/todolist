<?php require_once("auth.php"); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- icon -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- Icon website -->
    <link rel="apple-touch-icon" sizes="180x180" href="img/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="img/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="img/favicon-16x16.png">
    <link rel="manifest" href="img/site.webmanifest">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $_SESSION['nama'] ?> To do list</title>

    <!-- css -->
    <style>
        /* font */
        @import url('https://fonts.googleapis.com/css2?family=Pacifico&display=swap');

        * {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Quicksand', sans-serif;
            background-color: #1B203A;
        }

        /* The side navigation menu */
        .sidenav {
            height: 100%;
            /* 100% Full-height */
            width: 0;
            /* 0 width - change this with JavaScript */
            position: fixed;
            /* Stay in place */
            z-index: 1;
            /* Stay on top */
            top: 0;
            /* Stay at the top */
            left: 0;
            background-color: rgb(37, 44, 72);
            /* Donker*/
            overflow-x: hidden;
            /* Disable horizontal scroll */
            padding-top: 60px;
            /* Place content 60px from the top */
            transition: 0.5s;
            /* 0.5 second transition effect to slide in the sidenav */
        }

        /* The navigation menu links */
        .sidenav a {
            padding: 8px 8px 8px 32px;
            text-decoration: none;
            font-size: 18px;
            color: #FFFFFF;
            display: block;
            transition: 0.3s;
        }

        /* When you mouse over the navigation links, change their color */
        .sidenav a:hover {
            background-color: #1B203A;
        }

        /* Position and style the close button (top right corner) */
        .sidenav .closebtn {
            position: absolute;
            top: 0;
            right: 25px;
            font-size: 36px;
            margin-left: 50px;
        }

        /* Style page content - use this if you want to push the page content to the right when you open the side navigation */
        #main {
            transition: margin-left .5s;
            padding: 20px;
        }

        /* icon menu */
        .menu {
            margin-left: 20px;
            margin-top: 20px;
            color: rgba(255, 255, 255, 1);
            cursor: pointer;
        }

        /* header */
        header {
            width: 100%;
            height: 60px;
            background-color: rgb(37, 44, 72);
        }

        .heading {
            margin-top: -50px;
            font-family: 'Pacifico', cursive;
            color: #FFFFFF;
            text-align: center;
            cursor: pointer;
        }

        /* The alert message box */
        .alert {
            padding: 20px;
            background-color: #2196F3;
            /* Blue */
            color: white;
            margin-bottom: 15px;
        }

        /* The close button */
        .closebtn {
            margin-left: 15px;
            color: white;
            font-weight: bold;
            float: right;
            font-size: 22px;
            line-height: 20px;
            cursor: pointer;
            transition: 0.3s;
        }

        /* When moving the mouse over the close button */
        .closebtn:hover {
            color: black;
        }

        /* On smaller screens, where height is less than 450px, change the style of the sidenav (less padding and a smaller font size) */
        @media screen and (max-height: 450px) {
            .sidenav {
                padding-top: 15px;
            }

            .sidenav a {
                font-size: 18px;
            }
        }
    </style>


</head>

<body>
    <!-- Sidebar start -->
    <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="index.php"><span class="material-icons home">
                home
            </span> Home</a>
        <a href="tambah.php"><span class="material-icons tambah">
                add_circle_outline
            </span> Tambah tugas</a>
        <a href="#">Clients</a>
        <a href="logout.php" onclick="return confirm('Apakah anda mau keluar?')"><span class="material-icons keluar">
                exit_to_app
            </span> Keluar</a>
    </div>

    <header>
        <!-- Use any element to open the sidenav -->
        <span class="material-icons menu" onclick="openNav()">
            menu
        </span>
        <h1 class="heading" onclick="document.location.href = 'index.php'">To do list</h1>
        <a href="logout.php">Logout</a>
    </header>

    <!-- Add all page content inside this div if you want the side nav to push page content to the right not used if you only want the sidenav to sit on top of the page -->
    <div id="main">
        <div class="alert">
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
            Halo <strong><?= $_SESSION['nama'] ?></strong>. <br>Selamat datang di to do list. Sebuah web yang akan <strong>mengelola daftar kegiatanmu</strong>. mulai dari <strong>mengerjakan tugas kuliah, pergi les, janji dengan klien</strong>. <br> <br> Lorem ipsum dolor sit amet consectetur, adipisicing elit. Labore atque corporis, laborum dolor expedita ex necessitatibus ut enim fugit, eligendi quaerat maxime aut delectus sequi dignissimos. Delectus natus sapiente praesentium!.
        </div>

        <div class="showTugas">
            <ul type="none">
                <?php
                $halaman = 4;
                $page = isset($_GET['halaman']) ? (int) $_GET['halaman'] : 1;
                $mulai = ($page > 1) ? ($page * $halaman) - $halaman : 0;
                $result = mysqli_query($conn, "SELECT * FROM tugas");
                $total = mysqli_num_rows($result);
                $pages = ceil($total / $halaman);
                $query = mysqli_query($conn, "SELECT * FROM tugas LIMIT $mulai, $halaman") or die(mysqli_error($conn));
                $no = $mulai + 1;

                while ($data = mysqli_fetch_assoc($query)) :
                ?>
                    <li><a href=""><?= $data['nama_tugas'] ?></a></li>
                <?php endwhile ?>
            </ul>
        </div>

        <div>
            page :
            <?php
            for ($i = 1; $i <= $pages; $i++) : ?>
                <a style="text-decoration: none; color: blue;" href="?halaman=<?php echo $i; ?>"> <?= $i ?></a>
            <?php endfor ?>
        </div>
    </div>


    <script>
        /* Set the width of the side navigation to 250px */
        function openNav() {
            document.getElementById("mySidenav").style.width = "250px";
        }

        /* Set the width of the side navigation to 0 */
        function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
        }
    </script>
</body>

</html>
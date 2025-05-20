<!DOCTYPE html>
<html lang="en">
<head>
    <title>EverAfterBook</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script src="script.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous" defer></script>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" />
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="css/headers.css">
    <link rel="stylesheet" href="css/style.css">

   <!-- <style>
        a {
            text-decoration: none;
        }

        .navbar {
            top: 0;
            left: 0;
            right: 0;
            width: 100%;
            box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
            border: 0;
            background-color: #f7d8db;
            z-index: 100;
            padding: 20px 0;
        }

        .navbar-brand {
            font-size: 30px;
            font-family: 'Playfair Display', serif;
            font-weight: bold;
            color: #7a4d56; /* Soft wedding pink color */
            margin-right: 20px;
        }

        .navbar-brand img {
            width: 190px; /* Placeholder for logo */
            height: auto;
            object-fit: contain;
        }

        .nav-pills .nav-item .nav-link {
            box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
            background-color: #e3a2b3; /* Soft wedding pink */
            border-radius: 30px;
            color: white;
            padding: 10px 20px;
            font-family: 'Playfair Display', serif;
        }

        .nav-pills .nav-item .nav-link:hover {
            background-color: #d36b7f;
            color: white;
        }

        .nav-pills .nav-item .nav-link.active {
            background-color: #7a4d56; /* Elegant color for active links */
            border-radius: 30px;
        }

        .navbar-toggler {
            border-color: #7a4d56;
        }

        .tab-content {
            height: 100%;
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }
    </style> -->
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="images/logo-tr.png" alt="Logo" /> <!-- Add your logo image here -->
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-lg-end" id="navbarSupportedContent">
                <ul class="nav nav-pills align-right flex-column flex-lg-row p-2" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" href="venues.php">Venues</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" href="aboutus.html">About</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header</title>
    <script src="script.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous" defer></script>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" />
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="css/headers.css">
    <link rel="stylesheet" href="css/adminstyle.css">
</head>
<body>

<div class="header navbar navbar-expand-lg navbar-light">
<div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="images/logo-tr.png" alt="Logo" /> 
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-lg-end" id="navbarSupportedContent">
                <ul class="nav nav-pills align-right flex-column flex-lg-row p-2" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" href="dashboard.php">Home</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" href="manage_venues.php">Venues</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" href="approve.php">Reservations</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" href="admin_optional_picks.php">Options</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    
</body>
</html>
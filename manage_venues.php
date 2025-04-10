<?php
include('db_connection.php');
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch all venues with their main image (if exists)
$query = "
    SELECT v.*, vi.image_url AS main_image
    FROM venues v
    LEFT JOIN venue_images vi ON v.venue_id = vi.venue_id AND vi.is_main = TRUE
    ORDER BY v.venue_id DESC
";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Venues</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: #f8f8f8;
        }

        .header {
            background-color: #B76E79;
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            margin: 0;
            font-size: 22px;
        }

        .header a {
            color: white;
            text-decoration: none;
            font-weight: bold;
            margin-left: 20px;
        }

        .container {
            max-width: 1100px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .top-actions {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 20px;
        }

        .top-actions a {
            background: #B76E79;
            color: white;
            padding: 10px 18px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            transition: background 0.2s;
        }

        .top-actions a:hover {
            background: #9a5b65;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0,0,0,0.08);
        }

        th, td {
            padding: 14px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        th {
            background-color: #f2f2f2;
        }

        img.thumb {
            width: 80px;
            height: 60px;
            object-fit: cover;
            border-radius: 6px;
        }

        .actions a {
            margin-right: 10px;
            text-decoration: none;
            font-weight: bold;
        }

        .edit-link {
            color: #007bff;
        }

        .delete-link {
            color: #cc0000;
        }
    </style>
</head>
<body>

<?php include('header_admin.php'); ?>

<div class="container">
    <div class="top-actions">
        <a href="add_venue.php">+ Add New Venue</a>
    </div>

    <table>
        <tr>
            <th>Main Image</th>
            <th>Name</th>
            <th>Location</th>
            <th>Capacity</th>
            <th>Price</th>
            <th>Actions</th>
        </tr>
        <?php while ($venue = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td>
                    <?php if ($venue['main_image']) { ?>
                        <img src="<?php echo htmlspecialchars($venue['main_image']); ?>" class="thumb" alt="Venue Image">
                    <?php } else { ?>
                        <span style="color:#aaa;">No image</span>
                    <?php } ?>
                </td>
                <td><?php echo htmlspecialchars($venue['name']); ?></td>
                <td><?php echo htmlspecialchars($venue['location']); ?></td>
                <td><?php echo htmlspecialchars($venue['capacity']); ?></td>
                <td>$<?php echo number_format($venue['price'], 2); ?></td>
                <td class="actions">
                    <a href="edit_venue.php?id=<?php echo $venue['venue_id']; ?>" class="edit-link">Edit</a>
                    <a href="delete_venue.php?id=<?php echo $venue['venue_id']; ?>" class="delete-link" onclick="return confirm('Are you sure you want to delete this venue?');">Delete</a>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>


<?php include('footer.php'); ?>
</body>
</html>

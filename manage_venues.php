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

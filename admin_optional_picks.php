<?php
include('db_connection.php');
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

function getOptions($conn, $table, $idColumn) {
    $stmt = $conn->prepare("SELECT * FROM $table ORDER BY $idColumn DESC");
    $stmt->execute();
    return $stmt->get_result();
}

$categories = [
    'music' => 'music_id',
    'menu'  => 'menu_id',
    'decor' => 'decor_id'
];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Optional Picks</title>
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

        .category-tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 30px;
        }

        .category-tabs button {
            padding: 10px 20px;
            background-color: #ddd;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .category-tabs button.active {
            background-color: #B76E79;
            color: white;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0,0,0,0.08);
            margin-bottom: 40px;
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

        .actions button {
            margin-right: 5px;
            padding: 6px 12px;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .edit-btn {
            background-color: #007bff;
            color: white;
        }

        .delete-btn {
            background-color: #cc0000;
            color: white;
        }

        .add-btn {
            background: #B76E79;
            color: white;
            padding: 10px 18px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            transition: background 0.2s;
            border: none;
            cursor: pointer;
            margin-bottom: 15px;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.5);
        }

        .modal-content {
            background-color: #fff;
            margin: 10% auto;
            padding: 20px;
            border-radius: 8px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.25);
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 24px;
            font-weight: bold;
            cursor: pointer;
        }

        .modal h3 {
            margin-top: 0;
        }

        .modal form input,
        .modal form select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .modal form button {
            background-color: #B76E79;
            color: white;
            border: none;
            padding: 10px 16px;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
        }
    </style>
</head>
<body>

<?php include('header_admin.php'); ?>

<div class="container">
    <h1>Manage Optional Picks</h1>

    <div class="category-tabs">
        <?php foreach ($categories as $category => $idColumn): ?>
            <button 
                class="tab-btn"
                onclick="showCategory('<?= $category ?>')" 
                id="tab-<?= $category ?>" 
                data-category="<?= $category ?>">
                <?= ucfirst($category) ?>
            </button>
        <?php endforeach; ?>
    </div>

    <?php foreach ($categories as $category => $idColumn): ?>
        <div class="category-section" id="section-<?= $category ?>" data-category="<?= $category ?>" style="display: none;">
            <?php $options = getOptions($conn, $category, $idColumn); ?>
            <h2><?= ucfirst($category) ?> Options</h2>

            <button class="add-btn" onclick="openAddModal('<?= $category ?>')">+ Add <?= ucfirst($category) ?></button>

            <table>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Style</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
                <?php while ($row = $options->fetch_assoc()): ?>
                    <tr>
                        <td>
                            <?php if (!empty($row['picture'])): ?>
                                <img src="<?= htmlspecialchars($row['picture']) ?>" class="thumb" alt="Image">
                            <?php else: ?>
                                <span style="color:#aaa;">No image</span>
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= htmlspecialchars($row['style']) ?></td>
                        <td>$<?= number_format($row['price'], 2) ?></td>
                        <td class="actions">
                            <button class="edit-btn" onclick="openEditModal('<?= $category ?>', <?= htmlspecialchars(json_encode($row)) ?>)">Edit</button>
                            <form class="delete-form" action="handle_optional_pick.php?category=<?= $category ?>" method="POST" onsubmit="return confirm('Delete this option?');" style="display:inline;">
                                <input type="hidden" name="category" value="<?= $category ?>">
                                <input type="hidden" name="id" value="<?= $row[$idColumn] ?>">
                                <button type="submit" name="action" value="delete" class="delete-btn">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </div>
    <?php endforeach; ?>
</div>

<!-- Modal Template -->
<div id="optionModal" class="modal">
    <div class="modal-content">
        <span class="close-modal" onclick="closeModal()">&times;</span>
        <h3 id="modalTitle">Add Option</h3>
        <form id="optionForm" action="handle_optional_pick.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="category" id="modalCategory">
            <input type="hidden" name="id" id="modalId">
            <input type="text" name="name" id="modalName" placeholder="Name" required>
            <input type="text" name="style" id="modalStyle" placeholder="Style" required>
            <input type="number" name="price" id="modalPrice" placeholder="Price" step="0.01" required>
            <input type="file" name="picture" id="modalPicture" accept="image/*">
            <button type="submit" name="action" id="modalAction" value="add">Submit</button>
        </form>
    </div>
</div>

<script>
function showCategory(category) {
    document.querySelectorAll('.category-section').forEach(section => {
        section.style.display = 'none';
    });
    document.querySelectorAll('.category-tabs button').forEach(btn => {
        btn.classList.remove('active');
    });

    document.getElementById('section-' + category).style.display = 'block';
    document.getElementById('tab-' + category).classList.add('active');
    history.replaceState(null, '', '?category=' + category);
}

function openAddModal(category) {
    document.getElementById('optionModal').style.display = 'block';
    document.getElementById('modalTitle').textContent = 'Add ' + capitalize(category);
    document.getElementById('optionForm').reset();
    document.getElementById('modalCategory').value = category;
    document.getElementById('modalId').value = '';
    document.getElementById('modalAction').value = 'add';
    document.getElementById('optionForm').action = 'handle_optional_pick.php?category=' + category;
}

function openEditModal(category, data) {
    document.getElementById('optionModal').style.display = 'block';
    document.getElementById('modalTitle').textContent = 'Edit ' + capitalize(category);
    document.getElementById('modalCategory').value = category;
    document.getElementById('modalId').value = data[Object.keys(data)[0]];
    document.getElementById('modalName').value = data.name;
    document.getElementById('modalStyle').value = data.style;
    document.getElementById('modalPrice').value = data.price;
    document.getElementById('modalAction').value = 'edit';
    document.getElementById('optionForm').action = 'handle_optional_pick.php?category=' + category;
}

function closeModal() {
    document.getElementById('optionModal').style.display = 'none';
}

function capitalize(str) {
    return str.charAt(0).toUpperCase() + str.slice(1);
}

window.onclick = function(event) {
    const modal = document.getElementById('optionModal');
    if (event.target === modal) {
        closeModal();
    }
}

window.addEventListener('DOMContentLoaded', () => {
    const params = new URLSearchParams(window.location.search);
    const category = params.get('category') || 'music';

    document.querySelectorAll('.category-tabs button').forEach(btn => {
        btn.classList.toggle('active', btn.dataset.category === category);
    });

    document.querySelectorAll('.category-section').forEach(section => {
        section.style.display = section.dataset.category === category ? 'block' : 'none';
    });
});
</script>

<?php include('footer.php'); ?>
</body>
</html>

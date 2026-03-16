<?php
declare(strict_types = 1);
include '../includes/database-connection.php';
include '../includes/functions.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) { redirect('categories.php', ['failure' => 'Category not found']); }

$category = pdo($pdo, "SELECT name FROM category WHERE id = :id;", [$id])->fetchColumn();
if (!$category) { redirect('categories.php', ['failure' => 'Category not found']); }

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        pdo($pdo, "DELETE FROM category WHERE id = :id;", [$id]);
        redirect('categories.php', ['success' => 'Category deleted']);
    } catch (PDOException $e) {
        if ($e->errorInfo[1] === 1451) {
            redirect('categories.php', ['failure' => 'Cannot delete — category has articles. Move or delete them first.']);
        } else { throw $e; }
    }
}

$page_title  = 'Delete Category';
$breadcrumbs = ['Categories' => 'categories.php', 'Delete' => null];
?>
<?php include '../includes/admin-header.php'; ?>
  <div class="confirm-box">
    <h1>Delete Category</h1>
    <p>Are you sure you want to permanently delete:<br><strong style="color:#f0f0f0;"><?= html_escape($category) ?></strong></p>
    <form action="category-delete.php?id=<?= $id ?>" method="POST">
      <div class="confirm-actions">
        <input type="submit" value="Yes, Delete" class="btn btn-danger">
        <a href="categories.php" class="btn btn-secondary">Cancel</a>
      </div>
    </form>
  </div>
<?php include '../includes/admin-footer.php'; ?>

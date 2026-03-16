<?php
declare(strict_types = 1);
include '../includes/database-connection.php';
include '../includes/functions.php';

$success = $_GET['success'] ?? null;
$failure = $_GET['failure'] ?? null;

$categories = pdo($pdo, "SELECT id, name, description, navigation FROM category ORDER BY id ASC;")->fetchAll();

$page_title  = 'Categories';
$breadcrumbs = ['Categories' => null];
?>
<?php include '../includes/admin-header.php'; ?>
  <div class="page-header">
    <h1>Categories</h1>
    <a href="category.php" class="btn btn-primary">+ Add Category</a>
  </div>

  <?php if ($success): ?><div class="alert alert-success"><?= html_escape($success) ?></div><?php endif; ?>
  <?php if ($failure): ?><div class="alert alert-danger"><?= html_escape($failure) ?></div><?php endif; ?>

  <table class="data-table">
    <thead>
      <tr><th>Name</th><th>Description</th><th>In Navigation</th><th>Actions</th></tr>
    </thead>
    <tbody>
      <?php foreach ($categories as $cat): ?>
      <tr>
        <td><strong><?= html_escape($cat['name']) ?></strong></td>
        <td style="color:#777;font-size:0.85rem;"><?= html_escape($cat['description']) ?></td>
        <td><?= $cat['navigation'] ? '<span class="badge-yes">● YES</span>' : '<span class="badge-no">○ NO</span>' ?></td>
        <td><div class="action-btns">
          <a href="category.php?id=<?= $cat['id'] ?>" class="btn btn-primary">Edit</a>
          <a href="category-delete.php?id=<?= $cat['id'] ?>" class="btn btn-danger">Delete</a>
        </div></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
<?php include '../includes/admin-footer.php'; ?>

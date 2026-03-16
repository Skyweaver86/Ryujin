<?php
declare(strict_types = 1);
include '../includes/database-connection.php';
include '../includes/functions.php';

$success = $_GET['success'] ?? null;
$failure = $_GET['failure'] ?? null;

$articles = pdo($pdo, "SELECT a.id, a.title, a.created, a.published,
                               c.name AS category,
                               CONCAT(m.forename,' ',m.surname) AS author,
                               i.file AS image_file, i.alt AS image_alt
                        FROM article AS a
                        JOIN category AS c ON a.category_id = c.id
                        JOIN member   AS m ON a.member_id   = m.id
                        LEFT JOIN image AS i ON a.image_id  = i.id
                        ORDER BY a.id DESC;")->fetchAll();

$page_title  = 'Articles';
$breadcrumbs = ['Articles' => null];
?>
<?php include '../includes/admin-header.php'; ?>
  <div class="page-header">
    <h1>Articles</h1>
    <a href="article.php" class="btn btn-primary">+ Add Article</a>
  </div>

  <?php if ($success): ?><div class="alert alert-success"><?= html_escape($success) ?></div><?php endif; ?>
  <?php if ($failure): ?><div class="alert alert-danger"><?= html_escape($failure) ?></div><?php endif; ?>

  <table class="data-table">
    <thead>
      <tr><th>Image</th><th>Title</th><th>Category</th><th>Author</th><th>Created</th><th>Published</th><th>Actions</th></tr>
    </thead>
    <tbody>
      <?php foreach ($articles as $article): ?>
      <tr>
        <td><img src="../uploads/<?= html_escape($article['image_file'] ?? 'blank.png') ?>" alt="<?= html_escape($article['image_alt'] ?? '') ?>"></td>
        <td><strong><?= html_escape($article['title']) ?></strong></td>
        <td><?= html_escape($article['category']) ?></td>
        <td><?= html_escape($article['author']) ?></td>
        <td><?= format_date($article['created']) ?></td>
        <td><?= $article['published'] ? '<span class="badge-yes">● YES</span>' : '<span class="badge-no">○ NO</span>' ?></td>
        <td><div class="action-btns">
          <a href="article.php?id=<?= $article['id'] ?>" class="btn btn-primary">Edit</a>
          <a href="article-delete.php?id=<?= $article['id'] ?>" class="btn btn-danger">Delete</a>
        </div></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
<?php include '../includes/admin-footer.php'; ?>

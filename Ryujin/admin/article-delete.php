<?php
declare(strict_types = 1);
include '../includes/database-connection.php';
include '../includes/functions.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) { redirect('articles.php', ['failure' => 'Article not found']); }

$article = pdo($pdo, "SELECT a.title, a.image_id, i.file AS image_file
                       FROM article AS a LEFT JOIN image AS i ON a.image_id = i.id
                       WHERE a.id = :id;", [$id])->fetch();
if (!$article) { redirect('articles.php', ['failure' => 'Article not found']); }

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $pdo->beginTransaction();
        if ($article['image_id']) {
            pdo($pdo, "UPDATE article SET image_id = null WHERE id = :article_id;", [$id]);
            pdo($pdo, "DELETE FROM image WHERE id = :id;", [$article['image_id']]);
            $path = '../uploads/' . $article['image_file'];
            if (file_exists($path)) { unlink($path); }
        }
        pdo($pdo, "DELETE FROM article WHERE id = :id;", [$id]);
        $pdo->commit();
        redirect('articles.php', ['success' => 'Article deleted']);
    } catch (PDOException $e) {
        $pdo->rollBack();
        throw $e;
    }
}

$page_title  = 'Delete Article';
$breadcrumbs = ['Articles' => 'articles.php', 'Delete' => null];
?>
<?php include '../includes/admin-header.php'; ?>
  <div class="confirm-box">
    <h1>Delete Article</h1>
    <p>Are you sure you want to permanently delete:<br><strong style="color:#f0f0f0;"><?= html_escape($article['title']) ?></strong></p>
    <form action="article-delete.php?id=<?= $id ?>" method="POST">
      <div class="confirm-actions">
        <input type="submit" value="Yes, Delete" class="btn btn-danger">
        <a href="articles.php" class="btn btn-secondary">Cancel</a>
      </div>
    </form>
  </div>
<?php include '../includes/admin-footer.php'; ?>

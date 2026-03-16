<?php
declare(strict_types = 1);
require '../includes/database-connection.php';
require '../includes/functions.php';

$article_count   = pdo($pdo, "SELECT COUNT(id) FROM article")->fetchColumn();
$category_count  = pdo($pdo, "SELECT COUNT(id) FROM category")->fetchColumn();
$published_count = pdo($pdo, "SELECT COUNT(id) FROM article WHERE published = 1")->fetchColumn();
$member_count    = pdo($pdo, "SELECT COUNT(id) FROM member")->fetchColumn();

$recent = pdo($pdo, "SELECT a.id, a.title, a.created, a.published,
                             c.id AS category_id, c.name AS category
                      FROM article AS a
                      JOIN category AS c ON a.category_id = c.id
                      ORDER BY a.id DESC LIMIT 5;")->fetchAll();

$categories = pdo($pdo, "SELECT id, name, description FROM category ORDER BY id ASC;")->fetchAll();

$page_title  = 'Dashboard';
$breadcrumbs = [];
?>
<?php include '../includes/admin-header.php'; ?>

  <div class="page-header">
    <h1>Dashboard</h1>
    <a href="article.php" class="btn btn-primary">+ New Article</a>
  </div>

  <!-- STATS -->
  <div class="stats-grid">
    <div class="stat-card">
      <div class="stat-label">TOTAL ARTICLES</div>
      <div class="stat-value"><?= $article_count ?></div>
    </div>
    <div class="stat-card">
      <div class="stat-label">PUBLISHED</div>
      <div class="stat-value"><?= $published_count ?></div>
    </div>
    <div class="stat-card">
      <div class="stat-label">CATEGORIES</div>
      <div class="stat-value"><?= $category_count ?></div>
    </div>
    <div class="stat-card">
      <div class="stat-label">MEMBERS</div>
      <div class="stat-value"><?= $member_count ?></div>
    </div>
  </div>

  <!-- BROWSE CATEGORIES -->
  <div class="page-header" style="margin-top:8px;">
    <h1 style="font-size:1.3rem;color:#555;letter-spacing:0.12em;">BROWSE BY CATEGORY</h1>
    <a href="categories.php" class="btn btn-secondary">Manage →</a>
  </div>

  <div class="category-cards">
    <?php foreach ($categories as $cat): ?>
      <a href="../category.php?id=<?= $cat['id'] ?>" class="category-card" target="_blank">
        <div class="category-card-name"><?= html_escape($cat['name']) ?></div>
        <div class="category-card-desc"><?= html_escape($cat['description']) ?></div>
        <div class="category-card-link">View on site →</div>
      </a>
    <?php endforeach; ?>
  </div>

  <!-- RECENT ARTICLES -->
  <div class="page-header" style="margin-top:32px;">
    <h1 style="font-size:1.3rem;color:#555;letter-spacing:0.12em;">RECENT ARTICLES</h1>
    <a href="articles.php" class="btn btn-secondary">View All →</a>
  </div>

  <table class="data-table">
    <thead>
      <tr>
        <th>Title</th>
        <th>Category</th>
        <th>Created</th>
        <th>Published</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($recent as $row): ?>
      <tr>
        <td><strong><?= html_escape($row['title']) ?></strong></td>
        <td>
          <a href="../category.php?id=<?= $row['category_id'] ?>" target="_blank"
             style="color:var(--red);transition:opacity 0.2s;" onmouseover="this.style.opacity=0.7" onmouseout="this.style.opacity=1">
            <?= html_escape($row['category']) ?>
          </a>
        </td>
        <td><?= format_date($row['created']) ?></td>
        <td><?= $row['published'] ? '<span class="badge-yes">● YES</span>' : '<span class="badge-no">○ NO</span>' ?></td>
        <td>
          <div class="action-btns">
            <a href="article.php?id=<?= $row['id'] ?>" class="btn btn-primary">Edit</a>
            <a href="article-delete.php?id=<?= $row['id'] ?>" class="btn btn-danger">Delete</a>
          </div>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <style>
    .category-cards {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
      gap: 16px;
      margin-bottom: 8px;
    }

    .category-card {
      display: block;
      background: var(--card, #161616);
      border: 1px solid var(--border, #242424);
      border-radius: 4px;
      padding: 20px 22px;
      text-decoration: none;
      transition: border-color 0.2s, transform 0.2s;
    }

    .category-card:hover {
      border-color: var(--red, #e8001d);
      transform: translateY(-3px);
    }

    .category-card-name {
      font-family: 'Bebas Neue', sans-serif;
      font-size: 1.4rem;
      letter-spacing: 0.1em;
      color: #f0f0f0;
      margin-bottom: 6px;
    }

    .category-card:hover .category-card-name {
      color: var(--red, #e8001d);
    }

    .category-card-desc {
      font-size: 0.78rem;
      color: #666;
      line-height: 1.5;
      margin-bottom: 14px;
    }

    .category-card-link {
      font-family: 'Bebas Neue', sans-serif;
      font-size: 0.75rem;
      letter-spacing: 0.15em;
      color: var(--red, #e8001d);
    }
  </style>

<?php include '../includes/admin-footer.php'; ?>
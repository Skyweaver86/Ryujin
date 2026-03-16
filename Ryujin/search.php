<?php
declare(strict_types = 1);
require 'includes/database-connection.php';              // Create PDO object
require 'includes/functions.php';                        // Include functions

$search = trim(filter_input(INPUT_GET, 'search', FILTER_DEFAULT) ?? ''); // Get search term

$sql = "SELECT a.id, a.title, a.summary, a.category_id, a.member_id,
               c.name AS category,
               CONCAT(m.forename, ' ', m.surname) AS author,
               i.file AS image_file,
               i.alt  AS image_alt
        FROM article   AS a
        JOIN category  AS c ON a.category_id = c.id
        JOIN member    AS m ON a.member_id   = m.id
        LEFT JOIN image AS i ON a.image_id   = i.id
        WHERE a.published = 1
          AND (a.title LIKE :search1 OR a.summary LIKE :search2 OR a.content LIKE :search3)
        ORDER BY a.id DESC;";                            // SQL to search articles
$term      = '%' . $search . '%';
$arguments = ['search1' => $term, 'search2' => $term, 'search3' => $term];
$articles  = pdo($pdo, $sql, $arguments)->fetchAll();   // Get results

$sql        = "SELECT id, name FROM category WHERE navigation = 1;"; // SQL to get categories
$navigation = pdo($pdo, $sql)->fetchAll();               // Get navigation categories
$section    = '';                                        // Current category
$title      = 'Search Ryujin';                          // HTML <title> content
$description = 'Search for sports cars, bikes, and F1 articles on Ryujin.'; // Meta description
?>
<?php include 'includes/header.php'; ?>
  <main class="container" id="content">
    <section class="header">
      <form action="search.php" method="get">
        <input type="text" name="search" value="<?= html_escape($search) ?>" placeholder="Enter search term">
        <input type="submit" value="SEARCH">
      </form>
    </section>
    <?php if ($search) { ?>
      <section class="grid">
        <?php if (count($articles) === 0) { ?>
          <p>No results found for "<?= html_escape($search) ?>".</p>
        <?php } else { ?>
          <?php foreach ($articles as $article) { ?>
            <article class="summary">
              <a href="article.php?id=<?= $article['id'] ?>">
                <img src="uploads/<?= html_escape($article['image_file'] ?? 'blank.png') ?>"
                     alt="<?= html_escape($article['image_alt']) ?>">
                <h2><?= html_escape($article['title']) ?></h2>
                <p><?= html_escape($article['summary']) ?></p>
              </a>
              <p class="credit">
                Posted in <a href="category.php?id=<?= $article['category_id'] ?>">
                  <?= html_escape($article['category']) ?></a>
                by <a href="member.php?id=<?= $article['member_id'] ?>">
                  <?= html_escape($article['author']) ?></a>
              </p>
            </article>
          <?php } ?>
        <?php } ?>
      </section>
    <?php } ?>
  </main>
<?php include 'includes/footer.php'; ?>
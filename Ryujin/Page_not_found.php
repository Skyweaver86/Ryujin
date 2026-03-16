<?php
declare(strict_types = 1);
http_response_code(404);

// Only load DB + functions if not already loaded
if (!isset($pdo)) {
    require 'includes/database-connection.php';
}
if (!function_exists('html_escape')) {
    require 'includes/functions.php';
}

$sql        = "SELECT id, name FROM category WHERE navigation = 1;";
$navigation = pdo($pdo, $sql)->fetchAll();
$section    = '';
$title      = 'Page Not Found';
$description = '';

include 'includes/header.php';
?>
  <main class="container" id="content">
    <section class="header">
      <h1>Page Not Found</h1>
      <p>Sorry, we couldn't find what you were looking for.</p>
    </section>
    <p style="padding: 0 0 24px 20px;">
      Go back to the <a href="index.php" style="color:var(--red);">home page</a> or
      email us at <a href="mailto:hello@ryujin.link" style="color:var(--red);">hello@ryujin.link</a>
    </p>
  </main>
<?php
include 'includes/footer.php';
exit;
?>

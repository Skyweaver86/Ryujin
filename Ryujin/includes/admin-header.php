<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ryujin Admin <?= isset($page_title) ? '— ' . html_escape($page_title) : '' ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Barlow:ital,wght@0,300;0,400;0,600;1,300&display=swap" rel="stylesheet">
    <style>
      *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
      :root {
        --red:    #e8001d;
        --dark:   #0a0a0a;
        --mid:    #111111;
        --card:   #161616;
        --border: #242424;
        --text:   #f0f0f0;
        --muted:  #777;
        --font-display: 'Bebas Neue', sans-serif;
        --font-body:    'Barlow', sans-serif;
      }
      body { background:var(--dark); color:var(--text); font-family:var(--font-body); font-weight:300; line-height:1.6; min-height:100vh; display:flex; flex-direction:column; }
      a { color:inherit; text-decoration:none; }

      /* TOP HEADER */
      header { background:var(--mid); border-bottom:1px solid var(--border); position:sticky; top:0; z-index:100; }
      .header-inner { max-width:1300px; margin:0 auto; padding:0 28px; display:flex; align-items:center; gap:24px; height:60px; }
      .logo { font-family:var(--font-display); font-size:1.8rem; letter-spacing:0.1em; color:var(--text); flex-shrink:0; }
      .logo span { color:var(--red); }
      .admin-badge { font-family:var(--font-display); font-size:0.68rem; letter-spacing:0.2em; color:var(--red); background:rgba(232,0,29,0.08); border:1px solid rgba(232,0,29,0.25); padding:3px 10px; border-radius:2px; }
      .header-nav { display:flex; align-items:center; gap:2px; flex:1; }
      .header-nav a { font-family:var(--font-display); font-size:0.88rem; letter-spacing:0.1em; color:var(--muted); padding:6px 14px; border-radius:2px; transition:color 0.2s,background 0.2s; }
      .header-nav a:hover, .header-nav a.active { color:var(--text); background:var(--border); }
      .header-nav a.active { color:var(--red); background:rgba(232,0,29,0.06); }
      .view-site { margin-left:auto; font-family:var(--font-display); font-size:0.82rem; letter-spacing:0.1em; color:var(--muted); border:1px solid var(--border); padding:5px 14px; border-radius:2px; transition:color 0.2s,border-color 0.2s; white-space:nowrap; }
      .view-site:hover { color:var(--red); border-color:var(--red); }

      /* BREADCRUMB */
      .breadcrumb-bar { background:var(--mid); border-bottom:1px solid var(--border); padding:9px 28px; }
      .breadcrumb-inner { max-width:1300px; margin:0 auto; display:flex; align-items:center; gap:8px; font-size:0.8rem; color:var(--muted); }
      .breadcrumb-inner a { color:var(--muted); transition:color 0.2s; }
      .breadcrumb-inner a:hover { color:var(--red); }
      .breadcrumb-inner .sep { color:var(--border); }
      .breadcrumb-inner .current { color:var(--text); }

      /* LAYOUT */
      .admin-layout { display:flex; flex:1; max-width:1300px; margin:0 auto; width:100%; padding:0 28px; gap:32px; }

      /* SIDEBAR */
      .sidebar { width:210px; flex-shrink:0; padding:24px 0; }
      .sidebar-section { margin-bottom:24px; }
      .sidebar-label { font-family:var(--font-display); font-size:0.65rem; letter-spacing:0.25em; color:var(--muted); padding:0 10px; margin-bottom:4px; }
      .sidebar a { display:flex; align-items:center; gap:9px; font-size:0.86rem; color:var(--muted); padding:8px 10px; border-radius:3px; transition:color 0.2s,background 0.2s; border-left:2px solid transparent; margin-bottom:1px; }
      .sidebar a:hover { color:var(--text); background:var(--card); }
      .sidebar a.active { color:var(--red); background:rgba(232,0,29,0.06); border-left-color:var(--red); }
      .sidebar .icon { font-size:0.95rem; opacity:0.75; }

      /* MAIN */
      .admin-main { flex:1; padding:28px 0; min-width:0; }

      /* PAGE HEADER */
      .page-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:24px; padding-bottom:16px; border-bottom:1px solid var(--border); }
      .page-header h1 { font-family:var(--font-display); font-size:2.2rem; letter-spacing:0.06em; line-height:1; }

      /* STATS */
      .stats-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(170px,1fr)); gap:14px; margin-bottom:32px; }
      .stat-card { background:var(--card); border:1px solid var(--border); border-radius:4px; padding:20px; transition:border-color 0.2s,transform 0.2s; }
      .stat-card:hover { border-color:var(--red); transform:translateY(-2px); }
      .stat-label { font-family:var(--font-display); font-size:0.68rem; letter-spacing:0.2em; color:var(--muted); margin-bottom:8px; }
      .stat-value { font-family:var(--font-display); font-size:2.8rem; color:var(--red); line-height:1; }

      /* ALERTS */
      .alert { padding:11px 16px; border-radius:3px; margin-bottom:20px; font-size:0.86rem; }
      .alert-success { background:rgba(0,200,80,0.07); border:1px solid rgba(0,200,80,0.2); color:#2ecc71; }
      .alert-danger  { background:rgba(232,0,29,0.07); border:1px solid rgba(232,0,29,0.2); color:#ff4455; }

      /* BUTTONS */
      .btn { display:inline-block; font-family:var(--font-display); font-size:0.8rem; letter-spacing:0.1em; padding:7px 16px; border-radius:2px; border:none; cursor:pointer; transition:opacity 0.2s,background 0.2s; text-decoration:none; white-space:nowrap; }
      .btn:hover { opacity:0.85; }
      .btn-primary { background:var(--red); color:#fff; }
      .btn-secondary { background:var(--card); color:var(--text); border:1px solid var(--border); }
      .btn-danger { background:#1a1010; color:#ff4455; border:1px solid #3a1515; }
      .btn-danger:hover { background:#ff4455; color:#fff; opacity:1; }
      .btn-save { margin-top:16px; }

      /* DATA TABLE */
      .data-table { width:100%; border-collapse:collapse; font-size:0.87rem; }
      .data-table th { background:var(--card); border-bottom:2px solid var(--red); padding:11px 14px; text-align:left; font-family:var(--font-display); font-size:0.75rem; letter-spacing:0.12em; color:var(--muted); white-space:nowrap; }
      .data-table td { padding:11px 14px; border-bottom:1px solid var(--border); vertical-align:middle; }
      .data-table tr:hover td { background:var(--card); }
      .data-table img { width:80px; height:50px; object-fit:cover; border-radius:2px; display:block; border:1px solid var(--border); }
      .action-btns { display:flex; gap:6px; }
      .badge-yes { color:#2ecc71; font-size:0.78rem; font-weight:600; }
      .badge-no  { color:var(--muted); font-size:0.78rem; }

      /* FORMS */
      .form-wrap { max-width:580px; }
      .form-group { margin-bottom:20px; }
      .form-group label { display:block; font-family:var(--font-display); font-size:0.75rem; letter-spacing:0.12em; color:var(--muted); margin-bottom:7px; }
      .form-control { width:100%; background:var(--card); border:1px solid var(--border); color:var(--text); font-family:var(--font-body); font-size:0.9rem; padding:10px 14px; border-radius:3px; outline:none; transition:border-color 0.2s; }
      .form-control:focus { border-color:var(--red); }
      textarea.form-control { min-height:110px; resize:vertical; }
      select, select.form-control { width:100%; background:var(--card); border:1px solid var(--border); color:var(--text); font-family:var(--font-body); font-size:0.9rem; padding:10px 14px; border-radius:3px; outline:none; cursor:pointer; }
      select:focus { border-color:var(--red); }
      .form-check { display:flex; align-items:center; gap:10px; margin-bottom:20px; }
      .form-check-input { accent-color:var(--red); width:16px; height:16px; cursor:pointer; }
      .form-check-label { font-size:0.88rem; cursor:pointer; }
      .form-control-file { color:var(--muted); font-size:0.86rem; }
      .errors { color:#ff4455; font-size:0.76rem; margin-top:5px; display:block; }
      .image-placeholder { border:2px dashed var(--border); border-radius:4px; padding:20px; margin-bottom:12px; }
      .alt { font-size:0.78rem; color:var(--muted); margin:8px 0 12px; }

      /* ADMIN ARTICLE TWO-COL */
      .admin-article-grid { display:grid; grid-template-columns:300px 1fr; gap:36px; align-items:start; }
      .admin-article-grid .image img { width:100%; border-radius:4px; border:1px solid var(--border); margin-bottom:12px; }

      /* DELETE CONFIRM */
      .confirm-box { background:var(--card); border:1px solid var(--border); border-radius:4px; padding:32px; max-width:480px; }
      .confirm-box h1 { font-size:1.8rem; margin-bottom:12px; }
      .confirm-box p { color:var(--muted); margin-bottom:24px; font-size:0.9rem; }
      .confirm-actions { display:flex; gap:12px; }

      @media (max-width:900px) {
        .sidebar { display:none; }
        .admin-article-grid { grid-template-columns:1fr; }
        .stats-grid { grid-template-columns:repeat(2,1fr); }
      }
    </style>
  </head>
  <body>

    <header>
      <div class="header-inner">
        <a href="../index.php" class="logo">RYU<span>JIN</span></a>
        <span class="admin-badge">ADMIN</span>
        <nav class="header-nav">
          <a href="index.php" <?= basename($_SERVER['PHP_SELF'])=='index.php' ? 'class="active"' : '' ?>>Dashboard</a>
          <a href="articles.php" <?= in_array(basename($_SERVER['PHP_SELF']),['articles.php','article.php','article-delete.php','image-delete.php','alt-text-edit.php']) ? 'class="active"' : '' ?>>Articles</a>
          <a href="categories.php" <?= in_array(basename($_SERVER['PHP_SELF']),['categories.php','category.php','category-delete.php']) ? 'class="active"' : '' ?>>Categories</a>
        </nav>
        <a href="../index.php" class="view-site">← View Site</a>
      </div>
    </header>

    <?php if (!empty($breadcrumbs)): ?>
    <div class="breadcrumb-bar">
      <div class="breadcrumb-inner">
        <a href="index.php">Admin</a>
        <?php foreach ($breadcrumbs as $label => $url): ?>
          <span class="sep">/</span>
          <?php if ($url): ?>
            <a href="<?= $url ?>"><?= html_escape($label) ?></a>
          <?php else: ?>
            <span class="current"><?= html_escape($label) ?></span>
          <?php endif; ?>
        <?php endforeach; ?>
      </div>
    </div>
    <?php endif; ?>

    <div class="admin-layout">
      <aside class="sidebar">
        <div class="sidebar-section">
          <div class="sidebar-label">CONTENT</div>
          <a href="articles.php" <?= in_array(basename($_SERVER['PHP_SELF']),['articles.php','article.php','article-delete.php']) ? 'class="active"' : '' ?>>
            <span class="icon">📄</span> Articles
          </a>
          <a href="article.php" <?= basename($_SERVER['PHP_SELF'])=='article.php' && empty($_GET['id']) ? 'class="active"' : '' ?>>
            <span class="icon">✏️</span> Add Article
          </a>
        </div>
        <div class="sidebar-section">
          <div class="sidebar-label">MANAGE</div>
          <a href="categories.php" <?= in_array(basename($_SERVER['PHP_SELF']),['categories.php','category.php','category-delete.php']) ? 'class="active"' : '' ?>>
            <span class="icon">🏷️</span> Categories
          </a>
          <a href="category.php" <?= basename($_SERVER['PHP_SELF'])=='category.php' && empty($_GET['id']) ? 'class="active"' : '' ?>>
            <span class="icon">➕</span> Add Category
          </a>
        </div>
        <div class="sidebar-section">
          <div class="sidebar-label">SITE</div>
          <a href="../index.php"><span class="icon">🏠</span> Home</a>
          <a href="../search.php"><span class="icon">🔍</span> Search</a>
        </div>
      </aside>

      <main class="admin-main">

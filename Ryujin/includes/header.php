<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= html_escape($description ?? '') ?>">
    <title><?= html_escape($title ?? 'Ryujin') ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Barlow:ital,wght@0,300;0,400;0,600;1,300&display=swap" rel="stylesheet">
    <style>
      *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

      :root {
        --red:    #e8001d;
        --dark:   #0a0a0a;
        --mid:    #141414;
        --card:   #1a1a1a;
        --border: #2a2a2a;
        --text:   #f0f0f0;
        --muted:  #888;
        --font-display: 'Bebas Neue', sans-serif;
        --font-body:    'Barlow', sans-serif;
      }

      html { scroll-behavior: smooth; }

      body {
        background: var(--dark);
        color: var(--text);
        font-family: var(--font-body);
        font-weight: 300;
        line-height: 1.6;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
      }

      a { color: inherit; text-decoration: none; }

      /* ── HEADER ── */
      header {
        background: var(--mid);
        border-bottom: 1px solid var(--border);
        position: sticky;
        top: 0;
        z-index: 100;
      }

      .header-inner {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 24px;
        display: flex;
        align-items: center;
        gap: 40px;
        height: 64px;
      }

      .logo {
        font-family: var(--font-display);
        font-size: 2rem;
        letter-spacing: 0.1em;
        color: var(--text);
        flex-shrink: 0;
      }

      .logo span {
        color: var(--red);
      }

      nav {
        display: flex;
        align-items: center;
        gap: 4px;
        flex: 1;
      }

      nav a {
        font-family: var(--font-display);
        font-size: 0.95rem;
        letter-spacing: 0.12em;
        color: var(--muted);
        padding: 6px 14px;
        border-radius: 2px;
        transition: color 0.2s, background 0.2s;
        white-space: nowrap;
      }

      nav a:hover,
      nav a.active {
        color: var(--text);
        background: var(--border);
      }

      nav a.active {
        color: var(--red);
        background: rgba(232, 0, 29, 0.08);
      }

      .search-form {
        display: flex;
        align-items: center;
        gap: 0;
        margin-left: auto;
      }

      .search-form input[type="text"] {
        background: var(--dark);
        border: 1px solid var(--border);
        border-right: none;
        color: var(--text);
        font-family: var(--font-body);
        font-size: 0.85rem;
        padding: 7px 14px;
        outline: none;
        width: 180px;
        transition: border-color 0.2s, width 0.3s;
        border-radius: 2px 0 0 2px;
      }

      .search-form input[type="text"]:focus {
        border-color: var(--red);
        width: 220px;
      }

      .search-form input[type="submit"] {
        background: var(--red);
        border: 1px solid var(--red);
        color: #fff;
        font-family: var(--font-display);
        font-size: 0.85rem;
        letter-spacing: 0.1em;
        padding: 7px 14px;
        cursor: pointer;
        transition: background 0.2s;
        border-radius: 0 2px 2px 0;
      }

      .search-form input[type="submit"]:hover {
        background: #c0001a;
      }

      /* ── CONTAINER ── */
      .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 40px 24px;
        flex: 1;
      }

      /* ── GRID (article cards) ── */
      .grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
        gap: 24px;
        margin-top: 32px;
      }

      .summary {
        background: var(--card);
        border: 1px solid var(--border);
        border-radius: 4px;
        overflow: hidden;
        transition: transform 0.25s, border-color 0.25s;
      }

      .summary:hover {
        transform: translateY(-4px);
        border-color: var(--red);
      }

      .summary > a {
        display: block;
      }

      .summary img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        display: block;
        transition: opacity 0.3s;
      }

      .summary:hover img { opacity: 0.9; }

      .summary h2 {
        font-family: var(--font-display);
        font-size: 1.35rem;
        letter-spacing: 0.05em;
        padding: 16px 16px 6px;
        line-height: 1.2;
      }

      .summary p {
        font-size: 0.9rem;
        color: var(--muted);
        padding: 0 16px 16px;
        line-height: 1.5;
      }

      .credit {
        font-size: 0.78rem !important;
        color: var(--muted) !important;
        padding: 10px 16px 14px !important;
        border-top: 1px solid var(--border);
      }

      .credit a {
        color: var(--red);
        transition: opacity 0.2s;
      }

      .credit a:hover { opacity: 0.8; }

      /* ── SECTION HEADER ── */
      .header {
        border-left: 4px solid var(--red);
        padding-left: 20px;
        margin-bottom: 24px;
        padding-bottom: 8px;
      }

      .header h1 {
        font-family: var(--font-display);
        font-size: 2.8rem;
        letter-spacing: 0.06em;
        line-height: 1.1;
      }

      .header p {
        color: var(--muted);
        font-size: 0.95rem;
        margin-top: 6px;
      }

      /* ── ARTICLE PAGE ── */
      .article {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 48px;
        align-items: start;
      }

      .article .image img {
        width: 100%;
        border-radius: 4px;
        border: 1px solid var(--border);
      }

      .article .text h1 {
        font-family: var(--font-display);
        font-size: 2.8rem;
        letter-spacing: 0.05em;
        line-height: 1.1;
        margin-bottom: 12px;
      }

      .article .date {
        font-size: 0.8rem;
        color: var(--red);
        letter-spacing: 0.15em;
        text-transform: uppercase;
        margin-bottom: 20px;
        font-weight: 600;
      }

      .article .content {
        font-size: 0.95rem;
        line-height: 1.8;
        color: #ccc;
        margin-bottom: 24px;
      }

      .article .credit {
        border: none !important;
        padding: 0 !important;
        font-size: 0.85rem !important;
      }

      /* ── MEMBER PAGE ── */
      .profile {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid var(--red);
        margin-top: 16px;
      }

      .member {
        font-size: 0.85rem;
        color: var(--muted);
        margin-top: 8px;
      }

      /* ── SEARCH PAGE ── */
      .header form {
        display: flex;
        gap: 0;
        margin-top: 16px;
      }

      .header form input[type="text"] {
        background: var(--card);
        border: 1px solid var(--border);
        border-right: none;
        color: var(--text);
        font-family: var(--font-body);
        font-size: 1rem;
        padding: 10px 18px;
        outline: none;
        width: 340px;
        border-radius: 2px 0 0 2px;
        transition: border-color 0.2s;
      }

      .header form input[type="text"]:focus {
        border-color: var(--red);
      }

      .header form input[type="submit"] {
        background: var(--red);
        border: 1px solid var(--red);
        color: #fff;
        font-family: var(--font-display);
        font-size: 1rem;
        letter-spacing: 0.12em;
        padding: 10px 24px;
        cursor: pointer;
        border-radius: 0 2px 2px 0;
        transition: background 0.2s;
      }

      .header form input[type="submit"]:hover { background: #c0001a; }

      /* ── 404 / ERROR ── */
      main h1 { font-family: var(--font-display); font-size: 2.4rem; letter-spacing: 0.05em; margin-bottom: 12px; }
      main p  { color: var(--muted); margin-bottom: 8px; }
      main a  { color: var(--red); }
      main a:hover { text-decoration: underline; }

      /* ── ARTICLE NO IMAGE ── */
      .article-no-image {
        max-width: 780px;
        margin: 0 auto;
        padding: 12px 0;
      }

      .article-no-image h1 {
        font-family: var(--font-display);
        font-size: 2.8rem;
        letter-spacing: 0.05em;
        line-height: 1.1;
        margin-bottom: 12px;
      }

      .article-no-image .date {
        font-size: 0.8rem;
        color: var(--red);
        letter-spacing: 0.15em;
        text-transform: uppercase;
        margin-bottom: 20px;
        font-weight: 600;
      }

      .article-no-image .content {
        font-size: 0.95rem;
        line-height: 1.8;
        color: #ccc;
        margin-bottom: 24px;
      }

      .article-no-image .credit {
        border: none !important;
        padding: 0 !important;
        font-size: 0.85rem !important;
      }

      /* ── RESPONSIVE ── */
      @media (max-width: 768px) {
        .header-inner { gap: 16px; }
        .search-form  { display: none; }
        nav a         { font-size: 0.8rem; padding: 6px 8px; }
        .article      { grid-template-columns: 1fr; }
        .grid         { grid-template-columns: 1fr; }
        .article .text h1 { font-size: 2rem; }
      }
    </style>
  </head>
  <body>
    <header>
      <div class="header-inner">
        <a href="index.php" class="logo">RYU<span>JIN</span></a>
        <nav>
          <?php foreach ($navigation as $nav) { ?>
            <a href="category.php?id=<?= $nav['id'] ?>"
               <?= (isset($section) && $section == $nav['id']) ? 'class="active"' : '' ?>>
              <?= html_escape($nav['name']) ?>
            </a>
          <?php } ?>
        </nav>
        <form class="search-form" action="search.php" method="get">
          <input type="text" name="search" placeholder="Search articles…">
          <input type="submit" value="GO">
        </form>
      </div>
    </header>
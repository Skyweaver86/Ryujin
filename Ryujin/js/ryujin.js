/* ============================================================
   RYUJIN — scripts.js
   Features:
   - Custom red cursor with hover expand
   - Scroll progress bar
   - Scroll-reveal for cards
   - Header shrink on scroll
   - Tilt effect on cards
   - Speedometer-style page load counter
   ============================================================ */

(function () {
  'use strict';

  /* ── 1. CUSTOM CURSOR ──────────────────────────────────── */
  const dot  = document.getElementById('cursor-dot');
  const ring = document.getElementById('cursor-ring');

  if (dot && ring && window.matchMedia('(pointer: fine)').matches) {
    let mouseX = 0, mouseY = 0;
    let ringX  = 0, ringY  = 0;
    let raf;

    document.addEventListener('mousemove', (e) => {
      mouseX = e.clientX;
      mouseY = e.clientY;

      // dot snaps instantly
      dot.style.left = mouseX + 'px';
      dot.style.top  = mouseY + 'px';
    });

    // ring follows with smooth lag
    function animateCursor() {
      ringX += (mouseX - ringX) * 0.14;
      ringY += (mouseY - ringY) * 0.14;
      ring.style.left = ringX + 'px';
      ring.style.top  = ringY + 'px';
      raf = requestAnimationFrame(animateCursor);
    }
    animateCursor();

    // expand ring on hoverable elements
    const hoverTargets = 'a, button, input[type="submit"], .summary, nav a, .logo';
    document.querySelectorAll(hoverTargets).forEach(el => {
      el.addEventListener('mouseenter', () => document.body.classList.add('cursor-hover'));
      el.addEventListener('mouseleave', () => document.body.classList.remove('cursor-hover'));
    });

    // hide cursor when leaving window
    document.addEventListener('mouseleave', () => {
      dot.style.opacity  = '0';
      ring.style.opacity = '0';
    });
    document.addEventListener('mouseenter', () => {
      dot.style.opacity  = '1';
      ring.style.opacity = '1';
    });
  }

  /* ── 2. SCROLL PROGRESS BAR ────────────────────────────── */
  const progressBar = document.getElementById('progress-bar');

  if (progressBar) {
    function updateProgress() {
      const scrollTop    = window.scrollY;
      const docHeight    = document.documentElement.scrollHeight - window.innerHeight;
      const pct          = docHeight > 0 ? (scrollTop / docHeight) * 100 : 0;
      progressBar.style.width = pct + '%';
    }
    window.addEventListener('scroll', updateProgress, { passive: true });
    updateProgress();
  }

  /* ── 3. HEADER SHRINK ON SCROLL ────────────────────────── */
  const header = document.querySelector('header');

  if (header) {
    window.addEventListener('scroll', () => {
      if (window.scrollY > 60) {
        header.style.background = 'rgba(8, 8, 8, 0.98)';
      } else {
        header.style.background = 'rgba(8, 8, 8, 0.92)';
      }
    }, { passive: true });
  }

  /* ── 4. SCROLL REVEAL ──────────────────────────────────── */
  const revealEls = document.querySelectorAll('.summary, .article, .header');

  if ('IntersectionObserver' in window && revealEls.length) {
    // override CSS animation so we control it with IntersectionObserver
    revealEls.forEach(el => {
      el.style.opacity   = '0';
      el.style.transform = 'translateY(24px)';
      el.style.transition = 'opacity 0.55s ease, transform 0.55s ease';
      el.style.animationName = 'none'; // cancel CSS animation
    });

    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.style.opacity   = '1';
          entry.target.style.transform = 'translateY(0)';
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: 0.08, rootMargin: '0px 0px -40px 0px' });

    revealEls.forEach((el, i) => {
      setTimeout(() => observer.observe(el), i * 40);
    });
  }

  /* ── 5. CARD TILT EFFECT ───────────────────────────────── */
  document.querySelectorAll('.summary').forEach(card => {
    card.addEventListener('mousemove', (e) => {
      const rect   = card.getBoundingClientRect();
      const x      = (e.clientX - rect.left) / rect.width  - 0.5;
      const y      = (e.clientY - rect.top)  / rect.height - 0.5;
      const tiltX  = y * 6;   // degrees
      const tiltY  = -x * 6;
      card.style.transform = `translateY(-5px) rotateX(${tiltX}deg) rotateY(${tiltY}deg)`;
      card.style.transformOrigin = 'center';
    });

    card.addEventListener('mouseleave', () => {
      card.style.transform = '';
    });
  });

  /* ── 6. SEARCH INPUT — live char counter hint ──────────── */
  const searchInputs = document.querySelectorAll('input[name="search"]');
  searchInputs.forEach(input => {
    input.addEventListener('keydown', (e) => {
      if (e.key === 'Enter') {
        e.preventDefault();
        input.closest('form').submit();
      }
    });
  });

  /* ── 7. IMAGE LAZY LOADING (for older browsers) ─────────── */
  if ('loading' in HTMLImageElement.prototype) {
    document.querySelectorAll('img').forEach(img => {
      img.loading = 'lazy';
    });
  }

  /* ── 8. ACTIVE NAV HIGHLIGHT ────────────────────────────── */
  // Highlight home link when on index
  const path = window.location.pathname;
  if (path.endsWith('index.php') || path === '/' || path.endsWith('/')) {
    document.querySelector('.logo')?.classList.add('active');
  }

  /* ── 9. SMOOTH ANCHOR LINKS ─────────────────────────────── */
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', (e) => {
      const target = document.querySelector(anchor.getAttribute('href'));
      if (target) {
        e.preventDefault();
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    });
  });

  /* ── 10. RED GLOW ON ARTICLE IMAGE HOVER ────────────────── */
  const articleImg = document.querySelector('.article .image img');
  if (articleImg) {
    articleImg.addEventListener('mouseenter', () => {
      articleImg.style.boxShadow = '0 0 40px rgba(232,0,29,0.3)';
    });
    articleImg.addEventListener('mouseleave', () => {
      articleImg.style.boxShadow = '';
    });
  }

})();

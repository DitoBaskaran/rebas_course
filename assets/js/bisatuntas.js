/**
 * BISATUNTAS — Main JavaScript v3.0 (2026)
 * Bento Morph Admin + Dark Mode + Command Palette
 */
(function() {
  'use strict';

  function init() {

    /* ---- Lucide Icons ---- */
    if (typeof lucide !== 'undefined') {
      lucide.createIcons();
    }

    /* ---- Dark Mode ---- */
    var themeToggle = document.getElementById('themeToggle');
    var html = document.documentElement;
    var savedTheme = localStorage.getItem('bisatuntas-theme');
    if (savedTheme === 'dark') {
      html.setAttribute('data-theme', 'dark');
    }
    if (themeToggle) {
      themeToggle.addEventListener('click', function() {
        var isDark = html.getAttribute('data-theme') === 'dark';
        if (isDark) {
          html.removeAttribute('data-theme');
          localStorage.setItem('bisatuntas-theme', 'light');
        } else {
          html.setAttribute('data-theme', 'dark');
          localStorage.setItem('bisatuntas-theme', 'dark');
        }
        if (typeof lucide !== 'undefined') {
          lucide.createIcons();
        }
        setTimeout(function() {
          if (typeof lucide !== 'undefined') {
            lucide.createIcons();
          }
        }, 50);
      });
    }

    /* ---- Sidebar Collapse ---- */
    var sidebar = document.getElementById('adminSidebar');
    var sidebarToggle = document.getElementById('sidebarToggle');
    var sidebarCollapseBtn = document.querySelector('.sidebar-collapse-btn');
    var sidebarCollapsed = localStorage.getItem('bisatuntas-sidebar') === 'collapsed';

    if (sidebar && sidebarCollapsed) {
      sidebar.classList.add('is-collapsed');
    }
    function toggleSidebarCollapse() {
      if (!sidebar) return;
      var isCollapsed = sidebar.classList.contains('is-collapsed');
      if (isCollapsed) {
        sidebar.classList.remove('is-collapsed');
        localStorage.setItem('bisatuntas-sidebar', 'expanded');
      } else {
        sidebar.classList.add('is-collapsed');
        localStorage.setItem('bisatuntas-sidebar', 'collapsed');
      }
      updateSidebarToggleIcon();
    }
    function updateSidebarToggleIcon() {
      if (!sidebarToggle || !sidebar) return;
      var isCollapsed = sidebar.classList.contains('is-collapsed');
      var icon = sidebarToggle.querySelector('i, svg');
      if (icon) {
        var iconName = isCollapsed ? 'panel-left-open' : 'panel-left-close';
        if (typeof lucide !== 'undefined') {
          var newIcon = document.createElement('i');
          newIcon.setAttribute('data-lucide', iconName);
          newIcon.style.width = '18px';
          newIcon.style.height = '18px';
          icon.parentNode.replaceChild(newIcon, icon);
          lucide.createIcons();
        }
      }
    }
    updateSidebarToggleIcon();
    if (sidebarCollapseBtn) {
      sidebarCollapseBtn.addEventListener('click', toggleSidebarCollapse);
    }
    if (sidebarToggle) {
      sidebarToggle.addEventListener('click', function(e) {
        e.preventDefault();
        toggleSidebarCollapse();
      });
    }

    /* ---- Mobile Sidebar Toggle ---- */
    window.toggleAdminSidebar = function() {
      var overlay = document.getElementById('sidebarOverlay');
      if (sidebar) {
        sidebar.classList.toggle('mobile-show');
        if (overlay) overlay.classList.toggle('mobile-show');
        document.body.style.overflow = sidebar.classList.contains('mobile-show') ? 'hidden' : '';
      }
    };
    var sidebarOverlay = document.getElementById('sidebarOverlay');
    if (sidebarOverlay) {
      sidebarOverlay.addEventListener('click', function() {
        if (sidebar) sidebar.classList.remove('mobile-show');
        sidebarOverlay.classList.remove('mobile-show');
        document.body.style.overflow = '';
      });
    }

    /* ---- Navbar scroll effect ---- */
    var navbar = document.getElementById('mainNavbar');
    if (navbar) {
      function updateNavbar() {
        if (window.scrollY > 15) {
          navbar.classList.add('is-scrolled');
        } else {
          navbar.classList.remove('is-scrolled');
        }
      }
      window.addEventListener('scroll', updateNavbar, { passive: true });
      updateNavbar();
    }

    /* ---- Command Palette ---- */
    var cmdPaletteOverlay = document.getElementById('cmdPalette');
    var cmdPaletteInput = document.getElementById('cmdPaletteInput');
    var cmdResults = document.getElementById('cmdResults');
    var cmdTrigger = document.getElementById('cmdTrigger');
    var cmdItems = [];

    function openCommandPalette() {
      if (cmdPaletteOverlay) {
        cmdPaletteOverlay.classList.add('active');
        if (cmdPaletteInput) {
          cmdPaletteInput.value = '';
          cmdPaletteInput.focus();
        }
        filterCommands('');
      }
    }

    function closeCommandPalette() {
      if (cmdPaletteOverlay) {
        cmdPaletteOverlay.classList.remove('active');
      }
    }

    document.addEventListener('keydown', function(e) {
      if ((e.metaKey || e.ctrlKey) && e.key === 'k') {
        e.preventDefault();
        if (cmdPaletteOverlay && cmdPaletteOverlay.classList.contains('active')) {
          closeCommandPalette();
        } else {
          openCommandPalette();
        }
      }
      if (e.key === 'Escape') {
        closeCommandPalette();
      }
    });

    if (cmdTrigger) {
      cmdTrigger.addEventListener('click', openCommandPalette);
    }

    if (cmdPaletteOverlay) {
      cmdPaletteOverlay.addEventListener('click', function(e) {
        if (e.target === cmdPaletteOverlay) {
          closeCommandPalette();
        }
      });
    }

    function filterCommands(query) {
      if (!cmdResults) return;
      var q = query.toLowerCase().trim();
      var filtered = !q ? cmdItems : cmdItems.filter(function(item) {
        return item.label.toLowerCase().indexOf(q) !== -1 ||
               item.keywords.toLowerCase().indexOf(q) !== -1;
      });
      renderResults(filtered);
    }

    function renderResults(items) {
      if (!cmdResults) return;
      if (items.length === 0) {
        cmdResults.innerHTML = '<div class="cmd-palette-empty">No results found</div>';
        return;
      }
      var html = '';
      items.forEach(function(item, i) {
        html += '<a href="' + item.url + '" class="cmd-palette-item" data-index="' + i + '">' +
                item.icon +
                '<span>' + item.label + '</span>' +
                '</a>';
      });
      cmdResults.innerHTML = html;
    }

    if (cmdPaletteInput) {
      cmdPaletteInput.addEventListener('input', function() {
        filterCommands(this.value);
      });
      cmdPaletteInput.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
          var first = cmdResults ? cmdResults.querySelector('.cmd-palette-item') : null;
          if (first) {
            window.location.href = first.getAttribute('href');
            closeCommandPalette();
          }
        }
      });
    }

    /* ---- Collect command palette items from sidebar ---- */
    function collectCommands() {
      cmdItems = [];
      var links = document.querySelectorAll('.admin-sidebar .nav-link');
      links.forEach(function(link) {
        var href = link.getAttribute('href');
        var labelEl = link.querySelector('span');
        var iconEl = link.querySelector('i, svg');
        if (href && labelEl) {
          var label = labelEl.textContent.trim();
          var iconHtml = iconEl ? iconEl.outerHTML : '<i data-lucide="circle"></i>';
          cmdItems.push({
            label: label,
            keywords: label.toLowerCase(),
            url: href,
            icon: iconHtml
          });
        }
      });
    }
    collectCommands();

    /* ---- Auto-dismiss alerts after 5 seconds ---- */
    document.querySelectorAll('.alert-dismissible').forEach(function(alert) {
      setTimeout(function() {
        var bsAlert = bootstrap.Alert.getInstance(alert);
        if (bsAlert) bsAlert.close();
        else alert.style.display = 'none';
      }, 5000);
    });

    /* ---- SweetAlert2 Confirm Dialogs (event delegation) ---- */
    document.addEventListener('click', function(e) {
      var el = e.target.closest('[data-confirm]');
      if (!el) return;
      var msg = el.getAttribute('data-confirm') || 'Apakah Anda yakin?';
      var confirmBtn = el.getAttribute('data-confirm-button') || 'Ya, lanjutkan!';
      var cancelBtn = el.getAttribute('data-cancel-button') || 'Batal';
      var icon = el.getAttribute('data-icon') || 'warning';
      e.preventDefault();
      var form = el.closest('form') || null;
      var href = el.getAttribute('href') || null;
      Swal.fire({
        title: msg,
        icon: icon,
        showCancelButton: true,
        confirmButtonText: confirmBtn,
        cancelButtonText: cancelBtn,
        confirmButtonColor: '#009688',
        cancelButtonColor: '#6c757d',
        reverseButtons: true
      }).then(function(result) {
        if (result.isConfirmed) {
          if (form) form.submit();
          else if (href) window.location.href = href;
        }
      });
    });

    /* ---- SweetAlert2 Toast Notifications ---- */
    document.querySelectorAll('[data-toast]').forEach(function(el) {
      var type = el.getAttribute('data-toast') || 'success';
      var message = el.getAttribute('data-message') || el.textContent.trim();
      if (message) {
        Swal.fire({
          icon: type,
          title: message,
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 4000,
          timerProgressBar: true,
          didOpen: function(toast) {
            toast.addEventListener('mouseenter', Swal.stopTimer);
            toast.addEventListener('mouseleave', Swal.resumeTimer);
          }
        });
        el.remove();
      }
    });

    /* ---- Image upload preview ---- */
    document.querySelectorAll('input[type="file"][data-preview]').forEach(function(input) {
      input.addEventListener('change', function() {
        var previewId = this.getAttribute('data-preview');
        var preview = document.getElementById(previewId);
        if (preview && this.files && this.files[0]) {
          var reader = new FileReader();
          reader.onload = function(ev) { preview.src = ev.target.result; preview.style.display = 'block'; };
          reader.readAsDataURL(this.files[0]);
        }
      });
    });

    /* ---- Color picker sync ---- */
    document.querySelectorAll('input[type="color"]').forEach(function(picker) {
      var key = picker.name.replace(/_color$/, '');
      var textInput = document.querySelector('input[name="' + key + '"]');
      if (textInput) {
        picker.addEventListener('input', function() { textInput.value = this.value; });
      }
    });

    /* ---- Sidebar active link ---- */
    var currentPath = window.location.pathname.replace(/\/+$/, '');
    document.querySelectorAll('.admin-sidebar .nav-link').forEach(function(link) {
      var href = link.getAttribute('href');
      if (href) {
        var linkPath = href.replace(/\/+$/, '');
        if (currentPath === linkPath || currentPath.indexOf(linkPath + '/') === 0) {
          link.classList.add('active');
        }
      }
    });

    /* ---- Scroll to top button ---- */
    var scrollBtn = document.getElementById('scrollTop');
    if (!scrollBtn) {
      scrollBtn = document.createElement('button');
      scrollBtn.id = 'scrollTop';
      scrollBtn.className = 'btn btn-primary rounded-circle shadow-lg';
      scrollBtn.innerHTML = '<i class="fas fa-arrow-up"></i>';
      scrollBtn.style.cssText = 'position:fixed;bottom:24px;right:24px;width:44px;height:44px;z-index:999;display:none;opacity:0;transition:opacity 0.3s;';
      document.body.appendChild(scrollBtn);
      scrollBtn.addEventListener('click', function() { window.scrollTo({ top: 0, behavior: 'smooth' }); });
    }
    window.addEventListener('scroll', function() {
      if (window.scrollY > 400) { scrollBtn.style.display = 'block'; requestAnimationFrame(function() { scrollBtn.style.opacity = '1'; }); }
      else { scrollBtn.style.opacity = '0'; setTimeout(function() { scrollBtn.style.display = 'none'; }, 300); }
    }, { passive: true });

    /* ---- AOS Animation Init ---- */
    if (typeof AOS !== 'undefined') {
      AOS.init({
        duration: 600,
        once: true,
        offset: 40,
        disable: function() { return window.innerWidth < 768; }
      });
    }

    /* ---- Page transition ---- */
    var adminContent = document.querySelector('.admin-content');
    if (adminContent) {
      adminContent.classList.add('page-enter');
    }

    /* ---- Quiz question type toggle ---- */
    document.querySelectorAll('[name="type"]').forEach(function(select) {
      if (select.closest('.question-form') || select.id.indexOf('type') !== -1) {
        toggleQuestionOptions(select);
        select.addEventListener('change', function() { toggleQuestionOptions(this); });
      }
    });

    /* ---- Navbar dropdown hover (desktop) ---- */
    if (window.innerWidth >= 992) {
      document.querySelectorAll('.navbar .dropdown').forEach(function(dropdown) {
        dropdown.addEventListener('mouseenter', function() {
          var menu = this.querySelector('.dropdown-menu');
          if (menu) { menu.classList.add('show'); var trigger = this.querySelector('.dropdown-toggle'); if (trigger) trigger.setAttribute('aria-expanded', 'true'); }
        });
        dropdown.addEventListener('mouseleave', function() {
          var menu = this.querySelector('.dropdown-menu');
          if (menu) { menu.classList.remove('show'); var trigger = this.querySelector('.dropdown-toggle'); if (trigger) trigger.setAttribute('aria-expanded', 'false'); }
        });
      });
    }

    /* ---- Tooltip init ---- */
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.forEach(function(el) { new bootstrap.Tooltip(el); });

    /* ---- Auto-resize textareas ---- */
    document.querySelectorAll('textarea.auto-resize').forEach(function(ta) {
      ta.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = this.scrollHeight + 'px';
      });
    });

    /* ---- Form validation enhancement ---- */
    document.querySelectorAll('form.needs-validation').forEach(function(form) {
      form.addEventListener('submit', function(e) {
        if (!form.checkValidity()) {
          e.preventDefault();
          e.stopPropagation();
        }
        form.classList.add('was-validated');
      });
    });

    /* ---- Keyboard shortcuts ---- */
    document.addEventListener('keydown', function(e) {
      if (e.key === 'g' && !e.metaKey && !e.ctrlKey) {
        var pressed = {};
        pressed[e.key] = true;
        var timer = setTimeout(function() {
          pressed = {};
        }, 500);
        document.addEventListener('keyup', function handler(ev) {
          if (pressed['g']) {
            if (ev.key === 'd') { window.location.href = document.querySelector('.admin-sidebar .nav-link[href*="dashboard"]')?.getAttribute('href') || '/admin/dashboard'; }
            if (ev.key === 'c') { window.location.href = document.querySelector('.admin-sidebar .nav-link[href*="courses"]')?.getAttribute('href') || '/admin/courses'; }
            if (ev.key === 's') { window.location.href = document.querySelector('.admin-sidebar .nav-link[href*="seminars"]')?.getAttribute('href') || '/admin/seminars'; }
            if (ev.key === 't') { window.location.href = document.querySelector('.admin-sidebar .nav-link[href*="tags"]')?.getAttribute('href') || '/admin/tags'; }
          }
          clearTimeout(timer);
          pressed = {};
          document.removeEventListener('keyup', handler);
        });
      }
    });

    /* ---- Micro-interactions: card lift ---- */
    document.querySelectorAll('.bento-card, .stat-card, .content-card, .card-modern').forEach(function(card) {
      card.addEventListener('mouseenter', function() {
        if (typeof gsap !== 'undefined') {
          gsap.to(this, { y: -4, duration: 0.3, ease: 'power2.out' });
        }
      });
      card.addEventListener('mouseleave', function() {
        if (typeof gsap !== 'undefined') {
          gsap.to(this, { y: 0, duration: 0.3, ease: 'power2.out' });
        }
      });
    });

    /* ---- Floating Labels: auto-set placeholder for floating label detection ---- */
    document.querySelectorAll('.form-float .form-control, .form-float .form-select').forEach(function(el) {
      if (!el.hasAttribute('placeholder')) {
        el.setAttribute('placeholder', ' ');
      }
      if (el.value && el.value !== '0') {
        el.classList.add('not-empty');
      }
      el.addEventListener('blur', function() {
        if (this.value) {
          this.classList.add('not-empty');
        } else {
          this.classList.remove('not-empty');
        }
      });
    });

    /* ---- Character Counter ---- */
    document.querySelectorAll('textarea[data-max-chars]').forEach(function(ta) {
      var max = parseInt(ta.getAttribute('data-max-chars'), 10);
      var counter = document.createElement('div');
      counter.className = 'char-counter';
      counter.textContent = '0 / ' + max;
      ta.parentNode.appendChild(counter);

      ta.addEventListener('input', function() {
        var len = this.value.length;
        counter.textContent = len + ' / ' + max;
        counter.className = 'char-counter';
        if (len > max * 0.85) counter.classList.add('warning');
        if (len >= max) {
          counter.classList.add('danger');
          this.value = this.value.substring(0, max);
          counter.textContent = max + ' / ' + max;
        }
      });
    });

    /* ---- Loading state on form submit ---- */
    document.querySelectorAll('form').forEach(function(form) {
      form.addEventListener('submit', function() {
        var btn = this.querySelector('[type="submit"]');
        if (btn && !btn.classList.contains('no-loading')) {
          btn.classList.add('btn-loading');
        }
      });
    });

    /* ---- Form dirty tracking ---- */
    document.querySelectorAll('form[data-track-dirty]').forEach(function(form) {
      var initialData = new FormData(form);
      var indicator = document.getElementById('dirtyIndicator');
      form.addEventListener('input', function() {
        var currentData = new FormData(form);
        var isDirty = false;
        for (var pair of currentData.entries()) {
          if (pair[1] !== initialData.get(pair[0])) {
            isDirty = true;
            break;
          }
        }
        if (indicator) {
          if (isDirty) {
            indicator.className = 'autosave-indicator saving';
            indicator.innerHTML = '<i data-lucide="clock" style="width:14px;height:14px;"></i> Unsaved changes';
          } else {
            indicator.className = 'autosave-indicator saved';
            indicator.innerHTML = '<i data-lucide="check-circle" style="width:14px;height:14px;"></i> All saved';
          }
          if (typeof lucide !== 'undefined') lucide.createIcons();
        }
      });
    });

    /* ---- Dealls-style Micro-interactions ---- */
    if (document.querySelector('.playful')) {
      /* Sidebar link icon subtle scale on hover */
      document.querySelectorAll('.playful .admin-sidebar .nav-link').forEach(function(link) {
        link.addEventListener('mouseenter', function() {
          var icon = this.querySelector('i, svg');
          if (icon) { icon.style.transform = 'scale(1.1)'; icon.style.transition = 'transform 0.15s ease'; }
        });
        link.addEventListener('mouseleave', function() {
          var icon = this.querySelector('i, svg');
          if (icon) { icon.style.transform = 'scale(1)'; }
        });
      });

      /* Avatar light scale on hover */
      document.querySelectorAll('.playful .admin-topbar-avatar').forEach(function(avatar) {
        avatar.addEventListener('mouseenter', function() {
          var circle = this.querySelector('.avatar-circle');
          if (circle) { circle.style.transform = 'scale(1.05)'; circle.style.transition = 'transform 0.15s ease'; }
        });
        avatar.addEventListener('mouseleave', function() {
          var circle = this.querySelector('.avatar-circle');
          if (circle) { circle.style.transform = ''; }
        });
      });
    }

  }

  function toggleQuestionOptions(select) {
    var type = select.value;
    var optionsRow = document.getElementById('optionsRow');
    if (optionsRow) {
      optionsRow.style.display = (type === 'multiple_choice') ? 'block' : 'none';
    }
  }

  /* ---- Admin tables -> mobile card list (app-table) ---- */
  function initAppTables() {
    var isMobile = window.matchMedia('(max-width: 768px)').matches;
    document.querySelectorAll('table.app-table').forEach(function(table) {
      var wrap = table.closest('.app-table-wrap') || table.parentNode;
      var list = wrap.querySelector(':scope > .app-row-list');
      if (!list) {
        list = document.createElement('div');
        list.className = 'app-row-list app-list';
        wrap.insertBefore(list, table);
      }
      if (!isMobile) {
        list.innerHTML = '';
        return;
      }
      var heads = Array.prototype.map.call(table.querySelectorAll('thead th'), function(th) {
        return th.textContent.trim().replace(/\s+/g, ' ');
      });
      var rows = table.querySelectorAll('tbody tr');
      var html = '';
      rows.forEach(function(row) {
        var cells = Array.prototype.map.call(row.querySelectorAll('td'), function(td) { return td; });
        var headCell = cells[0];
        var headHtml = headCell ? headCell.innerHTML : '';
        var body = '';
        var actions = '';
        var meta = [];
        cells.forEach(function(td, i) {
          var cls = (td.className || '') + ' ' + (td.getAttribute('class') || '');
          var label = heads[i] || '';
          var inner = td.innerHTML.trim();
          if (!inner) return;
          if (cls.indexOf('td-title') !== -1 || cls.indexOf('app-row-title') !== -1 || (i === 0 && !actions)) {
            body = '<div class="app-row-title">' + inner + '</div>';
          } else if (cls.indexOf('td-actions') !== -1 || td.querySelector('a.app-action, .app-action, .btn')) {
            actions = inner;
          } else if (td.querySelector('.app-chip, .role-badge, .status-badge')) {
            meta.push('<span>' + inner + '</span>');
          } else {
            meta.push('<span><b>' + label + ':</b> ' + inner + '</span>');
          }
        });
        html += '<div class="app-row app-row-card">' +
          '<div class="app-row-head">' + headHtml + '</div>' +
          (body ? body : '') +
          (meta.length ? '<div class="app-row-meta">' + meta.join('') + '</div>' : '') +
          (actions ? '<div class="app-actions">' + actions + '</div>' : '') +
        '</div>';
      });
      list.innerHTML = html || '<div class="app-empty"><i class="fas fa-inbox"></i><p>Data kosong</p></div>';
    });
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }

  window.addEventListener('resize', function() {
    initAppTables();
  });
  initAppTables();

})();

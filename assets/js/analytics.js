/**
 * BISATUNTAS — Universal Event Tracker
 * Tracks key user events to GA4 + Facebook Pixel
 */
(function() {
  'use strict';

  window.BISATUNTAS = window.BISATUNTAS || {};

  BISATUNTAS.track = function(eventName, params) {
    params = params || {};

    // GA4 Event
    if (typeof gtag !== 'undefined') {
      gtag('event', eventName, params);
    }

    // Facebook Pixel Event
    if (typeof fbq !== 'undefined') {
      fbq('trackCustom', eventName, params);
    }

    // Console log in development
    if (window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1') {
      console.log('[BISATUNTAS Track]', eventName, params);
    }
  };

  // Track PageView with additional data
  var pageData = {
    page_title: document.title,
    page_path: window.location.pathname,
    page_url: window.location.href,
  };

  if (document.querySelector('[data-course-id]')) {
    pageData.course_id = document.querySelector('[data-course-id]').getAttribute('data-course-id');
    pageData.content_type = 'course';
  }

  BISATUNTAS.track('page_view', pageData);

  // Track enrollment button clicks
  document.addEventListener('click', function(e) {
    var enrollBtn = e.target.closest('[data-track-enroll]');
    if (enrollBtn) {
      BISATUNTAS.track('begin_checkout', {
        course_id: enrollBtn.getAttribute('data-track-enroll'),
        price: enrollBtn.getAttribute('data-track-price') || '0',
      });
    }

    var shareBtn = e.target.closest('[data-track-share]');
    if (shareBtn) {
      BISATUNTAS.track('share', {
        content_id: shareBtn.getAttribute('data-track-share'),
        platform: shareBtn.getAttribute('data-track-platform') || 'unknown',
      });
    }
  });

  // Track purchase complete (check for URL parameter)
  if (window.location.search.indexOf('purchase=success') !== -1) {
    BISATUNTAS.track('purchase', {
      transaction_id: new URLSearchParams(window.location.search).get('tx_id') || '',
    });
  }

  // Track registration complete
  if (window.location.search.indexOf('registered=true') !== -1) {
    BISATUNTAS.track('complete_registration', {});
  }

  // UTM Capture — store in cookie/session via AJAX
  (function() {
    var params = ['utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content'];
    var utmData = {};
    var hasUtm = false;

    params.forEach(function(p) {
      var val = new URLSearchParams(window.location.search).get(p);
      if (val) {
        utmData[p.replace('utm_', '')] = val;
        hasUtm = true;
      }
    });

    if (hasUtm) {
      // Save to cookie for 30 days
      document.cookie = 'bisatuntas_utm=' + encodeURIComponent(JSON.stringify(utmData)) +
        '; path=/; max-age=' + (30 * 24 * 60 * 60);

      // Send to server via beacon
      if (navigator.sendBeacon) {
        var formData = new FormData();
        formData.append('utm_data', JSON.stringify(utmData));
        navigator.sendBeacon('/index.php?/home/capture_utm', formData);
      }
    }
  })();
})();

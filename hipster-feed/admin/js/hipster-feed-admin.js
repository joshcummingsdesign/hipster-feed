(function ($) {
  'use strict';

  /**
   * Shows spinner on form submit
   */
  var showSpinner = function () {
    $('form').submit(function () {
      $(this).find('.spinner').addClass('is-active');
    });
  };

  /**
   * Logs user out
   */
  var logOut = function () {

    $('#hipster-feed-logout').click(function (e) {

      e.preventDefault();

      $.post(ajaxurl, {
        security: hipsterSettings.nonce,
        action: 'logout'
      })
      .done(function(res) {
        if (res !== 'success') {
          console.error('Response failure');
        } else {
          $('#hipster-feed-profile').addClass('is-hidden');
          $('#hipster-feed-authenticate').removeClass('is-hidden');
        }
      })
      .fail(function() {
        console.error('AJAX failure');
      });
    });
  }

  var resetParam = function () {

    var href = window.location.href;
    var regex = /&code=\w+/g;

    if (href.match(regex)) {
      href = href.replace(regex, '');
      history.replaceState(null, null, href);
    }
  };

  $(document).ready(function () {
    showSpinner();
    logOut();
    resetParam();
  });

})(jQuery);

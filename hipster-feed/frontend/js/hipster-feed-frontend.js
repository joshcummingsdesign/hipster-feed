/* global settings */

(function ($) {
  'use strict';

  /**
   * Displays Instagram slider
   * @return {undefined}
   */
  var hipsterFeed = function () {

    var items = settings.items ? parseInt(settings.items) : 5,
        loop  = settings.loop === '1',
        nav   = settings.nav === '1',
        dots  = settings.dots === '1';

    $('.hipster-feed-slider').owlCarousel({
      items: items,
      loop: loop,
      nav: nav,
      dots: dots
    });

  };

  /**
   * Checks for owlCarousel and initializes
   * @return {undefined}
   */
  var hipsterFeedInit = function () {
    if (typeof (owlCarousel) === 'undefined') {
      var cssFile = settings.owlCarouselCSS;
      var cssLink = '<link rel="stylesheet" href="' + cssFile + '">';
      $('head').append(cssLink);
      $.getScript(settings.owlCarouselJS, hipsterFeed);
    } else {
      hipsterFeed();
    }
  };

  $(document).ready(function () {
    hipsterFeedInit();
  });

})(jQuery);

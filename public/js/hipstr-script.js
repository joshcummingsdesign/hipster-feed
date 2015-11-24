/*****************************************
* Front End Script
/****************************************/

jQuery(document).ready(function($) {

  'use strict';

  $(".owl-carousel").owlCarousel({
    loop: true,
    margin: 20,
    nav: true,
    navText: [
      '<span class="arrows"><i class="fa fa-arrow-left"></i></span>',
      '<span class="arrows"><i class="fa fa-arrow-right"></i></span>'
    ],
    responsive: {
      0: {
        items: 1
      },
      600: {
        items: 2
      },
      900: {
        items: 3
      },
      1200: {
        items: 4
      },
      1300: {
        items: 5
      }
    }
  });

});

/* [ ---- Gebo Admin Panel - common ---- ] */

$(document).ready(function() {
  gebo_nav_mouseover.init();
});

//* main menu mouseover
gebo_nav_mouseover = {
  init: function() {
    $('header li.dropdown').mouseenter(function() {
      if($('body').hasClass('menu_hover')) {
        $(this).addClass('navHover')
      }
    }).mouseleave(function() {
      if($('body').hasClass('menu_hover')) {
        $(this).removeClass('navHover open')
      }
    });
  }
};


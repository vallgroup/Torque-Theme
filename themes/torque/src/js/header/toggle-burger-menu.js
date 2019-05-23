($ => {
  // bind toggle nav
  $(document).ready(() => {
    const navToggle = $(".torque-burger-menu");
    const nav = $(".torque-navigation-toggle");
    const outside_nav = $("main");

    navToggle.on("click", e => {
      e.preventDefault();

      /* Toggle the menu active/inactive */
      nav.toggleClass("active");
      navToggle.toggleClass("active");
    });

    /* When the 'main' element is clicked, toggle the menu by removing '/'.active' */
    outside_nav.click(function(){
      if ( navToggle.hasClass('active') ) {
        nav.toggleClass("active");
        navToggle.toggleClass("active");
        /* Unbind the event listener for 'main' element */
        //$('main').off('click');
      }
    });

  });
})(jQuery);

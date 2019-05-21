($ => {
  // bind toggle nav
  $(document).ready(() => {
    const navToggle = $(".torque-burger-menu");
    const nav = $(".torque-navigation-toggle");

    navToggle.on("click", e => {
      e.preventDefault();

      /* Toggle the menu active/inactive */
      nav.toggleClass("active");
      navToggle.toggleClass("active");

      /* Add event listener to close menu when */
      if ( navToggle.hasClass('active') ) {
        $('main').click(function(){
          /* When the 'main' element is clicked, toggle the menu by removing '/'.active' */
          nav.toggleClass("active");
          navToggle.toggleClass("active");

          /* Unbind the event listener for 'main' element */
          $('main').off('click');
        });
      }
    });
  });
})(jQuery);

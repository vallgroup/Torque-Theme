// assign our function to the global scope
window.onRecaptchaSubmit = onRecaptchaSubmit;

document.addEventListener('DOMContentLoaded', checkRecaptchaBadge, false);
document.addEventListener('scroll', checkRecaptchaBadge, false);

function checkRecaptchaBadge(e) {
  // set vars
  const theForm = document.querySelector(tqRecaptcha.formSelector);
  const recaptchaBadge = document.querySelector('body > div > .grecaptcha-badge');

  if (null !== recaptchaBadge) {
    if (
      null === theForm
      || !isScrolledIntoView(theForm)
    ) {
      // hide
      recaptchaBadge.style.right = '-286px';
    } else {
      // show
      recaptchaBadge.style.right = '-186px';
    }
  }
}

function onRecaptchaSubmit(token) {
  // set vars
  const theForm = document.querySelector(tqRecaptcha.formSelector);
  const theButton = document.querySelector(`${tqRecaptcha.formSelector} .contact-submit`);
  const overlayClassName = 'recaptcha-loading-overlay';
  const overlayHTML = '<div class="' + overlayClassName + '">Loading...</div>';

  console.log('Running Google reCAPTCHA callback function...');

  // early exit
  if (undefined === grecaptcha) {
    console.log('Google reCAPTCHA script not loaded correctly...');
    return;
  }

  // check for a response
  const gRecaptchaResponse = token;
  if ('' !== gRecaptchaResponse) {
    // add loading overlay
    theButton.insertAdjacentHTML('afterend', overlayHTML);
    // send Google reCAPTCHA response to our validation PHP script
    jQuery.ajax({
      type: 'POST',
      url: tqRecaptcha.ajaxURL,
      data: {
        'action': tqRecaptcha.action,
        'g-recaptcha-response': gRecaptchaResponse
      }
    })
    .done(function(response) {
      console.log('Google reCAPTCHA response: ', response);
      if ('valid' === response) {
        if (theForm.checkValidity()) {
          // if the response was valid, and the form is valid, submit it!
          theForm.submit();
        } else {
          // show the HTML5 validation warnings
          theForm.reportValidity();
        }
      } else {
        alert('The Google reCAPTCHA check has failed. Please refresh the page and try again, ensuring you\'re not using an incognito browser session. If you continued to experience issues please contact us directly via email.');
      }

      // remove the loading overlay
      document.querySelector(`.${overlayClassName}`).remove();
  
      // reset the reCAPTCHA
      grecaptcha.reset();
    })
  }
}

function isScrolledIntoView(el) {
  var rect = el.getBoundingClientRect();
  var elemTop = rect.top;
  var elemBottom = rect.bottom;

  // Only completely visible elements return true:
  // var isVisible = (elemTop >= 0) && (elemBottom <= window.innerHeight);

  // Partially visible elements return true:
  var isVisible = elemTop < window.innerHeight && elemBottom >= 0;

  return isVisible;
}

// function isScrolledIntoView(elem) {
//   var docViewTop = $(window).scrollTop();
//   var docViewBottom = docViewTop + $(window).height();

//   var elemTop = $(elem).offset().top;
//   var elemBottom = elemTop + $(elem).height();

//   return ((elemBottom <= docViewBottom) && (elemTop >= docViewTop));
// }

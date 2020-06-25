// assign our function to the global scope
window.onRecaptchaSubmit = onRecaptchaSubmit;

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

/**
 * This file is packaged by webpack, so we have support for latest js features for all browsers.
 */

/**
 *
 * First page is rendered by initial server render of the page,
 * then this process will repeat as necessary
 *
 * 1. If next page exists, a load more button is rendered as part of the page
 *    with a 'data-page-id' attribute which will correspond to the id of the next page
 *
 * 2. User clicks the button, sending request for next page.
 *
 * 3. We receive the html for the next posts in the loop
 *
 * 4. If a next page is available, we also receive a new load more button in that html, with a new 'data-page-id' attribute
 *
 * 5. We remove the current load more button
 *
 * 6. We rebind the function to the new button, if it exists, and the process restarts with the new page.
 *
 */

($ => {
  $(document).ready(function($) {
    console.log(loadMoreData);
    for (let loadMoreId in loadMoreData) {
      bindClick();

      function bindClick() {
        $("button#" + loadMoreId).click(onClick);
      }

      async function onClick(e) {
        const loopWrapper = $(e.target)
          .parent()
          .parent(); // make sure we exit out of the button's wrapper div

        const pageId = $(e.target).attr("data-page-id"); // this was set when the button was generated server side

        const newPosts = await fetch(
          `${window.location.origin}/index.php/wp-json/torque/v1/load-more`,
          {
            method: "POST",
            body: JSON.stringify({
              ...loadMoreData[loadMoreId],
              paged: pageId
            }),
            headers: {
              "Content-Type": "application/json"
            }
          }
        );
        const newNodes = await newPosts.text();

        // the newNodes includes a new 'load more' button if another page exists
        loopWrapper.append(newNodes);
        // so remove the current button
        $(e.target).remove();
        // and rebind this function to the next button
        bindClick();
      }
    }
  });
})(jQuery);

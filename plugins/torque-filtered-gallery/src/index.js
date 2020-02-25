// entry point for React side of plugin
//
import React from "react";
import ReactDOM from "react-dom";
import App from "./app/App";
import "./app/scss/main.scss";

const entry = document.querySelectorAll(".torque-filtered-gallery-react-entry");

entry.forEach(entry => {
  if (entry) {
    const sharedProps = {
      site: entry.getAttribute("data-site"),
      galleryID: entry.getAttribute("data-gallery_id"),
      postsPerPage: entry.getAttribute("data-posts_per_page"),
      loopTemplate: entry.getAttribute("data-loop-template"),
      hideFilters: entry.getAttribute("data-hide_filters") === '1',
      useLightbox: entry.getAttribute("data-use_lightbox") === '1',
    };

    const filtersTypes = entry.getAttribute("data-filters_types");
    const filtersArgs = entry.getAttribute("data-filters_args");

    // pass through the data-site attr as props so the app knows where to send requests
    ReactDOM.render(
      filtersTypes && filtersArgs && (
        <App
          {...sharedProps}
          filtersTypes={filtersTypes}
          filtersArgs={filtersArgs}
        />
      ),
      entry
    );
  }
});

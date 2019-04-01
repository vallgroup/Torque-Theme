// entry point for React side of plugin
//
import React from "react";
import ReactDOM from "react-dom";
import App from "./app/App";
import AppCustomFilters from "./app/AppCustomFilters";
import "./app/scss/main.scss";

const entry = document.querySelectorAll(".torque-filtered-loop-react-entry");

entry.forEach(entry => {
  if (entry) {
    const sharedProps = {
      site: entry.getAttribute("data-site"),
      postType: entry.getAttribute("data-post_type"),
      postsPerPage: entry.getAttribute("data-posts_per_page"),
      loopTemplate: entry.getAttribute("data-loop-template")
    };

    const filtersTypes = entry.getAttribute("data-filters_types");
    const filtersArgs = entry.getAttribute("data-filters_args");

    // pass through the data-site attr as props so the app knows where to send requests
    ReactDOM.render(
      filtersTypes && filtersArgs ? (
        <AppCustomFilters
          {...sharedProps}
          filtersTypes={filtersTypes}
          filtersArgs={filtersArgs}
        />
      ) : (
        <App
          {...sharedProps}
          tax={entry.getAttribute("data-tax")}
          parent={entry.getAttribute("data-parent")}
          firstTerm={entry.getAttribute("data-first_term")}
        />
      ),
      entry
    );
  }
});

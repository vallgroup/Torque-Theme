// entry point for React side of plugin
//
import React from "react";
import ReactDOM from "react-dom";
import App from "./app/App";
import AppCustomFilters from "./app/AppCustomFilters";
import "./app/scss/main.scss";

const entry = document.querySelectorAll(".torque-filtered-loop-react-entry");

entry.forEach((entry) => {
  if (entry) {
    const sharedProps = {
      site: entry.getAttribute("data-site"),
      postType: entry.getAttribute("data-post_type"),
      postsPerPage: entry.getAttribute("data-posts_per_page"),
      loopTemplate: entry.getAttribute("data-loop-template"),
    };

    const filtersTypes = entry.getAttribute("data-filters_types");
    const filtersArgs = entry.getAttribute("data-filters_args");
    const categoryTermExclude = entry.getAttribute("data-category_term_exclude");
    const categoryTermInclude = entry.getAttribute("data-category_term_include");
    const useCustomLabel = entry.getAttribute("data-use_custom_label");
    const perPageOffset = entry.getAttribute("data-per_page_offset");

    // pass through the data-site attr as props so the app knows where to send requests
    ReactDOM.render(
      filtersTypes && filtersArgs ? (
        <AppCustomFilters
          {...sharedProps}
          filtersTypes={filtersTypes}
          filtersArgs={filtersArgs}
          categoryTermExclude={categoryTermExclude}
          categoryTermInclude={categoryTermInclude}
          useCustomLabel={useCustomLabel}
          perPageOffset={perPageOffset || 0}
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

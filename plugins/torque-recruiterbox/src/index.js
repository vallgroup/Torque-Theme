// entry point for React side of plugin
//
import React from "react";
import ReactDOM from "react-dom";
import App from "./app/App";
import "./app/scss/main.scss";

const entry = document.querySelectorAll(".torque-recruiterbox-react-entry");

entry.forEach(entry => {
  if (entry) {
    const sharedProps = {
      site: entry.getAttribute("data-site"),
      apiFilters: {
        'tags': entry.getAttribute("data-tags"),
        'city': entry.getAttribute("data-city"),
        'state': entry.getAttribute("data-state"),
        'country': entry.getAttribute("data-country"),
        'title': entry.getAttribute("data-title"),
        'description': entry.getAttribute("data-description"),
        'order_by': entry.getAttribute("data-order_by"),
        'allows_remote': entry.getAttribute("data-allows_remote"),
        'position_type': entry.getAttribute("data-position_type"),
        'team': entry.getAttribute("data-team"),
      },
    };

    // pass through the data-site attr as props so the app knows where to send requests
    ReactDOM.render(<App {...sharedProps} />, entry);
  }
});

// entry point for React side of plugin
import React from "react";
import ReactDOM from "react-dom";
import App from "./app/App";

const entry = document.querySelectorAll(".torque-image-grid-react-entry");

entry.forEach(entry => {
  if (entry) {
    const sharedProps = {
      site: entry.getAttribute("data-site"),
      slug: entry.getAttribute("data-slug"),
    };

    // pass through the data-site attr as props so the app knows where to send requests
    ReactDOM.render(
      <App
        {...sharedProps}
      />,
      entry
    );
  }
});

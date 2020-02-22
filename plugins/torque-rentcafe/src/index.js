// entry point for React side of plugin
//
import React from "react";
import ReactDOM from "react-dom";
import App from "./app/App";
import "./app/scss/main.scss";

const entry = document.querySelectorAll(".torque-rentcafe-react-entry");

entry.forEach(entry => {
  if (entry) {
    const sharedProps = {
      site: entry.getAttribute("data-site"),
      requestType: entry.getAttribute("data-request_type"),
      PropertyCode: entry.getAttribute("data-property_code")
    };

    ReactDOM.render(
      <App {...sharedProps} />,
      entry
    );
  }
});

// entry point for React side of plugin
//
import React from "react";
import ReactDOM from "react-dom";
import App from "./app/App";
import "./app/scss/main.scss";

const entry = document.querySelectorAll(".torque-slideshow-react-entry");

entry.forEach(entry => {
  if (entry) {
    // pass through the data-site attr as props so the app knows where to send requests
    ReactDOM.render(
      <App
        site={entry.getAttribute("data-site")}
        id={entry.getAttribute("data-id")}
        type={entry.getAttribute("data-type")}
        template={entry.getAttribute("data-template")}
      />,
      entry
    );
  }
});

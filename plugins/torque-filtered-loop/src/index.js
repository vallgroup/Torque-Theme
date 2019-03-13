// entry point for React side of plugin
//
import React from "react";
import ReactDOM from "react-dom";
import App from "./app/App";
import "./app/scss/main.scss";

const entry = document.querySelectorAll(".torque-filtered-loop-react-entry");

entry.forEach(entry => {
  if (entry) {
    // pass through the data-site attr as props so the app knows where to send requests
    ReactDOM.render(
      <App
        site={entry.getAttribute("data-site")}
        postType={entry.getAttribute("data-post_type")}
        tax={entry.getAttribute("data-tax")}
        parent={entry.getAttribute("data-parent")}
        firstTerm={entry.getAttribute("data-first_term")}
        loopTemplate={entry.getAttribute("data-loop-template")}
      />,
      entry
    );
  }
});

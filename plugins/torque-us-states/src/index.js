// entry point for React side of plugin
//
import React from "react";
import ReactDOM from "react-dom";
import App from "./app/App";
import "./app/scss/main.scss";

if (!global._babelPolyfill) {
  require("babel-polyfill");
}

const entry = document.querySelectorAll(".torque-us-states-react-entry");

entry.forEach(entry => {
  if (entry) {
    // pass through the data-site attr as props so the app knows where to send requests
    ReactDOM.render(
      <App
        site={entry.getAttribute("data-site")}
        postType={entry.getAttribute("data-post_type")}
        linkText={entry.getAttribute("data-link_text")}
        loopLinkSourceMetaKey={entry.getAttribute(
          "data-loop_link_source_meta_key"
        )}
      />,
      entry
    );
  }
});

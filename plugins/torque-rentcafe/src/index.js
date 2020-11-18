// entry point for React side of plugin
//
import React from "react";
import ReactDOM from "react-dom";
import { BrowserRouter as Router } from "react-router-dom";
import App from "./app/App";
import "./app/scss/main.scss";

const entry = document.querySelectorAll(".torque-rentcafe-react-entry");

entry.forEach(entry => {
  if (entry) {
    const sharedProps = {
      site: entry.getAttribute("data-site"),
      incomeRestricted: entry.getAttribute("data-income_restricted") === 'true',
      siteMap: entry.getAttribute("data-site_map"),
    };

    ReactDOM.render(
      <Router>
        <App {...sharedProps} />
      </Router>,
      entry
    );
  }
});

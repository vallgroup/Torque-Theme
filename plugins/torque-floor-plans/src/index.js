// entry point for React side of plugin
import React from "react";
import ReactDOM from "react-dom";
import App from "./app/App";
import "./app/scss/main.scss";

const entry = document.querySelectorAll(".torque-floor-plans-react-entry");

entry.forEach(entry => {
  if (entry) {
    ReactDOM.render(
      <App
        site={entry.getAttribute("data-site")}
        dataSource={entry.getAttribute("data-source")}
        dataSourceProps={{
          entrata: {
            propertyID: entry.getAttribute("data-entrata-property-id")
          }
        }}
      />,
      entry
    );
  }
});

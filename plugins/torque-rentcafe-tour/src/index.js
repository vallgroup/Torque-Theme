// entry point for React side of plugin
//
import React from "react";
import ReactDOM from "react-dom";
import App from "./app/App";
import "./app/scss/main.scss";

const entry = document.querySelectorAll(".torque-rentcafe-tour-react-entry");

entry.forEach(entry => {
  if (entry) {
    const sharedProps = {
      site: entry.getAttribute("data-site"),
      apiParams: {
        MarketingAPIKey: entry.getAttribute("data-marketing_api_key"),
        CompanyCode: entry.getAttribute("data-company_code"),
        PropertyId: entry.getAttribute("data-property_id"),
        PropertyCode: entry.getAttribute("data-property_code"),
      },
    };

    // pass through the data-site attr as props so the app knows where to send requests
    ReactDOM.render(<App {...sharedProps} />, entry);
  }
});

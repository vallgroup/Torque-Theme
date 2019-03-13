// entry point for React side of plugin
//
import React from "react";
import ReactDOM from "react-dom";
import App from "./app/App";
import "./app/scss/main.scss";

const entry = document.querySelectorAll(".torque-map-react-entry");

entry.forEach(entry => {
  if (entry) {
    // pass through the data-site attr as props so the app knows where to send requests
    ReactDOM.render(
      <App
        site={entry.getAttribute("data-site") || null}
        apiKey={entry.getAttribute("data-api_key") || null}
        center={entry.getAttribute("data-center") || null}
        zoom={entry.getAttribute("data-zoom") || null}
        title={entry.getAttribute("data-title") || null}
        centerMarker={entry.getAttribute("data-center_marker") || null}
        mapID={entry.getAttribute("data-map_id") || null}
      />,
      entry
    );
  }
});

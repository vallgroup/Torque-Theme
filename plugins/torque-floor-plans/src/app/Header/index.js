import React, { memo } from "react";
import { getFloorWithAffix } from "../App";

const Header = ({ floorPlan }) => {
  return (
    floorPlan && (
      <React.Fragment>
        <div
          style={{
            display: "inline-block",
            verticalAlign: "top",
            paddingRight: "25px",
            width: "33%",
            boxSizing: "border-box"
          }}
        >
          <h3 style={{ width: "100%", textTransform: "uppercase" }}>
            {getFloorWithAffix(floorPlan)}
          </h3>
          <h4 style={{ width: "100%", textTransform: "uppercase" }}>
            {floorPlan.post_title}
          </h4>
        </div>
        <div
          style={{
            display: "inline-block",
            verticalAlign: "top",
            width: "66%"
          }}
        >
          {floorPlan?.downloads?.pdf ? (
            <a href={floorPlan.downloads.pdf} target="_blank">
              <button>{"Download PDF"}</button>
            </a>
          ) : null}
        </div>
      </React.Fragment>
    )
  );
};

export default memo(Header);

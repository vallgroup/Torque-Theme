import React, { memo } from "react";
import classnames from "classnames";
import { getFloorWithAffix } from "../App";
import FloorPlansList from "./FloorPlansList";
import Dropdown from "./Dropdown";
import style from "./FloorPlanSelector.scss";

/*

  Floor plan shape

  {
    downloads: {pdf: ""}
    floor_number: ""
    post_title: "Floor Plan 2"
    rsf: ""
    thumbnail: "http://localhost:8000/wp-content/uploads/2019/03/Screen-Shot-2019-02-18-at-19.41.26.png"
  }

 */

const FloorPlanSelector = ({ withDropdown, floorPlans, ...props }) => {
  return (
    floorPlans && (
      <React.Fragment>
        <h4 className={style.title}>
          {"CLICK TO PREVIEW FLOOR PLAN ON THE RIGHT"}
        </h4>
        {withDropdown ? (
          <Dropdown>
            <FloorPlansList floorPlans={floorPlans} {...props} />
          </Dropdown>
        ) : (
          <FloorPlansList floorPlans={floorPlans} {...props} />
        )}
      </React.Fragment>
    )
  );
};

export default memo(FloorPlanSelector);

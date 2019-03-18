import React, { memo } from "react";
import classnames from "classnames";
import { getFloorWithAffix } from "../App";
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

const FloorPlanSelector = ({ floorPlans, selected, updateSelected }) => {
  return (
    floorPlans && (
      <React.Fragment>
        <h4 className={style.title}>
          {"CLICK TO PREVIEW FLOOR PLAN ON THE RIGHT"}
        </h4>
        {floorPlans.map((floorPlan, index) => {
          const rsf = floorPlan.rsf.replace(/\d(?=(\d{3})$)/g, "$&,");

          return (
            <div
              key={index}
              className={classnames(style.option, "option", {
                active: index === selected
              })}
              onClick={() => {
                updateSelected(index);
              }}
            >
              <div
                className={classnames(style.optionBlock, style.floor, "floor")}
              >
                {getFloorWithAffix(floorPlan)}
              </div>

              <div className={classnames(style.optionBlock, "title")}>
                {floorPlan.post_title}
              </div>

              <div
                className={classnames(style.optionBlock, "rsf")}
              >{`${rsf} RSF`}</div>
            </div>
          );
        })}
      </React.Fragment>
    )
  );
};

export default FloorPlanSelector;

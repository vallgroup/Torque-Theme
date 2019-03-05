import React, { memo } from "react";
import { getFloorWithAffix } from "../App";
import style from "./FloorPlanSelector.scss";

const FloorPlanSelector = ({ floorPlans, updateSelected }) => {
  return (
    floorPlans && (
      <React.Fragment>
        <h4 className={style.title}>
          {"CLICK TO PREVIEW FLOOR PLAN ON THE RIGHT"}
        </h4>
        {floorPlans
          .sort((a, b) => {
            return a.floor_number > b.floor_number;
          })
          .map((floorPlan, index) => {
            const rsf = floorPlan.rsf.replace(/\d(?=(\d{3})$)/g, "$&,");

            return (
              <div
                key={index}
                className={style.option}
                onClick={() => {
                  updateSelected(index);
                }}
              >
                <div className={`${style.optionBlock} ${style.floor}`}>
                  {getFloorWithAffix(floorPlan)}
                </div>

                <div className={`${style.optionBlock}`}>
                  {floorPlan.post_title}
                </div>

                <div className={`${style.optionBlock}`}>{`${rsf} RSF`}</div>
              </div>
            );
          })}
      </React.Fragment>
    )
  );
};

export default FloorPlanSelector;

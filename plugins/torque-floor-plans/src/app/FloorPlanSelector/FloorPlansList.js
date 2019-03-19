import React, { memo } from "react";
import classnames from "classnames";
import { getFloorWithAffix } from "../App";
import style from "./FloorPlanSelector.scss";

const FloorPlansList = ({
  floorPlans,
  selected,
  updateSelected,
  onFloorPlanClick
}) => {
  const handleClick = index => () => {
    onFloorPlanClick && onFloorPlanClick();
    updateSelected && updateSelected(index);
  };

  return floorPlans.map((floorPlan, index) => {
    const rsf = floorPlan.rsf.replace(/\d(?=(\d{3})$)/g, "$&,");

    return (
      <div
        key={index}
        className={classnames(style.option, "option", {
          active: index === selected
        })}
        onClick={handleClick(index)}
      >
        <div className={classnames(style.optionBlock, style.floor, "floor")}>
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
  });
};

export default memo(FloorPlansList);

import React, { memo } from "react";
import FloorPlanInfo from "../data-sources/entrata/FloorPlanInfo";

const Thumbnail = ({ floorPlan, dataSource }) => {
  return floorPlan?.thumbnail ? (
    <React.Fragment>
      <div>
        <img
          style={{
            width: "100%",
            height: "100%",
            objectFit: "contain"
          }}
          src={floorPlan.thumbnail}
        />
      </div>

      {dataSource === "entrata" && <FloorPlanInfo floorPlan={floorPlan} />}
    </React.Fragment>
  ) : null;
};

export default memo(Thumbnail);

import React, { memo } from "react";

const Thumbnail = ({ floorPlan }) => {
  return floorPlan?.thumbnail ? (
    <img
      style={{
        width: "100%",
        height: "100%",
        objectFit: "contain"
      }}
      src={floorPlan.thumbnail}
    />
  ) : null;
};

export default memo(Thumbnail);

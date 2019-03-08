import React, { memo } from "react";

const FloorPlanInfo = ({ floorPlan: { post_title, rsf } }) => {
  return (
    <div className="floor-plan-info">
      <div className="floor-plan-info-block floor-plan-name">
        <div className="title">{post_title}</div>
        <div className="rsf">{`${rsf} RSF`}</div>
        <div className="call">Call for availability</div>
      </div>

      <div className="floor-plan-info-block floor-plan-share">
        <div className="share-icon print" />
        <div className="share-icon share" />
        <div className="share-icon " />
      </div>

      <div className="floor-plan-info-block floor-plan-key" />
    </div>
  );
};

export default memo(FloorPlanInfo);

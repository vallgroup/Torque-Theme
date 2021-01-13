import React, { useState } from "react";

const ViewToggle = ({ currView, handleViewUpdate }) => {

  console.log('currView', currView)

  return (
    <div className={`torque-custom-filter-tabs`}>
      <div
        className={`tabs-title-wrapper`}
      >
        <span className="tabs-title">
          {'View'}
        </span>
      </div>

      <div
        className={`tabs-wrapper view-toggle`}
      >
        <div
          className={`tabs-item grid ${'grid' === currView ? 'selected' : ''}`}
          onClick={() => handleViewUpdate('grid')}
        >
          {'Grid'}
        </div>
        <div
          className={`tabs-item map ${'map' === currView ? 'selected' : ''}`}
          onClick={() => handleViewUpdate('map')}
        >
          {'Map'}
        </div>
      </div>

    </div>
  );
};

export default ViewToggle;

import style from "./App.scss";
import React, { memo, useState, useEffect } from "react";
import PropTypes from "prop-types";
import DataSource from "./data-sources";
import FloorPlanSelector from "./FloorPlanSelector";
import Header from "./Header";
import Thumbnail from "./Thumbnail";
import SearchBar from "./data-sources/entrata/SearchBar";

const App = ({ site, dataSource }) => {
  const [floorPlans, setFloorPlans] = useState([]);
  const [selected, setSelected] = useState(0);

  const getFloorPlans = async () => {
    try {
      const source = new DataSource({ site, dataSource });
      const floorPlans = await source.getFloorPlans();

      setFloorPlans(floorPlans);
      setSelected(0);
    } catch (e) {
      console.log(e);
      setFloorPlans([]);
      setSelected(0);
    }
  };

  useEffect(
    () => {
      getFloorPlans();
    },
    [site, dataSource]
  );

  const selectedFloorPlan = floorPlans[selected];

  return floorPlans?.length || dataSource === "entrata" ? (
    <div className={`torque-floor-plans ${style.floorPlans}`}>
      <div className={`torque-floor-plans-header-wrapper ${style.header}`}>
        {dataSource === "entrata" ? (
          <SearchBar setFloorPlans={setFloorPlans} site={site} />
        ) : (
          <Header floorPlan={selectedFloorPlan} />
        )}
      </div>
      <div className={`torque-floor-plans-selector ${style.selector}`}>
        <div className={`torque-floor-plans-list ${style.list}`}>
          <FloorPlanSelector
            floorPlans={floorPlans}
            updateSelected={setSelected}
          />
        </div>
        <div className={`torque-floor-plans-thumbnail ${style.thumbnail}`}>
          <Thumbnail floorPlan={selectedFloorPlan} />
        </div>
      </div>
    </div>
  ) : null;
};

App.propTypes = {
  site: PropTypes.string.isRequired,
  dataSource: PropTypes.string
};

export function getFloorWithAffix(floorPlan) {
  let affix = "th";

  switch (Math.abs(parseInt(floorPlan.floor_number))) {
    case 1:
      affix = "st";
      break;

    case 2:
      affix = "nd";
      break;

    case 3:
      affix = "rd";
      break;

    default:
      affix = "th";
  }

  return `${floorPlan.floor_number}${affix} floor`;
}

export default memo(App);

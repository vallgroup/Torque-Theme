import style from "./App.scss";
import React, { memo, useState, useEffect } from "react";
import axios from "axios";
import FloorPlanSelector from "./FloorPlanSelector/FloorPlanSelector";
import Header from "./Header/Header";
import Thumbnail from "./Thumbnail/Thumbnail";

// props
//
// site: string

const App = ({ site }) => {
  const [floorPlans, setFloorPlans] = useState([]);
  const [selected, setSelected] = useState(0);

  const getFloorPlans = async () => {
    try {
      const url = `${site}/wp-json/floor-plans/v1/floor-plans/`;
      const {
        data: { floor_plans, success }
      } = await axios.get(url);

      if (success) {
        setFloorPlans(floor_plans);
        setSelected(0);
      } else {
        throw "Failed getting floor plans";
      }
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
    [site]
  );

  const selectedFloorPlan = floorPlans[selected];

  return floorPlans?.length ? (
    <div className={`torque-floor-plans ${style.floorPlans}`}>
      <div className={`torque-floor-plans-header-wrapper ${style.header}`}>
        <Header floorPlan={selectedFloorPlan} />
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

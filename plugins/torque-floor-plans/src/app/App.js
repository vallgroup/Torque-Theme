import style from "./App.scss";
import React, { memo, useState, useEffect, useCallback, useMemo } from "react";
import PropTypes from "prop-types";
import Loading from "./Loading";
import DataSource from "./data-sources";
import FloorPlanSelector from "./FloorPlanSelector";
import Header from "./Header";
import Thumbnail from "./Thumbnail";
import SearchBar from "./data-sources/entrata/SearchBar";

const App = ({ site, dataSource }) => {
  const [floorPlans, setFloorPlans] = useState([]);
  const [isFetching, setIsFetching] = useState(false);
  const [selected, setSelected] = useState(0);

  const getFloorPlans = useCallback(
    async () => {
      try {
        setIsFetching(true);
        const source = new DataSource({ site, dataSource });
        const floorPlans = await source.getFloorPlans();

        setFloorPlans(floorPlans);
        setSelected(0);
        setIsFetching(false);
      } catch (e) {
        console.log(e);
        setFloorPlans([]);
        setSelected(0);
      }
    },
    [site, dataSource]
  );

  useEffect(
    () => {
      getFloorPlans();
    },
    [getFloorPlans]
  );

  const sortedFloorPlans = useMemo(
    () =>
      floorPlans.sort((a, b) => {
        return a.floor_number > b.floor_number;
      }),
    [floorPlans]
  );
  const selectedFloorPlan = sortedFloorPlans[selected];

  return sortedFloorPlans?.length || dataSource === "entrata" ? (
    <div className={`torque-floor-plans ${style.floorPlans}`}>
      <div className={`torque-floor-plans-header-wrapper ${style.header}`}>
        {dataSource === "entrata" ? (
          <SearchBar
            setFloorPlans={setFloorPlans}
            site={site}
            setIsFetching={setIsFetching}
          />
        ) : (
          <Header floorPlan={selectedFloorPlan} />
        )}
      </div>
      {isFetching ? (
        <Loading />
      ) : (
        Boolean(sortedFloorPlans?.length) && (
          <div className={`torque-floor-plans-selector ${style.selector}`}>
            <div className={`torque-floor-plans-list ${style.list}`}>
              <FloorPlanSelector
                floorPlans={sortedFloorPlans}
                updateSelected={setSelected}
                selected={selected}
                withDropdown={dataSource === "entrata"}
              />
            </div>
            <div className={`torque-floor-plans-thumbnail ${style.thumbnail}`}>
              <Thumbnail
                floorPlan={selectedFloorPlan}
                dataSource={dataSource}
              />
            </div>
          </div>
        )
      )}
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

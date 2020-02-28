import React, { useState, useEffect } from "react";
import axios from "axios";
import isEmpty from "../../helpers/objectHelpers";
// import getType from "../../helpers/floorplanHelpers";
import Filters from "../Filters/Filters"
import FloorplanGridView from "../FloorplanGridView/FloorplanGridView";
import { FloorplansContainer } from "./Floorplans.styles.js";
import { propertyCodes } from "./Floorplans.config";
import { filtersConfig } from "../Filters/Filters.config";

// props
//
// floorplans: object 
// availabilities: object 
const Floorplans = ({
  floorplans,
  availabilities
}) => {
  const [ allfloorplans, setAllFloorplans ] = useState(floorplans);
  const [ filteredFloorplans, setFilteredFloorplans ] = useState(floorplans);

  // console.log('propertyCodes', propertyCodes);
  // console.log('filteredFloorplans', filteredFloorplans);
  console.log('filteredFloorplans.length', filteredFloorplans.length);

  const handleFiltersUpdated = (newFilters) => {
    console.log('<Floorplans> newFilters', newFilters);
    setFilteredFloorplans(
      getType('type', newFilters['type'], allfloorplans )
    );
  }

  const getType = (filterKey, filterValue, floorplans) => {
    const allValue = filtersConfig[filterKey].values[0];
    // early exit
    if (filterValue === allValue) {
      return floorplans;
    }

    let objIndex = 0;
    const filteredFloorplans = {};
    for (let index = 0; index < Object.keys(floorplans).length; index++) {
      const filterName = filtersConfig[filterKey].data_name;
      if ( parseInt(floorplans[index][filterName]) >= parseInt(filterValue)) {
        filteredFloorplans[objIndex] = floorplans[index];
        objIndex++;
      }
    };

    return filteredFloorplans;
  }

  return (
    <>
    <Filters 
      filtersUpdated={handleFiltersUpdated}
    />
    {!isEmpty(filteredFloorplans)
      ? <FloorplansContainer>
        {Object.entries(filteredFloorplans).map(([key, floorplan]) => {
          return (
            <FloorplanGridView
              key={floorplan?.FloorplanId}
              floorplan={floorplan}
              availabilities={availabilities || null}
            />
          );
        })}
      </FloorplansContainer>
      : null}
    </>
  );
}

export default Floorplans

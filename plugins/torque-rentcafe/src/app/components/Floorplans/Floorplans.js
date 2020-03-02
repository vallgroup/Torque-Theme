import React, { useState, useEffect } from "react";
import axios from "axios";
import isEmpty from "../../helpers/objectHelpers";
import FiltersHelpers from "../../helpers/filtersHelpers";
import Filters from "../Filters/Filters"
import FloorplanGridView from "../FloorplanGridView/FloorplanGridView";
import { FloorplansContainer } from "./Floorplans.styles.js";
import { LoadingMessage } from "../../styles/App.styles";

// props
//
// floorplans: object 
// availabilities: object 
// incomeRestricted: boolean
const Floorplans = ({
  initialFloorplans,
  availabilities,
  incomeRestricted
}) => {
  const [ filteredFloorplans, setFilteredFloorplans ] = useState(initialFloorplans);
  const __filtersHelper = new FiltersHelpers(initialFloorplans);

  // filter for income-restricted listings
  useEffect(() => {
    // Filters are to be hidden and the results limited by price
    if (incomeRestricted) {
      const updatedFloorplans = __filtersHelper
        .getByIncomeRestricted() // limit results by price
        .floorplans; // return the filtered floorplans

      setFilteredFloorplans(updatedFloorplans);
    }
  }, []);

  useEffect(() => {
    // reset the floorplans in the helper
    __filtersHelper.floorplans = initialFloorplans;
  }, [filteredFloorplans]);

  const handleFiltersUpdated = (newFilters) => {

    // check whether 'townhouse' was selected, and if so default building to 'all'
    // NB: further logic found in <FilterTypeButton> lines: 26-36.
    if (newFilters.type === 'townhouse') {
      newFilters.building = 'all';
    }

    console.log('newFilters', newFilters);

    const updatedFloorplans = __filtersHelper
      .getByBuilding(newFilters['building']) // must be called first, because getByType has potential to override it if 'townhouse' is selected...
      .getByType(newFilters['type'])
      .getByAvailability(newFilters['availability'], availabilities)
      .getByPrice(newFilters['price'])
      // .getByFloor('floor', newFilters['floor'])
      .floorplans; // return the filtered floorplans

    setFilteredFloorplans(updatedFloorplans);
  }

  return (
    <>
    {!incomeRestricted
      && <Filters 
        filtersUpdated={handleFiltersUpdated}
      />}
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
      : <LoadingMessage>
        {'We couldn\'t find any floor plans matching your criteria.'}
      </LoadingMessage>}
    </>
  );
}

export default Floorplans

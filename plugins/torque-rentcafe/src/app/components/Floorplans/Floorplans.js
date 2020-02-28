import React, { useState, useEffect } from "react";
import axios from "axios";
import isEmpty from "../../helpers/objectHelpers";
import FiltersHelpers from "../../helpers/filtersHelpers";
import Filters from "../Filters/Filters"
import FloorplanGridView from "../FloorplanGridView/FloorplanGridView";
import { FloorplansContainer } from "./Floorplans.styles.js";
import { LoadingMessage } from "../../styles/App.styles";
import { displayOptions } from "../../config/Floorplans.config";

// props
//
// floorplans: object 
// availabilities: object 
const Floorplans = ({
  initialFloorplans,
  availabilities,
  incomeRestricted
}) => {
  const [ filteredFloorplans, setFilteredFloorplans ] = useState(initialFloorplans);
  const __filtersHelper = new FiltersHelpers(initialFloorplans);

  useEffect(() => {
    // Filters are to be hidden and the results limited by price
    if (incomeRestricted) {
      const updatedFloorplans = __filtersHelper
        .getByPrice(displayOptions.income_restricted_rent) // limit results by price
        .floorplans; // return the filtered floorplans

      setFilteredFloorplans(updatedFloorplans);
    }
  }, []);

  useEffect(() => {
    // reset the floorplans in the helper
    __filtersHelper.floorplans = initialFloorplans;
  }, [filteredFloorplans]);

  const handleFiltersUpdated = (newFilters) => {
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

import React, { useState, useEffect } from "react";
import axios from "axios";
import isEmpty from "../../helpers/objectHelpers";
import FiltersHelpers from "../../helpers/filtersHelpers";
import Filters from "../Filters/Filters"
import FloorplanGridView from "../FloorplanGridView/FloorplanGridView";
import {
  FloorplansContainer,
  FloorplanDisclaimer
} from "./Floorplans.styles.js";
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

  useEffect(() => {
    // if incomeRestricted is TRUE, filter for income-restricted listings
    const updatedFloorplans = __filtersHelper
      .getByIncomeRestricted(incomeRestricted) // limit results by price
      .floorplans; // return the filtered floorplans

    setFilteredFloorplans(updatedFloorplans);

  }, []);

  useEffect(() => {
    // reset the floorplans in the helper
    __filtersHelper.floorplans = initialFloorplans;
  }, [filteredFloorplans]);

  const handleFiltersUpdated = (newFilters) => {

    console.log('newFilters', newFilters);

    // check whether 'townhouse' was selected, and if so default building to 'all'
    // NB: further logic found in <FilterTypeButton> lines: 26-36.
    if (newFilters.type === 'townhouse') {
      newFilters.building = 'all';
    }

    const updatedFloorplans = __filtersHelper
      .getByIncomeRestricted(incomeRestricted)
      .getByBuilding(newFilters['building']) // must be called first, because getByType has potential to override it if 'townhouse' is selected...
      .getByType(newFilters['type'])
      .getByAvailability(newFilters['availability'], availabilities)
      .getByPrice(newFilters['price'])
      // .getByFloor('floor', newFilters['floor'])
      .floorplans; // return the filtered floorplans

    setFilteredFloorplans(updatedFloorplans);
  }

  const floorplanDisclaimer = () => {
    if (!incomeRestricted) {
      return <FloorplanDisclaimer dangerouslySetInnerHTML={{
        __html: '<p>All dimensions are approximate. Not all features are available in every apartment.</p><p>Based on availability.</p><p>Monthly utility fees will apply in addition to above rental amount, based on size of unit. Other additional fees may apply.</p>'
      }} />
    } else {
      return <FloorplanDisclaimer dangerouslySetInnerHTML={{
        __html: '<p>All dimensions are approximate. Not all features are available in every apartment.</p><p>Based on availability.</p>'
      }} />
    }
  }

  return (
    <>
    {!incomeRestricted
      && <Filters 
        filtersUpdated={handleFiltersUpdated}
      />}
    {!isEmpty(filteredFloorplans)
      ? <>
        <FloorplansContainer>
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
        {floorplanDisclaimer()}
      </>
      : <LoadingMessage>
        {'We couldn\'t find any floor plans matching your criteria.'}
      </LoadingMessage>}
    </>
  );
}

export default Floorplans

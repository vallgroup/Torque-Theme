import React, { useState, useEffect } from "react";
import { isEmpty } from "../../helpers/objectHelpers";
import FilterTypeButton from "./FilterTypeButton"
import FilterTypeRange from "./FilterTypeRange"
import {
  FiltersContainer,
  FiltersButtonsContainer,
  FiltersFormButton,
  SiteMapButton,
} from "./Filters.styles.js";
import { filtersConfig } from "../../config/Filters.config";

// props
const Filters = ({
  filtersUpdated,
  hasSiteMap,
  siteMapVisible,
  toggleSiteMap,
}) => {
  const [ currentFilters, setCurrentFilters ] = useState({});

  useEffect(() => {
    resetFilters();
  }, []);

  useEffect(() => {
    !isEmpty(currentFilters) && filtersUpdated(currentFilters);
  }, [currentFilters]);

  const updateFilters = (key, value) => {
    setCurrentFilters({
      ...currentFilters,
      [key]: value
    });
    toggleSiteMap(false);
  }

  const resetFilters = () => {
    /* Note: only searching by 'type' for Everton project */
    const newFilters = {
      type: filtersConfig.type.initial,
      // price: filtersConfig.price.initial,
      // building: filtersConfig.building.initial,
      // availability: filtersConfig.availability.initial,
      // floor: filtersConfig.floor.initial,
    };
    // update state
    setCurrentFilters(newFilters);
    // callback to update the floorplans grid
    filtersUpdated(newFilters); // NB: pass the object, not the state
  }

  const renderInputs = () => {
    return (<>
      {Object.entries(filtersConfig).map(([key, filter], index) => {
        if ('button' === filter.type) {
          return <FilterTypeButton
            currentFilters={currentFilters}
            key={key}
            filterKey={key}
            filter={filter}
            active={currentFilters[key]}
            handleChange={updateFilters}
          />
        } 
        /* Note: not in use for Everton project */
        /* else if ('range' === filter.type) {
          return <FilterTypeRange
            key={key}
            filterKey={key}
            filter={filter}
            value={currentFilters[key]}
            handleChange={updateFilters}
          />
        } */
      })}
    </>)
  }

  return (
    <>
    <FiltersContainer>
      {!isEmpty(filtersConfig)
        && renderInputs()}
      {hasSiteMap 
        && <SiteMapButton
          onClick={() => toggleSiteMap()}
          active={siteMapVisible}
        >
          {'Site Map'}
        </SiteMapButton>}
    </FiltersContainer>

    {/* Note: not used in Everton Project, as we search on 'type' change instead */}
    {/* <FiltersButtonsContainer>
      <FiltersFormButton
        type={'solid'}
        onClick={() => filtersUpdated(currentFilters)}
      >
        {'Search'}
      </FiltersFormButton>

      <FiltersFormButton
        type={'reversed'}
        onClick={() => resetFilters()}
      >
        {'Clear All'}
      </FiltersFormButton>
    </FiltersButtonsContainer> */}
    </>
  );
}

export default Filters

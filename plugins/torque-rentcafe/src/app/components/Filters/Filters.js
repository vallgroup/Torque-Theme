import React, { useState, useEffect } from "react";
import { isEmpty } from "../../helpers/objectHelpers";
import FilterTypeButton from "./FilterTypeButton"
import FilterTypeRange from "./FilterTypeRange"
import {
  FiltersContainer,
  FiltersButtonsContainer,
  FiltersFormButton,
} from "./Filters.styles.js";
import { filtersConfig } from "../../config/Filters.config";

// props
const Filters = ({
  filtersUpdated
}) => {
  const [ currentFilters, setCurrentFilters ] = useState({});

  useEffect(() => {
    resetFilters();
  }, []);

  const updateFilters = (key, value) => {
    setCurrentFilters({
      ...currentFilters,
      [key]: value
    });
  }

  const resetFilters = () => {
    const newFilters = {
      type: filtersConfig.type.initial,
      price: filtersConfig.price.initial,
      building: filtersConfig.building.initial,
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
        } else if ('range' === filter.type) {
          return <FilterTypeRange
            key={key}
            filterKey={key}
            filter={filter}
            value={currentFilters[key]}
            handleChange={updateFilters}
          />
        }
      })}
    </>)
  }

  return (
    <>
    <FiltersContainer>
      {!isEmpty(filtersConfig)
        && renderInputs()}
    </FiltersContainer>

    <FiltersButtonsContainer>
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
    </FiltersButtonsContainer>
    </>
  );
}

export default Filters

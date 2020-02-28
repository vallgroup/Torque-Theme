import React, { useState, useEffect } from "react";
import isEmpty from "../../helpers/objectHelpers";
import FilterTypeButton from "./FilterTypeButton"
import FilterTypeRange from "./FilterTypeRange"
import {
  FiltersContainer,
  FiltersButtonsContainer,
  FiltersFormButton,
} from "./Filters.styles.js";
import { filtersConfig } from "./Filters.config";

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
      availability: filtersConfig.availability.initial,
      price: filtersConfig.price.initial,
      building: filtersConfig.building.initial,
      floor: filtersConfig.floor.initial,
    };
    setCurrentFilters(newFilters);
  }

  const renderInputs = () => {
    return (<>
      {Object.entries(filtersConfig).map(([key, filter], index) => {
        if ('button' === filter.type) {
          return <FilterTypeButton
            filterKey={key}
            filter={filter}
            active={currentFilters[key]}
            handleChange={updateFilters}
          />
        } else if ('range' === filter.type) {
          return <FilterTypeRange
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

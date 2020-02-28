import React, { useState, useEffect } from "react";
import {
  FilterContainer,
  FilterTitle,
  FilterButtonsContainer,
  FilterButton,
} from "./Filters.styles.js";

const FilterTypeButton = ({
  filterKey,
  filter,
  active,
  handleChange
}) => {
  return (
    active
      ? <FilterContainer
          key={filterKey}
        >
          <FilterTitle>{filter.title}</FilterTitle>
          <FilterButtonsContainer>
            {filter.values.map((value, index) => {
              return (
                <FilterButton
                  key={index}
                  value={value}
                  active={value === active}
                  onClick={(event) => handleChange(filterKey, event.target.value)}
                >
                  {value}
                </FilterButton>
              )
            })}
          </FilterButtonsContainer>
        </FilterContainer>
      : null
  )
}

export default FilterTypeButton

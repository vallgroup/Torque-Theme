import React, { useState, useEffect } from "react";
import numberWithCommas from "../../helpers/numberHelpers";
import {
  FilterContainer,
  FilterTitle,
  FilterRangeContainer,
  FilterRange,
  RangeMin,
  RangeMax,
} from "./Filters.styles.js";

const FilterTypeRange = ({
  filterKey,
  filter,
  value,
  handleChange
}) => {
  return (
    value 
      ? <FilterContainer
          key={filterKey}
        >
          <FilterTitle>{(filter.title || 'filter') + numberWithCommas(value)}</FilterTitle>
          <FilterRangeContainer>
            <FilterRange
              type={'range'} 
              min={filter.values.min}
              max={filter.values.max}
              value={value}
              onChange={(event) => handleChange(filterKey, event.target.value)}
              step={filter.values.step}
            />
            <RangeMin>
              {'$' + numberWithCommas(filter.values.min)}
            </RangeMin>
            <RangeMax>
              {'$' + numberWithCommas(filter.values.max) + '+'}
            </RangeMax>
          </FilterRangeContainer>
        </FilterContainer>
      : null
  )
}

export default FilterTypeRange

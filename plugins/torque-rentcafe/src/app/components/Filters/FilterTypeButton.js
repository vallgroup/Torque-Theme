import React, { useState, useEffect } from "react";
import {
  FilterContainer,
  FilterTitle,
  FilterButtonsContainer,
  FilterButton,
  SiteMapButton,
} from "./Filters.styles.js";

const FilterTypeButton = ({
  currentFilters,
  filterKey,
  filter,
  active,
  handleChange,
  includeSiteMapBtn,
  hasSiteMap,
  siteMapVisible,
  toggleSiteMap,
}) => {
  return (
    active
      ? <FilterContainer
          id={filterKey}
          key={filterKey}
        >
          <FilterTitle>{filter.title}</FilterTitle>
          <FilterButtonsContainer>
            {filter.values.map((value, index) => {

              const isDisabled = filterKey === 'building'
                && currentFilters.type === 'townhouse'
                && (value === 'north' || value === 'south');

              const isActive = (value === active
                && filterKey !== 'building')
                || (value === active
                  && currentFilters.type !== 'townhouse')
                || (filterKey === 'building'
                  && value === 'all'
                  && currentFilters.type === 'townhouse');
              
              return (
                <FilterButton
                  key={index}
                  value={value}
                  active={isActive}
                  disabled={isDisabled}
                  onClick={(event) => handleChange(filterKey, event.target.value)}
                >
                  {value}
                </FilterButton>
              )
            })}
            {includeSiteMapBtn && hasSiteMap
              && <SiteMapButton
                onClick={() => toggleSiteMap()}
                active={siteMapVisible}
              >
                {'Site Map'}
              </SiteMapButton>}
          </FilterButtonsContainer>
        </FilterContainer>
      : null
  )
}

export default FilterTypeButton

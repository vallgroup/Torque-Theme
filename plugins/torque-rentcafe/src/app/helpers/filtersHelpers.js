import { filtersConfig } from "../config/Filters.config";
import { buildingCodes } from "../config/Floorplans.config";
/**
 * 
 */
export default class FiltersHelpers {

  constructor(floorplans) {
    this.floorplans = floorplans;
  }

  getByType (filterValue) {
    const filterKey = 'type';
    // early exit, if filter value as initial
    const allValue = filtersConfig[filterKey].values[0];
    if (filterValue === allValue) {
      return this;
    }

    // if townhouse is selected, filter by building instead
    if ( filterValue === 'townhouse' ) {
      // update the key and filter by building instead
      return this.getByBuilding(filterValue)
    }

    // if studio is selected, update the search value to 0
    if ( filterValue === 'studio' ) {
      filterValue = 0;
    }

    const operator = (floorplanValue, filterValue) => {
      return parseInt(floorplanValue) === parseInt(filterValue);
    };

    this.loopThroughFilters(filterKey, filterValue, operator);

    return this;
  }

  getByAvailability (filterValue, availabilities) {
    const filterKey = 'availability';
    // early exit, if filter value as initial
    const allValue = filtersConfig[filterKey].values[0];
    let filterValueLower = 0;
    let filterValueUpper = 0;

    if (filterValue === allValue) {
      return this;
    } else if (filterValue === 'now') {
      // current month
      // >= today + 0
      // <= today + 30 days
      const todaysDate = new Date();
      filterValueLower = todaysDate.setDate(todaysDate.getDate() + 0); // today() + 0 days
      filterValueUpper = todaysDate.setDate(todaysDate.getDate() + 30); // today() + 30 days
    } else { 
      // assume only other option (1-3 months)
      // >= today + 30 days
      // <= today + 120 days
      const todaysDate = new Date();
      filterValueLower = todaysDate.setDate(todaysDate.getDate() + 30); // today() + 30 days
      filterValueUpper = todaysDate.setDate(todaysDate.getDate() + 120); // today() + 120 days
    }

    // define operator
    const operator = (floorplanValue, filterValueLower, filterValueUpper) => {
      // assuming floorplanValue format: MM/DD/YYYY
      floorplanValue = floorplanValue.split("/"); // get date parts
      floorplanValue = new Date(floorplanValue[2], floorplanValue[0] - 1, floorplanValue[1]);  // Y/M/D & months are 0-based
      floorplanValue = floorplanValue.setDate(floorplanValue.getDate()); // get date in correct format for comparison

      return (
        (floorplanValue >= filterValueLower)
        && (floorplanValue <= filterValueUpper)
      );
    };

    this.loopThroughFiltersForAvailability(filterKey, filterValueLower, filterValueUpper, operator, availabilities);

    return this;
  }

  getByPrice (filterValue) {
    const filterKey = 'price';
    // early exit, if filter value is equal to max, return all
    if ( filterValue === filtersConfig[filterKey].values.max ) {
      return this;
    }

    const operator = (floorplanValue, filterValue) => {
      return parseInt(floorplanValue) <= parseInt(filterValue);
    };

    this.loopThroughFilters(filterKey, filterValue, operator);

    return this;
  }

  getByBuilding (filterValue) {
    const filterKey = 'building';
    // early exit, if filter value as initial
    const allValue = filtersConfig[filterKey].values[0];
    if (filterValue === allValue) {
      return this;
    }

    // set the filter value to a property ID based on the mapped building codes
    filterValue = buildingCodes[filterValue].property_id;

    const operator = (floorplanValue, filterValue) => {
      return parseInt(floorplanValue) === parseInt(filterValue);
    };

    this.loopThroughFilters(filterKey, filterValue, operator);

    return this;
  }

  /**
   * 
   * @param {string} filterKey 
   * @param {string} filterValue 
   * @param {function} operator 
   */
  loopThroughFilters (filterKey, filterValue, operator) {
    let objIndex = 0;
    const filteredFloorplans = {};
    const floorplanKeys = Object.keys(this.floorplans);

    floorplanKeys.forEach((key, index) => {
      const filterName = filtersConfig[filterKey].data_name;
      if ( operator(this.floorplans[index][filterName], filterValue) ) {
        filteredFloorplans[objIndex] = this.floorplans[index];
        objIndex++;
      }
    });
        
    this.floorplans = filteredFloorplans;

    return this;
  }

  /**
   * 
   * @param {string} filterKey 
   * @param {Date} filterValueLower 
   * @param {Date} filterValueUpper 
   * @param {function} operator 
   * @param {object} availabilities 
   */
  loopThroughFiltersForAvailability (filterKey, filterValueLower, filterValueUpper, operator, availabilities) {
    let objIndex = 0;
    const filteredFloorplans = {};
    const floorplanKeys = Object.keys(this.floorplans);

    floorplanKeys.forEach((key, index) => {
      const filterName = filtersConfig[filterKey].data_name;
      const floorplanValue = this.findFirstAvailability(this.floorplans[index], availabilities);
      if ( operator(floorplanValue, filterValueLower, filterValueUpper) ) {
        filteredFloorplans[objIndex] = this.floorplans[index];
        objIndex++;
      }
    });
        
    this.floorplans = filteredFloorplans;

    return this;
  }

  /**
   * Given a floorplan (which has a FloorPlanId), find the first matching availability in the availabilities provided
   * 
   * @param {object} floorplan 
   * @param {object} availabilities 
   */
  findFirstAvailability (floorplan, availabilities) {
    let fpAvailable = null;
    for (let index = 0; index < Object.keys(availabilities).length; index++) {
      if ( availabilities[index].FloorplanId === floorplan.FloorplanId ) {
        fpAvailable = availabilities[index].AvailableDate;
        break;
      }
    };
    return fpAvailable;
  }
}

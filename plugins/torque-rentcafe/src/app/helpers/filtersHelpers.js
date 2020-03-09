import { filtersConfig } from "../config/Filters.config";
import { buildingCodes } from "../config/Floorplans.config";
import {
  isEmpty,
  sortObjectOfObjectsAlphabetically
} from "../helpers/objectHelpers";
/**
 * 
 */
export default class FiltersHelpers {

  constructor(floorplans) {
    this.floorplans = floorplans;
  }

  sortAlphabetically () {
    if (!isEmpty(this.floorplans)) {
      this.floorplans = sortObjectOfObjectsAlphabetically(this.floorplans, 'FloorplanName');
    }
    return this;
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

  getOnlyAvailable (availabilities) {
    let objIndex = 0;
    const filteredFloorplans = {};
    const floorplanKeys = Object.keys(this.floorplans);

    // for each floorplan, check if matching entries in availabilities
    floorplanKeys.forEach((key, index) => {
      // returns null if not found
      const floorplanValue = this.findFirstAvailability(this.floorplans[index], availabilities);
      if ( floorplanValue ) {
        filteredFloorplans[objIndex] = this.floorplans[index];
        objIndex++;
      }
    });
        
    this.floorplans = filteredFloorplans;

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
      // >= today + 0 && <= today + 30 days
      const todaysDate = new Date();
      filterValueLower = todaysDate.setDate(todaysDate.getDate() + 0); // today() + 0 days
      filterValueUpper = todaysDate.setDate(todaysDate.getDate() + 30); // today() + 30 days
    } else { 
      // assume only other option (1-3 months)
      // >= today + 30 days && <= today + 120 days
      const todaysDate = new Date();
      filterValueLower = todaysDate.setDate(todaysDate.getDate() + 30); // today() + 30 days
      filterValueUpper = todaysDate.setDate(todaysDate.getDate() + 120); // today() + 120 days
    }

    // define operator
    const operator = (floorplanValue, filterValueLower, filterValueUpper) => {
      // get fp date date in milliseconds
      const floorplanValueParsed = Date.parse(floorplanValue);
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

    // if filter value is equal to max, update the operator to include >= as well as <=
    if ( filterValue === filtersConfig[filterKey].values.max ) {

      const operator = (floorplanValue, filterValue) => {
        return (
          (
            parseInt(floorplanValue) <= parseInt(filterValue)
            || parseInt(floorplanValue) >= parseInt(filterValue)
          )
          && parseInt(floorplanValue) !== -1
          && floorplanValue.toLowerCase() !== 'n/a'
          && floorplanValue !== ''
        );
      };

      this.loopThroughFilters(filterKey, filterValue, operator);

    } else {

      const operator = (floorplanValue, filterValue) => {
        return (
          parseInt(floorplanValue) <= parseInt(filterValue)
          && parseInt(floorplanValue) !== -1
          && floorplanValue.toLowerCase() !== 'n/a'
          && floorplanValue !== ''
        );
      };

      this.loopThroughFilters(filterKey, filterValue, operator);

    }

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

  getByIncomeRestricted (returnIncomeRestricted = false) {
    let objIndex = 0;
    const filteredFloorplans = {};
    const floorplanKeys = Object.keys(this.floorplans);
    const hasA = new RegExp(/(.*)A$/);

    // check floorplan name for 'A' 
    floorplanKeys.forEach((key, index) => {
      if ( returnIncomeRestricted && hasA.test(this.floorplans[index].FloorplanName) ) {
        // keep only ARO, if 'A' in title
        filteredFloorplans[objIndex] = this.floorplans[index];
        objIndex++;
      } else if ( !returnIncomeRestricted && !hasA.test(this.floorplans[index].FloorplanName) ) {
        // keep only non-ARO, if 'A' not in title
        filteredFloorplans[objIndex] = this.floorplans[index];
        objIndex++;
      }
    });

    this.floorplans = filteredFloorplans;

    return this;
  }

  removeIncomeRestricted () {
    let objIndex = 0;
    const filteredFloorplans = {};
    const floorplanKeys = Object.keys(this.floorplans);
    const hasA = new RegExp(/(.*)A$/);

    // check floorplan name for 'A' 
    floorplanKeys.forEach((key, index) => {
      if ( !hasA.test(this.floorplans[index].FloorplanName) ) {
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
      if ( floorplanValue && operator(floorplanValue, filterValueLower, filterValueUpper) ) {
        filteredFloorplans[objIndex] = this.floorplans[index];
        objIndex++;
      }
    });
        
    this.floorplans = filteredFloorplans;

    return this;
  }

  /**
   * Given a floorplan (which has a FloorPlanId);
   * 1) find all matching availabilities in the availabilities provided
   * 2) of those availablities, get the most recent/soonest
   * 
   * @param {object} floorplan 
   * @param {object} availabilities 
   */
  findFirstAvailability (floorplan, availabilities) {
    let dateIndex = 0;
    let fpAvailable = [];
    for (let index = 0; index < Object.keys(availabilities).length; index++) {
      if (availabilities[index].FloorplanId === floorplan.FloorplanId) {
        fpAvailable[dateIndex] = availabilities[index].AvailableDate;
        dateIndex++;
      }
    };
    
    // sort date in ASC order
    fpAvailable.sort((a, b) => {
      return Date.parse(a) - Date.parse(b);
    });

    // return the first availability
    return fpAvailable[0] || null;
  }
}

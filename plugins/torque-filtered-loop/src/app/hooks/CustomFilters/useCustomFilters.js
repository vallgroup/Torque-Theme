import { useMemo, useEffect, useState } from "react";
import useCustomFilterSettings from "./useCustomFilterSettings";
import useQueryString from "../useQueryString";
import { arrayContains, removeArrayItem, arrEmpty } from "../../helpers";

export default (filtersTypes, filtersArgs) => {
  const [query, setQueryStringParam] = useQueryString();

  const filterSettings = useCustomFilterSettings(filtersTypes, filtersArgs);

  const initFilters = {};
  filterSettings.forEach(filter => {
    if (query[filter.args]) initFilters[filter.id] = query[filter.args];
  });

  const [filters, setFilters] = useState(initFilters);

  // Use to create an update function specific to each filter.
  // createFilterUpdater('some_filter_id') becomes a function you can pass to that filter's onChange handler
  const createFilterUpdater = useMemo(
    () => (filterId) => (value, multiSelect = false) => () => {

      // console.log('filterId', filterId)
      // console.log('value', value)
      // console.log('multiSelect', multiSelect)

      if (
        multiSelect 
        && 0 !== value
      ) {
        value = combineFilterValues(filterId, value);
      }

      setFilters(filters => ({
        ...filters,
        [filterId]: value
      })),
    []
    }
  );

  // update query string if filters change
  useEffect(
    () => {
      // console.log('filters', filters)
      let filterId = "";
      for (filterId in filters) {
        const filterSetting = filterSettings.find(({ id }) => id === filterId);
        if (filterSetting && !["dropdown_date"].includes(filterSetting.type))
          setQueryStringParam(filterSetting.args, filters[filterId]);
      }
    },
    [filters]
  );

  const combineFilterValues = (filterId, value) => {
    let _newValue = value;

    if (Array.isArray(filters[filterId])) {
      // console.log('filter val IS in array')
      
      if (arrayContains(filters[filterId], value)) {
        // console.log('filter val exists in array, so REMOVE it')
        _newValue = removeArrayItem(filters[filterId], value)
      } else {
        // console.log('filter val not in array, so ADD it')
        filters[filterId].push(value)
        _newValue = filters[filterId]
      }

      if (arrEmpty(_newValue)) {
        // console.log('array now empty, so set val to 0 to reset filter')
        _newValue = 0
      } else if (1 === _newValue.length) {
        // console.log('array now only has 1 val, so convert to an int instead')
        _newValue = _newValue[0]
      }

    } else if (
      filters[filterId]
      && 0 !== value
    ) {
      // console.log('filter val not AN array')

      if (filters[filterId] === value) {
        // console.log('filter val already selected, so REMOVE it')
        _newValue = 0
      } else {
        // console.log('filter key exists, but val not found, so ADD it')
        _newValue = [
          filters[filterId],
          value
        ]
      }
      
    }

    // console.log('_newValue', _newValue)
    // console.log('---------------')

    return _newValue;
  }

  return { filterSettings, filters, createFilterUpdater };
};

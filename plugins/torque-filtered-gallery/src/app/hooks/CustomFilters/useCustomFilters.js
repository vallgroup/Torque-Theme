import { useMemo, useEffect, useState } from "react";
import useCustomFilterSettings from "./useCustomFilterSettings";
import useQueryString from "../useQueryString";

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
    () => filterId => value => () =>
      setFilters(filters => ({
        ...filters,
        [filterId]: value
      })),
    []
  );

  // update query string if filters change
  useEffect(
    () => {
      let filterId = "";
      for (filterId in filters) {
        const filterSetting = filterSettings.find(({ id }) => id === filterId);
        if (filterSetting && !["dropdown_date"].includes(filterSetting.type))
          setQueryStringParam(filterSetting.args, filters[filterId]);
      }
    },
    [filters]
  );

  return { filterSettings, filters, createFilterUpdater };
};

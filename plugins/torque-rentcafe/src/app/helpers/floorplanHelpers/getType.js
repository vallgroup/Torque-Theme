import { useState, useEffect } from "react";
import { filtersConfig } from "../Components/Filters/Filters.config";

export default (filterKey, filterValue, floorplans) => {
  // request
  const [filteredFloorplans, setFilteredFloorplans] = useState({});
  
  useEffect(
    () => {
      const updatedFloorplans = Object.entries(floorplans).filter(([key, floorplan], index) => {
        const data_name = filters[filterKey].data_name;
        return parseInt(floorplan[data_name]) >= filterValue;
      });
      setFilteredFloorplans(updatedFloorplans);
    },
    [filterKey, filterValue, floorplans]
  );

  return { filteredFloorplans };
};

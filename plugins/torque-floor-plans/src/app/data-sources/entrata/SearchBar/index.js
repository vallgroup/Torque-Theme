import React, { memo, useState, useEffect, useCallback } from "react";
import classnames from "classnames";
import Entrata from "..";
import Loading from "../../../Loading";
import DatePicker from "react-datepicker";
import style from "./SearchBar.scss";

const SearchBar = ({ setFloorPlans, site, setIsFetching }) => {
  const [unitTypes, setUnitTypes] = useState([]);
  const [selectedUnitTypes, setSelectedUnitTypes] = useState([]);
  const [startDate, setStartDate] = useState();

  useEffect(
    () => {
      const getUnitTypes = async () => {
        const entrata = new Entrata({ site });
        const unitTypes = await entrata.getUnitTypes();

        setSelectedUnitTypes([]);
        setUnitTypes(unitTypes);
      };

      getUnitTypes();
    },
    [site]
  );

  const handleUnitTypeClick = name => () => {
    const newSelectedUnitTypes = selectedUnitTypes.splice(0);
    const index = newSelectedUnitTypes.indexOf(name);

    index > -1
      ? newSelectedUnitTypes.splice(index, 1)
      : newSelectedUnitTypes.push(name);

    setSelectedUnitTypes(newSelectedUnitTypes);
  };

  const handleDateChange = date => setStartDate(new Date(date));
  useEffect(
    () => {
      // very hacky way to pass this to another component,
      // but we dont want to integrate redux
      // and it really doesnt make sense to move this to the top level App, since it's only relevant to Entrata
      window.torqueStartDate = formatDate(startDate);
    },
    [startDate]
  );

  const handleSubmit = async () => {
    setIsFetching(true);
    const finalUnitTypes = selectedUnitTypes.length
      ? selectedUnitTypes
      : Object.keys(unitTypes); //  if no unit types are selecting then use them all
    const unitTypeIds = finalUnitTypes
      .reduce((acc, unitType) => [...acc, ...unitTypes[unitType]], [])
      .filter(Boolean)
      .join(",");

    let finalStartDate = startDate;
    if (!startDate) {
      // default start date to today if they dont select one
      finalStartDate = new Date();
      setStartDate(finalStartDate);
    }

    const formattedStartDate = formatDate(finalStartDate);

    const entrata = new Entrata({ site });
    const floorPlans = await entrata.getFloorPlans({
      unitTypeIds: unitTypeIds,
      startDate: formattedStartDate
    });

    setIsFetching(false);
    setFloorPlans(floorPlans);
  };

  useEffect(
    () => {
      // submit to get all floor posts on initial load
      if (Object.keys(unitTypes).length) handleSubmit();
    },
    [unitTypes]
  );

  return (
    <div className={classnames("search-bar", style.root)}>
      <div className={classnames("search-bar-title", style.title)}>
        {"Select apartment type and move-in date"}
      </div>

      <div className={classnames("unit-types", style.unit_types)}>
        {Object.keys(unitTypes).length ? (
          Object.keys(unitTypes).map(unitType => (
            <div
              key={unitType}
              className={classnames("unit-type", {
                ["selected"]: selectedUnitTypes.includes(unitType)
              })}
              onClick={handleUnitTypeClick(unitType)}
            >
              {unitType.toUpperCase()}
            </div>
          ))
        ) : (
          <Loading />
        )}
      </div>

      <div className="date-picker-wrapper">
        <DatePicker
          selected={startDate}
          onChange={handleDateChange}
          className="date-picker"
          placeholderText="Move-in date"
        />
      </div>

      <button onClick={handleSubmit} className="search-button">
        {"Search"}
      </button>
    </div>
  );
};

function formatDate(date) {
  if (!date) return "";

  return date.toLocaleDateString("en-US", {
    month: "2-digit",
    day: "2-digit",
    year: "numeric"
  });
}

export default memo(SearchBar);

import React, { memo, useState, useEffect, useCallback } from "react";
import classnames from "classnames";
import Entrata from "..";
import DatePicker from "react-datepicker";
import style from "./SearchBar.scss";

const SearchBar = ({ setFloorPlans, site }) => {
  const [unitTypes, setUnitTypes] = useState([]);
  const [selectedUnitTypes, setSelectedUnitTypes] = useState([]);
  const [startDate, setStartDate] = useState();

  const getUnitTypes = useCallback(
    async () => {
      const entrata = new Entrata({ site });
      const unitTypes = await entrata.getUnitTypes();

      setUnitTypes(unitTypes);
      setSelectedUnitTypes([]);
    },
    [site]
  );

  useEffect(
    () => {
      getUnitTypes();
    },
    [getUnitTypes]
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

  const handleSubmit = async () => {
    const unitTypeIds = selectedUnitTypes
      .reduce((acc, unitType) => [...acc, ...unitTypes[unitType]], [])
      .filter(Boolean)
      .join(",");

    let finalStartDate = startDate;
    if (!startDate) {
      // default start date to today if they dont select one
      finalStartDate = new Date();
      setStartDate(finalStartDate);
    }

    const formattedStartDate = finalStartDate.toLocaleDateString("en-US", {
      month: "2-digit",
      day: "2-digit",
      year: "numeric"
    });

    const entrata = new Entrata({ site });
    const floorPlans = await entrata.getFloorPlans({
      unitTypeIds: unitTypeIds.length ? unitTypeIds : undefined,
      startDate: formattedStartDate
    });

    setFloorPlans(floorPlans);
  };

  return (
    <div className={classnames("search-bar", style.root)}>
      <div className={classnames("search-bar-title", style.title)}>
        {"Select apartment type and move-in date"}
      </div>

      <div className={classnames("unit-types", style.unit_types)}>
        {Object.keys(unitTypes).map(unitType => (
          <div
            key={unitType}
            className={classnames("unit-type", {
              ["selected"]: selectedUnitTypes.includes(unitType)
            })}
            onClick={handleUnitTypeClick(unitType)}
          >
            {unitType.toUpperCase()}
          </div>
        ))}
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

export default memo(SearchBar);

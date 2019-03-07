import React, { memo, useState, useEffect } from "react";
import Entrata from "..";
import DatePicker from "react-datepicker";
import style from "./SearchBar.scss";

const SearchBar = ({ setFloorPlans, site }) => {
  const [unitTypes, setUnitTypes] = useState([]);
  const [selectedUnitTypes, setSelectedUnitTypes] = useState([]);
  const [startDate, setStartDate] = useState(new Date());

  const getUnitTypes = async () => {
    const entrata = new Entrata({ site });
    const unitTypes = await entrata.getUnitTypes();

    setUnitTypes(unitTypes);
    setSelectedUnitTypes([]);
  };

  useEffect(
    () => {
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

  const handleSubmit = async () => {
    const unitTypeIds = selectedUnitTypes
      .reduce((acc, unitType) => [...acc, ...unitTypes[unitType]], [])
      .filter(Boolean)
      .join(",");

    const formattedStartDate = startDate.toLocaleDateString("en-US", {
      month: "2-digit",
      day: "2-digit",
      year: "numeric"
    });

    const entrata = new Entrata({ site });
    const floorPlansResults = await entrata.getFloorPlans({
      unitTypeIds: unitTypeIds.length ? unitTypeIds : undefined,
      startDate: formattedStartDate
    });

    const floorPlans = floorPlansResults.map(floorPlan => ({
      downloads: { pdf: "" },
      floor_number: 0,
      post_title: floorPlan?.UnitTypes?.UnitType[0]["@value"],
      rsf: floorPlan?.SquareFeet["@attributes"]?.Max.toString(),
      thumbnail: floorPlan?.File[0]?.Src
    }));

    setFloorPlans(floorPlans);
  };

  return (
    <div className={style.root}>
      <div>{"Select apartment type and move-in date"}</div>
      <div className={style.search_wrapper}>
        {Object.keys(unitTypes).map(unitType => (
          <div key={unitType} onClick={handleUnitTypeClick(unitType)}>
            {unitType}
          </div>
        ))}
      </div>
      <DatePicker selected={startDate} onChange={handleDateChange} />
      <button onClick={handleSubmit}>{"Search"}</button>
    </div>
  );
};

export default memo(SearchBar);

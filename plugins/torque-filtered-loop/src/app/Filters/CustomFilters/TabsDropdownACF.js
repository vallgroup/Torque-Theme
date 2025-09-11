import React, { memo } from "react";
import Filters from "..";
import { useACFSelectChoices } from "../../hooks";
import { Dropdown } from "../../components";
import { useIsDesktop } from "../../hooks/useIsDesktop";

const TabsDropdownACF = ({ site, value, onChange, args }) => {
  const isDesktop = useIsDesktop();
  if (typeof args !== "string") {
    console.warn(
      `TabsACF: expected args to be an acf select field id but got ${args}`
    );
    return null;
  }

  const choices = useACFSelectChoices(site, args);
  // hijack the Filters component to use its' markup.. we just have to change the choices to fit
  const filterOptions = Object.keys(choices).map((choiceKey) => ({
    term_id: choiceKey,
    name: choices[choiceKey],
  }));

  const dropdownOptions = Object.keys(choices).map((choiceKey) => ({
    key: choiceKey,
    name: choices[choiceKey],
  }));

  return (
    <>
      {isDesktop ? (
        <Filters
          className="torque-acf-tabs-filters"
          terms={filterOptions}
          activeTerm={value}
          updateActiveTerm={onChange}
        />
      ) : (
        <Dropdown
          title={value || "All"}
          options={dropdownOptions}
          value={value}
          onChange={onChange}
          id="dropdown-tax"
        />
      )}
    </>
  );
};

export default memo(TabsDropdownACF);

import React, { memo } from "react";
import Filters from "..";
import { useACFSelectChoices } from "../../hooks";

const TabsACF = ({ site, value, onChange, args }) => {
  if (typeof args !== "string") {
    console.warn(
      `TabsACF: expected args to be an acf select field id but got ${args}`
    );
    return null;
  }

  const choices = useACFSelectChoices(site, args);
  // hijack the Filters component to use its' markup.. we just have to change the choices to fit
  const filterOptions = Object.keys(choices).map(choiceKey => ({
    term_id: choiceKey,
    name: choices[choiceKey]
  }));

  return (
    <Filters
      className="torque-acf-tabs-filters"
      terms={filterOptions}
      activeTerm={value}
      updateActiveTerm={onChange}
    />
  );
};

export default memo(TabsACF);

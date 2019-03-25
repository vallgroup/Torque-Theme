import React, { memo } from "React";
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

  return (
    <Filters
      className="torque-acf-tabs-filters"
      terms={choices}
      activeTerm={0}
      updateActiveTerm={onChange}
      hideAllOption
    />
  );
};

export default memo(TabsACF);

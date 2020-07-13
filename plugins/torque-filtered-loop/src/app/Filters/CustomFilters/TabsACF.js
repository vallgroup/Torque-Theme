import React, { memo } from "React";
import Filters from "..";
import { useACFSelectChoices } from "../../hooks";

const TabsACF = ({ filters, value, onChange }) => {

  if (!filters) {
    return null;
  }

  return (
    <Filters
      className="torque-acf-tabs-filters"
      terms={filters}
      activeTerm={value || 0}
      updateActiveTerm={onChange}
    />
  );
};

export default memo(TabsACF);

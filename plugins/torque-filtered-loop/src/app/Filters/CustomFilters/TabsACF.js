import React, { memo } from "React";
import Filters from "..";
import { useWPTerms } from "../../hooks";

const TabsACF = ({ site, value, onChange, args }) => {
  return (
    <Filters
      className="torque-acf-tabs-filters"
      terms={[]}
      activeTerm={0}
      updateActiveTerm={onChange}
      hideAllOption
    />
  );
};
export default memo(TabsACF);

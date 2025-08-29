import React, { memo, useMemo } from "react";
import { Dropdown } from "../../components";
import { useDateChoices } from "../../hooks";

const DropdownDate = ({ site, value, onChange, postType, useCustomLabel }) => {
  const dates = useDateChoices(site, postType);

  const dropdownOptions = useMemo(
    () =>
      dates.map((date) => ({
        key: date,
        name: date,
      })),
    [dates]
  );

  return dates?.length ? (
    <Dropdown
      title={useCustomLabel ? "Date" : "Filter by Date"}
      options={dropdownOptions}
      value={value}
      onChange={onChange}
      id="dropdown-date"
    />
  ) : null;
};

export default memo(DropdownDate);

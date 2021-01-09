import React, { memo, useMemo } from "react";
import { Dropdown } from "../../components";
import { useDateChoices } from "../../hooks";

const DropdownDate = ({ site, value, onChange, postType }) => {
  const dates = useDateChoices(site, postType);

  const dropdownOptions = useMemo(
    () =>
      dates.map(date => ({
        key: date,
        name: date
      })),
    [dates]
  );

  return dates?.length ? (
    <Dropdown
      title={'Date'}
      options={dropdownOptions}
      value={value}
      onChange={onChange}
    />
  ) : null;
};

export default memo(DropdownDate);

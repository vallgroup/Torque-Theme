import React, { memo, useMemo } from "react";
import { Tabs } from "../../components";
import { useDateChoices } from "../../hooks";

const TabsDate = ({ site, value, onChange, postType }) => {
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
    <Tabs
      title={'Date'}
      options={dropdownOptions}
      value={value}
      onChange={onChange}
    />
  ) : null;
};

export default memo(TabsDate);

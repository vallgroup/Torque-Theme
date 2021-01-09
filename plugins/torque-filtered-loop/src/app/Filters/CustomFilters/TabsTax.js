import React, { memo, useMemo, useEffect, useState } from "react";
import { Tabs } from "../../components";
import Filters from "..";
import { useWPTerms } from "../../hooks";

const TabsTax = ({ site, value, onChange, args, multiSelect = false }) => {
  const [filterTitle, setFilterTitle] = useState('Filter')

  if (typeof args !== "string") {
    console.warn(`TabsTax: expected args to be a tax but got ${args}`);
    return null;
  }

  const [terms, taxName] = useWPTerms(site, args);

  const tabsOptions = useMemo(
    () =>
      terms.map(term => ({
        key: term.term_id,
        name: term.name
      })),
    [terms]
  );

  // set the filter title
  useEffect(() => {
    if ('Categories' === taxName) {
      setFilterTitle('View')
    } else if ('Tags' === taxName) {
      setFilterTitle('Tags')
    } else {
      setFilterTitle(taxName)
    }
  },[taxName])

  return terms?.length ? (
    <Tabs
      title={filterTitle}
      options={tabsOptions}
      value={value}
      onChange={onChange}
      multiSelect={multiSelect}
  />
  ) : null;
};

export default memo(TabsTax);

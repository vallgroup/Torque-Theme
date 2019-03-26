import React, { memo, useMemo } from "react";
import { Dropdown } from "../../components";
import { useWPTerms } from "../../hooks";

const DropdownTax = ({ site, value, onChange, args }) => {
  if (typeof args !== "string") {
    console.warn(`DropdownTax: expected args to be a tax but got ${args}`);
    return null;
  }

  const [terms, taxName] = useWPTerms(site, args);
  const dropdownOptions = useMemo(
    () =>
      terms.map(term => ({
        key: term.term_id,
        name: term.name
      })),
    [terms]
  );

  return terms?.length ? (
    <Dropdown
      title={`Filter by ${taxName}`}
      options={dropdownOptions}
      value={value}
      onChange={onChange}
    />
  ) : null;
};

export default memo(DropdownTax);

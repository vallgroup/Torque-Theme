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
    () => {
      if ('Regions' === taxName) {
console.log(terms, taxName)
        sortByNeighborhood(terms)
      }
      return terms.map(term => ({
        key: term.term_id,
        name: term.name
      }))
    },
    [terms, taxName]
  );


  return terms?.length ? (
    <Dropdown
      title={`Filter by ${taxName}`}
      options={dropdownOptions}
      value={value}
      onChange={onChange}
    />
  ) : null;

  function sortByNeighborhood(terms) {
    const neighborhoods = [
      'Chicago Near West',
      'Chicago North',
      'Chicago North and West Suburbs',
      'Chicago South',
      'Chicago South Suburbs',
      'Chicago West',
    ];

    return terms.sort((a, b) => {

      if (-1 !== neighborhoods.indexOf(a.name)
        && -1 !== neighborhoods.indexOf(b.name)) {
        return 0;
      } else
      if (-1 !== neighborhoods.indexOf(a.name)) {
        return -1;
      } else
      if(-1 !== neighborhoods.indexOf(b.name)) {
        return 1;
      }
    })
  }
};

export default memo(DropdownTax);

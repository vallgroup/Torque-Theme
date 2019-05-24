import React, { memo, useMemo } from "react";
import { Dropdown } from "../../components";
import { useWPTerms } from "../../hooks";
import { useNeighborhoodOrder } from "../../hooks";

const DropdownTax = ({ site, value, onChange, args }) => {
  if (typeof args !== "string") {
    console.warn(`DropdownTax: expected args to be a tax but got ${args}`);
    return null;
  }

  const [terms, taxName] = useWPTerms(site, args);
  const order = useNeighborhoodOrder(site);

  const dropdownOptions = useMemo(
    () => {
      if ('Regions' === taxName) {
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
    if (0 === order.length) {
      return terms;
    }

    return terms.sort((a, b) => {

      if (-1 !== order.indexOf(a.term_id)
        && -1 !== order.indexOf(b.term_id)) {
        return 0;
      } else
      if (-1 !== order.indexOf(a.term_id)) {
        return -1;
      } else
      if(-1 !== order.indexOf(b.term_id)) {
        return 1;
      }
    })
  }
};

export default memo(DropdownTax);

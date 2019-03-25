import React, { memo } from "react";
import { useWPTerms } from "../../hooks";

const DropdownTax = ({ site, value, onChange, args }) => {
  const terms = useWPTerms(site, args);
  console.log(terms);

  return null;
};

export default memo(DropdownTax);

import React, { memo, useMemo } from "react";
import PropTypes from "prop-types";
import classnames from "classnames";
import { filterTermsByParent } from "./helpers";

const Filters = ({ terms, activeTerm, updateActiveTerm, parentId }) => {
  const filteredTerms = filterTermsByParent(terms, parentId);

  const allTerm = {
    id: 0,
    name: "All"
  };

  return (
    <div className={"torque-filtered-loop-filters"}>
      <button
        className={classnames("torque-filtered-loop-filter-button", {
          active: allTerm.id === activeTerm
        })}
        onClick={updateActiveTerm(allTerm.id)}
        dangerouslySetInnerHTML={{ __html: allTerm.name }}
      />
      {filteredTerms.map(term => (
        <button
          key={term.id}
          className={classnames("torque-filtered-loop-filter-button", {
            active: term.id === activeTerm
          })}
          onClick={updateActiveTerm(term.id)}
          dangerouslySetInnerHTML={{ __html: term.name }}
        />
      ))}
    </div>
  );
};

Filters.propTypes = {
  terms: PropTypes.array.isRequired,
  activeTerm: PropTypes.number.isRequired,
  updateActiveTerm: PropTypes.func.isRequired,
  parentId: PropTypes.number
};

export default memo(Filters);

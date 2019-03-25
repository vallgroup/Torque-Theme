import React, { memo, useMemo } from "react";
import PropTypes from "prop-types";
import classnames from "classnames";
import { filterTermsByParent } from "../helpers";

const Filters = ({
  className,
  terms,
  activeTerm,
  updateActiveTerm,
  parentId,
  hideAllOption
}) => {
  const filteredTerms = filterTermsByParent(terms, parentId);

  const allTerm = {
    id: 0,
    name: "All"
  };

  return (
    <div className={classnames("torque-filtered-loop-filters", className)}>
      {!hideAllOption && (
        <button
          className={classnames("torque-filtered-loop-filter-button", {
            active: allTerm.id === activeTerm
          })}
          onClick={updateActiveTerm(allTerm.id)}
          dangerouslySetInnerHTML={{ __html: allTerm.name }}
        />
      )}

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
  className: PropTypes.string,
  terms: PropTypes.array.isRequired,
  activeTerm: PropTypes.number.isRequired,
  updateActiveTerm: PropTypes.func.isRequired,
  parentId: PropTypes.number,
  hideAllOption: PropTypes.bool
};

export default memo(Filters);

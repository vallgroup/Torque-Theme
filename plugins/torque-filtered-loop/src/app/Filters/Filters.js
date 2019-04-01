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
    term_id: 0,
    name: "All"
  };

  return (
    <div className={classnames("torque-filtered-loop-filters", className)}>
      {!hideAllOption && (
        <button
          className={classnames("torque-filtered-loop-filter-button", {
            active: allTerm.term_id === activeTerm
          })}
          onClick={updateActiveTerm(allTerm.term_id)}
          dangerouslySetInnerHTML={{ __html: allTerm.name }}
        />
      )}

      {filteredTerms.map(term => (
        <button
          key={term.term_id}
          className={classnames("torque-filtered-loop-filter-button", {
            active: term.term_id === activeTerm
          })}
          onClick={updateActiveTerm(term.term_id)}
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

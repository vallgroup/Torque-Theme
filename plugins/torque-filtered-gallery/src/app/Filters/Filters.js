import React, { memo, useMemo } from "react";
import PropTypes from "prop-types";
import classnames from "classnames";

const Filters = ({
  className,
  terms,
  activeTerm,
  updateActiveTerm,
  hideAllOption
}) => {
  const allTerm = {
    term_id: 0,
    name: "All"
  };

  return (
    <div className={classnames("torque-filtered-gallery-filters", className)}>
      {!hideAllOption && (
        <button
          className={classnames("torque-filtered-gallery-filter-button", {
            active: allTerm.term_id === activeTerm
          })}
          onClick={updateActiveTerm(allTerm.term_id)}
          dangerouslySetInnerHTML={{ __html: allTerm.name }}
        />
      )}

      {terms.map(term => (
        <button
          key={term.term_id}
          className={classnames("torque-filtered-gallery-filter-button", {
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
  activeTerm: PropTypes.any.isRequired,
  updateActiveTerm: PropTypes.func.isRequired,
  hideAllOption: PropTypes.bool
};

Filters.defaultProps = {
  activeTerm: 0
};

export default memo(Filters);

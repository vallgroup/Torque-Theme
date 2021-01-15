import React, { memo, useMemo } from "react";
import PropTypes from "prop-types";
import classnames from "classnames";

const Filters = ({
  className,
  terms,
  activeTerm,
  updateActiveTerm,
  hideAllOption,
  hideFilters,
  iframeOptions
}) => {
  const allTerm = {
    term_id: 0,
    name: "View All"
  };

  return (
    0 < terms?.length && !hideFilters // if no terms passed in, hide the filters
      && <div className={classnames("torque-filtered-gallery-filters", className)}>
        {!hideAllOption && (
          <button
            className={classnames("torque-filtered-gallery-filter-button", {
              active: allTerm.term_id === activeTerm
            })}
            onClick={updateActiveTerm(allTerm.term_id)}
            // onClick={updateActiveTerm(allTerm.term_id)}
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
            // onClick={updateActiveTerm(term.term_id)}
            dangerouslySetInnerHTML={{ __html: term.name }}
          />
        ))}

        {(iframeOptions.iframeButtonTitle && iframeOptions.iframeURL)
          && <button
            className={classnames("torque-filtered-gallery-filter-button", {
              active: iframeOptions.showIframe
            })}
            onClick={() => iframeOptions.setShowIframe(!iframeOptions.showIframe)}
            dangerouslySetInnerHTML={{ __html: iframeOptions.iframeButtonTitle }}
          />}
      </div>
  );
};

Filters.propTypes = {
  className: PropTypes.string,
  terms: PropTypes.array.isRequired,
  activeTerm: PropTypes.any.isRequired,
  updateActiveTerm: PropTypes.func.isRequired,
  hideAllOption: PropTypes.bool,
  iframeOptions: PropTypes.object
};

Filters.defaultProps = {
  activeTerm: 0
};

export default memo(Filters);

import React, { memo } from "react";
import classnames from "classnames";
import PropTypes from "prop-types";

const ItemsList = ({ titles, current, onClick: handleClick }) => {
  return (
    <div className="tq-items-list">
      {titles.map((title, index) => {
        const isCurrent = index === current;

        return (
          <button
            key={index}
            className={classnames({ active: isCurrent }, "tq-items-list-item")}
            onClick={handleClick && handleClick(index)}
          >
            {title}
          </button>
        );
      })}
    </div>
  );
};

ItemsList.propTypes = {
  titles: PropTypes.array,
  current: PropTypes.number,
  onClick: PropTypes.func
};

ItemsList.defaultProps = {
  current: 0
};

export default memo(ItemsList);

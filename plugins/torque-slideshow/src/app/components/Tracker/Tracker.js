import styles from "./Tracker.scss";
import React, { memo } from "react";
import classnames from "classnames";
import PropTypes from "prop-types";

const Tracker = ({ length = 0, current, onClick: handleClick }) => {
  return (
    <div className={classnames(styles.root, "tq-tracker")}>
      {[...Array(length)].map((el, index) => {
        const isCurrent = index === current;

        return (
          <div
            key={index}
            className={classnames(
              styles.tracker_icon,
              { [styles.active]: isCurrent, active: isCurrent },
              "tq-tracker-icon"
            )}
            onClick={handleClick && handleClick(index)}
          />
        );
      })}
    </div>
  );
};

Tracker.propTypes = {
  length: PropTypes.number,
  current: PropTypes.number,
  onClick: PropTypes.func
};

Tracker.defaultProps = {
  current: 0
};

export default memo(Tracker);

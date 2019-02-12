import styles from "./Tracker.scss";
import React, { memo } from "react";
import classnames from "classnames";
import PropTypes from "prop-types";

const Tracker = ({ images, current, onClick: handleClick }) => {
  return (
    <div className={classnames(styles.root, "tq-tracker")}>
      {images.map((image, index) => {
        const isCurrent = index === current;

        return (
          <div
            key={`${image}_${index}`}
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
  images: PropTypes.array,
  current: PropTypes.number,
  onClick: PropTypes.func
};

Tracker.defaultProps = {
  images: [],
  current: 0
};

export default memo(Tracker);

import styles from "./Slideshow.scss";
import React, { memo } from "react";
import classnames from "classnames";
import PropTypes from "prop-types";
import Swipe from "react-easy-swipe";
import useSlide from "../../hooks/useSlide";
import Tracker from "../Tracker";
import arrow from "../../images/arrow.svg";

const Slideshow = ({ length, interval = 0, slideTemplate }) => {
  const [slide, createSetSlide, incrementSlide, decrementSlide] = useSlide(
    length,
    interval
  );

  console.log(slide);

  return (
    <div className={classnames(styles.root, "tq-slideshow")}>
      <Swipe onSwipeLeft={incrementSlide} onSwipeRight={decrementSlide}>
        <div className={classnames(styles.slide, "tq-slide")}>
          {slideTemplate(slide)}
        </div>
      </Swipe>

      <div
        className={classnames(
          styles.side_overlay,
          styles.side_overlay_right,
          "tq-side-overlay",
          "tq-side-overlay-right"
        )}
        onClick={incrementSlide}
      >
        <img
          className={classnames(
            styles.arrow,
            styles.arrow_right,
            "tq-slideshow-arrow",
            "tq-slideshow-arrow-right"
          )}
          src={arrow}
        />
      </div>

      <div
        className={classnames(
          styles.side_overlay,
          styles.side_overlay_left,
          "tq-side-overlay",
          "tq-side-overlay-left"
        )}
        onClick={decrementSlide}
      >
        <img
          className={classnames(
            styles.arrow,
            styles.arrow_left,
            "tq-slideshow-arrow",
            "tq-slideshow-arrow-left"
          )}
          src={arrow}
        />
      </div>

      <div className={classnames(styles.tracker, "tq-tracker-wrapper")}>
        <Tracker length={length} current={slide} onClick={createSetSlide} />
      </div>
    </div>
  );
};

Slideshow.propTypes = {
  length: PropTypes.number.isRequired,
  interval: PropTypes.number,
  slideTemplate: PropTypes.func.isRequired
};

export default memo(Slideshow);

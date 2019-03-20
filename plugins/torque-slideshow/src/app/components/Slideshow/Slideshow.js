import styles from "./Slideshow.scss";
import React, { Fragment, memo } from "react";
import classnames from "classnames";
import PropTypes from "prop-types";
import Swipe from "react-easy-swipe";
import useSlide from "../../hooks/useSlide";
import Tracker from "../Tracker";
import ItemsList from "../ItemsList";
import arrow from "../../images/arrow.svg";

const Slideshow = ({ items, interval = 0, slideTemplate, withItemList }) => {
  const length = items.length;

  const [slide, createSetSlide, incrementSlide, decrementSlide] = useSlide(
    length,
    interval
  );

  return (
    <Fragment>
      {withItemList && (
        <ItemsList
          titles={items.map(item => item.post_title)}
          current={slide}
          onClick={createSetSlide}
        />
      )}

      <div className={classnames(styles.root, "tq-slideshow")}>
        <Swipe onSwipeLeft={incrementSlide} onSwipeRight={decrementSlide}>
          <div className={classnames(styles.slide, "tq-slide")}>
            {slideTemplate(items[slide])}
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
    </Fragment>
  );
};

Slideshow.propTypes = {
  items: PropTypes.array.isRequired,
  interval: PropTypes.number,
  slideTemplate: PropTypes.func.isRequired
};

export default memo(Slideshow);

import styles from "./Slideshow.scss";
import React, { memo, useState, useEffect } from "react";
import classnames from "classnames";
import PropTypes from "prop-types";
import Swipe from "react-easy-swipe";
import useInterval from "../hooks/useInterval";
import Tracker from "./Tracker";
import arrow from "../images/arrow.svg";

const Slideshow = ({ images, interval }) => {
  const [slide, setSlide] = useState(0);

  const incrementSlide = () => setSlide((slide + 1) % images.length);
  const decrementSlide = () => setSlide((slide - 1) % images.length);
  const createSetSlide = index => () => setSlide(index);

  const preloadImages = () => {
    images.forEach(image => {
      const img = new Image();
      img.src = image;
    });
  };

  useEffect(
    () => {
      preloadImages();
    },
    [images]
  );

  const intervalInt = parseInt(interval);
  useInterval(() => {
    incrementSlide(slide + 1);
  }, intervalInt);

  return (
    <div className={classnames(styles.root, "tq-slideshow")}>
      <Swipe onSwipeLeft={incrementSlide} onSwipeRight={decrementSlide}>
        <div
          className={classnames(styles.slide, "tq-slide")}
          style={{ backgroundImage: `url('${images[slide]}')` }}
        />
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
        <Tracker images={images} current={slide} onClick={createSetSlide} />
      </div>
    </div>
  );
};

Slideshow.propTypes = {
  images: PropTypes.array
};

Slideshow.defaultProps = {
  images: []
};

export default memo(Slideshow);

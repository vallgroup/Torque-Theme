import styles from "./ImageSlideshow.scss";
import React, { memo, useEffect } from "react";
import classnames from "classnames";
import PropTypes from "prop-types";
import Slideshow from "../components/Slideshow";

const ImageSlideshow = ({ images, interval }) => {
  useEffect(
    () => {
      const preloadImages = () => {
        images.forEach(image => {
          const img = new Image();
          img.src = image;
        });
      };

      preloadImages();
    },
    [images]
  );

  return (
    <Slideshow
      length={images.length}
      interval={interval}
      slideTemplate={slide => (
        <div
          className={classnames(styles.image_slide, "image-slide")}
          style={{ backgroundImage: `url('${images[slide]}')` }}
        />
      )}
    />
  );
};

ImageSlideshow.propTypes = {
  images: PropTypes.array,
  interval: PropTypes.number
};

ImageSlideshow.defaultProps = {
  images: []
};

export default memo(ImageSlideshow);

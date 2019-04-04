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
      items={images}
      interval={interval}
      slideTemplate={image => {

        const _slides = images.map((_img, idx) => {
          const activeClass = null !== _img.match(image)
            ? classnames(styles.active_slide, "active-slide")
            : ''
          return <div
            key={idx}
            className={`${activeClass} ${classnames(styles.image_slide, "image-slide")}`}
            style={{ backgroundImage: `url('${_img}')` }}
          />
        })

        return (_slides)
      }}
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

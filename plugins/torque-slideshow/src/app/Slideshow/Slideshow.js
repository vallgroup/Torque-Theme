import styles from "./Slideshow.scss";
import React, { memo, useState } from "react";
import classnames from "classnames";
import PropTypes from "prop-types";

const Slideshow = ({ images }) => {
  const [slide, setSlide] = useState(0);

  return (
    <div className={classnames(styles.root, "tq-slideshow")}>
      <div
        className={classnames(styles.slide, "tq-slide")}
        style={{ backgroundImage: `url('${images[slide]}')` }}
      />
    </div>
  );
};

export default memo(Slideshow);

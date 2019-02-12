import React, { memo, useState, useEffect } from "react";
import PropTypes from "prop-types";
import axios from "axios";
import Slideshow from "./Slideshow";

const App = ({ site, id }) => {
  const [slideshow, updateSlideshow] = useState(false);

  const getSlideshow = async () => {
    try {
      const url = `${site}/wp-json/slideshow/v1/slideshows/${id}`;
      const response = await axios.get(url);

      if (response.data.success) {
        updateSlideshow(response.data.slideshow);
      }
    } catch (err) {
      console.log(err);
    }
  };

  useEffect(
    () => {
      getSlideshow();
    },
    [site, id]
  );

  const images = slideshow?.meta?.images[0]?.split(",") || [];

  return <Slideshow images={images} />;
};

App.propTypes = {
  site: PropTypes.string.isRequired,
  id: PropTypes.string.isRequired
};

export default memo(App);

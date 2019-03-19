import React, { memo, useState } from "react";
import useSlideshowFetch from "./hooks/useSlideshowFetch";
import PropTypes from "prop-types";
import ImageSlideshow from "./ImageSlideshow";

const App = ({ site, id, type = "image" }) => {
  const [data, updateData] = useState(false);

  useSlideshowFetch(site, id, {}, updateData);

  const images = data?.meta?.images;
  const imagesArray = (images?.length && images[0].split(",")) || [];

  const posts = data?.meta?.posts;

  const interval = parseInt(data?.meta?.interval);

  if (type === "image") {
    return <ImageSlideshow images={imagesArray} interval={interval} />;
  } else if (type === "post") {
    //return <PostSlideshow posts={posts} interval={interval} />;
    return null;
  } else {
    console.warn('Slideshow type should be one of "image" or "post"');
    return null;
  }
};

App.propTypes = {
  site: PropTypes.string.isRequired,
  id: PropTypes.string.isRequired,
  type: PropTypes.string
};

export default memo(App);

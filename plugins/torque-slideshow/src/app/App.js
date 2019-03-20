import React, { memo, useState } from "react";
import useSlideshowFetch from "./hooks/useSlideshowFetch";
import PropTypes from "prop-types";
import ImageSlideshow from "./ImageSlideshow";
import PostSlideshow from "./PostSlideshow";

const App = ({ site, id, type = "image" }) => {
  const [data, updateData] = useState(false);

  useSlideshowFetch(site, id, null, updateData);

  const images = data?.meta?.images;
  const imagesArray = (images?.length && images[0].split(",")) || [];

  const posts = data?.meta?.posts;

  const interval = parseInt(data?.meta?.interval);

  if (type === "image" && imagesArray.length) {
    return <ImageSlideshow images={imagesArray} interval={interval} />;
  } else if (type === "post" && posts?.length) {
    return <PostSlideshow site={site} postIds={posts} interval={interval} />;
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

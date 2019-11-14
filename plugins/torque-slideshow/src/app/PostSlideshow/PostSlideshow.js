import styles from "./PostSlideshow.scss";
import React, { memo, useState, useMemo } from "react";
import classnames from "classnames";
import PropTypes from "prop-types";
import useSlideshowFetch from "../hooks/useSlideshowFetch";
import Slideshow from "../components/Slideshow";
import {
  Template_0,
  Template_Atlantic,
  Template_UST_Floorplans,
  Template_UST_Locations
} from "./templates";

const PostSlideshow = ({ site, postIds, interval, template }) => {
  const [posts, setPosts] = useState([]);

  const params = useMemo(() => ({ ids: postIds }), [postIds]);
  useSlideshowFetch(site, "posts", params, setPosts);

  return (
    posts.length > 0 && (
      <Slideshow
        className={`template_${template}`}
        items={posts}
        interval={interval}
        withItemList
        slideTemplate={post => {
          switch (template) {
            case "ust_floorplans":
              return <Template_UST_Floorplans post={post} />;

            case "ust_locations":
              return <Template_UST_Locations post={post} />;

            case "interra":
              return <Template_Atlantic post={post} />;

            case "0":
            default:
              return <Template_0 post={post} />;
          }
        }}
      />
    )
  );
};

PostSlideshow.propTypes = {
  posts: PropTypes.array,
  interval: PropTypes.number
};

PostSlideshow.defaultProps = {
  posts: []
};

export default memo(PostSlideshow);

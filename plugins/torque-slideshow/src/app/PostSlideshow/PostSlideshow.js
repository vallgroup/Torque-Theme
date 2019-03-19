import styles from "./PostSlideshow.scss";
import React, { memo, useState, useMemo } from "react";
import classnames from "classnames";
import PropTypes from "prop-types";
import useSlideshowFetch from "../hooks/useSlideshowFetch";
import Slideshow from "../components/Slideshow";

const PostSlideshow = ({ site, postIds, interval }) => {
  const [posts, setPosts] = useState([]);

  const params = useMemo(() => ({ ids: postIds }), [postIds]);
  useSlideshowFetch(site, "posts", params, setPosts);

  console.log(posts);

  return (
    <Slideshow
      length={posts.length}
      interval={interval}
      slideTemplate={slide => (
        <div className={classnames(styles.post_slide, "post-slide")}>
          {posts[slide]?.post_title}
        </div>
      )}
    />
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

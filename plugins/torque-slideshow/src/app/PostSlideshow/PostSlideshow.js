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

  return (
    posts.length > 0 && (
      <Slideshow
        length={posts.length}
        interval={interval}
        slideTemplate={slide => {
          const post = posts[slide];

          return (
            <div className={classnames(styles.post_slide, "post-slide")}>
              {post.thumbnail && <img src={post.thumbnail} />}

              <h3>{post.post_title}</h3>

              <div className="slideshow-post-excerpt slideshow-post-field">
                {post.post_excerpt || post.post_content}
              </div>

              {Object.keys(post.meta).map(metaKey => {
                const meta = post.meta[metaKey];

                if (typeof meta !== "string") return null;

                return (
                  <div
                    key={metaKey}
                    className={classnames(
                      "slideshow-post-field",
                      `slideshow-${metaKey}`
                    )}
                  >
                    {post.meta[metaKey]}
                  </div>
                );
              })}

              <a
                href={post.permalink}
                target="_blank"
                referrer="noreferrer noopener"
              >
                <button>{`Visit ${post.post_type_label}`}</button>
              </a>

              <div className="slideshow-post-terms">
                {post.terms.map(term => (
                  <div key={term} className="post_term">
                    {term}
                  </div>
                ))}
              </div>
            </div>
          );
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

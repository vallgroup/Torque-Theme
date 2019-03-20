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
        items={posts}
        interval={interval}
        withItemList
        slideTemplate={post => {
          return (
            <div
              className={classnames(
                styles.post_slide,
                "post-slide",
                `post-type-${post.post_type_label.split(" ").join("-")}`
              )}
            >
              <div
                style={{ backgroundImage: `url(${post.thumbnail})` }}
                className="post-image"
              />

              <div className="post-details">
                <h3>{post.post_title}</h3>

                <div className="slideshow-post-excerpt slideshow-post-field">
                  {post.post_excerpt || post.post_content}
                </div>

                {Object.keys(post.meta).map(metaKey => {
                  const meta = post.meta[metaKey];

                  if (typeof meta !== "string") return null;

                  const className = classnames(
                    "slideshow-post-field",
                    `slideshow-${metaKey}`
                  );

                  // we use a different element depending on the meta name,
                  // since the meta could be absolutley anything,
                  // its the best way i can think of doing this now
                  // without heavy involvement from the child theme

                  if (metaKey.includes("image")) {
                    return (
                      <img
                        key={metaKey}
                        className={className}
                        src={post.meta[metaKey]}
                      />
                    );
                  }

                  if (metaKey.includes("download") || metaKey.includes("pdf")) {
                    return (
                      <a
                        key={metaKey}
                        href={post.meta[metaKey]}
                        className={className}
                        target="_blank"
                        referrer="noopener noreferrer"
                      >
                        <button>
                          <span>Download</span>
                        </button>
                      </a>
                    );
                  }

                  return (
                    <div
                      key={metaKey}
                      className={className}
                      dangerouslySetInnerHTML={{ __html: post.meta[metaKey] }}
                    />
                  );
                })}

                <a
                  href={post.permalink}
                  target="_blank"
                  referrer="noreferrer noopener"
                  className="slideshow-link-to-post"
                >
                  <button>{`Visit ${post.post_type_label}`}</button>
                </a>

                <div className="slideshow-post-terms">
                  {post.terms.map(term => (
                    <div key={term} className="post-term">
                      {term}
                    </div>
                  ))}
                </div>
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

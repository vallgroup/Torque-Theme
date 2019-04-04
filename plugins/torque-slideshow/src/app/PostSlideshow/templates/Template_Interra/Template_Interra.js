import styles from "./Template_Interra.scss";
import React, { memo } from "react";
import classnames from "classnames";
import PropTypes from "prop-types";

const Template = ({ post }) => {
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

        {post.meta["listing_city"] && (
          <div
            className={classnames(
              "slideshow-post-field",
              `slideshow-listing_city`
            )}
          >
            {post.meta["listing_city"]}
          </div>
        )}

        <a
          href={post.permalink}
          target="_blank"
          referrer="noreferrer noopener"
          className="slideshow-link-to-post"
        >
          <button>{`View ${post.post_type_label}`}</button>
        </a>

        <div className="slideshow-post-terms">
          {post.term_objects.map(term => (
            <div key={term.term_id} className="post-term">
              <a href={`/listings?${term.taxonomy}=${term.term_id}`}>
                {term.name}
              </a>
            </div>
          ))}
        </div>
      </div>
    </div>
  );
};

Template.propTypes = {
  post: PropTypes.object
};

export default memo(Template);

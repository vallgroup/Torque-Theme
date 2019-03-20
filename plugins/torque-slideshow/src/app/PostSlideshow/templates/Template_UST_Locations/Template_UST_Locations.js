import styles from "./Template_UST_Locations.scss";
import React, { memo } from "react";
import classnames from "classnames";
import PropTypes from "prop-types";

// renders all possible meta and fields

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

        <div className="slideshow-post-excerpt slideshow-post-field">
          {post.post_excerpt || post.post_content}
        </div>
      </div>
    </div>
  );
};

Template.propTypes = {
  post: PropTypes.object
};

export default memo(Template);

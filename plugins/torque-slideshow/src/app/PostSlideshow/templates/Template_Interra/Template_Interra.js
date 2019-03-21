import styles from "./Template_Interra.scss";
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

        {Object.keys(post.meta).map(metaKey => {
          const meta = post.meta[metaKey];

          if (typeof meta !== "string") return null;

          const className = classnames(
            "slideshow-post-field",
            `slideshow-${metaKey}`
          );

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
};

Template.propTypes = {
  post: PropTypes.object
};

export default memo(Template);

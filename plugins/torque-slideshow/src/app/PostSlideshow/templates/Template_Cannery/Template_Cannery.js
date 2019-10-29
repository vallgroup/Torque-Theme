import styles from "./Template_Cannery.scss";
import React, { memo } from "react";
import classnames from "classnames";
import PropTypes from "prop-types";

// renders all possible meta and fields

const Template = ({ post }) => {
  console.log(post)
  const title = post?.post_title;
  const floorPlan = post?.thumbnail;
  const rsf = post?.meta?.floor_plan_rsf;
  const download = post?.meta?.floor_plan_downloads_pdf;

  return (
    <div
      className={classnames(
        styles.post_slide,
        "post-slide",
        `post-type-${post.post_type_label.split(" ").join("-")}`
      )}
    >
      <h1>{title}</h1>

      {rsf && (
        <div
          className={classnames(
            "slideshow-post-field",
            "slideshow-rsf"
          )}
        >
          <span>
            {`${rsf} SF`}
          </span>
        </div>
      )}

      {download && (
        <a href={download} target="_blank" referrer="noopener noreferrer">
            <span>{`Download Floorplan`}</span>
        </a>
      )}

      {floorPlan && (
        <div
          className={classnames("slideshow-post-field", "slideshow-floor-plan")}
        >
          <img src={floorPlan} />
        </div>
      )}

    </div>
  );
};

Template.propTypes = {
  post: PropTypes.object
};

export default memo(Template);

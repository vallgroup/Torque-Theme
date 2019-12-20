import styles from "./Template_Cannery.scss";
import React, { memo } from "react";
import classnames from "classnames";
import PropTypes from "prop-types";
import './Template_Cannery.scss'

// renders all possible meta and fields

const Template = ({ post }) => {
  const title = post?.post_title;
  const floorPlan = post?.thumbnail;
  const rsf = Number(post?.meta?.floor_plan_rsf).toLocaleString(); // format number (enforced via ACF) with commas
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

import styles from "./Template_UST_Floorplans.scss";
import React, { memo } from "react";
import classnames from "classnames";
import PropTypes from "prop-types";

// renders all possible meta and fields

const Template = ({ post }) => {
  const floorPlan = post?.meta?.floor_plan_images_floor_plan;
  const stackingPlan = post?.meta?.floor_plan_images_stacking_plan;
  const view = post?.meta?.floor_plan_images_view;
  const download = post?.meta?.floor_plan_downloads_pdf;

  return (
    <div
      className={classnames(
        styles.post_slide,
        "post-slide",
        `post-type-${post.post_type_label.split(" ").join("-")}`
      )}
    >
      {floorPlan && (
        <div
          className={classnames("slideshow-post-field", "slideshow-floor-plan")}
        >
          <img src={floorPlan} />
          {download && (
            <a href={download} target="_blank" referrer="noopener noreferrer">
              <button className={"slideshow-download-pdf"}>
                <span>{"FLOORPLAN"}</span>
              </button>
            </a>
          )}
        </div>
      )}

      {stackingPlan && (
        <div
          className={classnames(
            "slideshow-post-field",
            "slideshow-stacking-plan"
          )}
        >
          <img src={stackingPlan} />
        </div>
      )}

      {stackingPlan && (
        <div className={classnames("slideshow-post-field", "slideshow-view")}>
          <img src={view} />
        </div>
      )}
    </div>
  );
};

Template.propTypes = {
  post: PropTypes.object
};

export default memo(Template);

import styles from "./Template_UST_Floorplans.scss";
import React, { memo } from "react";
import classnames from "classnames";
import PropTypes from "prop-types";

import LightBox from '../../../components/LightBox'

// renders all possible meta and fields

const Template = ({ post, posts, changeTheme }) => {
  const floorPlan = post?.meta?.floor_plan_images_floor_plan;
  const stackingPlan = post?.meta?.floor_plan_images_stacking_plan;
  const view = post?.meta?.floor_plan_images_view;
  const download = post?.meta?.floor_plan_downloads_pdf;

  const _360 = post?.meta?.floor_plan_images_360;

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

      <div className={classnames("slideshow-post-field", "slideshow-view")}>
        {_360
          ? <LightBox
            view={view}
            render={_360}
            currentPost={post}
            posts={posts}
            changeTheme={changeTheme}>
            </LightBox>
          : <img src={view} />}
      </div>
    </div>
  );
};

Template.propTypes = {
  post: PropTypes.object
};

export default memo(Template);

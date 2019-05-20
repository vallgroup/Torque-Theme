import React, { memo } from "react";
import classnames from "classnames";

const LightBoxLink = (props) => {

  const handleClick = e => {
    e.preventDefault();
    props.toggle(!props.open)
  }

  return (
    <a
      href="#__open_360_lightbox"
      onClick={handleClick}
      className={classnames("slideshow-post-field", "slideshow-view")}>
        <img src={props.view} />
    </a>
  )
}

export default memo(LightBoxLink);
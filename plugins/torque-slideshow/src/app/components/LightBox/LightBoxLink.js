import React, { memo } from "react";
import classnames from "classnames";
import {
  LightBoxLinkWrapper,
} from './LightBox.components'

import svg360 from '../../images/360.svg'


const LightBoxLink = (props) => {

  const handleClick = e => {
    e.preventDefault();
    props.toggle(!props.open)
  }

  return (<LightBoxLinkWrapper>
    <a
      href="#__open_360_lightbox"
      onClick={handleClick}
      className={classnames("slideshow-post-field", "slideshow-view")}>
        <img src={props.view} />
        <img className={classnames("icon-360")} src={svg360} />
    </a>
  </LightBoxLinkWrapper>)
}

export default memo(LightBoxLink);
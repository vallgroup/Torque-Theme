import styles from "./LightBox.scss";
import React, { memo, useState } from "react";
import classnames from "classnames";
import PropTypes from "prop-types";

import {
  LightBoxWrapper,
} from './LightBox.components'
import LightBoxDialog from './LightBoxDialog'
import LightBoxLink from './LightBoxLink'
import useLightBoxToggle from '../../hooks/useLightBoxToggle'


const LightBox = (props) => {

  const [open, toggleLightBox] = useLightBoxToggle()

  if (open) {
    props.changeTheme('lightbox-active')
  } else {
    props.changeTheme('')
  }

  return (<LightBoxWrapper>
    <LightBoxLink
      view={props.view}
      open={open}
      toggle={toggleLightBox} />

    <LightBoxDialog
     open={open}
     toggle={toggleLightBox}
     render={props.render}
     currentPost={props.currentPost}
     posts={props.posts} />
  </LightBoxWrapper>);
};

LightBox.propTypes = {

};

LightBox.defaultProps = {
  current: 0
};

export default LightBox;
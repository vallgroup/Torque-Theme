import styles from "./LightBox.scss";
import React, { memo, useState } from "react";
import classnames from "classnames";
import PropTypes from "prop-types";

import {
  LightBoxDialogDiv,
  LightBoxClose,
  IframeWrapper,
  Iframe360,
  LightBoxControls,
  LightBoxControlsTab
} from './LightBox.components'

const LightBoxDialog = (props) => {

  const [render, setRender] = useState(props.render)

  const _posts = props.posts.map(post => {
    return {
      title: post.post_title,
      render: post?.meta?.floor_plan_images_360
    }
  })

  const handleClose = e => {
    e.preventDefault();
    props.toggle(false)
  }


  const handleRenderSwitch = newRender => {

    if (newRender && '' !== newRender) {
      setRender(newRender)
    }
  }

  return (<LightBoxDialogDiv
    open={props.open}>
    <LightBoxClose
      href="#_close_lightbox"
      onClick={handleClose} />

    <IframeWrapper>
      <Iframe360
        src={`${render}`}
        allowFullScreen={true}
        frameBorder={0} />
    </IframeWrapper>


    <LightBoxControls>
      {_posts.map((post, idx) => {
        if (post) {
          return <LightBoxControlsTab
            active={post.render === render}
            key={idx}
            count={_posts.length}
            onClick={() => handleRenderSwitch(post.render)}>
            {post.title}
          </LightBoxControlsTab>
        }
      })}
    </LightBoxControls>
  </LightBoxDialogDiv>);
};

LightBoxDialog.propTypes = {
  // open: false,
};

LightBoxDialog.defaultProps = {
  current: 0
};

export default LightBoxDialog;

const useLightBoxToggle = (bool) => {
  const [open, setOpen] = useState(bool)
  return {
    open,
    onClick: e => {
      e.preventDefault();

    }
  }
}


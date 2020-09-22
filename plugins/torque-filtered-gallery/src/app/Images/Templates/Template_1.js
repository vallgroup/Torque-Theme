import React from "react";
import PropTypes from "prop-types";

class Template_1 extends React.PureComponent {
  render() {
    const { image } = this.props;
    const imageUrl = image.url;
    const imageCaption = image.caption || '';

    return (<>
      <div className={"loop-image template-1"}>
        <div className={"image-container"}>
          <img
            src={imageUrl}
            className={"featured-image"}
            alt={imageCaption}
          />
        </div>
        <div className={"image-caption"}>
          {imageCaption}
        </div>
      </div>
    </>);
  }
}

Template_1.propTypes = {
  image: PropTypes.object.isRequired
};

export default Template_1;

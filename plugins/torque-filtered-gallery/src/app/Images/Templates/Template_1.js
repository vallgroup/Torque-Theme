import React from "react";
import PropTypes from "prop-types";

class Template_1 extends React.PureComponent {
  render() {
    const { image } = this.props;

    const lightboxOptions = {}

    const imageUrl = image.url;
    const imageCaption = image.caption || '';

    console.log('image', image);

    return (<>
      <div className={"loop-image template-1"}>
        <div className={"image-container"}>
          <img
            src={imageUrl}
            className={"featured-image"}
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

import React from "react";
import PropTypes from "prop-types";

class Template_0 extends React.PureComponent {
  render() {
    const { image } = this.props;

    const lightboxOptions = {}

    const imageUrl = image.url;

    console.log('image', image);

    return (
      <div className={"loop-image template-0"}>
          <img
            src={imageUrl}
            className={"featured-image"}
          />
      </div>
    );
  }
}

Template_0.propTypes = {
  image: PropTypes.object.isRequired
};

export default Template_0;

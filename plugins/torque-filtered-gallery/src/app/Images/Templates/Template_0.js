import React from "react";
import PropTypes from "prop-types";

class Template_0 extends React.PureComponent {
  render() {
    const { image } = this.props;
    const imageUrl = image.url;
    const imageCaption = image.caption || '';

    return (
      <div className={"loop-image template-0"}>
        <img
          src={imageUrl}
          className={"featured-image"}
          alt={imageCaption}
        />
      </div>
    );
  }
}

Template_0.propTypes = {
  image: PropTypes.object.isRequired
};

export default Template_0;

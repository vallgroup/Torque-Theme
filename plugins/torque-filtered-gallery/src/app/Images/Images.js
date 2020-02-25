import React from "react";
import PropTypes from "prop-types";
import { Template_0, Template_1, Template_2 } from "./Templates";

class Images extends React.PureComponent {
  render() {
    return (
        <div className={"images-wrapper"}>
          {0 < this.props.images.length
            ? this.props.images.map((image, index) => {
            switch (this.props.loopTemplate) {
              case "template-2":
                // maybe later used for a lightbox functionality? 
                // return <Template_2 key={index} image={image} />;

              case "template-1":
                // maybe later used to add an overlay with image title?
                // return <Template_1 key={index} image={image} />;

              case "template-0":
              default:
                return (
                  <Template_0
                    key={index}
                    image={image}
                  />
                );
            }
          })
        : <p>{'No images found for this category. Please select another from the filters above.'}</p>}
        </div>
    );
  }
}

Images.propTypes = {
  images: PropTypes.array.isRequired,
  loopTemplate: PropTypes.string.isRequired,
  parentId: PropTypes.number
};

Images.defaultProps = {
  loopTemplate: "template-0"
};

export default Images;

import React from "react";
import PropTypes from "prop-types";
import { Template_0, Template_1, Template_2 } from "./Templates";

class Images extends React.PureComponent {
  render() {

    // add loading message while pulling images from WP server
    if (false === this.props.images) return (<p>{'Loading gallery...'}</p>)

    return (
        <div className={"images-wrapper"}>
          {0 < this.props.images.length
            ? this.props.images.map((image, index) => {
            switch (this.props.loopTemplate) {
              case "template-2":
                // not in-use
                // return <Template_2 key={index} image={image} />;

              case "template-1":
                // image with caption
                return (
                  <Template_1
                    key={index}
                    image={image}
                  />
                );

              case "template-0":
              default:
                // image only
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
  images: PropTypes.oneOfType([
    PropTypes.array.isRequired,
    PropTypes.bool.isRequired
  ]),
  loopTemplate: PropTypes.string.isRequired,
  parentId: PropTypes.number
};

Images.defaultProps = {
  loopTemplate: "template-0"
};

export default Images;

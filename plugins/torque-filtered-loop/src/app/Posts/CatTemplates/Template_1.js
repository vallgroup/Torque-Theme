import React from "react";
import PropTypes from "prop-types";

class Template_1 extends React.PureComponent {
  render() {
    const {
      post,
      title,
      image,
      copy,
    } = this.props;

    const _title = title || post?.post_title;
    const backgroundImage = image || post?.thumbnail;
    const content = copy || post?.post_content;
console.log('backgroundImage -- ', backgroundImage);
    return (
      <div className={"loop-post template-1"}>
        <div className={"featured-image-wrapper"}>
          <div
            className={"featured-image"}
            style={{ backgroundImage: `url(${backgroundImage})` }}
          />
        </div>

        <div className={"content-wrapper"}>
          <h4 dangerouslySetInnerHTML={{ __html: _title }} />

          <div
            className="content"
            dangerouslySetInnerHTML={{ __html: content }}
          />
        </div>
      </div>
    );
  }
}

Template_1.propTypes = {
  post: PropTypes.object.isRequired,
  title: PropTypes.string,
  image: PropTypes.string,
  copy: PropTypes.string,
};

export default Template_1;

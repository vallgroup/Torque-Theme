import React from "react";
import PropTypes from "prop-types";

class Template_1 extends React.PureComponent {
  render() {
    const { post } = this.props;

    const backgroundImage = post?.thumbnail;
    const content = post?.post_content;

    return (
      <div className={"loop-post template-1"}>
        <div className={"featured-image-wrapper"}>
          <div
            className={"featured-image"}
            style={{ backgroundImage: `url(${backgroundImage})` }}
          />
        </div>

        <div className={"content-wrapper"}>
          <h4 dangerouslySetInnerHTML={{ __html: post.post_title }} />

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
  post: PropTypes.object.isRequired
};

export default Template_1;

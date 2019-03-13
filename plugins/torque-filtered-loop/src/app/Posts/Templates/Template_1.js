import React from "react";
import PropTypes from "prop-types";

class Template_1 extends React.PureComponent {
  render() {
    const { post } = this.props;

    const backgroundImage =
      post?._embedded["wp:featuredmedia"] &&
      post?._embedded["wp:featuredmedia"][0]?.source_url;
    const content = post?.content?.rendered;

    return (
      <div className={"loop-post template-1"}>
        {backgroundImage && (
          <div className={"featured-image-wrapper"}>
            <div
              className={"featured-image"}
              style={{ backgroundImage: `url(${backgroundImage})` }}
            />
          </div>
        )}

        <div className={"content-wrapper"}>
          <a href={post.link}>
            <h4 dangerouslySetInnerHTML={{ __html: post.title.rendered }} />
          </a>

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

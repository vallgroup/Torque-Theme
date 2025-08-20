import React from "react";
import PropTypes from "prop-types";

/**
 * Used for Interra specifically
 */
class Template_3 extends React.PureComponent {
  render() {
    const { post } = this.props;

    const backgroundImage = post?.thumbnail;
    const excerpt = post?.post_excerpt;

    return (
      <div className={"post-item template-3"}>
        <div className={"wrap-content"}>
          <a className={"wrap-title"} href={post.permalink}>
            <h4 dangerouslySetInnerHTML={{ __html: post.post_title }} />
          </a>

          <div
            className="excerpt"
            dangerouslySetInnerHTML={{ __html: excerpt }}
          />
        </div>

        <a className={"wrap-image"} href={post.permalink}>
          <img src={backgroundImage} />
        </a>
      </div>
    );
  }
}

Template_3.propTypes = {
  post: PropTypes.object.isRequired,
};

export default Template_3;

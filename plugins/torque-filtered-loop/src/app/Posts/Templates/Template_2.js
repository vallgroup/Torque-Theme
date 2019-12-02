import React from "react";
import PropTypes from "prop-types";

class Template_2 extends React.PureComponent {
  render() {
    const { post } = this.props;

    const backgroundImage = post?.thumbnail;
    const excerpt = post?.post_excerpt;

    return (
      <div className={"loop-post template-1"}>
        <a href={post.permalink}>
          <div className={"featured-image-wrapper"}>
            <div
              className={"featured-image"}
              style={{ backgroundImage: `url(${backgroundImage})` }}
            />
          </div>
        </a>

        <div className={"content-wrapper"}>
          <a href={post.permalink}>
            <h5 dangerouslySetInnerHTML={{ __html: post.post_title }} />
          </a>

          <div
            className="excerpt"
            dangerouslySetInnerHTML={{ __html: excerpt }}
          />

          <a href={post.permalink}>
            <button>Read On</button>
          </a>

          <div className={"post-terms-wrapper"}>{this.renderTerms()}</div>
        </div>
      </div>
    );
  }

  renderTerms() {
    const { post } = this.props;
    const terms = post.terms;

    return (
      terms &&
      terms.map((term, index) => {
        return (
          <div
            key={index}
            className={"term"}
            dangerouslySetInnerHTML={{ __html: term.name }}
          />
        );
      })
    );
  }
}

Template_2.propTypes = {
  post: PropTypes.object.isRequired
};

export default Template_2;

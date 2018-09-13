import React from "react";
import PropTypes from "prop-types";

class Template_0 extends React.PureComponent {
  render() {
    const { post } = this.props;

    const backgroundImage =
      post._embedded["wp:featuredmedia"] &&
      post._embedded["wp:featuredmedia"][0] &&
      post._embedded["wp:featuredmedia"][0].source_url;

    return (
      <div className={"loop-post template-0"}>
        <div className={"featured-image-wrapper"}>
          <div
            className={"featured-image"}
            style={{ backgroundImage: `url(${backgroundImage})` }}
          />
        </div>

        <div className={"content-wrapper"}>
          <div className={"post-terms-wrapper"}>{this.renderTerms()}</div>

          <h3 dangerouslySetInnerHTML={{ __html: post.title.rendered }} />

          <a href={post.link}>
            <button>View</button>
          </a>
        </div>
      </div>
    );
  }

  renderTerms() {
    const { post, parentId } = this.props;
    const terms =
      post._embedded["wp:term"] &&
      post._embedded["wp:term"][0] &&
      post._embedded["wp:term"][0].length &&
      post._embedded["wp:term"][0];

    return (
      terms &&
      terms.map((term, index) => {
        if (term.id === parentId) {
          return null;
        }

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

Template_0.propTypes = {
  post: PropTypes.object.isRequired,
  parentId: PropTypes.number
};

export default Template_0;

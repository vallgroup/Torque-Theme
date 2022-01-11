import React from "react";
import PropTypes from "prop-types";

class Template_6 extends React.PureComponent {
  render() {
    const { post } = this.props;

    const backgroundImage = post?.thumbnail;
    const excerpt = post?.post_excerpt;

    return (
      <div className={"loop-post template-5"}>

        {backgroundImage
          ? <a href={post.permalink}>
            <div className={"featured-image-wrapper"}>
              <div
                className={"featured-image"}
                style={{ backgroundImage: `url(${backgroundImage})` }}
              />
            </div>
          </a>
          : null}

        <div className={"content-wrapper"}>

          <div className={"post-terms-wrapper"}>{this.renderTerms()}</div>

          <a href={post.permalink}>
            <h3
              className="post-title"
              dangerouslySetInnerHTML={{ __html: post.post_title }}
            />
          </a>

          <div
            className="post-excerpt"
            dangerouslySetInnerHTML={{ __html: excerpt }}
          />

          <a
            className="post-cta"
            href={post.permalink}
          >
            <span>Learn More</span>
          </a>
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
          'newcastle_property_location' === term.taxonomy
            ? <div
              key={index}
              className={"term"}
              dangerouslySetInnerHTML={{ __html: term.name }}
            />
            : null);
      })
    );
  }
}

Template_6.propTypes = {
  post: PropTypes.object.isRequired
};

export default Template_6;

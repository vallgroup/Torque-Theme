import React from "react";
import PropTypes from "prop-types";

/**
 * Used for Interra specifically
 */
class Template_3_variation extends React.PureComponent {
  render() {
    const { post } = this.props;

    const backgroundImage = post?.thumbnail;

    return (
      <div className={"post-item template-3-variation"}>
        <a className={"wrap-image"} href={post.permalink}>
          <img src={backgroundImage} />
        </a>
        <div className={"wrap-content"}>
          <a className={"wrap-title"} href={post.permalink}>
            <h4 dangerouslySetInnerHTML={{ __html: post.post_title }} />
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
      terms
        .sort((a, b) => {
          if (
            "interra_listing_property_type" === a.taxonomy &&
            "interra_listing_property_type" === b.taxonomy
          ) {
            return 0;
          } else if ("interra_listing_property_type" === a.taxonomy) {
            return -1;
          } else if ("interra_listing_property_type" === b.taxonomy) {
            return 1;
          }
        })
        .map((term, index) => {
          return (
            <div key={index} className={"term"}>
              <a href={`/listings?${term.taxonomy}=${term.term_id}`}>
                {term.name}
              </a>
            </div>
          );
        })
    );
  }
}

Template_3_variation.propTypes = {
  post: PropTypes.object.isRequired,
};

export default Template_3_variation;

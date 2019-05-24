import React from "react";
import PropTypes from "prop-types";

/**
 * Used for Interra specifically
 */
class Template_2 extends React.PureComponent {
  render() {
    const { post } = this.props;

    const backgroundImage = post?.thumbnail;
    const excerpt = post?.post_excerpt;

    const buttonText =
      post.post_type === "torque_listing"
        ? "View Listing"
        : post.post_type === "post"
        ? "Read More"
        : "View";

    return (
      <div className={"loop-post template-2"}>
        <a className={"single-listing-link"} href={post.permalink}>
          <div className={"featured-image-wrapper"}>
            <div
              className={"featured-image"}
              style={{ backgroundImage: `url(${backgroundImage})` }}
            />
          </div>
        </a>

        <div className={"content-wrapper"}>
          <a className={"single-listing-link"} href={post.permalink}>
            <h4 dangerouslySetInnerHTML={{ __html: post.post_title }} />
          </a>

          <div
            className="excerpt"
            dangerouslySetInnerHTML={{ __html: excerpt }}
          />

          <a className={"single-listing-link"} href={post.permalink}>
            <button>{buttonText}</button>
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
      terms.sort((a, b) => {
        if ("interra_listing_property_type" === a.taxonomy
          && "interra_listing_property_type" === b.taxonomy) {
          return 0;
        } else
        if ("interra_listing_property_type" === a.taxonomy) {
          return -1;
        } else
        if ("interra_listing_property_type" === b.taxonomy) {
          return 1;
        }
      }).map((term, index) => {
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

Template_2.propTypes = {
  post: PropTypes.object.isRequired
};

export default Template_2;

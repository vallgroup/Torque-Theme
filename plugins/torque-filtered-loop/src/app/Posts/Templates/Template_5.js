import React from "react";
import PropTypes from "prop-types";

class Template_5 extends React.PureComponent {
  render() {
    const { post } = this.props;

    const backgroundImage = post?.thumbnail;
    const excerpt = post?.post_excerpt;

    // determine if this post is of type 'Retail'
    let isRetail = false;
    post.terms.forEach(term => {
      if (
        'newcastle_property_type' === term.taxonomy
        && 'Retail' === term.name
      ) {
        isRetail = true;
        return;
      }
    });

    // early exit
    if (!isRetail) return null;
    
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
        console.log('term.taxonomy', term.taxonomy)
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

Template_5.propTypes = {
  post: PropTypes.object.isRequired
};

export default Template_5;

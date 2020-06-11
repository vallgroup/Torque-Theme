import React from "react";
import PropTypes from "prop-types";

class Template_3 extends React.PureComponent {
  render() {
    const { post } = this.props;

    const backgroundImage = post?.thumbnail;
    const excerpt = post?.post_excerpt;

    return (
      <div className={"loop-post template-1"}>
        <div className={"content-wrapper"}>
          
          <h4 dangerouslySetInnerHTML={{ __html: post.post_title }} />

          <div className={"featured-image-wrapper"}>
            <div
              className={"featured-image"}
              style={{ backgroundImage: `url(${backgroundImage})` }}
            />
          </div>

          <div className="meta-wrapper">
            <div className="rsf">
              {this.formatedSF()}
            </div>
            <div
              className="excerpt"
              dangerouslySetInnerHTML={{ __html: excerpt }}
            />
          </div>

          <a 
            className="download-wrapper"
            href={post?.meta?.floor_plan_downloads_pdf || ''}
          >
            {'Download Full Floorplan'}
          </a>
        </div>
      </div>
    );
  }

  formatedSF() {
    const { post } = this.props;
    const rsf = post.meta?.floor_plan_rsf || '';

    return rsf + ' SF';
  }
}

Template_3.propTypes = {
  post: PropTypes.object.isRequired
};

export default Template_3;

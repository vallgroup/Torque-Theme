import React from "react";
import PropTypes from "prop-types";

class Template_3 extends React.PureComponent {
  render() {
    const {
      cat,
      onChange
    } = this.props;

    const _title = cat?.name
    const backgroundImage = cat?.thumbnail;
    const button = cat.description

    const selectNewCat = (e) => {
      e.preventDefault()

      onChange(cat.term_id)
    }

    return (
      <div className={"loop-post loop-cat template-3"}>
        <div className={"content-wrapper"}>
          <div className={"featured-image-wrapper"}>
            <a
              href={'#cat_selected'}
              onClick={selectNewCat}
            >
              <div
                className={"featured-image"}
                style={{ backgroundImage: `url(${backgroundImage})` }}
              />
            </a>
          </div>
          {button && '' !== button &&
            <a
              className="download-wrapper"
              href={'#cat_selected'}
              onClick={selectNewCat}
            >
              {button}
            </a>
          }
        </div>
      </div>
    );
  }

  formatedSF() {
    const { post } = this.props;
    const rsf = post?.meta?.floor_plan_rsf || '';

    return ('' !== rsf) ? rsf + ' SF' : null;
  }
}

Template_3.propTypes = {
  cat: PropTypes.object.isRequired,
  onChange: PropTypes.function,
};

export default Template_3;

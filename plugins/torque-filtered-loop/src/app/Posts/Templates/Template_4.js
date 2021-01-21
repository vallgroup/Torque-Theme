import React, { setState } from "react";
import PropTypes from "prop-types";
import { InfoBox_0 } from "../../components/InfoBox";

class Template_4 extends React.PureComponent {
  constructor(props) {
    super(props);
    this.state = {
      isOpen: false,
      infoBoxHeight: null,
    };
  }

  render() {
    const { post } = this.props;

    const backgroundImage = post?.thumbnail;
    const title = post?.post_title;

    return (
      <div 
        className={"loop-post template-4"}
        style={{ marginBottom: this.state.isOpen ? this.state.infoBoxHeight : '2em' }}
      >

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

          <div className={"post-terms-wrapper"}>{this.renderTerms('newcastle_property_type')}</div>

          {title
            ? <h3
              className="post-title"
              dangerouslySetInnerHTML={{ __html: title }}
            />
            : null}

          <a
            className={`post-cta ${this.state.isOpen ? `opened` : ``}`}
            href={"#"}
            onClick={e => this.handleCtaClick(e)}
          >
            <span>
              {this.state.isOpen 
                ? 'Close'
                : 'View Details'}
            </span>
          </a>
        </div>

        {this.state.isOpen
          ? <InfoBox_0 
            post={post}
            setHeight={this.setInfoBoxHeight.bind(this)}
          />
          : null}

      </div>
    );
  }

  // this function is passed to the child info box component, which returns the height of the info box when it loads
  // this height is then used to add a spacer at the bottom of the grid item
  setInfoBoxHeight(height) {
    height
      && this.setState({
        infoBoxHeight: height
      });
  }

  // handles the open/closed state of this grid item's info box
  handleCtaClick(e) {
    // prevent default anchor events
    e.preventDefault();
    e.stopPropagation();

    // update the state
    this.setState({
      isOpen: !this.state.isOpen
    });
  }

  renderTerms(tax = null) {
    const { post } = this.props;
    const terms = post.terms;

    tax = tax ? tax : 'category'

    return (
      terms &&
      terms.map((term, index) => {
        return (
          tax === term.taxonomy
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

Template_4.propTypes = {
  post: PropTypes.object.isRequired
};

export default Template_4;

import React, { useEffect, useState, useContext } from "react";
import PropTypes from "prop-types";
import { InfoBox_0 } from "../../components/InfoBox";
import InfoBoxContext from "../../context";

export default function Template_4({ post }) {
  // context
  const { openInfoBox } = useContext(InfoBoxContext);
  const { setOpenInfoBox } = useContext(InfoBoxContext);
  // states
  const [isOpen, setIsOpen] = useState(false);
  const [infoBoxHeight, setInfoBoxHeight] = useState(null);
  // vars
  const backgroundImage = post?.thumbnail;
  const title = post?.post_title;

  useEffect(() => {
    setIsOpen(openInfoBox === post.ID);
    // openInfoBox === post.ID && setIsOpen(true);
  },[openInfoBox]);

  // handles the open/closed state of this grid item's info box
  const handleCtaClick = (e) => {
    // prevent default anchor events
    e.preventDefault();
    e.stopPropagation();

    // update the context
    // if closing the info box send false, else the new ID
    setOpenInfoBox(isOpen
      ? false
      : post.ID);
  }

  const renderTerms = (tax = null) => {
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

  return (
    <div 
      className={"loop-post template-4"}
      style={{ marginBottom: isOpen ? infoBoxHeight : '2em' }}
    >

      {backgroundImage
        ? <div className={"featured-image-wrapper"}>
          <div
            className={"featured-image"}
            style={{ backgroundImage: `url(${backgroundImage})` }}
          />
        </div>
        : null}

      <div className={"content-wrapper"}>

        <div className={"post-terms-wrapper"}>
          {renderTerms('newcastle_property_type')}
        </div>

        {title
          ? <h3
            className="post-title"
            dangerouslySetInnerHTML={{ __html: title }}
          />
          : null}

        <a
          className={`post-cta ${isOpen ? `opened` : ``}`}
          href={"#"}
          onClick={e => handleCtaClick(e)}
        >
          <span>
            {isOpen 
              ? 'Close'
              : 'View Details'}
          </span>
        </a>
      </div>

      {isOpen
        ? <InfoBox_0 
          post={post}
          setHeight={setInfoBoxHeight}
        />
        : null}

    </div>
  );
}

Template_4.propTypes = {
  post: PropTypes.object.isRequired
};

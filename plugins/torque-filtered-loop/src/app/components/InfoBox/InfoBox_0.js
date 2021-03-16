import React, { useRef, useEffect } from "react";
import { arrayContains, arrEmpty } from "../../helpers";

// used in-line, for displaying info box in the grid
const InfoBox_0 = ({ post, setHeight }) => {
  // refs
  const infoBox = useRef();

  // vars
  const isRetail = post?.terms
    ? Boolean(post.terms.find((term, idx) => {
      return 'retail' === term.name.toLowerCase();
    }))
    : false;
  const thumbnail = post?.thumbnail;
  const title = post?.post_title;
  const excerpt = isRetail
    ? post?.acf?.retail_description
    : post?.acf?.multifamily_description;
  const webLink = post?.acf?.website_link;
  const retailLink = post?.permalink;
  // additional link ACF defs:
  // field_604b44007d3ae - bool, open in new tab
  // field_6000f35bd8e33 - string, title of link/file
  // field_6000f362d8e34 - string, either 'link' or 'file'
  // field_6000f3b1d8e35 - object, file ()
  // field_6000f3c8d8e36 - string, link url
  const additionalLinks = post?.acf?.additional_files_links;

  console.log({additionalLinks, webLink});

  // when the infoBox is updated, send the div height to parent component
  // this height is then used to add a spacer at the bottom of the grid item
  useEffect(() => {
    setHeight(infoBox.current.offsetHeight)
  }, [infoBox]);

  const renderAddress = () => {
    const streetAddress = post?.acf?.street_address;
    const city = post?.acf?.city;
    const state = post?.acf?.state;
    const zipCode = post?.acf?.zip_code;

    return (
      <div className={"info-box-address-wrapper"}>
        {streetAddress
          && <span className={"street-address"}>
            {streetAddress}
          </span>}
        {city
          && <><br/><span className={"city"}>
            {city}
          </span></>}
        {state
          && <span className={"state"}>
            {`, ${state}`}
          </span>}
        {zipCode
          && <span className={"zip-code"}>
            {`, ${zipCode}`}
          </span>}
      </div>
    )
  }

  return (
    <div
      className={"info-box-wrapper template-0"}
      ref={infoBox}
    >
      <div className={"info-box-col1"}>

        {title
          ? <h3
            className="info-box-title"
            dangerouslySetInnerHTML={{ __html: title }}
          />
          : null}

        {renderAddress()}

        {excerpt
          && <div
            className={"info-box-excerpt"}
            dangerouslySetInnerHTML={{ __html: excerpt }}
          ></div>}

        <div className={"info-box-buttons-wrapper"}>

          {isRetail
            ? <a
              className={"info-box-button cta-retail"}
              href={retailLink}
            >
              {'View Retail'}
            </a>
            : null}

          {"" !== webLink && "" !== webLink.title && "" !== webLink.url
            ? <a
              className={"info-box-button cta-website"}
              href={webLink.url}
              target={webLink.target || "_self"}
              rel={"_blank" === webLink.target ? "nofollow noopener" : ""}
            >
              {webLink.title}
            </a>
            : null}

          {additionalLinks && additionalLinks.map((link, idx) => {
            ('link' === link.field_6000f362d8e34 && '' !== link.field_6000f3c8d8e36) &&
              <a
                key={idx}
                className={"info-box-button cta-website additional-link"}
                href={link.field_6000f3c8d8e36}
                target={'1' === link.field_604b44007d3ae ? '_blank' : '_self'}
              >
                {link.field_6000f35bd8e33}
              </a>
          })}
          
        </div>

      </div>
      <div className={"info-box-col2"}>
        {thumbnail
            ? <div className={"featured-image-wrapper"}>
              <div
                className={"featured-image"}
                style={{ backgroundImage: `url(${thumbnail})` }}
              />
            </div>
            : null}
      </div>
    </div>
  )
}

export default InfoBox_0;

import React, { useRef, useEffect } from "react";
import { arrayContains, arrEmpty } from "../../helpers";

const InfoBox_1 = ({ post }) => {
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
      className={"info-box-wrapper template-1"}
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
          {webLink
            ? <a 
              className={"info-box-button cta-website"}
              href={webLink}
              target={"_blank"}
              rel={"nofollow noopener"}
            >
              {'View Website'}
            </a>
            : null}
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

export default InfoBox_1;

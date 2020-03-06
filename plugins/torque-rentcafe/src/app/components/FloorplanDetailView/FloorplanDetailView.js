import React, { useState, useEffect } from "react";
import { useLocation } from "react-router-dom";
import SimpleReactLightbox, { SRLWrapper } from "simple-react-lightbox";
import numberWithCommas from "../../helpers/numberHelpers";
import Details from "../FloorplanDetailView/Details";
import { 
  FloorplanDetailContainer,
  BackToFloorplans,
  BackIcon,
  FloorplanContentContainer,
  TitleContainer,
  FloorplanButtonsContainer,
  FloorplanButton,
  FloorplanImageContainer,
  FloorplanImage,
  FloorplanThumbnailContainer,
  FloorplanThumbnail,
} from "../FloorplanDetailView/FloorplanDetailView.styles";
import { buildingCodes } from "../../config/Floorplans.config";

const FloorplanDetailView = ({
  floorplanId,
  floorplans,
  availabilities
}) => {
  // routing
  const location = useLocation();
  // states
  const [ floorplan, setFloorplan ] = useState(null);
  const [ currentImageIndex, setCurrentImageIndex ] = useState(0);
  // lightbox options
  const options = {
    showCaption: false,
    enablePanzoom: false,
    thumbnailsOpacity: 0.0
  }

  useEffect(() => {
    // find the floorplan instance
    Object.keys(floorplans).forEach((key, value) => {
      if ( floorplans[key].FloorplanId === floorplanId ) {
        setFloorplan(floorplans[key]);
      }
    });
  }, []);

  console.log('floorplan', floorplan);

  const propertyId = floorplan?.PropertyId || null
  const fpImages = floorplan?.FloorplanImageURL
    ? floorplan.FloorplanImageURL.split(',')
    : [];
  const fpTitle = floorplan?.FloorplanName || null;
  const fpBeds = floorplan?.Beds
    ? floorplan.Beds
    : null;
  const fpBaths = floorplan?.Baths
    ? floorplan.Baths.split('.')[0] // remove the '.00' for instance
    : null;
  let fpAvailable = null;
  for (let index = 0; index < Object.keys(availabilities).length; index++) {
    if ( availabilities[index].FloorplanId === floorplanId ) {
      fpAvailable = availabilities[index].AvailableDate;
      break;
    }
  };
  const fpSF = floorplan?.MaximumSQFT
    ? numberWithCommas(floorplan.MaximumSQFT)
    : null;
  const fpPrice = floorplan?.MinimumRent
    ? 'From $' + numberWithCommas(floorplan.MinimumRent) + '/mo'
    : null;
  let fpBuilding = 'N/A';
  Object.keys(buildingCodes).forEach((key, index) => {
    if ( parseInt(buildingCodes[key].property_id) === parseInt(propertyId) ) {
      fpBuilding = key;
    }
  });
  const fpDetails = {
    'Square Feet': fpSF,
    'Bedrooms': fpBeds,
    'Bathrooms': fpBaths,
    'Availability': fpAvailable, 
    'Price': fpPrice,
    'Building': fpBuilding,
  };

  const availabilityUrl = floorplan?.AvailabilityURL || null;

  // workaround so clicking the main image opens the lightbox, but we don't need to wrap the main image in the lightbox component, hence it doesn't display as a lightbox thumbnail duplicate...
  const openLightbox = () => {
    const selector = '.thumbnail-index-' + currentImageIndex.toString();
    const thumbnailToClick = document.querySelectorAll(selector)[0];
    thumbnailToClick && thumbnailToClick.click();
  }
  
  return (
    !!floorplan
      && <FloorplanDetailContainer>

        <BackToFloorplans href={location.pathname} >
          <BackIcon>
            {'\u2039'}
          </BackIcon>
          {'  View All'}
        </BackToFloorplans>

        <FloorplanContentContainer>

          {!!fpTitle
            && <TitleContainer>
              {'Unit ' + fpTitle}
            </TitleContainer>}

          {!!fpDetails
            && <Details details={fpDetails} />}

          <FloorplanButtonsContainer>
            {/* TODO: Download a PDF floorplan, when available */}
            {/* {0 < fpImages.length
              && <FloorplanButton
                href={fpImages[currentImageIndex]}
                target={'_blank'}
              >
                {'Download Floorplan'}
              </FloorplanButton>} */}

            {availabilityUrl
              && <FloorplanButton href={availabilityUrl} target={'_blank'}>
                {'Apply Now'}
              </FloorplanButton>}
          </FloorplanButtonsContainer>

        </FloorplanContentContainer>
        <FloorplanImageContainer>

          {0 < fpImages.length
            && <SimpleReactLightbox key={currentImageIndex}>
            <FloorplanImage 
              src={fpImages[currentImageIndex]}
              onClick={() => openLightbox()}
            />
            <SRLWrapper {...options}>
              <FloorplanThumbnailContainer>
              {fpImages.map((image, index) => {
                const thumbId = 'thumbnail-index-' + index.toString();
                return (
                  <FloorplanThumbnail
                    key={index}
                    className={thumbId}
                    src={image}
                    active={index === currentImageIndex}
                    onClick={() => setCurrentImageIndex(index)}
                  />
                )
              })}
            </FloorplanThumbnailContainer>
            </SRLWrapper>
          </SimpleReactLightbox>}

        </FloorplanImageContainer>
      </FloorplanDetailContainer>
  )
}

export default FloorplanDetailView

import React, { useState, useEffect } from "react";
import numberWithCommas from "../../helpers/numberHelpers";
import FiltersHelpers from "../../helpers/filtersHelpers";
import Title from "./Title";
import Details from "./Details";
import { 
  FloorplanContainer,
  FloorplanImageContainer,
  FloorplanImage,
  FloorplanContentContainer,
  FloorplanButtonsContainer,
  FloorplanButton,
} from "./FloorplanGridView.styles.js";
import { buildingCodes } from "../../config/Floorplans.config";

const FloorplanGridView = ({ 
  floorplan,
  availabilities
}) => {

  const fpId = floorplan?.FloorplanId || null;
  const propertyId = floorplan?.PropertyId || null

  const fpImage = floorplan?.FloorplanImageURL
    ? floorplan?.FloorplanImageURL.split(',')[0]
    : null;

  const fpTitle = floorplan?.FloorplanName || null;
  
  const fpBeds = floorplan?.Beds
    ? floorplan.Beds
    : null;
  const fpBaths = floorplan?.Baths
    ? floorplan.Baths.split('.')[0] // remove the '.00' for instance
    : null;
  const fpType = fpBeds && fpBaths
    ? fpBeds + ' bed/' + fpBaths + ' bath'
    : null

  const fpSF = floorplan?.MaximumSQFT
    ? numberWithCommas(floorplan.MaximumSQFT)
    : null;
  const fpPrice = floorplan?.MinimumRent 
    && floorplan.MinimumRent !== '-1'
    && floorplan.MinimumRent !== ''
      ? 'From $' + numberWithCommas(floorplan.MinimumRent) + '/mo'
      : null;
  let fpBuilding = 'N/A';
  Object.keys(buildingCodes).forEach((key, index) => {
    if ( parseInt(buildingCodes[key].property_id) === parseInt(propertyId) ) {
      fpBuilding = key;
    }
  });
  const fpDetails = {
    Type: fpType || null,
    // Building: fpBuilding || null, 
    SF: fpSF || null,
    Price: fpPrice || null,
  }

  const availabilityUrl = floorplan?.AvailabilityURL || null
  
  return (
    <FloorplanContainer>

      {fpImage
        && <FloorplanImageContainer>
          <FloorplanImage src={fpImage} />
        </FloorplanImageContainer>}

      <FloorplanContentContainer>
        {fpTitle
          && <Title title={fpTitle} />}

        {fpDetails
          && <Details details={fpDetails} />}
      </FloorplanContentContainer>

      <FloorplanButtonsContainer>
        <FloorplanButton
          href={'?floorplanId=' + fpId}
        >
          {'View Details'}
        </FloorplanButton>

        {availabilityUrl
          && <FloorplanButton href={availabilityUrl} target={'_blank'}>
            {'Check Availability'}
          </FloorplanButton>}
      </FloorplanButtonsContainer>

    </FloorplanContainer>
  )
}

export default FloorplanGridView

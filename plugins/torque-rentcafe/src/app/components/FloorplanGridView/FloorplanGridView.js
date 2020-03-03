import React, { useState, useEffect } from "react";
import numberWithCommas from "../../helpers/numberHelpers";
import Title from "./Title";
import Details from "./Details";
import { 
  FloorplanContainer,
  FloorplanImage,
  FloorplanContentContainer,
  FloorplanButtonsContainer,
  FloorplanButton,
} from "./FloorplanGridView.styles.js";

const FloorplanGridView = ({ 
  floorplan,
  availabilities
}) => {

  const fpId = floorplan?.FloorplanId || null;

  const fpImage = floorplan?.FloorplanImageURL || null;
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

  let fpAvailable = null;
  for (let index = 0; index < Object.keys(availabilities).length; index++) {
    if (
      availabilities[index].AvailableDate !== 'N/A'
      && availabilities[index].AvailableDate !== ''
      && availabilities[index].FloorplanId === floorplan.FloorplanId
    ) {
      fpAvailable = availabilities[index].AvailableDate;
      break;
    }
  };

  const fpSF = floorplan?.MaximumSQFT
    ? numberWithCommas(floorplan.MaximumSQFT)
    : null;
  const fpPrice = floorplan?.MinimumRent 
    && floorplan.MinimumRent !== '-1'
    && floorplan.MinimumRent !== ''
      ? 'From $' + numberWithCommas(floorplan.MinimumRent) + '/mo'
      : null;
  const fpDetails = {
    Type: fpType || null,
    Available: fpAvailable || null, 
    SF: fpSF || null,
    Price: fpPrice || null,
  }

  const availabilityUrl = floorplan?.AvailabilityURL || null
  
  return (
    <FloorplanContainer>

      {fpImage
        && <FloorplanImage src={fpImage} />}

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
            {'Apply Now'}
          </FloorplanButton>}
      </FloorplanButtonsContainer>

    </FloorplanContainer>
  )
}

export default FloorplanGridView

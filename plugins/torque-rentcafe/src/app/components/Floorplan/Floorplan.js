import React, { useState, useEffect } from "react";
import Title from "./Title";
import Details from "./Details";
import { 
  FloorplanContainer,
  FloorplanImage,
  FloorplanContentContainer,
  FloorplanButtonsContainer,
  FloorplanButton,
} from "./Floorplan.styles.js";

const Floorplan = ({ floorplan }) => {

  const fpImage = floorplan?.FloorplanImageURL || null;
  const fpTitle = floorplan?.FloorplanName || null;
  
  // TODO: need to format this data to remove '.' or '.00'?
  const fpBeds = floorplan?.Beds
    ? parseInt(floorplan.Beds)
    : null;
  const fpBaths = floorplan?.Baths
    ? parseInt(floorplan.Baths)
    : null;
  const fpType = fpBeds && fpBaths
    ? fpBeds + ' bed/' + fpBaths + ' bath'
    : fpBeds
      ? fpBeds + ' bed'
      : fpBaths
        ? fpBaths + ' bath'
        : null
  
  const fpAvailable = null; // TODO: need to fetch from another resource...
  const fpSF = floorplan?.MaximumSQFT || null;
  const fpPrice = floorplan?.MinimumRent || null;
  const fpDetails = {
    Type: fpType || null,
    Available: fpAvailable || null, 
    SF: fpSF || null,
    Price: fpPrice || null,
  }

  const availabilityUrl = floorplan?.AvailabilityURL || null

  // console.log('fpBeds', typeof fpBeds);
  // console.log('fpBaths', typeof fpBaths);
  // console.log('fpBeds', parseInt(fpBeds));
  // console.log('fpBaths', parseInt(fpBaths));
  
  return (
    <FloorplanContainer
      className={'FloorplanContainer'}
    >

      {fpImage
        && <FloorplanImage
          className={'FloorplanImage'}
          src={fpImage}
        />}

      <FloorplanContentContainer
        className={'FloorplanContentContainer'}
      >
        {fpTitle
          && <Title title={fpTitle} />}

        {fpDetails
          && <Details details={fpDetails} />}
      </FloorplanContentContainer>

      <FloorplanButtonsContainer
        className={'FloorplanButtonsContainer'}
      >
        <>
        <FloorplanButton
          className={'FloorplanButtonOne'}
          href={'#'}
        >
          {'View Details'}
        </FloorplanButton>

        {availabilityUrl
          && <FloorplanButton
            className={'FloorplanButtonTwo'}
            href={availabilityUrl}
          >
            {'Apply Now'}
          </FloorplanButton>}
        </>
      </FloorplanButtonsContainer>

    </FloorplanContainer>
  )
}

export default Floorplan

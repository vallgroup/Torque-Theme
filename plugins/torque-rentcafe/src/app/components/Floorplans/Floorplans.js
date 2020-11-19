import React, { useState, useEffect } from "react";
import axios from "axios";
import SimpleReactLightbox, { SRLWrapper } from "simple-react-lightbox";
import { isEmpty } from "../../helpers/objectHelpers";
import FiltersHelpers from "../../helpers/filtersHelpers";
import Filters from "../Filters/Filters"
import FloorplanGridView from "../FloorplanGridView/FloorplanGridView";
import FloorplansDisclaimer from "./FloorplansDisclaimer";
import {
  FloorplansContainer,
  FloorplanDisclaimer,
  SiteMapLightboxWrapper,
  SiteMapImageAnchor,
  SiteMapImage,
} from "./Floorplans.styles.js";
import { LoadingMessage } from "../../styles/App.styles";

// props
//
// floorplans: object 
// availabilities: object 
// incomeRestricted: boolean
const Floorplans = ({
  initialFloorplans,
  availabilities,
  incomeRestricted,
  siteMap,
}) => {
  const [ filteredFloorplans, setFilteredFloorplans ] = useState(initialFloorplans);
  const __filtersHelper = new FiltersHelpers(initialFloorplans);

  const [ siteMapVisible, setSiteMapVisible ] = useState(false);

  // lightbox options
  const options = {
    showCaption: true,
    enablePanzoom: false,
    thumbnailsOpacity: 0.0
  }
  // lightbox callbacks
  // const callbacks = {
  //     onSlideChange: object => console.log(object),
  //     onLightboxOpened: object => console.log(object),
  //     onLightboxClosed: object => console.log(object),
  //     onCountSlides: object => console.log(object)
  // };

  useEffect(() => {
    // if incomeRestricted is TRUE, filter for income-restricted listings
    const updatedFloorplans = __filtersHelper
      .getByIncomeRestricted(incomeRestricted) // 'incomeRestricted' is true or false, filtering accordingly
      .getOnlyAvailable(availabilities)
      .sortAlphabetically()
      .floorplans; // return the filtered floorplans

    setFilteredFloorplans(updatedFloorplans);
  }, []);

  useEffect(() => {
    // reset the floorplans in the helper
    __filtersHelper.floorplans = initialFloorplans;
  }, [filteredFloorplans]);

  const handleFiltersUpdated = (newFilters) => {
    // console.log('newFilters', newFilters);

    // check whether 'townhouse' was selected, and if so default building to 'all'
    // NB: further logic found in <FilterTypeButton> lines: 26-36.
    if (newFilters.type === 'townhouse') {
      newFilters.building = 'all';
    }

    /* Note: only searching by 'type' filter for Everton project */
    const updatedFloorplans = __filtersHelper
      // .getByIncomeRestricted(incomeRestricted) // 'incomeRestricted' is true or false, filtering accordingly
      // .getByBuilding(newFilters['building']) // must be called first, because getByType has potential to override it if 'townhouse' is selected...
      .getByType(newFilters['type'])
      // .getByPrice(newFilters['price'])
      .getOnlyAvailable(availabilities)
      // .getByAvailability(newFilters['availability'], availabilities)
      // .getByFloor('floor', newFilters['floor'])
      .sortAlphabetically()
      .floorplans; // return the filtered floorplans

    setFilteredFloorplans(updatedFloorplans);
  }

  const toggleSiteMap = (forcedState = null) => {
    if ( null !== forcedState ) {
      setSiteMapVisible(forcedState);
    } else {
      setSiteMapVisible(!siteMapVisible);
    }
  }

  // console.log('filteredFloorplans', filteredFloorplans);

  return (<>
    <Filters
      filtersUpdated={handleFiltersUpdated}
      hasSiteMap={!!siteMap}
      siteMapVisible={siteMapVisible}
      toggleSiteMap={toggleSiteMap}
    />
    {!isEmpty(filteredFloorplans)
      ? <>
        <SimpleReactLightbox 
          key={Object.keys(filteredFloorplans).length}
        >
          <SRLWrapper 
            options={options}
            // callbacks={callbacks}
          >
            <FloorplansContainer>
              {Object.entries(filteredFloorplans).map(([key, floorplan]) => {
                return (
                  <FloorplanGridView
                    key={floorplan?.FloorplanId}
                    floorplan={floorplan}
                    availabilities={availabilities || null}
                  />
                );
              })}
              {!!siteMap 
                && <>
                  <SiteMapLightboxWrapper
                    show={siteMapVisible}
                    onClick={() => toggleSiteMap(false)}
                  />
                  <SiteMapImageAnchor
                    href={siteMap}
                    data-attribute={"SRL"}
                    show={siteMapVisible}
                  >
                    <SiteMapImage 
                      src={siteMap} 
                      show={siteMapVisible}
                      alt="Site Map"
                    />
                  </SiteMapImageAnchor>
                </>}
            </FloorplansContainer>
          </SRLWrapper>
        </SimpleReactLightbox>
        {/* <FloorplansDisclaimer incomeRestricted={incomeRestricted} /> */}
      </>
      : <LoadingMessage>
        {'We couldn\'t find any floor plans matching your criteria.'}
      </LoadingMessage>}
  </>);
}

export default Floorplans

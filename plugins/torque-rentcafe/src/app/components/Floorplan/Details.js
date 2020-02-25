import React from "react";
import isEmpty from "../../helpers/objectHelpers";
import {
  DetailsContainer,
  DetailWrapper,
  DetailName,
  DetailValue,
} from "./Floorplan.styles.js";

const Details = ({ details }) => {
  
  return (
    !isEmpty(details)
      ? <DetailsContainer
        className={'DetailWrapper'}
      >
        {Object.entries(details).map(([key, detail]) => {
            // console.log('floorplan.FloorplanId', floorplan.FloorplanId);
            return (
              <DetailWrapper 
                key={key}
                className={'DetailWrapper'}
              >
                <>
                  <DetailName
                    className={'DetailName'}
                  >
                    {key + ': '}
                  </DetailName>
                  <DetailValue 
                    className={'DetailValue'}
                  >
                    {detail
                      ? detail
                      : 'N/A'}
                  </DetailValue>
                </>
              </DetailWrapper>
            )
          })}
      </DetailsContainer>
      : null
  );
}

export default Details

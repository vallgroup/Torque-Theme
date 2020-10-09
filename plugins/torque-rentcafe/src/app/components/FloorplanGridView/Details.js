import React from "react";
import { isEmpty } from "../../helpers/objectHelpers";
import {
  DetailsContainer,
  DetailWrapper,
  DetailName,
  DetailValue,
} from "./FloorplanGridView.styles.js";

const Details = ({ details }) => {
  
  return (
    !isEmpty(details)
      ? <DetailsContainer>
        {Object.entries(details).map(([key, detail]) => {
            return (
              <DetailWrapper
                key={key}
                className={key}
              >
                <DetailName>
                  {key + ': '}
                </DetailName>
                <DetailValue>
                  {detail
                    ? detail
                    : 'N/A'}
                </DetailValue>
              </DetailWrapper>
            )
          })}
      </DetailsContainer>
      : null
  );
}

export default Details

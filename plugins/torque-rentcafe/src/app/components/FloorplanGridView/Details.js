import React from "react";
import { isEmpty } from "../../helpers/objectHelpers";
import {
  DetailsContainer,
  DetailWrapper,
  DetailName,
  DetailIcon,
  DetailValue,
} from "./FloorplanGridView.styles.js";
import bedsImg from "../../assets/beds-icon.png";
import sfImg from "../../assets/sf-icon.png";
import priceImg from "../../assets/price-icon.png";

const Details = ({ details }) => {

  const icons = {
    Type: bedsImg,
    SF: sfImg,
    Price: priceImg,
  }
  
  return (
    !isEmpty(details)
      ? <DetailsContainer>
        {Object.entries(details).map(([key, detail]) => {
            const icon = icons[key]
            return (
              <DetailWrapper
                key={key}
                className={key}
              >
                <DetailName>
                  {icon
                    ? <DetailIcon src={icon}/>
                    : key}
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

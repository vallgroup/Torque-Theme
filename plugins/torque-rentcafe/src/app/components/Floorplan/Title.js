import React from "react";
import {
  TitleContainer
} from "./Floorplan.styles.js";

const Title = ({ title }) => {
  
  return (
    title 
      && <TitleContainer
        className={'TitleContainer'}
      >
        {'Unit ' + title}
      </TitleContainer>
  )
}

export default Title

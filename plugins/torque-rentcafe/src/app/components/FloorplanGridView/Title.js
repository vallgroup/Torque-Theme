import React from "react";
import {
  TitleContainer
} from "./FloorplanGridView.styles.js";

const Title = ({ title }) => {
  
  return (
    title 
      && <TitleContainer>
        {'Unit ' + title}
      </TitleContainer>
  )
}

export default Title

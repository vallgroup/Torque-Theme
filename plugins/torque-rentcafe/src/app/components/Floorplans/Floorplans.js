import React, { useState, useEffect } from "react";
import axios from "axios";
import isEmpty from "../../helpers/objectHelpers";
import Floorplan from "../Floorplan/Floorplan";
import { FloorplansContainer } from "./Floorplans.styles.js";

const Floorplans = ({ floorplanData }) => {

  const { floorplans } = floorplanData;
  
  return (
    !isEmpty(floorplans)
      ? <FloorplansContainer
        className={'FloorplansContainer'}
      >
        {Object.entries(floorplans).map(([key, floorplan]) => {
          // console.log('floorplan.FloorplanId', floorplan.FloorplanId);
          return <Floorplan key={floorplan?.FloorplanId} floorplan={floorplan} />
        })}
      </FloorplansContainer>
      : null
  );
}

export default Floorplans

import React from "react";
import { createRequestParams } from "./helpers";
import { useWPFloorplans } from "./hooks";
import Floorplans from "./components/Floorplans/Floorplans";

// props
//
// site: string 
const App = ({ site, requestType, PropertyCode }) => {
  const params = createRequestParams({ requestType, PropertyCode });
  const floorplanData = useWPFloorplans( site, params );

  return (
    <Floorplans floorplanData={floorplanData} />
  );
}

export default App

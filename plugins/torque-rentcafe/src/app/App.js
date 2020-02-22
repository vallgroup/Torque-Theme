import React from "react";
import { createRequestParams } from "./helpers";
import { useWPFloorplans } from "./hooks";
import FloorplansContainer from "./components/FloorplansContainer/FloorplansContainer";

// props
//
// site: string 
const App = ({ site, requestType, PropertyCode }) => {
  const params = createRequestParams({ requestType, PropertyCode });
  const floorplans = useWPFloorplans( site, params );

  return (
    <FloorplansContainer
      floorplans={floorplans}
    />
  )
}

export default App

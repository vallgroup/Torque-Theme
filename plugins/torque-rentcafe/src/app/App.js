import React from "react";
import { useLocation } from "react-router-dom";
import { createRequestParams } from "./helpers";
import { useWPFloorplans } from "./hooks";
import Floorplans from "./components/Floorplans/Floorplans";
import FloorplanDetailView from "./components/FloorplanDetailView/FloorplanDetailView";
import { LoadingMessage } from "./styles/App.styles";

// props
//
// site: string 
// requestType: string 
// PropertyCode: string 
const App = ({ 
  site,
  requestType,
  PropertyCode,
  incomeRestricted, 
}) => {
  
  // API query
  const params = createRequestParams({ requestType, PropertyCode });
  const { floorplans, availabilities } = useWPFloorplans( site, params );
  
  // URL query
  const useQuery = () => {
    return new URLSearchParams(useLocation().search);
  }
  const query = useQuery();
  const floorplanId = query.get("floorplanId") || null;

  return ( 
    0 < floorplans.length
      ? <>
        {floorplanId
          ? <FloorplanDetailView
            floorplanId={floorplanId}
            floorplans={floorplans}
            availabilities={availabilities}
          />
          : <Floorplans 
            initialFloorplans={floorplans}
            availabilities={availabilities}
            incomeRestricted={incomeRestricted}
          />}
      </>
      : <LoadingMessage>
        {'Loading floorplan information...'}
      </LoadingMessage>
  );
}

export default App

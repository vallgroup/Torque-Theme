import React from "react";
import { FloorplansDisclaimerContainer } from "./Floorplans.styles";

const FloorplansDisclaimer = ({
  incomeRestricted
}) => {
  if (!incomeRestricted) {
    return <FloorplansDisclaimerContainer dangerouslySetInnerHTML={{
      __html: '<p>All dimensions are approximate. Not all features are available in every apartment.</p><p>Based on availability.</p><p>Monthly utility fees will apply in addition to above rental amount, based on size of unit. Other additional fees may apply.</p>'
    }} />
  } else {
    return <FloorplansDisclaimerContainer dangerouslySetInnerHTML={{
      __html: '<p>All dimensions are approximate. Not all features are available in every apartment.</p><p>Based on availability.</p>'
    }} />
  }
}

export default FloorplansDisclaimer
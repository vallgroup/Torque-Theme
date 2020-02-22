import { useMemo } from "react";

export default ({ requestType, propertyCode }) =>
  useMemo(
    () => {
      const params = {
        request_type: requestType,
        property_code: propertyCode,
      };

      return params;
    },
    [requestType, propertyCode]
  );

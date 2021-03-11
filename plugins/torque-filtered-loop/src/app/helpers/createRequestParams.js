import { useMemo } from "react";

export default ({ postType, taxParams, metaParams, dateParams }) =>
  useMemo(
    () => {
      const params = {
        post_type: postType
      };

      if (taxParams) {
        Object.keys(taxParams).forEach(taxSlug => {
          params[`tax_${taxSlug}`] = taxParams[taxSlug];
        });
      }

      if (metaParams) {
        Object.keys(metaParams).forEach(metaKey => {
          params[`meta_${metaKey}`] = metaParams[metaKey];
        });
      }

      if (dateParams) {
        dateParams.forEach(dateParam => {
          if (dateParam === 0) return;

          const date = new Date(dateParam);

          if (4 === dateParam.length) {
            // we have the year only
            params["year"] = date.getFullYear();
          } else {
            // we have the year and month
            params["year"] = date.getFullYear();
            params["monthnum"] = date.getMonth() + 1; // js indexes months from 0
          }
        });
      }

      return params;
    },
    [postType, taxParams, metaParams]
  );

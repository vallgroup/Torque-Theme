import { useMemo } from "react";

export default ({ postType, taxParams, metaParams }) =>
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

      return params;
    },
    [postType, taxParams, metaParams]
  );

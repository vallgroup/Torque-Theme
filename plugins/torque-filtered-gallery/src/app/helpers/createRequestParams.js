import { useMemo } from "react";

export default ({ galleryID, metaParams }) =>
  useMemo(
    () => {
      const params = {
        gallery_id: galleryID
      };

      if (metaParams) {
        Object.keys(metaParams).forEach(metaKey => {
          params[`meta_${metaKey}`] = metaParams[metaKey];
        });
      }

      return params;
    },
    [galleryID, metaParams]
  );

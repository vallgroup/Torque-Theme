import { useMemo } from "react";

export default (tax, parentId, activeTerm) =>
  useMemo(
    () => {
      let params = {};

      if (parentId) {
        //
        // if we have a parent Id,
        // then if we have an active term we want to filter with that,
        // otherwise we want to filter on the parent term and get all posts
        //
        params = activeTerm
          ? {
              [tax]: activeTerm
            }
          : {
              [tax]: parentId
            };
      } else {
        //
        // if theres no parent term
        // then if we have an active term we filter on that
        // otherwise we get all posts
        params = activeTerm
          ? {
              [tax]: activeTerm
            }
          : {};
      }

      return params;
    },
    [tax, parentId, activeTerm]
  );

import { useMemo } from "react";

export default (terms, parentId) =>
  useMemo(
    () => {
      if (!parentId) {
        return terms;
      }

      return terms.filter(term => {
        return term.parent === parentId;
      });
    },
    [terms, parentId]
  );

import { useMemo } from "react";

export default (terms, parent) =>
  useMemo(
    () => {
      if (!terms?.length) return 0;

      let parentId = 0;
      for (let i = 0; i < terms.length; i++) {
        const term = terms[i];

        if (term.slug === parent) {
          parentId = term.term_id;
          break;
        }
      }

      return parentId;
    },
    [terms, parent]
  );

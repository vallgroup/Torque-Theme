import { useState, useEffect } from "react";

export default (terms, parent) => {
  const [parentId, setParentId] = useState(0);

  useEffect(
    () => {
      const getParentId = () => {
        if (!terms?.length) return setParentId(0);

        let parentId = 0;
        for (let i = 0; i < terms.length; i++) {
          const term = terms[i];

          if (term.slug === parent) {
            parentId = term.term_id;
            break;
          }
        }

        setParentId(parentId);
      };

      getParentId();
    },
    [terms, parent]
  );

  return parentId;
};

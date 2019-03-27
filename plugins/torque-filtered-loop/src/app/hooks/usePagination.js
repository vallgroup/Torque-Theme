import { useState, useMemo, useEffect } from "react";

export default requestParams => {
  const [page, setPage] = useState(1);
  const [hasNextPage, setHasNextPage] = useState(false);

  useEffect(
    () => {
      setPage(1); // reset page if params change
      setHasNextPage(false);
    },
    [requestParams]
  );

  const getNextPage = useMemo(
    () => {
      // function will be false if next page is not available
      if (!hasNextPage) return false;

      return () => setPage(page => page + 1);
    },
    [hasNextPage]
  );

  return [page, getNextPage, setHasNextPage];
};

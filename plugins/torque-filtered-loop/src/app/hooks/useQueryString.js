import { useMemo } from "react";

export default () =>
  useMemo(() => {
    const urlParams = new URLSearchParams(window.location.search);

    const query = {};
    urlParams.forEach((value, key) => {
      query[key] = isInteger(value) ? parseInt(value) : value;
    });

    const setQuery = (key, value) => {
      urlParams.set(key, value);
      window.history.pushState({}, "", "?" + urlParams.toString());
    };

    return [query, setQuery];
  }, []);

function isInteger(str) {
  return /^\+?(0|[1-9]\d*)$/.test(str);
}

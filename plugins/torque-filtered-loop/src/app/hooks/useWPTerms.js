import { useState, useEffect } from "react";
import axios from "axios";

export default (site, taxSlug) => {
  const [terms, setTerms] = useState([]);

  useEffect(
    () => {
      if (!taxSlug) return;

      const getTerms = async () => {
        try {
          const url = `${site}/wp-json/wp/v2/${taxSlug}`;
          const response = await axios.get(url);
          const terms = response.data;

          setTerms(terms);
        } catch (e) {
          console.warn(e);
          this.setState({ terms: [] });
        }
      };

      getTerms();
    },
    [site, taxSlug]
  );

  return terms;
};

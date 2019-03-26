import { useState, useEffect } from "react";
import axios from "axios";

export default (site, tax) => {
  const [terms, setTerms] = useState([]);

  useEffect(
    () => {
      if (!tax) return;

      const getTerms = async () => {
        try {
          const url = `${site}/wp-json/filtered-loop/v1/terms`;
          const params = { tax };
          const response = await axios.get(url, { params });

          if (response.data.success && response.data.terms) {
            return setTerms(response.data.terms);
          }

          return setTerms([]);
        } catch (e) {
          console.warn(e);
          setTerms([]);
        }
      };

      getTerms();
    },
    [site, tax]
  );

  return terms;
};

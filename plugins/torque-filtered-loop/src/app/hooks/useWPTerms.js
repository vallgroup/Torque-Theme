import { useState, useEffect } from "react";
import axios from "axios";

export default (site, tax) => {
  const [terms, setTerms] = useState([]);
  const [taxName, setTaxName] = useState("");

  useEffect(
    () => {
      if (!tax) return;

      const getTerms = async () => {
        try {
          const url = `${site}/wp-json/filtered-loop/v1/terms`;
          const params = { tax };
          const response = await axios.get(url, { params });

          if (
            response.data.success &&
            response.data.terms &&
            response.data.tax_name
          ) {
            const { terms, tax_name: taxName } = response.data;

            const termsArray =
              typeof terms === "object" ? Object.values(terms) : terms;
            setTerms(termsArray);

            setTaxName(taxName);

            return;
          }

          setTaxName("");
          setTerms([]);
          return;
        } catch (e) {
          console.warn(e);
          setTerms([]);
          setTaxName("");
        }
      };

      getTerms();
    },
    [site, tax]
  );

  return [terms, taxName];
};

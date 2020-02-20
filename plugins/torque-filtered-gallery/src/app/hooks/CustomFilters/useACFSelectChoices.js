import { useState, useEffect } from "react";
import axios from "axios";

export default (site, fieldId, galleryID) => {
  const [choices, setChoices] = useState([]);

  useEffect(
    () => {
      if (!fieldId) return;

      const getChoices = async () => {
        try {
          const url = `${site}/wp-json/filtered-gallery/v1/filters/acf-select`;
          const params = { 
            field_id: fieldId,
            gallery_id: galleryID
           };
          const response = await axios.get(url, { params });

          if (response.data.success && response.data.choices) {
            const { choices } = response.data;

            return setChoices(choices);
          }

          return setChoices([]);
        } catch (e) {
          console.warn(e);
          setChoices([]);
        }
      };

      getChoices();
    },
    [site, fieldId]
  );

  return choices;
};

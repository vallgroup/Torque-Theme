import { useState, useEffect } from "react";
import axios from "axios";

export default (site, postType, dateType) => {
  const [dates, setDates] = useState([]);

  useEffect(
    () => {
      if (!postType) return;

      const getDates = async () => {
        try {
          const url = `${site}/wp-json/filtered-loop/v1/filters/dropdown-date`;
          const params = { 
            post_type: postType,
            date_type: dateType || 'YYYY MM',
          };
          const response = await axios.get(url, { params });

          if (response.data.success && response.data.dates) {
            const { dates } = response.data;

            return setDates(dates);
          }

          return setDates([]);
        } catch (e) {
          console.warn(e);
          setDates([]);
        }
      };

      getDates();
    },
    [site, postType]
  );

  return dates;
};

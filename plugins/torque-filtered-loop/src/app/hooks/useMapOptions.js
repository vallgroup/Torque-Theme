import { useState, useEffect } from "react";
import axios from "axios";

export default (site) => {
  const [mapOptions, setMapOptions] = useState({});

  useEffect(
    () => {
      if (!site) return;

      const getMapOptions = async () => {
        try {
          const url = `${site}/wp-json/filtered-loop/v1/map-options`;
          const response = await axios.get(url);

          if (
            response?.data?.success 
            && response?.data?.map_options
          ) {
            setMapOptions(response.data.map_options);
            return;
          }

          setMapOptions({});
          return;
        } catch (e) {
          console.warn(e);
          setMapOptions({});
        }
      };

      getMapOptions();
    },
    [site]
  );

  return { mapOptions };
};

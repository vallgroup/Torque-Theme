import { useEffect } from "react";
import axios from "axios";

export default (site, endpoint, params, onSuccess) => {
  useEffect(
    () => {
      const getData = async () => {
        try {
          const url = `${site}/wp-json/slideshow/v1/slideshows/${endpoint}`;
          console.log(url)
          const response = await axios.get(url, { params });

          if (response?.data?.success) {
            onSuccess(response.data.data);
          }
        } catch (err) {
          console.log(err);
        }
      };

      getData();
    },
    [site, endpoint, params, onSuccess]
  );
};

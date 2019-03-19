import { useEffect } from "react";
import axios from "axios";

export default (site, id, params, onSuccess) => {
  useEffect(
    () => {
      const getData = async () => {
        try {
          const url = `${site}/wp-json/slideshow/v1/slideshows/${id}`;
          const response = await axios.get(url, { params });

          if (response?.data?.success) {
            onSuccess(response.data.slideshow);
          }
        } catch (err) {
          console.log(err);
        }
      };

      getData();
    },
    [site, id, onSuccess]
  );
};

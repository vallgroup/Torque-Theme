import { useState, useEffect } from "react";
import axios from "axios";

export default (site, activeTerm, params) => {
  // request
  const [images, setImages] = useState([]);
  useEffect(
    () => {
      const getImages = async () => {
        try {
          const response = await axios.get(
            `${site}/wp-json/filtered-gallery/v1/images`,
            {
              params
            }
          );

          const newImages = response?.data?.images || [];
          return setImages(newImages);
        } catch (e) {
          console.warn(e);
          setImages([]);
        }
      };

      getImages();
    },
    [site, params, activeTerm]
  );

  return { images };
};

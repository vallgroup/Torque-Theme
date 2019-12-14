import { useState, useEffect } from "react";
import axios from "axios";

export default (site, slug) => {
  const [grid, setGrid] = useState([]);

  useEffect(
    () => {
      if (!slug) return;

      const getGrid = async () => {
        try {
          // ping API
          const url = `${site}/wp-json/image-grid/v1/torque-image-grid/`;
          const params = { slug };
          const response = await axios.get(url, { params });
          // If grid found, save to state
          if (
            response.data.success &&
            response.data.grid
          ) {
            const { grid } = response.data;
            setGrid(grid);
            return; // exit once set state
          }
          // else set to empty array
          setGrid([]);
          return;
        } catch (e) {
          // else set to empty array
          console.warn(e);
          setGrid([]);
        }
      };
      
      // Call function to ping API
      getGrid();
    },
    [site, slug]
  );

  return [grid];
};

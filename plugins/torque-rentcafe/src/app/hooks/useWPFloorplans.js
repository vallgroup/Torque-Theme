import { useState, useEffect } from "react";
import axios from "axios";

export default (site, params) => {

  // request
  const [floorplans, setFloorplans] = useState([]);
  useEffect(
    () => {
      const getFloorplans = async () => {
        try {
          const response = await axios.get(
            `${site}/wp-json/torque-rentcafe/v1/floorplans`,
            { params }
          );

          const newFloorplans = response?.data?.floorplans || [];
          
          console.log('newFloorplans', newFloorplans);
          // console.log('newFloorplans response', response);
          // console.log('response?.data?.floorplans', response?.data?.floorplans);

          return setFloorplans(newFloorplans);
        } catch (e) {
          console.warn(e);
          setFloorplans([]);
        }
      };

      getFloorplans();
    },
    [site, params]
  );

  return { floorplans };
};

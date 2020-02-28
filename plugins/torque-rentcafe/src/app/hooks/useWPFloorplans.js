import { useState, useEffect } from "react";
import axios from "axios";

export default (site, params) => {

  // request
  const [floorplans, setFloorplans] = useState([]);
  const [availabilities, setAvailabilities] = useState([]);
  useEffect(
    () => {
      const getFloorplans = async () => {
        try {
          const response = await axios.get(
            `${site}/wp-json/torque-rentcafe/v1/floorplans`,
            { params }
          );
          const newAvailabilities = response?.data?.availabilities || [];
          const newFloorplans = response?.data?.floorplans || [];
          // set new availabilities
          setAvailabilities(newAvailabilities)
          // set new floorplans
          return setFloorplans(newFloorplans);
        } catch (e) {
          console.warn(e);
          setAvailabilities([]);
          setFloorplans([]);
        }
      };

      getFloorplans();
    },
    [site, params]
  );

  return { floorplans, availabilities };
};

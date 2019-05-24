import { useState, useEffect } from "react";
import axios from "axios";

export default (site) => {
  const [order, setOrder] = useState([]);

  useEffect(
    () => {
      const getOrder = async () => {
        try {
          const url = `${site}/wp-json/filtered-loop/v1/terms/get-neighborhood-order`;
          const response = await axios.get(url);

          if (
            response.data.success &&
            response.data.order
          ) {
            const { order } = response.data;
            setOrder(order);
            return;
          }

          setOrder([]);
          return;
        } catch (e) {
          console.warn(e);
          setOrder([]);
        }
      };

      getOrder();
    },
    [site]
  );

  return order;
};

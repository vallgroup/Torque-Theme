import { useMemo } from "react";

export default (filtersTypes, filtersArgs) =>
  useMemo(
    () => {
      const filtersTypesArr = filtersTypes.replace(/\s+/g, "").split(",");
      const filtersArgsArr = filtersArgs.replace(/\s+/g, "").split(",");

      return filtersTypesArr.map((filterType, index) => ({
        id: `${filterType}_${index}`,
        type: filterType,
        args: filtersArgsArr[index]
      }));
    },
    [filtersTypes, filtersArgs]
  );

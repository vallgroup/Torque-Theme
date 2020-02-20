import { useMemo } from "react";

export default (filterVals, customFiltersSettings) =>
  useMemo(
    () => {
      const metaParams = {};

      Object.keys(filterVals).forEach(filterId => {
        const filterType = customFiltersSettings.find(
          filterSetting => filterSetting.id === filterId
        );
        if (!filterType) return;

        switch (filterType.type) {
          case "tabs_acf": {
            const metaKey = filterType.args;
            const metaVal = filterVals[filterId];

            metaParams[metaKey] = metaVal;
            break;
          }
        }
      });

      return { metaParams };
    },
    [filterVals, customFiltersSettings]
  );

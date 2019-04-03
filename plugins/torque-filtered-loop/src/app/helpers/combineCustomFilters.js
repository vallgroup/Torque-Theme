import { useMemo } from "react";

export default (filterVals, customFiltersSettings) =>
  useMemo(
    () => {
      const taxParams = {};
      const metaParams = {};
      const dateParams = [];

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

          case "dropdown_tax": {
            const taxName = filterType.args;
            const termId = filterVals[filterId];
            if (termId === 0) break;

            taxParams[taxName] = termId;
            break;
          }

          case "dropdown_date": {
            dateParams.push(filterVals[filterId]);
            break;
          }
        }
      });

      return { taxParams, metaParams, dateParams };
    },
    [filterVals, customFiltersSettings]
  );

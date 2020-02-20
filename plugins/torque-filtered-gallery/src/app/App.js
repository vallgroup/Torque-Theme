import React, { memo, useMemo, useState, useEffect } from "react";
import PropTypes from "prop-types";
import Images from "./Images";
import { TabsACF } from "./Filters/CustomFilters";
import { useCustomFilters, useWPImages } from "./hooks";
import { createRequestParams, combineCustomFilters } from "./helpers";

const App = ({
  site,
  galleryID,
  filtersTypes,
  filtersArgs,
  loopTemplate
}) => {
  const { filterSettings, filters, createFilterUpdater } = useCustomFilters(
    filtersTypes,
    filtersArgs
  );

  const { metaParams } = combineCustomFilters(
    filters,
    filterSettings
  );
  const params = createRequestParams({
    galleryID,
    metaParams
  });
  const { images } = useWPImages(site, null, params);

  return filterSettings?.length ? (
    <div className={"torque-filtered-gallery custom-filters"}>
      {filterSettings.map((filter, index) => {
        const customFilterProps = {
          key: filter.id,
          value: filters[filter.id],
          onChange: createFilterUpdater(filter.id),
          args: filter.args,
          site,
          galleryID
        };

        switch (filter.type) {
          case "tabs_acf":
            return <TabsACF {...customFilterProps} />;

          default:
            console.warn(`Filter type ${filter.type} not found`);
            return null;
        }
      })}

      <Images images={images} loopTemplate={loopTemplate} />
    </div>
  ) : null;
};

export default memo(App);

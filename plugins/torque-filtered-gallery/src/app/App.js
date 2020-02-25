import React, { memo, useMemo, useState, useEffect } from "react";
import PropTypes from "prop-types";
import Images from "./Images";
import { TabsACF } from "./Filters/CustomFilters";
import { useCustomFilters, useWPImages } from "./hooks";
import { createRequestParams, combineCustomFilters } from "./helpers";
import SimpleReactLightbox, { SRLWrapper } from "simple-react-lightbox";

const App = ({
  site,
  galleryID,
  filtersTypes,
  filtersArgs,
  loopTemplate,
  hideFilters,
  useLightbox,
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
  const numImages = Object.keys(images).length;
  const lightboxOptions = {
    showCaption: false,
    enablePanzoom: false
  }

  return filterSettings?.length ? (
    <div className={"torque-filtered-gallery custom-filters"}>
      {filterSettings.map((filter, index) => {
        const customFilterProps = {
          key: filter.id,
          value: filters[filter.id],
          onChange: createFilterUpdater(filter.id),
          args: filter.args,
          site,
          galleryID,
          hideFilters,
        };

        switch (filter.type) {
          case "tabs_acf":
            return <TabsACF {...customFilterProps} />;

          default:
            console.warn(`Filter type ${filter.type} not found`);
            return null;
        }
      })}

      {/* By passing the number of images as a key, we force the lightbox component to re-render, hence updating the thumbnails, etc... */}
      {0 < numImages && useLightbox
        && <SimpleReactLightbox key={numImages}>
          <SRLWrapper {...lightboxOptions}>
            <Images images={images} loopTemplate={loopTemplate} />
          </SRLWrapper>
        </SimpleReactLightbox>}
      {/* If no images, don't load the lightbox components as it throws an error (plugin is missing a check somewhere...) */}
      {0 >= numImages || !useLightbox
        && <Images images={images} loopTemplate={loopTemplate} />}
    </div>
  ) : null;
};

export default memo(App);

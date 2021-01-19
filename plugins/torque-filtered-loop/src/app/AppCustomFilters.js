import React, { memo, useMemo, useState, useEffect, useRef } from "react";
import PropTypes from "prop-types";
import Posts from "./Posts";
import MapView from "./MapView";
import { 
  DropdownTax, 
  TabsTax,
  DropdownDate,
  TabsDate,
  TabsACF,
  ViewToggle,
} from "./Filters/CustomFilters";
import { useCustomFilters, useWPPosts, useMapOptions } from "./hooks";
import { createRequestParams, combineCustomFilters } from "./helpers";

const App = ({
  site,
  postType,
  postsPerPage,
  filtersTypes,
  filtersArgs,
  loopTemplate,
  enableMapView
}) => {
  // states
  const [currView, setCurrView] = useState('grid');

  // refs
  const mapWrapperRef = useRef();

  // custom hooks
  const { filterSettings, filters, createFilterUpdater } = useCustomFilters(
    filtersTypes,
    filtersArgs
  );
  const { taxParams, metaParams, dateParams } = combineCustomFilters(
    filters,
    filterSettings
  );
  const params = createRequestParams({
    postType,
    taxParams,
    metaParams,
    dateParams
  });
  const { posts, getNextPage } = useWPPosts(site, null, params, postsPerPage);
  const { mapOptions } = useMapOptions(site);

  const handleViewUpdate = (newView) => {
    setCurrView(newView)
  }

  return filterSettings?.length ? (
    <div className={"torque-filtered-loop custom-filters"}>

      <div className={"filters-wrapper"}>

        {enableMapView
          && <ViewToggle 
            currView={currView}
            handleViewUpdate={handleViewUpdate} 
          />}

        {filterSettings.map((filter, index) => {
          const customFilterProps = {
            key: filter.id,
            value: filters[filter.id],
            onChange: createFilterUpdater(filter.id),
            args: filter.args,
            site
          };

          switch (filter.type) {

            // Taxonomy - dropdown
            case "dropdown_tax":
              return <DropdownTax {...customFilterProps} />;

            // Taxonomy - tabs
            case "tabs_tax":
              return <TabsTax {...customFilterProps} />;

            // Taxonomy - tabs (multi-select)
            case "tabs_tax_multi":
              return <TabsTax {...customFilterProps} multiSelect={true} />;

            // Date - dropdown
            case "dropdown_date":
              return <DropdownDate {...customFilterProps} postType={postType} />;

            // Date - tabs
            case "tabs_date":
              return <TabsDate {...customFilterProps} postType={postType} />;

            // ACF - tabs
            case "tabs_acf":
              return <TabsACF {...customFilterProps} />;

            default:
              console.warn(`Filter type ${filter.type} not found`);
              return null;
          }
        })}
      </div>

      {'map' === currView
        ? mapOptions 
          && <div 
            ref={mapWrapperRef}
            className={"map-wrapper"}
          >
            <MapView 
              // todo pull from server
              apiKey={mapOptions.api_key}
              posts={posts}
              mapOptions={mapOptions}
              loopTemplate={loopTemplate}
              mapWrapperRef={mapWrapperRef}
            />
          </div>
        : <Posts 
          posts={posts} 
          loopTemplate={loopTemplate} 
        />}

      {getNextPage && (
        <button
          className="torque-filtered-loop-load-more"
          onClick={getNextPage}
        >
          Load More
        </button>
      )}
    </div>
  ) : null;
};

export default memo(App);

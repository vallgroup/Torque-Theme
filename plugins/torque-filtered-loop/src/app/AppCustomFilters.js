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
import { createRequestParams, combineCustomFilters, arrEmpty } from "./helpers";
import InfoBoxContext from "../app/context";

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
  const [currPosts, setCurrPosts] = useState(false);
  const [openInfoBox, setOpenInfoBox] = useState(false);

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

  // for template #5, filter out non-retail posts
  useEffect(() => {
    var _newPosts = []
    if (
      'template-5' === loopTemplate && 
      !arrEmpty(posts) &&
      false !== posts
    ) {
      _newPosts = posts.filter((post, idx) => {
        let isRetail = false;
        post.terms.forEach(term => {
          if (
            'newcastle_property_type' === term.taxonomy
            && 'Retail' === term.name
          ) {
            isRetail = true;
            return;
          }
        });
        return isRetail;
      });
    } else {
      _newPosts = posts;
    }
    setCurrPosts(_newPosts);
  }, [posts]);

  return filterSettings?.length ? (
    <InfoBoxContext.Provider value={{openInfoBox, setOpenInfoBox}}>
      <div className={`torque-filtered-loop custom-filters ${loopTemplate}`}>

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
          && mapOptions 
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
            </div>}
            
        
        {'grid' === currView 
          && <Posts 
            posts={currPosts}
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
    </InfoBoxContext.Provider>
  ) : null;
};

export default memo(App);

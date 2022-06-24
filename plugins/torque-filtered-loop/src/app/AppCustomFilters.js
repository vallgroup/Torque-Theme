import React, { memo, useMemo, useState, useEffect } from "react";
import PropTypes from "prop-types";
import Posts from "./Posts";
import { DropdownDate, DropdownTax, TabsACF } from "./Filters/CustomFilters";
import { useCustomFilters, useWPPosts } from "./hooks";
import { createRequestParams, combineCustomFilters } from "./helpers";

const App = ({
  site,
  postType,
  postsPerPage,
  filtersTypes,
  filtersArgs,
  loopTemplate
}) => {
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
  //filter post for possible duplicates
  const filteredPosts = posts.filter((post, index, array) => array.findIndex(t => t.ID == post.ID) == index);
  return filterSettings?.length ? (
    <div className={"torque-filtered-loop custom-filters"}>
      {filterSettings.map((filter, index) => {
        const customFilterProps = {
          key: filter.id,
          value: filters[filter.id],
          onChange: createFilterUpdater(filter.id),
          args: filter.args,
          site
        };

        switch (filter.type) {
          case "tabs_acf":
            return <TabsACF {...customFilterProps} />;

          case "dropdown_tax":
            return <DropdownTax {...customFilterProps} />;

          case "dropdown_date":
            return <DropdownDate {...customFilterProps} postType={postType} />;

          default:
            console.warn(`Filter type ${filter.type} not found`);
            return null;
        }
      })}

      <Posts posts={filteredPosts} loopTemplate={loopTemplate} />

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

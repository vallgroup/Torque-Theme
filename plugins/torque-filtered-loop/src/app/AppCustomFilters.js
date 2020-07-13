import React, { memo, useMemo, useState, useEffect } from "react";
import PropTypes from "prop-types";
import Posts from "./Posts";
import Categories from "./Posts/Categories";
import { DropdownDate, DropdownTax, TabsACF } from "./Filters/CustomFilters";
import { useCustomFilters, useWPPosts, useWPTerms } from "./hooks";
import { createRequestParams, combineCustomFilters } from "./helpers";

const App = ({
  site,
  postType,
  postsPerPage,
  filtersTypes,
  filtersArgs,
  loopTemplate
}) => {

  const [terms, taxName] = useWPTerms(site, 'floor_plan_cat')
  const [selectedFilter, setSelectedFilter] = useState(null)

  // const { filterSettings, filters, createFilterUpdater } = useCustomFilters(
  //   filtersTypes,
  //   filtersArgs
  // );
  //
  // const { taxParams, metaParams, dateParams } = combineCustomFilters(
  //   filters,
  //   filterSettings
  // );

  const params = createRequestParams({postType});
  const { posts, getNextPage } = useWPPosts(site, null, params, postsPerPage);

  const onSelection = (_newTerm) => {setSelectedFilter(_newTerm)}

  if (!terms && !posts) return null;

  return terms?.length ? (
    <div className={"torque-filtered-loop custom-filters"}>
      <TabsACF
        value={selectedFilter}
        filters={terms}
        onChange={onSelection}
      />

      {!selectedFilter ||
        0 === selectedFilter ?
        <Categories
          filterSelected={selectedFilter}
          terms={terms}
          onCatSelected={onSelection}
        /> :
        <Posts
          filterSelected={selectedFilter}
          posts={posts}
          loopTemplate={loopTemplate}
        />
      }

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

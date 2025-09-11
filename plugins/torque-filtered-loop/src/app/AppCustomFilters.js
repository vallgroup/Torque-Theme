import React, { memo, useMemo, useState, useEffect } from "react";
import PropTypes from "prop-types";
import Posts from "./Posts";
import { DropdownDate, DropdownTax, TabsACF } from "./Filters/CustomFilters";
import { useCustomFilters, useWPPosts } from "./hooks";
import { createRequestParams, combineCustomFilters } from "./helpers";
import PostsHorizontal from "./Posts/PostsHorizontal";
import PostsVariation from "./Posts/PostsVariation";
import TabsDropdownACF from "./Filters/CustomFilters/TabsDropdownACF";

const App = ({
  site,
  postType,
  postsPerPage,
  filtersTypes,
  filtersArgs,
  loopTemplate,
  categoryTermExclude,
  categoryTermInclude,
  useCustomLabel,
  perPageOffset,
  useTemplateVariation,
}) => {
  const { filterSettings, filters, createFilterUpdater } = useCustomFilters(
    filtersTypes,
    filtersArgs
  );
  const [calculatedPostsPerPage, setCalculatedPostsPerPage] =
    useState(postsPerPage);

  const { taxParams, metaParams, dateParams } = combineCustomFilters(
    filters,
    filterSettings
  );
  const params = createRequestParams({
    postType,
    taxParams,
    metaParams,
    dateParams,
    categoryTermExclude,
    categoryTermInclude,
  });

  const { posts, getNextPage, page, isLoading } = useWPPosts(
    site,
    null,
    params,
    calculatedPostsPerPage
  );

  //filter post for possible duplicates
  const filteredPosts = posts.filter(
    (post, index, array) => array.findIndex((t) => t.ID == post.ID) == index
  );

  useEffect(() => {
    if (page === 1 && loopTemplate === "template-3") {
      setCalculatedPostsPerPage(
        parseInt(postsPerPage) + parseInt(perPageOffset)
      );
    }
  }, [page]);

  const includeTabsAcf = filterSettings.find(
    (item) => item.type === "tabs_acf"
  );

  return filterSettings?.length ? (
    <div className={"torque-filtered-loop custom-filters"}>
      {includeTabsAcf && loopTemplate === "template-3" && (
        <div className="wrap-top-filters">
          <TabsDropdownACF
            key={includeTabsAcf.id}
            value={filters[includeTabsAcf.id]}
            onChange={createFilterUpdater(includeTabsAcf.id)}
            args={includeTabsAcf.args}
            site={site}
          />
        </div>
      )}
      <div className="wrap-filters">
        {useCustomLabel === 'true' && <p>Filters</p>}
        {filterSettings.map((filter, _) => {
          const customFilterProps = {
            key: filter.id,
            value: filters[filter.id],
            onChange: createFilterUpdater(filter.id),
            args: filter.args,
            site,
          };

          switch (filter.type) {
            case "tabs_acf":
              return loopTemplate === "template-3" ? null : (
                <TabsACF {...customFilterProps} />
              );

            case "dropdown_tax":
              return (
                <DropdownTax
                  {...customFilterProps}
                  categoryTermExclude={categoryTermExclude}
                  useCustomLabel
                />
              );

            case "dropdown_date":
              return (
                <DropdownDate
                  {...customFilterProps}
                  postType={postType}
                  useCustomLabel
                />
              );

            default:
              console.warn(`Filter type ${filter.type} not found`);
              return null;
          }
        })}
      </div>

      {loopTemplate === "template-3" ? (
        useTemplateVariation === "true" ? (
          <>
            <PostsVariation posts={filteredPosts} />
            {getNextPage && (
              <button
                className="torque-filtered-loop-load-more"
                onClick={getNextPage}
              >
                Load More
              </button>
            )}
          </>
        ) : (
          <PostsHorizontal
            posts={filteredPosts}
            loopTemplate={loopTemplate}
            getNextPage={getNextPage}
            isLoading={isLoading}
          />
        )
      ) : (
        <>
          <Posts posts={filteredPosts} loopTemplate={loopTemplate} />
          {getNextPage && (
            <button
              className="torque-filtered-loop-load-more"
              onClick={getNextPage}
            >
              Load More
            </button>
          )}
        </>
      )}
    </div>
  ) : null;
};

export default memo(App);

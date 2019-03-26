import React, { memo, useMemo, useState, useEffect } from "react";
import PropTypes from "prop-types";
import Posts from "./Posts";
import { DropdownDate, DropdownTax, TabsACF } from "./Filters/CustomFilters";
import { useCustomFilterSettings, useWPPosts } from "./hooks";
import { createRequestParams, combineCustomFilters } from "./helpers";

const App = ({ site, postType, filtersTypes, filtersArgs, loopTemplate }) => {
  const [filters, setFilters] = useState({});
  const createUpdateFilter = useMemo(
    () => filterId => value => () =>
      setFilters(filters => ({
        ...filters,
        [filterId]: value
      })),
    []
  );

  const filterSettings = useCustomFilterSettings(filtersTypes, filtersArgs);
  useEffect(
    () => {
      setFilters({}); // reset filters if filter settings change
    },
    [filterSettings]
  );

  const { taxParams, metaParams } = combineCustomFilters(
    filters,
    filterSettings
  );
  const params = createRequestParams({ postType, taxParams, metaParams });
  const posts = useWPPosts(site, null, params);

  return filterSettings?.length ? (
    <div className={"torque-filtered-loop custom-filters"}>
      {filterSettings.map((filter, index) => {
        const customFilterProps = {
          key: filter.id,
          value: filters[filter.id],
          onChange: createUpdateFilter(filter.id),
          args: filter.args,
          site
        };

        switch (filter.type) {
          case "tabs_acf":
            return <TabsACF {...customFilterProps} />;

          case "dropdown_tax":
            return <DropdownTax {...customFilterProps} />;

          case "dropdown_date":
            return <DropdownDate {...customFilterProps} />;

          default:
            console.warn(`Filter type ${filter.type} not found`);
            return null;
        }
      })}

      <Posts posts={posts} loopTemplate={loopTemplate} />
    </div>
  ) : null;
};

export default memo(App);

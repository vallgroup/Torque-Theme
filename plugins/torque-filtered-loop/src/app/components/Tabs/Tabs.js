import React, { memo, useState, useMemo, useEffect } from "react";
import { arrayContains, arrEmpty } from "../../helpers";
import styles from "./Tabs.scss";
import classnames from "classnames";

const Tabs = ({ title, options, value, onChange, multiSelect }) => {
  const [isOpen, setIsOpen] = useState(false);
  const handleTabsClick = useMemo(
    () => e => {
      e.stopPropagation();
      setIsOpen(isOpen => !isOpen);
    },
    []
  );

  useEffect(
    () => {
      // close tabs when clicking outside
      function handleBodyClick() {
        setIsOpen(false);
      }

      if (isOpen) {
        document.addEventListener("click", handleBodyClick);
        return () => document.removeEventListener("click", handleBodyClick);
      }
    },
    [isOpen]
  );

  const optionsWithAll = options.slice(0);
  
  !multiSelect && optionsWithAll.unshift({
    key: 0,
    name: "View All"
  });

  const selectedOptions = useMemo(
    () => {
      let values = [];

      if (Array.isArray(value)) {
        // if currently selected 'value' is an array, we have multiple selected
        value.forEach(v => {
          // for each selected value, add it to the array of selectedOptions (if found)
          const valFound = options.find(option => option.key === v)
          if (valFound) values.push(valFound.key)
        })
      } else {
        // we have a single selected value, so make sure it is in the options and push it to the selectedOptions
        const valFound = options.find(option => option.key === value)
        if (valFound) values.push(valFound.key)
      }
      return values
    },
    [optionsWithAll, value]
  );

  const filterWrapperCls = multiSelect
    ? 'multi-select'
    : ''

  return (
    <div className={classnames(styles.root, "torque-custom-filter-tabs")}>
      <div
        className={classnames(styles.title_wrapper, "tabs-title-wrapper")}
        onClick={handleTabsClick}
      >
        <span className="tabs-title">
          <span className="pre-title">Filter by </span>
          {title}
        </span>
      </div>

      <div
        className={classnames(styles.tabs_wrapper, `tabs-wrapper ${filterWrapperCls}`)}
      >
        {optionsWithAll.map(({ key, name }) => {
          // if:
          //  1) not multi-select
          //  2) there are no selectedOptions
          //  3) the key is 0, 
          // --> pre-select the 'All' option
          // else:
          // --> check if option is in selectedOptions array, and style accordingly
          const isSelected = !multiSelect
            && arrEmpty(selectedOptions) 
            && 0 === key
              ? true
              : arrayContains(selectedOptions, key)
          const selectedCls = isSelected
            ? 'selected'
            : ''

          return (<div 
            key={key} 
            className={`tabs-item ${selectedCls}`}
            onClick={onChange(key, multiSelect)}>
            {name}
          </div>)
        })}
      </div>
    </div>
  );
};

export default memo(Tabs);

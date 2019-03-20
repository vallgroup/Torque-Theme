import React, { memo, useState, useRef, useEffect } from "react";
import classnames from "classnames";
import style from "./FloorPlanSelector.scss";

const Dropdown = ({ children }) => {
  const [isDropdownOpen, setDropdownOpen] = useState(false);
  const toggleDropdownOpen = () => setDropdownOpen(!isDropdownOpen);

  const [canScrollToTop, setCanScrollToTop] = useState(false);
  const activateScrollToTop = () => setCanScrollToTop(true);
  const dropdownRef = useRef(null);

  useEffect(
    () => {
      if (!dropdownRef?.current || !canScrollToTop) return;

      const { top } = dropdownRef.current.getBoundingClientRect();

      if (!isDropdownOpen && top)
        window.scrollTo(0, top + window.scrollY - 100);
    },
    [isDropdownOpen, canScrollToTop, dropdownRef]
  );

  return (
    <div
      ref={dropdownRef}
      className={classnames(style.dropdown_wrapper, "dropdown-wrapper", {
        [style.open]: isDropdownOpen,
        open: isDropdownOpen
      })}
      onClick={activateScrollToTop}
    >
      <div
        className={classnames(style.dropdown_title, "dropdown-title")}
        onClick={toggleDropdownOpen}
      >
        SELECT A PLAN
      </div>
      <div
        className={classnames(style.dropdown_items, "dropdown-items")}
        onClick={toggleDropdownOpen}
      >
        {children}
      </div>
    </div>
  );
};

export default memo(Dropdown);

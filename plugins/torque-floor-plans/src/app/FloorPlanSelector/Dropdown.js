import React, { memo, useState, useRef, useEffect } from "react";
import classnames from "classnames";
import style from "./FloorPlanSelector.scss";

const Dropdown = ({ children }) => {
  const [isDropdownOpen, setDropdownOpen] = useState(false);
  const toggleDropdownOpen = () => setDropdownOpen(!isDropdownOpen);
  const dropdownRef = useRef(null);

  const [canScrollToTop, setCanScrollToTop] = useState(false);
  const windowWidth = useWindowWidth();
  useEffect(
    () => {
      if (windowWidth > 1024) setCanScrollToTop(false);
      else setCanScrollToTop(false);
    },
    [windowWidth]
  );

  useEffect(
    () => {
      if (!dropdownRef?.current || !canScrollToTop) return;

      const { top } = dropdownRef.current.getBoundingClientRect();

      if (!isDropdownOpen && top)
        window.scrollTo(0, top + window.scrollY - 120);
    },
    [isDropdownOpen, canScrollToTop, dropdownRef]
  );

  const handleDropdownTitleClick = () => {
    toggleDropdownOpen();
    setCanScrollToTop(true);
  };

  return (
    <div
      ref={dropdownRef}
      className={classnames(style.dropdown_wrapper, "dropdown-wrapper", {
        [style.open]: isDropdownOpen,
        open: isDropdownOpen
      })}
    >
      <div
        className={classnames(style.dropdown_title, "dropdown-title")}
        onClick={handleDropdownTitleClick}
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

function useWindowWidth() {
  const [width, setWidth] = useState(window.innerWidth);

  useEffect(() => {
    const handleResize = () => setWidth(window.innerWidth);
    window.addEventListener("resize", handleResize);
    return () => {
      window.removeEventListener("resize", handleResize);
    };
  });

  return width;
}

export default memo(Dropdown);

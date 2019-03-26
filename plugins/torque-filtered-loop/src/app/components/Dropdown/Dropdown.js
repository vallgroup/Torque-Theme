import styles from "./Dropdown.scss";
import React, { memo, useState, useMemo } from "react";
import classnames from "classnames";

const Dropdown = ({ title, options, value, onChange }) => {
  const [isOpen, setIsOpen] = useState(false);
  const toggleOpen = () => setIsOpen(!isOpen);

  const optionsWithAll = options.slice(0);
  optionsWithAll.unshift({
    key: 0,
    name: "All"
  });

  const selectedOption = useMemo(
    () => options.find(option => option.key === value),
    [optionsWithAll, value]
  );

  return (
    <div className={classnames(styles.root, "torque-custom-filter-dropdown")}>
      <div
        className={classnames(styles.title_wrapper, "dropdown-title-wrapper")}
        onClick={toggleOpen}
      >
        <span className="dropdown-title">{title}</span>
        {selectedOption && (
          <span className="dropdown-value">{selectedOption.name}</span>
        )}
      </div>

      {isOpen && (
        <div
          className={classnames(styles.dropdown_wrapper, "dropdown-wrapper")}
        >
          {optionsWithAll.map(({ key, name }) => (
            <div key={key} className="dropdown-item" onClick={onChange(key)}>
              {name}
            </div>
          ))}
        </div>
      )}
    </div>
  );
};

export default memo(Dropdown);

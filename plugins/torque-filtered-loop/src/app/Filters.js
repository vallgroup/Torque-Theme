import React from "react";
import PropTypes from "prop-types";

class Filters extends React.PureComponent {
  constructor(props) {
    super(props);

    this.state = {
      terms: this.filterTermsByParent()
    };
  }

  componentDidUpdate(prevProps) {
    if (prevProps.terms !== this.props.terms) {
      this.setState({ terms: this.filterTermsByParent() });
    }
  }

  render() {
    const { terms } = this.state;

    return (
      <div className={"torque-filtered-loop-filters"}>
        {terms.map((term, index) => {
          const isActive = term.id === this.props.activeTerm;

          return (
            <button
              key={index}
              className={`torque-filtered-loop-filter-button ${
                isActive ? "active" : ""
              }`}
              onClick={() => this.props.updateActiveTerm(term.id)}
            >
              {term.name}
            </button>
          );
        })}
      </div>
    );
  }

  filterTermsByParent() {
    const { terms, parentId } = this.props;

    if (!parentId) {
      return terms;
    }

    return terms.filter(term => {
      return term.parent === parentId;
    });
  }
}

export default Filters;

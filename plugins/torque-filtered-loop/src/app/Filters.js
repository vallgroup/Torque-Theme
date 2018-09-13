import React from "react";
import PropTypes from "prop-types";

class Filters extends React.Component {
  constructor(props) {
    super(props);

    this.state = {
      terms: this.filterTermsByParent()
    };
  }

  // If the terms change, we filter the terms by any parent Id that we might get.
  //
  // Doing it only when terms change and saving it on the state
  // just saves us from running the filter unecessarily
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
              dangerouslySetInnerHTML={{ __html: term.name }}
            />
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

Filters.propTypes = {
  terms: PropTypes.array.isRequired,
  activeTerm: PropTypes.number.isRequired,
  updateActiveTerm: PropTypes.func.isRequired,
  parentId: PropTypes.number
};

export default Filters;

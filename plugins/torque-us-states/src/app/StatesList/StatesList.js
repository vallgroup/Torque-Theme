import React from "react";
import PropTypes from "prop-types";
import classnames from "classnames";
import styles from "./StatesList.scss";

class StatesList extends React.PureComponent {
  constructor(props) {
    super(props);

    this.handleClick = this.handleClick.bind(this);
  }

  render() {
    const { states, currentState, updateCurrentState } = this.props;

    return Object.keys(states).map((stateCode, index) => {
      return (
        <div
          key={index}
          id={stateCode}
          className={this.getStateClassName(stateCode)}
          onClick={this.handleClick}
        >
          {states[stateCode].post_title}
        </div>
      );
    });
  }

  getStateClassName(stateCode) {
    const { currentState } = this.props;

    const active = stateCode === currentState;

    return classnames(styles.state, "torque-us-states-state-list-state", {
      [styles.active]: active,
      active: active
    });
  }

  handleClick(e) {
    e.preventDefault();

    const { id } = e.target;
    const { states } = this.props;

    const stateCodes = Object.keys(states);

    if (!id || !stateCodes.includes(id)) {
      return;
    }

    this.props.updateCurrentState(id);
  }
}

StatesList.propTypes = {
  states: PropTypes.object.isRequired,
  currentState: PropTypes.string.isRequired,
  updateCurrentState: PropTypes.func.isRequired
};

export default StatesList;

import React, { Component } from "react";
import axios from "axios";
import Map from "./Map/Map";
import Loop from "./Loop/Loop";

class App extends Component {
  constructor(props) {
    super(props);

    this.state = {
      states: {},
      currentState: ""
    };

    this.updateCurrentState = this.updateCurrentState.bind(this);
  }

  componentDidMount() {
    this.getStates();
  }

  render() {
    const { states, currentState, posts } = this.state;
    const { site, postType } = this.props;
    return (
      <div className={"torque-us-states-wrapper"}>
        <div className={"torque-us-states-map-wrapper"}>
          <Map
            states={states}
            currentState={currentState}
            updateCurrentState={this.updateCurrentState}
          />
        </div>

        <div className={"torque-us-states-loop-wrapper"}>
          <Loop
            currentState={currentState}
            site={site}
            postType={postType}
            currentStateName={this.getCurrentStateName()}
          />
        </div>
      </div>
    );
  }

  updateCurrentState(stateCode) {
    this.setState({ currentState: stateCode });
  }

  async getStates() {
    const { site } = this.props;

    try {
      const url = `${site}/index.php/wp-json/us-states/v1/states`;

      const response = await axios.get(url);

      if (response.data.success) {
        this.setState({ states: response.data.states });
      }
    } catch (e) {
      console.warn(e);
    }
  }

  getCurrentStateName() {
    const { currentState, states } = this.state;

    if (!states[currentState]) {
      return "";
    } else {
      return states[currentState].post_title;
    }
  }
}

export default App;

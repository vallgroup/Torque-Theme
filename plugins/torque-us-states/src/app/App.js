import React, { Component } from "react";
import axios from "axios";
import ScrollableAnchor, {
  goToAnchor,
  configureAnchors
} from "react-scrollable-anchor";
import Map from "./Map/Map";
import Loop from "./Loop/Loop";
import StatesList from "./StatesList/StatesList";

const LOOP_ANCHOR_ID = "torque-us-states-loop-anchor";
configureAnchors({ offset: -60, scrollDuration: 200 });

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
    const {
      site,
      postType,
      instructionalText,
      linkText,
      loopLinkSourceMetaKey
    } = this.props;
    return (
      <div className={"torque-us-states-wrapper"}>
        <div className={"torque-us-states-top-section-wrapper"}>
          <div className={"torque-us-states-map-wrapper"}>
            <Map
              states={states}
              currentState={currentState}
              updateCurrentState={this.updateCurrentState}
            />

            {instructionalText && (
              <div className={"torque-us-states-instructional-text"}>
                {instructionalText}
              </div>
            )}

            <div className={"torque-us-states-states-list-wrapper"}>
              <StatesList
                states={states}
                currentState={currentState}
                updateCurrentState={this.updateCurrentState}
              />
            </div>
          </div>
        </div>

        <ScrollableAnchor id={LOOP_ANCHOR_ID}>
          <div className={"torque-us-states-loop-wrapper"}>
            <Loop
              currentState={currentState}
              currentStateName={this.getCurrentStateName()}
              site={site}
              postType={postType}
              linkText={linkText}
              loopLinkSourceMetaKey={loopLinkSourceMetaKey}
            />
          </div>
        </ScrollableAnchor>
      </div>
    );
  }

  updateCurrentState(stateCode) {
    goToAnchor(LOOP_ANCHOR_ID);

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

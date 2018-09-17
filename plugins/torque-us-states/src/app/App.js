import React, { Component } from "react";
import Map from "./Map/Map";

class App extends Component {
  constructor(props) {
    super(props);

    this.state = {
      states: [],
      posts: [],
      currentState: ""
    };
  }

  render() {
    const { states, currentState, posts } = this.state;
    return <Map states={states} currentState={currentState} />;
  }
}

export default App;

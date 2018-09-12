import React, { Component } from "react";
import PropTypes from "prop-types";
import axios from "axios";
import Filters from "./Filters";

class App extends Component {
  constructor(props) {
    super(props);

    this.state = {
      terms: [],
      parentId: 0,
      activeTerm: 0
    };

    this.updateActiveTerm = this.updateActiveTerm.bind(this);
  }

  componentDidMount() {
    this.getTerms();
  }

  componentDidUpdate(prevProps, prevState) {
    if (prevState.activeTerm !== this.state.activeTerm) {
      this.getPosts();
    }
  }

  render() {
    console.log(this.state);
    if (!this.state.terms.length) {
      return null;
    }

    return (
      <Filters
        terms={this.state.terms}
        activeTerm={this.state.activeTerm}
        updateActiveTerm={this.updateActiveTerm}
        parentId={this.state.parentId}
      />
    );
  }

  updateActiveTerm(termId) {
    this.setState({ activeTerm: termId });
  }

  async getTerms() {
    try {
      const url = `${this.props.site}/wp-json/wp/v2/${this.props.tax}`;
      const response = await axios.get(url);
      const terms = response.data;

      const parentId = this.getParentId(terms);

      this.setState({ terms, parentId });
    } catch (e) {
      console.warn(e);
      this.setState({ terms: [] });
    }
  }

  async getPosts() {
    try {
      const url = `${this.props.site}/wp-json/wp/v2/posts?${this.props.tax}=${
        this.state.activeTerm
      }`;
      const response = await axios.get(url);
      console.log(response.data);
    } catch (e) {
      console.warn(e);
    }
  }

  getParentId(terms) {
    // get parent id
    let parentId = 0;
    for (let i = 0; i < terms.length; i++) {
      const term = terms[i];

      if (term.slug === this.props.parent) {
        parentId = term.id;
        break;
      }
    }

    return parentId;
  }
}

App.propTypes = {
  site: PropTypes.string.isRequired,
  tax: PropTypes.string.isRequired,
  parent: PropTypes.string,
  loopTemplate: PropTypes.string
};

export default App;

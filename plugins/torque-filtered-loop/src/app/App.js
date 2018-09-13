import React, { Component } from "react";
import PropTypes from "prop-types";
import axios from "axios";
import Filters from "./Filters";
import Posts from "./Posts/Posts";

class App extends Component {
  constructor(props) {
    super(props);

    this.state = {
      terms: [],
      posts: [],
      postsCache: {},
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
    if (!this.state.terms.length) {
      return null;
    }

    return (
      <div className={"torque-filtered-loop"}>
        <Filters
          terms={this.state.terms}
          activeTerm={this.state.activeTerm}
          updateActiveTerm={this.updateActiveTerm}
          parentId={this.state.parentId}
        />
        <Posts
          posts={this.state.posts}
          loopTemplate={this.props.loopTemplate}
          parentId={this.state.parentId}
        />
      </div>
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
      if (this.getPostsFromCache()) {
        return;
      }

      //prettier-ignore
      const url = `${this.props.site}/wp-json/wp/v2/posts?${this.props.tax}=${this.state.activeTerm}&_embed&posts_per_page=50`;
      const response = await axios.get(url);

      this.setState({ posts: response.data });
      this.addPostsToCache(response.data);
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

  /**
   * Cacheing functions
   */

  getPostsFromCache() {
    const { postsCache, activeTerm } = this.state;

    if (Object.keys(postsCache).includes(activeTerm.toString())) {
      this.setState({ posts: postsCache[activeTerm] });
      return true;
    }

    return false;
  }

  addPostsToCache(posts) {
    this.setState(({ postsCache, activeTerm }) => {
      const newPostsCache = Object.assign({}, postsCache);
      newPostsCache[activeTerm] = posts;

      return { postsCache: newPostsCache };
    });
  }
}

App.propTypes = {
  site: PropTypes.string.isRequired,
  tax: PropTypes.string.isRequired,
  parent: PropTypes.string,
  loopTemplate: PropTypes.string
};

export default App;

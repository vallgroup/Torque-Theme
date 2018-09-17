import React from "react";
import PropTypes from "prop-types";
import axios from "axios";

class Loop extends React.Component {
  constructor(props) {
    super(props);

    this.state = {
      posts: [],
      post_type: {},
      loading: false
    };
  }

  componentDidUpdate(prevProps) {
    if (prevProps.currentState !== this.props.currentState) {
      this.getPosts();
    }
  }

  render() {
    return (
      <React.Fragment>
        <p
          className={"torque-us-states-loop-title"}
          dangerouslySetInnerHTML={{ __html: this.getLoopTitle() }}
        />
        <div className={"torque-us-states-loop"}>
          {!this.state.loading && this.state.posts.map(this.renderPost)}
        </div>
      </React.Fragment>
    );
  }

  getLoopTitle() {
    if (this.state.post_type && this.state.post_type.label) {
      return `${this.props.currentStateName} ${this.state.post_type.label}`;
    } else {
      return this.props.currentStateName;
    }
  }

  renderPost(post) {
    return (
      <div className={"torque-us-states-loop-post"}>
        {post.featured_image && (
          <div className={"featured-image-wrapper"}>
            <div
              className={"featured-image"}
              style={{
                backgroundImage: `url(${post.featured_image})`
              }}
            />
          </div>
        )}
        <p
          className={"loop-post-title"}
          dangerouslySetInnerHTML={{ __html: post.post_title }}
        />
        <p
          className={"loop-post-excerpt"}
          dangerouslySetInnerHTML={{ __html: post.post_excerpt }}
        />
        <button>View Website</button>
      </div>
    );
  }

  async getPosts() {
    const { currentState, site, postType } = this.props;

    this.setState({ loading: true });

    try {
      const url = `${site}/index.php/wp-json/us-states/v1/loop`;

      const response = await axios.get(url, {
        params: {
          post_type: postType,
          state: currentState
        }
      });

      if (response.data.success) {
        this.setState({
          posts: response.data.posts,
          post_type: response.data.post_type,
          loading: false
        });
      } else {
        throw `No posts found for ${currentState}`;
      }
    } catch (e) {
      console.warn(e);
      this.setState({ posts: [], loading: false });
    }
  }
}

Loop.propTypes = {
  currentState: PropTypes.string,
  currentStateName: PropTypes.string,
  site: PropTypes.string.isRequired,
  postType: PropTypes.string.isRequired
};

export default Loop;

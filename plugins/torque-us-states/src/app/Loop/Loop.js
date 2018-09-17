import React from "react";
import PropTypes from "prop-types";
import axios from "axios";

class Loop extends React.PureComponent {
  constructor(props) {
    super(props);

    this.state = {
      posts: []
    };
  }

  componentDidUpdate(prevProps) {
    if (prevProps.currentState !== this.props.currentState) {
      this.getPosts();
    }
  }

  render() {
    console.log(this.state);
    return null;
  }

  async getPosts() {
    const { currentState, site, postType } = this.props;

    try {
      const url = `${site}/index.php/wp-json/us-states/v1/loop`;

      const response = await axios.get(url, {
        params: {
          post_type: postType,
          state: currentState
        }
      });

      if (response.data.success) {
        this.setState({ posts: response.data.posts });
      } else {
        throw `No posts found for ${currentState}`;
      }
    } catch (e) {
      console.warn(e);
      this.setState({ posts: [] });
    }
  }
}

Loop.propTypes = {
  currentState: PropTypes.string,
  site: PropTypes.string.isRequired,
  postType: PropTypes.string.isRequired
};

export default Loop;

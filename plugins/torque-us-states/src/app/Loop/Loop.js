import React from "react";
import PropTypes from "prop-types";
import axios from "axios";

class Loop extends React.Component {
  constructor(props) {
    super(props);

    this.state = {
      posts: [],
      post_type: {}
    };

    this.renderPost = this.renderPost.bind(this);
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
          {this.state.posts.map(this.renderPost)}
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

  renderPost(post, index) {
    const { linkText } = this.props;

    return (
      <div key={index} className={"torque-us-states-loop-post"}>
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
          dangerouslySetInnerHTML={{ __html: this.getExcerpt(post) }}
        />
        <a href={post.custom_link || ""} target="_blank">
          <button>{linkText}</button>
        </a>
      </div>
    );
  }

  getExcerpt(post) {
    if (post.post_excerpt) {
      return post.post_excerpt;
    } else {
      return post.post_content.substring(0, 100);
    }
  }

  async getPosts() {
    const { currentState, site, postType, loopLinkSourceMetaKey } = this.props;

    try {
      const url = `${site}/index.php/wp-json/us-states/v1/loop`;

      const response = await axios.get(url, {
        params: {
          post_type: postType,
          state: currentState,
          loop_link_source_meta_key: loopLinkSourceMetaKey
        }
      });

      if (response.data.success) {
        this.setState({
          posts: response.data.posts,
          post_type: response.data.post_type
        });
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
  currentStateName: PropTypes.string,
  site: PropTypes.string.isRequired,
  postType: PropTypes.string.isRequired,
  linkText: PropTypes.string.isRequired,
  loopLinkSourceMetaKey: PropTypes.string.isRequired
};

export default Loop;

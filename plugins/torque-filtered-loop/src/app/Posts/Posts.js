import React from "react";
import PropTypes from "prop-types";
import { Template_0 } from "./Templates";

class Posts extends React.PureComponent {
  render() {
    return (
      <div className={"posts-wrapper"}>
        {this.props.posts.map((post, index) => {
          switch (this.props.loopTemplate) {
            case "template-0":
            default:
              return (
                <Template_0
                  key={index}
                  post={post}
                  parentId={this.props.parentId}
                />
              );
          }
        })}
      </div>
    );
  }
}

Posts.propTypes = {
  posts: PropTypes.array.isRequired,
  loopTemplate: PropTypes.string.isRequired,
  parentId: PropTypes.number
};

Posts.defaultProps = {
  loopTemplate: "template-0"
};

export default Posts;

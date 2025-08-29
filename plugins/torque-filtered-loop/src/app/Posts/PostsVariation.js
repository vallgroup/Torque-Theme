import React from "react";
import PropTypes from "prop-types";
import Template_3_variation from "./Templates/Template_3_variation";

class PostsVariation extends React.PureComponent {
  render() {
    return (
      <div className={"posts-wrapper-variation"}>
        {this.props.posts.map((post, index) => {
          return <Template_3_variation key={index} post={post} />;
        })}
      </div>
    );
  }
}

PostsVariation.propTypes = {
  posts: PropTypes.array.isRequired,
  parentId: PropTypes.number,
};

export default PostsVariation;

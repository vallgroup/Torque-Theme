import React from "react";
import PropTypes from "prop-types";
import { Template_0, Template_1, Template_2, Template_3 } from "./Templates";

class Posts extends React.PureComponent {
  render() {

    return (
      <div className={"posts-wrapper"}>
        {this.props.posts.filter((post, idx) => (
          (!this.props.filterSelected ||
          0 == this.props.filterSelected) ?
          true :
          (post.terms && post.terms[0] && post.terms[0].term_id == this.props.filterSelected)
        ))
        .map((post, index) => {
          switch (this.props.loopTemplate) {
            case "template-3":
              return <Template_3 key={index} post={post} />;

            case "template-2":
              return <Template_2 key={index} post={post} />;

            case "template-1":
              return <Template_1 key={index} post={post} />;

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
  filterSelected: PropTypes.number.isRequired,
  parentId: PropTypes.number
};

Posts.defaultProps = {
  loopTemplate: "template-0"
};

export default Posts;

import React from "react";
import PropTypes from "prop-types";
import { Template_0, Template_1, Template_2, Template_3, Template_5 } from "./Templates";
import Template_4 from "./Templates";
import { arrEmpty } from "../helpers";
import NoPostsNotice from "../components/NoPostsNotice";

class Posts extends React.PureComponent {
  render() {
    if (arrEmpty(this.props.posts)) {
      return <NoPostsNotice loopTemplate={this.props.loopTemplate} />
    } else {
      return (
        <div className={"posts-wrapper"}>
          {this.props.posts.map((post, index) => {
            switch (this.props.loopTemplate) {
              case "template-5":
                return <Template_5 key={index} post={post} />;
              case "template-4":
                return <Template_4 key={index} post={post} />;
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

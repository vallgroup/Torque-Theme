import React from "react";
import PropTypes from "prop-types";
import { Template_0, Template_1, Template_2, Template_3 } from "./Templates";

class PostsHorizontal extends React.PureComponent {
  postsWrapperRef = React.createRef();

  componentDidMount() {
    if (this.postsWrapperRef.current) {
      this.postsWrapperRef.current.addEventListener(
        "scroll",
        this.handleScroll
      );
    }
  }

  componentWillUnmount() {
    if (this.postsWrapperRef.current) {
      this.postsWrapperRef.current.removeEventListener(
        "scroll",
        this.handleScroll
      );
    }
  }

  handleScroll = () => {
    const postsWrapper = this.postsWrapperRef.current;
    if (!postsWrapper) {
      return;
    }

    if (this.props.isLoading) {
      return;
    }

    // Get the scroll properties
    const { scrollLeft, scrollWidth, clientWidth } = postsWrapper;
    const scrollTolerance = 20;

    // Check if the user has scrolled to the far right
    if (scrollLeft + clientWidth >= scrollWidth - scrollTolerance) {
      if (this.props.getNextPage) {
        this.props.getNextPage();
      }
    }
  };

  chunkArray = (array, size) => {
    const chunkedArr = [];
    for (let i = 0; i < array.length; i += size) {
      chunkedArr.push(array.slice(i, i + size));
    }
    return chunkedArr;
  };

  renderSinglePost = (post, selectedTemplate = "template-0", index) => {
    switch (selectedTemplate) {
      case "template-3":
        return <Template_3 key={index} post={post} />;
      case "template-2":
        return <Template_2 key={index} post={post} />;
      case "template-1":
        return <Template_1 key={index} post={post} />;
      case "template-0":
      default:
        return (
          <Template_0 key={index} post={post} parentId={this.props.parentId} />
        );
    }
  };

  render() {
    const chunkedItems = this.chunkArray(this.props.posts.slice(0, 4), 4);
    const chunkedItemsRest = this.chunkArray(this.props.posts.slice(4), 6);
    const combinedChunks = chunkedItems.concat(chunkedItemsRest);

    return (
      <div className={"posts-wrapper"} ref={this.postsWrapperRef}>
        {combinedChunks.map((group, index) => {
          return (
            <div className="column-post" key={index}>
              {group.map((post) => {
                return this.renderSinglePost(
                  post,
                  this.props.loopTemplate,
                  post.ID
                );
              })}
            </div>
          );
        })}
        {this.props.getNextPage && (
          <button
            className="torque-filtered-loop-load-more"
            onClick={this.props.getNextPage}
          >
            Load More
          </button>
        )}
      </div>
    );
  }
}

PostsHorizontal.propTypes = {
  posts: PropTypes.array.isRequired,
  loopTemplate: PropTypes.string.isRequired,
  parentId: PropTypes.number,
};

PostsHorizontal.defaultProps = {
  loopTemplate: "template-0",
};

export default PostsHorizontal;

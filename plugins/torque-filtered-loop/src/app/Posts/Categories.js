import React from "react";
import PropTypes from "prop-types";
import { Template_0, Template_1, Template_2, Template_3 } from "./CatTemplates";

class Categories extends React.PureComponent {
  render() {

    return (
      // preserve id from Posts for styling purposes
      <div className={"categories-wrapper"}>
        {this.props.terms.filter((post, idx) => (
          (!this.props.filterSelected ||
          0 == this.props.filterSelected) ?
          true :
          (post.terms && post.terms[0] && post.terms[0].term_id == this.props.filterSelected)
        ))
        .map((post, index) => {
          console.log('loading this category: ', post, this.props.loopTemplate);
          switch (this.props.loopTemplate) {
            case "template-3":
              return <Template_3
                key={index}
                cat={post}
                onChange={this.props.onCatSelected}
              />;

            case "template-2":
              return <Template_2 key={index} post={post} />;

            case "template-1":
              return <Template_1
              key={index}

              />;

            case "template-0":
            default:
              return (
                <Template_0
                  key={index}
                  post={post}
                />
              );
          }
        })}
      </div>
    );
  }
}

Categories.propTypes = {
  terms: PropTypes.array.isRequired,
  loopTemplate: PropTypes.string,
  filterSelected: PropTypes.number,
  onCatSelected: PropTypes.function,
};

Categories.defaultProps = {
  loopTemplate: "template-3"
};

export default Categories;

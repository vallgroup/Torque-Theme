import { useMemo } from "react";

export default (firstTerm, posts) =>
  useMemo(
    () => {
      if (!firstTerm) {
        return posts;
      }

      const firstPosts = [];
      const otherPosts = [];

      posts.forEach(post => {
        if (
          post?.terms?.some(
            term => parseInt(term.term_id) === parseInt(firstTerm)
          )
        ) {
          firstPosts.push(post);
        } else {
          otherPosts.push(post);
        }
      });

      return [...firstPosts, ...otherPosts];
    },
    [firstTerm, posts]
  );

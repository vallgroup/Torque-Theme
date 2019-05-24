<?php

/**
 * @see https://gist.github.com/charleslouis/5924863
 */

class Torque_ACF_Search {

  public static $ACF_SEARCHABLE_FIELDS_FILTER_HANDLE = 'torque_acf_searchable_fields_filter_handle';

  /**
   * [list_searcheable_acf list all the custom fields we want to include in our search query]
   *
   * @return [array] [list of custom fields]
   */
  public static function tq_list_searcheable_acf(){

    // let child theme add it's own searchable fields
    //
    // its a 'like' match on the meta key so title and content should catch most text fields by default
    $list_searcheable_acf = apply_filters( self::$ACF_SEARCHABLE_FIELDS_FILTER_HANDLE, array("title", "content") );
    return $list_searcheable_acf;
  }


  public function __construct() {
    add_filter( 'posts_search', array($this, 'tq_advanced_custom_search'), 500, 2 );
  }

  /**
   * [advanced_custom_search search that encompasses ACF/advanced custom fields and taxonomies and split expression before request]
   *
   * @param  [query-part/string]      $where    [the initial "where" part of the search query]
   * @param  [object]                 $wp_query []
   * @return [query-part/string]      $where    [the "where" part of the search query as we customized]
   *
   * see https://vzurczak.wordpress.com/2013/06/15/extend-the-default-wordpress-search/
   * credits to Vincent Zurczak for the base query structure/spliting tags section
   */
  public function tq_advanced_custom_search( $where, $wp_query ) {

    global $wpdb;

    if ( empty( $where ))
        return $where;

    // get search expression
    $terms = $wp_query->query_vars[ 's' ];

    // explode search expression to get search terms
    $exploded = explode( ' ', $terms );
    if( $exploded === FALSE || count( $exploded ) == 0 )
        $exploded = array( 0 => $terms );

    // reset search in order to rebuild it as we wish
    $where = '';

    // get searcheable_acf, a list of advanced custom fields you want to search content in
    $list_searcheable_acf = self::tq_list_searcheable_acf();

    foreach( $exploded as $tag ) :

        /**
         * IF: $tag contains an apostrophe, search for both the word with (sanitised) and without it
         * ELSEIF: $tag ends in an 's' (and by virtue of the first IF doesn't contain an apostrophe), search for the word as it is and also with an apostrophe...
         * ELSE: Search for the $tag as it is!
         */

        $tag = strtolower( $tag );

        if ( strpos( $tag, "'" ) !== false ) {
          
          // $tag contains apostrophe
          $back_slashed_tag = addslashes( $tag );
          $tag_without_aspostrophe = str_replace( "'", "", $tag );

          $where .= "
          AND (
            (wp_posts.post_title LIKE '%$back_slashed_tag%')
            OR (wp_posts.post_title LIKE '%$tag_without_aspostrophe%')
            OR (wp_posts.post_content LIKE '%$back_slashed_tag%')
            OR (wp_posts.post_content LIKE '%$tag_without_aspostrophe%')
            OR EXISTS (
              SELECT * FROM wp_postmeta
                WHERE post_id = wp_posts.ID
                  AND (";

            foreach ($list_searcheable_acf as $searcheable_acf) :
              if ($searcheable_acf == $list_searcheable_acf[0]):
                $where .= " (meta_key LIKE '%" . $searcheable_acf . "%' AND meta_value LIKE '%$back_slashed_tag%')
                            OR (meta_key LIKE '%" . $searcheable_acf . "%' AND meta_value LIKE '%$tag_without_aspostrophe%')";
              else :
                $where .= " OR (meta_key LIKE '%" . $searcheable_acf . "%' AND meta_value LIKE '%$back_slashed_tag%')
                            OR (meta_key LIKE '%" . $searcheable_acf . "%' AND meta_value LIKE '%$tag_without_aspostrophe%') ";
              endif;
            endforeach;

            $where .= ")
              )
              OR EXISTS (
                SELECT * FROM wp_comments
                WHERE comment_post_ID = wp_posts.ID
                  AND ( comment_content LIKE '%$back_slashed_tag%'
                        OR comment_content LIKE '%$tag_without_aspostrophe%')
              )
              OR EXISTS (
                SELECT * FROM wp_terms
                INNER JOIN wp_term_taxonomy
                  ON wp_term_taxonomy.term_id = wp_terms.term_id
                INNER JOIN wp_term_relationships
                  ON wp_term_relationships.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id
                WHERE (
                taxonomy = 'post_tag'
                  OR taxonomy = 'category'
                  OR taxonomy = 'myCustomTax'
                )
                  AND object_id = wp_posts.ID
                  AND (wp_terms.name LIKE '%$back_slashed_tag%'
                      OR wp_terms.name LIKE '%$tag_without_aspostrophe%')
              )
          )";

        } elseif (substr($tag, -1) == 's') {

          // $tag contains 's' as last letter in word, so add single-char wildcard
          $tag_with_added_aspostrophe = substr_replace( $tag, "_", -1, 0 );

          $where .= "
          AND (
            (wp_posts.post_title LIKE '%$tag%')
            OR (wp_posts.post_title LIKE '%$tag_with_added_aspostrophe%')
            OR (wp_posts.post_content LIKE '%$tag%')
            OR (wp_posts.post_content LIKE '%$tag_with_added_aspostrophe%')
            OR EXISTS (
              SELECT * FROM wp_postmeta
                WHERE post_id = wp_posts.ID
                  AND (";

            foreach ($list_searcheable_acf as $searcheable_acf) :
              if ($searcheable_acf == $list_searcheable_acf[0]):
                $where .= " (meta_key LIKE '%" . $searcheable_acf . "%' AND meta_value LIKE '%$tag%')
                            OR (meta_key LIKE '%" . $searcheable_acf . "%' AND meta_value LIKE '%$tag_with_added_aspostrophe%')";
              else :
                $where .= " OR (meta_key LIKE '%" . $searcheable_acf . "%' AND meta_value LIKE '%$tag%')
                            OR (meta_key LIKE '%" . $searcheable_acf . "%' AND meta_value LIKE '%$tag_with_added_aspostrophe%') ";
              endif;
            endforeach;

            $where .= ")
              )
              OR EXISTS (
                SELECT * FROM wp_comments
                WHERE comment_post_ID = wp_posts.ID
                  AND ( comment_content LIKE '%$tag%'
                        OR comment_content LIKE '%$tag_with_added_aspostrophe%')
              )
              OR EXISTS (
                SELECT * FROM wp_terms
                INNER JOIN wp_term_taxonomy
                  ON wp_term_taxonomy.term_id = wp_terms.term_id
                INNER JOIN wp_term_relationships
                  ON wp_term_relationships.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id
                WHERE (
                taxonomy = 'post_tag'
                  OR taxonomy = 'category'
                  OR taxonomy = 'myCustomTax'
                )
                  AND object_id = wp_posts.ID
                  AND (wp_terms.name LIKE '%$tag%'
                      OR wp_terms.name LIKE '%$tag_with_added_aspostrophe%')
              )
          )";

        } else {

          $where .= "
          AND (
            (wp_posts.post_title LIKE '%$tag%')
            OR (wp_posts.post_content LIKE '%$tag%')
            OR EXISTS (
              SELECT * FROM wp_postmeta
                WHERE post_id = wp_posts.ID
                  AND (";

            foreach ($list_searcheable_acf as $searcheable_acf) :
              //$searcheable_acf = $this->validateMySQLString( $searcheable_acf );
              if ($searcheable_acf == $list_searcheable_acf[0]):
                $where .= " (meta_key LIKE '%" . $searcheable_acf . "%' AND meta_value LIKE '%$tag%') ";
              else :
                $where .= " OR (meta_key LIKE '%" . $searcheable_acf . "%' AND meta_value LIKE '%$tag%') ";
              endif;
            endforeach;

            $where .= ")
              )
              OR EXISTS (
                SELECT * FROM wp_comments
                WHERE comment_post_ID = wp_posts.ID
                  AND comment_content LIKE '%$tag%'
              )
              OR EXISTS (
                SELECT * FROM wp_terms
                INNER JOIN wp_term_taxonomy
                  ON wp_term_taxonomy.term_id = wp_terms.term_id
                INNER JOIN wp_term_relationships
                  ON wp_term_relationships.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id
                WHERE (
                taxonomy = 'post_tag'
                  OR taxonomy = 'category'
                  OR taxonomy = 'myCustomTax'
                )
                  AND object_id = wp_posts.ID
                  AND wp_terms.name LIKE '%$tag%'
              )
          )";

        } /* END IF/ELSE */
        
    endforeach;
    return $where;
  }
}

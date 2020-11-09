<?php

/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Interface
 */

get_header();
?>
<div id="content-wrapper" class="d-flex flex-column">

  <!-- Main Content -->
  <div id="content">



    <!-- Begin Page Content -->
    <div class="container-fluid">



      <!-- Page Heading -->

      <?php get_template_part('template-parts/content', get_post_type()); ?>



      <?php
      get_footer();

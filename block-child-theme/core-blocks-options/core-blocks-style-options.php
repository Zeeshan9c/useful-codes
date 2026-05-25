<?php

/**
 * Core Block Style Variations
 *
 * Registers custom style options for native WordPress blocks.
 * Styles are applied via inline CSS scoped to the variation class.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function register_custom_block_styles() {
    if ( function_exists( 'register_block_style' ) ) {

        // Outline Button
        register_block_style('core/button', [
            'name'  => 'outline',
            'label' => __('Outline', 'block-child-textdomain'),
            'inline_style' => '
                .wp-block-button.is-style-outline .wp-block-button__link {
                    background-color: transparent;
                    color: var(--wp--preset--color--white);
                    border-color: var(--wp--preset--color--white);
                }

                .wp-block-button.is-style-outline .wp-block-button__link:hover {
                    background-color: var(--wp--preset--color--accent);
                    color: var(--wp--preset--color--white);
                    border-color: var(--wp--preset--color--white);
                }
            ',
        ]);

        // Blue Button
        register_block_style(
            'core/button',
            array(
                'name'         => 'blue',
                'label'        => __( 'Blue', 'block-child-textdomain' ),
                'inline_style' => '
                    .wp-block-button.is-style-blue .wp-block-button__link {
                        background-color: var(--wp--preset--color--primary);
                        color: var(--wp--preset--color--white);
                        border-color: var(--wp--preset--color--primary);
                    }
                    .wp-block-button.is-style-blue .wp-block-button__link:hover {
                        background-color: var(--wp--preset--color--white);
                        color: var(--wp--preset--color--primary);
                    }
                    .wp-block-button.is-style-blue .wp-block-button__link svg path {
                        fill: currentcolor;
                    }
                ',
            )
        );

        // Arrow Text Download
        register_block_style(
            'core/button',
            array(
                'name'         => 'arrow-text-download',
                'label'        => __( 'Download Button', 'block-child-textdomain' ),
                'inline_style' => '
                    .wp-block-button.is-style-arrow-text-download .wp-block-button__link {
                        padding: 0 !important;
                        background-color: transparent;
                        border: none !important;
                        font-size: clamp(18px, 2.5vw, 24px) !important;
                        line-height: 1.6 !important;
                        color: var(--wp--preset--color--accent);
                        font-weight: 600 !important;
                        position: relative;
                        text-align: left;
                        width: calc(100% + 1px);
                        padding-bottom: 2px;
                        background-image: linear-gradient(transparent calc(100% - 2px), transparent 2px);
                        background-repeat: no-repeat;
                        background-size: 100% 100%;
                        max-width: max-content;
                        border-radius: 0;
                        display: inline;
                    }
                    .wp-block-button.is-style-arrow-text-download .wp-block-button__link span.last {
                        // display: inline-block;
                        text-decoration: none;
                        white-space: nowrap;
                        left: -0.5px;
                        position: relative;
                    }
                    .wp-block-button.is-style-arrow-text-download .wp-block-button__link span.last::after {
                        content: "";
                        width: 25px !important;
                        height: 24px;
                        display: inline-block;
                        background-image: url("../assets/images/arrow-plum.svg");
                        background-image: url("'.IMPRESSION_HOMES_DIR_URI.'/assets/images/download-btn-icon.svg");
                        background-size: contain;
                        background-position: center;
                        background-repeat: no-repeat;
                        margin-bottom: -3px;
                        margin-left: 12px;
                    }
                    .wp-block-button.is-style-arrow-text-download .wp-block-button__link:hover {
                        background-color: transparent !important;
                        color: var(--wp--preset--color--accent);
                        background-image: linear-gradient(transparent calc(100% - 2px), currentcolor 2px);
                    }
                    .wp-block-button.is-style-arrow-text-download .wp-block-button__link:hover:before {
                        opacity: 1;
                    }
                    .wp-block-button.is-style-arrow-text-download .wp-block-button__link:before {
                        content: "";
                        background-color: currentcolor;
                        position: absolute;
                        width: 100%;
                        height: 2px;
                        opacity: 1;
                        top: auto;
                        bottom: 0;
                        opacity: 0;
                    }
                    @media (max-width: 781px) {
                        .wp-block-button.is-style-arrow-text-download .wp-block-button__link {
                            line-height: 1.4 !important;
                        }
                        .wp-block-button.is-style-arrow-text-download .wp-block-button__link span.last::after {
                            margin-left: 9px;
                            width: 16px !important;
                            height: 18px;
                            
                        }
                    }
                ',
            )
        );

        // Group Set Min Height
        register_block_style(
            'core/group',
            array(
                'name'  => 'section-large',
                'label' => 'Section Large',
                'inline_style' =>
                    '.wp-block-group.is-style-section-large {
                        min-height: 700px;
                    }
                    @media (max-width: 781px) {
                        .wp-block-group.is-style-section-large {
                            min-height: 466px;
                        }
                    }'
            )
        );

        // Separator Style Option
        register_block_style(
            'core/separator',
            array(
                'name'  => 'default',
                'label' => 'Default',
                'inline_style' =>
                    '.wp-block-separator.is-style-default {
                        height: 4px !important;
                        width: 100px !important;
                        border-radius: 20px;
                    }
                    @media (max-width: 767px) {
                        .wp-block-separator.is-style-default {
                            width: 60px !important;
                        }
                    }'
            )
        );

        // List Style
        register_block_style(
            'core/list',
            array(
                'name'  => 'default',
                'label' => __( 'Default', 'block-child-textdomain' ),
                'inline_style' => '
                    .wp-block-list.is-style-default {
                        padding-left: 30px
                    }
                    .wp-block-list.is-style-default > li::marker {
                    font-size: 75%;
                    }
                ',
            )
        );

        // Columns Style Options 3 Columns and 3/2 Columns 
        register_block_style(
            'core/columns',
            array(
                'name'         => 'grid-three-columns',
                'label'        => __( '3 Columns (HomePage)', 'block-child-textdomain' ),
                'inline_style' => '
                    /* The Container */
                    .wp-block-columns.is-style-grid-three-columns {
                        display: flex !important;
                        flex-wrap: wrap !important;
                        flex-direction: row !important;
                        /* Uses your theme.json blockGap value */
                        gap: 24px !important;
                        justify-content: center;
                    }

                    .wp-block-columns.is-style-grid-three-columns > .wp-block-column > .wp-block-group {
                        height: 100%;
                    }

                    /* The Direct Children */
                    .wp-block-columns.is-style-grid-three-columns > .wp-block-column {
                        flex-basis: calc((100% - 48px) / 3) !important;
                        flex-grow: 0 !important;
                        flex-shrink: 0 !important;
                        margin: 0 !important;
                    }
                    
                    .wp-block-columns.is-style-grid-three-columns > .wp-block-column > .wp-block-group{
                        display: flex;
                        flex-direction: column;
                    }
                    .wp-block-columns.is-style-grid-three-columns > .wp-block-column > .wp-block-group > .wp-block-group:nth-child(2){
                        height: 100%;
                        display: flex;
                        flex-direction: column;
                        gap: 15px;
                    }
                    .wp-block-columns.is-style-grid-three-columns > .wp-block-column > .wp-block-group > .wp-block-group:nth-child(2) .wp-block-buttons{
                        margin-top: auto !important
                    }

                    .wp-block-columns.is-style-grid-three-columns-30 > .wp-block-column > .wp-block-group {
                        display: flex !important;
                        flex-direction: column;
                    }
                    .wp-block-columns.is-style-grid-three-columns-30 > .wp-block-column > .wp-block-group > div{
                        width: 100%;
                    }
                    .wp-block-columns.is-style-grid-three-columns-30 > .wp-block-column > .wp-block-group .wp-block-buttons{
                        margin-top: auto !important;
                        padding-top: 16px
                    }

                    /* Responsive: Stack on Tablet */
                    @media (max-width: 1024px) {
                        .wp-block-columns.is-style-grid-three-columns > .wp-block-column {
                            flex-basis: calc((100% - 24px) / 2) !important;       
                        }
                    }
                    @media (max-width: 781px) {
                        .wp-block-columns.is-style-grid-three-columns .wp-block-buttons {
                            margin-left: 0 !important;
                            justify-content: flex-start !important
                        }
                        .wp-block-columns.is-style-grid-three-columns > .wp-block-column > .wp-block-group .card_header_group{
                            margin-left: 0 !important
                        }
                        .wp-block-columns.is-style-grid-three-columns > .wp-block-column > .wp-block-group > .wp-block-group:nth-child(2){
                            gap: 7px;
                        }
                    }
                    /* Responsive: Stack on mobile */
                    @media (max-width: 600px) {
                        .wp-block-columns.is-style-grid-three-columns {
                            gap: 8px !important;
                        }
                        .wp-block-columns.is-style-grid-three-columns > .wp-block-column {
                            flex-basis: 100% !important;
                        }
                        
                    }
                ',
            )
        );

        // Pagination Style
        register_block_style('core/query-pagination', [
            'name'  => 'outline-box',
            'label' => __('Outline Box', 'block-child-textdomain'),
            'inline_style' => '
                .wp-block-query-pagination.is-style-    -box {
                    display: flex;
                    justify-content: center;
                    gap: 10px;
                    margin-top: var(--wp--preset--spacing--spacing-before-cta);
                }
                .wp-block-query-pagination.is-style-outline-box span:not([aria-hidden="true"]),
                .wp-block-query-pagination.is-style-outline-box a {
                    border: none;
                    border-radius: 6px;
                    text-decoration: none;
                    color: ##404040;
                    background-color: #F5F5F5;
                    color: var(--wp--preset--color--subheading);
                    font-weight: 500;
                    font-size: 16px;
                    line-height: 32px;
                    vertical-align: middle;
                    width:33px;
                    height: 33px;
                    display: inline-flex;
                    align-items: center;
                    justify-content: center;
                    transition: all 0.3s ease-in-out;
                    position: relative;
                }
                .wp-block-query-pagination.is-style-outline-box a:hover,
                .wp-block-query-pagination.is-style-outline-box :is(span:not([aria-hidden="true"]), a).current {
                    background-color: #79003C;
                    color: #fff;
                }
                .wp-block-query-pagination.is-style-outline-box :is(.wp-block-query-pagination-next-arrow,.wp-block-query-pagination-previous-arrow){
                    margin: 0;
                    display: none;
                }
                .wp-block-query-pagination.is-style-outline-box :is(.wp-block-query-pagination-next):after{
                    background-image: url("'.IMPRESSION_HOMES_DIR_URI.'/assets/images/arrow-right-plum.svg");
                    background-repeat: no-repeat;
                    background-position: center;
                    background-size: 15px;
                }
                .wp-block-query-pagination.is-style-outline-box :is(.wp-block-query-pagination-previous):after{
                    background-image: url("'.IMPRESSION_HOMES_DIR_URI.'/assets/images/arrow-left-plum.svg");
                    background-repeat: no-repeat;
                    background-position: center;
                    background-size: 15px;
                }
                .wp-block-query-pagination.is-style-outline-box :is(.wp-block-query-pagination-next,.wp-block-query-pagination-previous):after{
                    content: "";
                    display: block;
                    width: 100%;
                    height: 100%;
                    position: absolute;
                    top: 0;
                    left: 0;
                    transition: all 0.3s ease-in-out;
                }
                .wp-block-query-pagination.is-style-outline-box :is(.wp-block-query-pagination-next,.wp-block-query-pagination-previous):hover:after{
                    -webkit-filter: brightness(0) saturate(100%) invert(100%) sepia(100%) saturate(0%) hue-rotate(305deg) brightness(106%) contrast(101%);
                    filter: brightness(0) saturate(100%) invert(100%) sepia(100%) saturate(0%) hue-rotate(305deg) brightness(106%) contrast(101%);
                }
                .wp-block-query-pagination.is-style-outline-box .wp-block-query-pagination-numbers{
                    display: flex;
                    gap: 10px;
                    align-items: center;
                    justify-content: center;
                    flex-wrap: wrap;
                }
                .wp-block-query-pagination.is-style-outline-box :is(.wp-block-query-pagination-next){
                    margin-left: 10px
                }
                .wp-block-query-pagination.is-style-outline-box :is(.wp-block-query-pagination-previous){
                    margin-right: 10px
                }
                @media (min-width: 782px) {
                    .gb-hide-page-dk:not(.gb-hide-page-mb) {
                        display: none !important;
                    }
                }
                @media (max-width: 781px) {
                    .gb-hide-page-mb {
                        display: none !important;
                    } 
                    .wp-block-query-pagination.is-style-outline-box span:not([aria-hidden="true"]), 
                    .wp-block-query-pagination.is-style-outline-box a{
                        width: 26px;
                        height: 26px;
                        font-size: 14px;
                        line-height: 28px;
                    }
                    .wp-block-query-pagination.is-style-outline-box :is(.wp-block-query-pagination-next, .wp-block-query-pagination-previous)::after{
                        background-size: 12px
                    }
                }
            ',
        ]);

        // Search Form Style
        register_block_style('core/search', [
            'name'  => 'search-outline',
            'label' => __('Search Outline', 'block-child-textdomain'),
            'inline_style' => '
                .wp-block-search.is-style-search-outline .wp-block-search__inside-wrapper {
                    padding: 0;
                    border: 0;
                    border-radius: 4px;
                }
                .serach_reset_wrapper .facetwp-input-wrap input,
                .wp-block-search.is-style-search-outline .wp-block-search__inside-wrapper .wp-block-search__input {
                    border-radius: 4px 0 0 4px;
                    font-size: 18px;
                    line-height: 1;
                    padding: 12px 20px;
                    border: 1px solid rgba(153, 161, 175, 1);
                    border-right: 0;
                    height: 45px;
                }
                .serach_reset_wrapper  .facetwp-icon,
                .wp-block-search.is-style-search-outline .wp-block-search__inside-wrapper .wp-block-search__button {
                    border-radius: 0 4px 4px 0;
                    margin: 0;
                    transition: 0.3s all;
                    height: 45px;
                    padding: 0;
                    width: 50px;
                    min-width: 50px;
                    outline: none !important;
                }

                .wp-block-search.is-style-search-outline .wp-block-search__inside-wrapper .wp-block-search__button:hover {
                    background-color: #1a2232;
                }
                    
                .serach_reset_wrapper .facetwp-input-wrap input:focus,
                body.search main .wp-block-search__inside-wrapper input:focus{
                    border-color: var(--wp--preset--color--primary-dark) !important
                }
                .wp-block-search.is-style-search-outline .wp-block-search__inside-wrapper .wp-block-search__button svg {
                    transition: 0.3s all !important;
                    color: #fff;
                    transform: rotate(-90deg);
                }
            ',
        ]);

        // Post Template Style - Articles Grid
        register_block_style('core/post-template', [
            'name'  => 'articles-grid',
            'label' => __('Articles Grid', 'block-child-textdomain'),
            'inline_style' => '
                .wp-block-post-template.is-style-articles-grid > li {
                    background: var(--wp--preset--color--white);
                    border-radius: 16px;
                    overflow: hidden;
                    transition: box-shadow 0.3s ease;
                    display: flex;
                    flex-direction: column;
                }
                .wp-block-post-template.is-style-articles-grid > li:hover {
                    box-shadow: 0 5px 10px rgba(0,0,0,0.05);
                }
                .wp-block-post-template.is-style-articles-grid [class*="time-to-read"],
                .wp-block-post-template.is-style-articles-grid .wp-block-reading-time {
                    position: absolute;
                    top: 10px;
                    left: 10px;
                    font-size: 14px;
                    line-height: 1;
                    font-weight: 500;
                    padding: 4px 12px;
                    border-radius: 20px;
                    backdrop-filter: blur(4px);
                    font-family: "Outfit";
                    z-index: 2;
                    text-transform: capitalize;
                }
                .wp-block-post-template.is-style-articles-grid .wp-block-group:nth-child(1) {
                    height: 240px;
                    min-height: 240px;
                    position: relative
                }
                .wp-block-post-template.is-style-articles-grid > li:nth-child(5n+1) .wp-block-group:nth-child(1), 
                .wp-block-post-template.is-style-articles-grid > li:nth-child(5n+2) .wp-block-group:nth-child(1){
                    min-height: 300px
                }
                .wp-block-post-template.is-style-articles-grid .wp-block-group:nth-child(1) .wp-block-post-featured-image {
                    position: absolute;
                    object-fit: cover;
                    top: 0;
                    left: 0;
                    inset: 0;
                    height: 100%;
                }
                .wp-block-post-template.is-style-articles-grid .wp-block-group:nth-child(1) .wp-block-post-featured-image img {
                    height: 100%;
                }
                .wp-block-post-template.is-style-articles-grid .wp-block-group:nth-child(2) {
                    padding: 24px;
                }
                .wp-block-post-template.is-style-articles-grid .wp-block-post-title {
                    color: var(--wp--preset--color--primary);
                    font-size: clamp(16px, 1.8vw, 20px);
                    line-height: 1.4;
                    font-weight: 700;
                }
                .wp-block-post-template.is-style-articles-grid .wp-block-read-more {
                    margin-top: clamp(8px, 1.5vw, 16px);
                }
                .wp-block-post-template.is-style-articles-grid .wp-block-group:nth-child(1):not(:has(.wp-block-post-featured-image)) {
                    background: url(/wp-content/uploads/2026/02/block-child-textdomain-logo.svg) center / 60% no-repeat;
                    background-color: rgba(246, 244, 237, 1);
                }
                .wp-block-post-template.is-style-articles-grid {
                    display: flex !important;
                    flex-wrap: wrap;
                    gap: 24px;
                    list-style: none;
                    padding: 0;
                    margin: 0;
                    justify-content: center;
                }
                .wp-block-post-template.is-style-articles-grid > li {
                    box-sizing: border-box;
                }

                .wp-block-post-template.is-style-articles-grid > li:nth-child(5n+1),
                .wp-block-post-template.is-style-articles-grid > li:nth-child(5n+2) {
                    flex: 0 0 calc(50% - 12px);
                }
                .wp-block-post-template.is-style-articles-grid > li:nth-child(5n+3),
                .wp-block-post-template.is-style-articles-grid > li:nth-child(5n+4),
                .wp-block-post-template.is-style-articles-grid > li:nth-child(5n) {
                    flex: 0 0 calc(33.333% - 16px);
                }
                .wp-block-post-template.is-style-articles-grid > li:nth-child(5n+1):last-child,
                .wp-block-post-template.is-style-articles-grid > li:nth-child(5n+3):last-child {
                    margin-left: auto;
                    margin-right: auto;
                }
                .wp-block-post-template.is-style-articles-grid > li:nth-last-child(2):nth-child(5n+3),
                .wp-block-post-template.is-style-articles-grid > li:nth-child(5n+4):last-child {
                    flex: 0 0 calc(50% - 12px);
                }
                .wp-block-post-template.is-style-articles-grid .wp-block-group:nth-child(2){
                    height: 100%;
                    display: flex;
                    flex-direction: column;
                }
                .wp-block-post-template.is-style-articles-grid .wp-block-group:nth-child(2) .wp-block-post-title{
                    margin-bottom: 16px
                }
                .wp-block-post-template.is-style-articles-grid .wp-block-group:nth-child(2) .wp-block-read-more{
                    margin-top: auto !important;
                }
                
                @media (min-width: 782px) and (max-width: 1024px) {
                    .wp-block-post-template.is-style-articles-grid > li:nth-child(n) {
                        flex: 0 0 calc((100% - 24px) / 2);
                    }
                }
                @media (max-width: 1024px) {
                    .wp-block-post-template.is-style-articles-grid > li:nth-child(5n+1) .wp-block-group:nth-child(1), 
                    .wp-block-post-template.is-style-articles-grid > li:nth-child(5n+2) .wp-block-group:nth-child(1){
                        min-height: 240px
                    }
                }
                @media (min-width: 782px) {
                    .wp-block-post-template.is-style-articles-grid {
                        transform: unset !important;
                    }
                    .wp-block-post-template.is-style-articles-grid > li{
                        margin: 0 !important;
                    }
                }
                @media (max-width: 781px) {
                    .wp-block-post-template.is-style-articles-grid {
                        flex-wrap: nowrap !important;
                        gap: 0;
                        overflow: visible;
                        padding: 0;
                        margin: 0;
                        justify-content: unset;
                    }
                    .wp-block-post-template.is-style-articles-grid > li {
                        width: 80vw;
                        flex-shrink: 0;
                        flex: none !important;
                    }
                    .wp-block-post-template.is-style-articles-grid > li:nth-child(5n+1) .wp-block-group:nth-child(1), 
                    .wp-block-post-template.is-style-articles-grid > li:nth-child(5n+2) .wp-block-group:nth-child(1),
                    .wp-block-post-template.is-style-articles-grid .wp-block-group:nth-child(1) {
                        height: 33vw;
                        min-height: 200px;
                    }
                    body .articles-grid-swiper-wrapper {
                        overflow: visible;
                    }
                    .wp-block-post-template.is-style-articles-grid > li {
                        height: auto;
                    }
                    .wp-block-query:has(.is-style-articles-grid) {
                        padding: 0 10px;
                    }
                    .articles-grid-swiper-controls {
                        display: flex;
                        align-items: center;
                        margin-top: 16px;
                        width: calc(100% + 20px);
                        margin-left: -10px;
                    }

                    .articles-grid-swiper-controls .swiper-button-prev,
                    .articles-grid-swiper-controls .swiper-button-next {
                        position: static;
                        margin: 0;
                        width: 48px;
                        height: 48px;
                        border-radius: 50%;
                        border-width: 1px;
                        border-style: solid;
                        border-color: rgb(26, 34, 50);
                        border-image: initial;
                        outline: none;
                        background-color: transparent;
                        transition: all 0.3s;
                    }
                    .articles-grid-swiper-controls .swiper-button-prev::after,
                    .articles-grid-swiper-controls .swiper-button-next::after {
                        color: rgb(26, 34, 50);
                        font-size: 14px;
                    }
                    .articles-grid-swiper-controls .swiper-button-prev:hover,
                    .articles-grid-swiper-controls .swiper-button-next:hover {
                        background-color: var(--wp--preset--color--accent);
                        border-color: var(--wp--preset--color--accent);
                    }
                    .articles-grid-swiper-controls .swiper-button-prev:hover::after,
                    .articles-grid-swiper-controls .swiper-button-next:hover::after {
                        color: var(--wp--preset--color--white);
                    }
                    .articles-grid-swiper-controls .swiper-button-prev {
                        margin-left: auto;
                        margin-right: 16px;
                    }
                    .articles-grid-swiper-controls .swiper-pagination {
                        order: -1;
                        max-width: max-content;
                        position: static;
                        line-height: 1;
                        margin-left: -3px;
                    }
                    .articles-grid-swiper-controls .swiper-pagination .swiper-pagination-bullet {
                        width: 12px;
                        height: 12px;
                        background: rgba(26, 34, 50, 0.2);
                        opacity: 1;
                        outline: none;
                    }
                    .articles-grid-swiper-controls .swiper-pagination .swiper-pagination-bullet.swiper-pagination-bullet-active {
                        background: rgba(26, 34, 50, 1);
                    }
                    .wp-block-post-template.is-style-articles-grid .wp-block-group:nth-child(2) {
                        padding: 16px;
                    }
                    .wp-block-post-template.is-style-articles-grid .wp-block-group:nth-child(2) .wp-block-post-title a{
                        line-height: 1.6;
                    }
                    .wp-block-post-template.is-style-articles-grid .wp-block-group:nth-child(2) .wp-block-post-title{
                        margin-bottom: 8px;
                    }
                }
            ',
        ]);
       
        // Gallery 4 Columns Flex
        register_block_style(
            'core/gallery',
            array(
                'name'         => 'gallery-4-col-flex',
                'label'        => __( 'Gallery 4 Columns', 'block-child-textdomain' ),
                'inline_style' => '
                    .wp-block-gallery.is-style-gallery-4-col-flex {
                        display: flex;
                        flex-wrap: wrap;
                        gap: 16px !important;
                        justify-content: center;
                    }
                    .wp-block-gallery.is-style-gallery-4-col-flex .wp-block-image {
                        flex: 0 0 calc(25% - 16px);
                        margin: 0;
                    }
                    .wp-block-gallery.is-style-gallery-4-col-flex .wp-block-image img {
                        width: 100%;
                        height: 100%;
                        object-fit: cover;
                        display: block;
                        border-radius: 8px;
                        min-height: 117px;
                    }
                    @media (max-width: 1024px) {
                        .wp-block-gallery.is-style-gallery-4-col-flex .wp-block-image {
                            flex: 0 0 calc(50% - 16px);
                        }
                    }
                    @media (max-width: 767px) {
                        .wp-block-gallery.is-style-gallery-4-col-flex{
                            gap: 8px !important
                        }
                        .wp-block-gallery.is-style-gallery-4-col-flex .wp-block-image {
                            flex: 0 0 calc(50% - 8px)
                        }
                        .wp-block-gallery .wp-block-image a{
                            border-radius: 4px !important;    
                        }
                        .wp-block-gallery.is-style-gallery-4-col-flex .wp-block-image img{
                            border-radius: 4px;
                        }
                    }
                ',
            )
        );
        
        // Gallery 3 Columns Flex
        register_block_style(
            'core/gallery',
            array(
                'name'         => 'gallery-3-col-flex',
                'label'        => __( 'Gallery 3 Columns', 'block-child-textdomain' ),
                'inline_style' => '
                    .wp-block-gallery.is-style-gallery-3-col-flex {
                        display: flex;
                        flex-wrap: wrap;
                        gap: 16px !important;
                        justify-content: center
                    }
                    .wp-block-gallery.is-style-gallery-3-col-flex .wp-block-image {
                        flex: 0 0 calc(33.333% - 16px);
                        margin: 0;
                    }
                    .wp-block-gallery.is-style-gallery-3-col-flex .wp-block-image img {
                        width: 100%;
                        height: 100%;
                        object-fit: cover;
                        display: block;
                        border-radius: 8px
                        min-height: 117px;
                    }
                    @media (max-width: 1024px) {
                        .wp-block-gallery.is-style-gallery-3-col-flex .wp-block-image {
                            flex: 0 0 calc(50% - 16px);
                        }
                    }
                    @media (max-width: 767px) {
                         .wp-block-gallery.is-style-gallery-4-col-flex{
                            gap: 8px !important
                        }
                        .wp-block-gallery.is-style-gallery-4-col-flex .wp-block-image {
                            flex: 0 0 calc(50% - 8px)
                        }
                        .wp-block-gallery .wp-block-image a{
                            border-radius: 4px !important;    
                        }
                        .wp-block-gallery.is-style-gallery-4-col-flex .wp-block-image img{
                            border-radius: 4px;
                        }
                    }
                ',
            )
        );

        // Gallery 2 Columns Flex
        register_block_style(
            'core/gallery',
            array(
                'name'         => 'gallery-2-col-flex',
                'label'        => __( 'Gallery 2 Columns', 'block-child-textdomain' ),
                'inline_style' => '
                    .wp-block-gallery.is-style-gallery-2-col-flex {
                        display: flex;
                        flex-wrap: wrap;
                        gap: 16px !important;
                        justify-content: center;
                    }
                    .wp-block-gallery.is-style-gallery-2-col-flex .wp-block-image {
                        flex: 0 0 calc(50% - 16px);
                        margin: 0;
                    }
                    .wp-block-gallery.is-style-gallery-2-col-flex .wp-block-image img {
                        width: 100%;
                        height: 100%;
                        object-fit: cover;
                        display: block;
                        border-radius: 8px;
                        min-height: 117px;
                    }
                    @media (max-width: 767px) {
                         .wp-block-gallery.is-style-gallery-4-col-flex{
                            gap: 8px !important
                        }
                        .wp-block-gallery.is-style-gallery-4-col-flex .wp-block-image {
                            flex: 0 0 calc(50% - 8px)
                        }
                        .wp-block-gallery .wp-block-image a{
                            border-radius: 4px !important;    
                        }
                        .wp-block-gallery.is-style-gallery-4-col-flex .wp-block-image img{
                            border-radius: 4px;
                        }
                    }
                ',
            )
        );

    }
}
add_action( 'init', 'register_custom_block_styles' );

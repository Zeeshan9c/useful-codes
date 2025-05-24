<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Table_Custom_Elementor_Widgets extends \Elementor\Widget_Base {

    public function get_name() {
        return 'flexible_table';
    }

    public function get_title() {
        return __( 'Flexible Table', 'elementor-table-widget' );
    }

    public function get_icon() {
        return 'eicon-table';
    }

    public function get_categories() {
        return [ 'general' ];
    }

    public function get_keywords() {
        return [ 'table', 'grid', 'data', 'responsive', 'sort', 'filter' ];
    }

    public function get_script_depends() {
        return [ 'jquery' ];
    }

    protected function register_controls() {
        // Table Content Section
        $this->start_controls_section(
            'table_content_section',
            [
                'label' => __( 'Table Content', 'elementor-table-widget' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'show_header',
            [
                'label' => __( 'Show Header', 'elementor-table-widget' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __( 'Show', 'elementor-table-widget' ),
                'label_off' => __( 'Hide', 'elementor-table-widget' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'table_caption',
            [
                'label' => __( 'Table Caption', 'elementor-table-widget' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '',
                'placeholder' => __( 'Enter table caption', 'elementor-table-widget' ),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'table_columns',
            [
                'label' => __( 'Columns', 'elementor-table-widget' ),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => [
                    [
                        'name' => 'column_name',
                        'label' => __( 'Column Name', 'elementor-table-widget' ),
                        'type' => \Elementor\Controls_Manager::TEXT,
                        'default' => __( 'Column', 'elementor-table-widget' ),
                        'label_block' => true,
                    ],
                    [
                        'name' => 'column_width',
                        'label' => __( 'Width', 'elementor-table-widget' ),
                        'type' => \Elementor\Controls_Manager::SLIDER,
                        'size_units' => [ '%', 'px' ],
                        'range' => [
                            '%' => [ 'min' => 1, 'max' => 100 ],
                            'px' => [ 'min' => 50, 'max' => 500 ],
                        ],
                        'default' => [ 'unit' => '%', 'size' => 20 ],
                    ],
                    [
                        'name' => 'column_alignment',
                        'label' => __( 'Alignment', 'elementor-table-widget' ),
                        'type' => \Elementor\Controls_Manager::CHOOSE,
                        'options' => [
                            'left' => [ 'title' => __( 'Left', 'elementor-table-widget' ), 'icon' => 'eicon-text-align-left' ],
                            'center' => [ 'title' => __( 'Center', 'elementor-table-widget' ), 'icon' => 'eicon-text-align-center' ],
                            'right' => [ 'title' => __( 'Right', 'elementor-table-widget' ), 'icon' => 'eicon-text-align-right' ],
                        ],
                        'default' => 'left',
                    ],
                ],
                'default' => [
                    [ 'column_name' => __( 'Column 1', 'elementor-table-widget' ) ],
                    [ 'column_name' => __( 'Column 2', 'elementor-table-widget' ) ],
                ],
                'title_field' => '{{{ column_name }}}',
                'prevent_empty' => true,
                'max_items' => 10, // Limit columns for performance
            ]
        );

        $this->add_control(
            'table_rows',
            [
                'label' => __( 'Rows', 'elementor-table-widget' ),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => [
                    [
                        'name' => 'row_cells',
                        'label' => __( 'Cells', 'elementor-table-widget' ),
                        'type' => \Elementor\Controls_Manager::TEXTAREA,
                        'description' => __( 'Enter cell values separated by line breaks.', 'elementor-table-widget' ),
                        'label_block' => true,
                    ],
                ],
                'default' => [
                    [ 'row_cells' => "Cell 1\nCell 2" ],
                    [ 'row_cells' => "Cell 3\nCell 4" ],
                ],
                'title_field' => __( 'Row', 'elementor-table-widget' ),
                'prevent_empty' => true,
                'max_items' => 50, // Limit rows for performance
            ]
        );

        $this->end_controls_section();

        // Table Features Section
        $this->start_controls_section(
            'table_features_section',
            [
                'label' => __( 'Features', 'elementor-table-widget' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'enable_sorting',
            [
                'label' => __( 'Enable Sorting', 'elementor-table-widget' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __( 'Yes', 'elementor-table-widget' ),
                'label_off' => __( 'No', 'elementor-table-widget' ),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->add_control(
            'enable_filtering',
            [
                'label' => __( 'Enable Filtering', 'elementor-table-widget' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __( 'Yes', 'elementor-table-widget' ),
                'label_off' => __( 'No', 'elementor-table-widget' ),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->add_control(
            'enable_pagination',
            [
                'label' => __( 'Enable Pagination', 'elementor-table-widget' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __( 'Yes', 'elementor-table-widget' ),
                'label_off' => __( 'No', 'elementor-table-widget' ),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->add_control(
            'rows_per_page',
            [
                'label' => __( 'Rows Per Page', 'elementor-table-widget' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 50,
                'step' => 1,
                'default' => 10,
                'condition' => [ 'enable_pagination' => 'yes' ],
            ]
        );

        $this->add_control(
            'responsive_table',
            [
                'label' => __( 'Responsive Behavior', 'elementor-table-widget' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'stack',
                'options' => [
                    'none' => __( 'None', 'elementor-table-widget' ),
                    'stack' => __( 'Stack on mobile', 'elementor-table-widget' ),
                    'scroll' => __( 'Horizontal scroll', 'elementor-table-widget' ),
                ],
            ]
        );

        $this->end_controls_section();

        // Table Style Section
        $this->start_controls_section(
            'table_style_section',
            [
                'label' => __( 'Table Style', 'elementor-table-widget' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'table_width',
            [
                'label' => __( 'Width', 'elementor-table-widget' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ '%', 'px' ],
                'range' => [
                    '%' => [ 'min' => 1, 'max' => 100 ],
                    'px' => [ 'min' => 100, 'max' => 1200 ],
                ],
                'default' => [ 'unit' => '%', 'size' => 100 ],
                'selectors' => [
                    '{{WRAPPER}} .flexible-table-container' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'table_alignment',
            [
                'label' => __( 'Alignment', 'elementor-table-widget' ),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [ 'title' => __( 'Left', 'elementor-table-widget' ), 'icon' => 'eicon-text-align-left' ],
                    'center' => [ 'title' => __( 'Center', 'elementor-table-widget' ), 'icon' => 'eicon-text-align-center' ],
                    'right' => [ 'title' => __( 'Right', 'elementor-table-widget' ), 'icon' => 'eicon-text-align-right' ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .flexible-table-container' => 'margin: 0 auto; float: none; text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'table_border',
                'selector' => '{{WRAPPER}} .flexible-table',
            ]
        );

        $this->add_control(
            'table_border_radius',
            [
                'label' => __( 'Border Radius', 'elementor-table-widget' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .flexible-table' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'table_box_shadow',
                'selector' => '{{WRAPPER}} .flexible-table',
            ]
        );

        $this->end_controls_section();

        // Header Style Section
        $this->start_controls_section(
            'header_style_section',
            [
                'label' => __( 'Header Style', 'elementor-table-widget' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [ 'show_header' => 'yes' ],
            ]
        );

        $this->add_control(
            'header_background',
            [
                'label' => __( 'Background Color', 'elementor-table-widget' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#f5f5f5',
                'selectors' => [
                    '{{WRAPPER}} .flexible-table thead th' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'header_text_color',
            [
                'label' => __( 'Text Color', 'elementor-table-widget' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#333333',
                'selectors' => [
                    '{{WRAPPER}} .flexible-table thead th' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'header_typography',
                'selector' => '{{WRAPPER}} .flexible-table thead th',
            ]
        );

        $this->add_control(
            'header_padding',
            [
                'label' => __( 'Padding', 'elementor-table-widget' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'default' => [
                    'top' => 10,
                    'right' => 10,
                    'bottom' => 10,
                    'left' => 10,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .flexible-table thead th' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'header_border',
                'selector' => '{{WRAPPER}} .flexible-table thead th',
            ]
        );

        $this->end_controls_section();

        // Row Style Section
        $this->start_controls_section(
            'row_style_section',
            [
                'label' => __( 'Row Style', 'elementor-table-widget' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'row_background',
            [
                'label' => __( 'Background Color', 'elementor-table-widget' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .flexible-table tbody tr' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'row_background_alt',
            [
                'label' => __( 'Alternate Row Color', 'elementor-table-widget' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#f9f9f9',
                'selectors' => [
                    '{{WRAPPER}} .flexible-table tbody tr:nth-child(even)' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'row_hover_background',
            [
                'label' => __( 'Hover Background', 'elementor-table-widget' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#e0e0e0',
                'selectors' => [
                    '{{WRAPPER}} .flexible-table tbody tr:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'row_text_color',
            [
                'label' => __( 'Text Color', 'elementor-table-widget' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#333333',
                'selectors' => [
                    '{{WRAPPER}} .flexible-table tbody td' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'row_typography',
                'selector' => '{{WRAPPER}} .flexible-table tbody td',
            ]
        );

        $this->add_control(
            'row_padding',
            [
                'label' => __( 'Padding', 'elementor-table-widget' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'default' => [
                    'top' => 10,
                    'right' => 10,
                    'bottom' => 10,
                    'left' => 10,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .flexible-table tbody td' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'row_border',
                'selector' => '{{WRAPPER}} .flexible-table tbody td',
            ]
        );

        $this->end_controls_section();

        // Caption Style Section
        $this->start_controls_section(
            'caption_style_section',
            [
                'label' => __( 'Caption Style', 'elementor-table-widget' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'caption_alignment',
            [
                'label' => __( 'Alignment', 'elementor-table-widget' ),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [ 'title' => __( 'Left', 'elementor-table-widget' ), 'icon' => 'eicon-text-align-left' ],
                    'center' => [ 'title' => __( 'Center', 'elementor-table-widget' ), 'icon' => 'eicon-text-align-center' ],
                    'right' => [ 'title' => __( 'Right', 'elementor-table-widget' ), 'icon' => 'eicon-text-align-right' ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .flexible-table-caption' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'caption_text_color',
            [
                'label' => __( 'Text Color', 'elementor-table-widget' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#333333',
                'selectors' => [
                    '{{WRAPPER}} .flexible-table-caption' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'caption_background',
            [
                'label' => __( 'Background Color', 'elementor-table-widget' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#f5f5f5',
                'selectors' => [
                    '{{WRAPPER}} .flexible-table-caption' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'caption_typography',
                'selector' => '{{WRAPPER}} .flexible-table-caption',
            ]
        );

        $this->add_control(
            'caption_padding',
            [
                'label' => __( 'Padding', 'elementor-table-widget' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'default' => [
                    'top' => 10,
                    'right' => 10,
                    'bottom' => 10,
                    'left' => 10,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .flexible-table-caption' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Pagination Style Section
        $this->start_controls_section(
            'pagination_style_section',
            [
                'label' => __( 'Pagination Style', 'elementor-table-widget' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [ 'enable_pagination' => 'yes' ],
            ]
        );

        $this->add_control(
            'pagination_button_color',
            [
                'label' => __( 'Button Color', 'elementor-table-widget' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#0073aa',
                'selectors' => [
                    '{{WRAPPER}} .flexible-table-pagination button' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'pagination_button_text_color',
            [
                'label' => __( 'Button Text Color', 'elementor-table-widget' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .flexible-table-pagination button' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'pagination_button_active_color',
            [
                'label' => __( 'Active Button Color', 'elementor-table-widget' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#005177',
                'selectors' => [
                    '{{WRAPPER}} .flexible-table-pagination button.active' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'pagination_typography',
                'selector' => '{{WRAPPER}} .flexible-table-pagination button',
            ]
        );

        $this->end_controls_section();

        // Filter Style Section
        $this->start_controls_section(
            'filter_style_section',
            [
                'label' => __( 'Filter Style', 'elementor-table-widget' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [ 'enable_filtering' => 'yes' ],
            ]
        );

        $this->add_control(
            'filter_background',
            [
                'label' => __( 'Background Color', 'elementor-table-widget' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .flexible-table-filter input' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'filter_text_color',
            [
                'label' => __( 'Text Color', 'elementor-table-widget' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#333333',
                'selectors' => [
                    '{{WRAPPER}} .flexible-table-filter input' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'filter_border',
                'selector' => '{{WRAPPER}} .flexible-table-filter input',
            ]
        );

        $this->add_control(
            'filter_padding',
            [
                'label' => __( 'Padding', 'elementor-table-widget' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'default' => [
                    'top' => 8,
                    'right' => 12,
                    'bottom' => 8,
                    'left' => 12,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .flexible-table-filter input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $columns = $settings['table_columns'];
        $rows = $settings['table_rows'];
        $show_header = $settings['show_header'];
        $table_caption = $settings['table_caption'];
        $responsive = $settings['responsive_table'];
        $enable_sorting = $settings['enable_sorting'];
        $enable_filtering = $settings['enable_filtering'];
        $enable_pagination = $settings['enable_pagination'];
        $table_id = 'flexible-table-' . $this->get_id();

        $responsive_class = $responsive === 'stack' ? 'flexible-table-stack' : ($responsive === 'scroll' ? 'flexible-table-scroll' : '');

        ?>
        <style>
            .flexible-table-container { max-width: 100%; overflow-x: auto; margin-bottom: 20px; }
            .flexible-table { border-collapse: collapse; width: 100%; max-height: 500px; overflow-y: auto; }
            .flexible-table th, .flexible-table td { border: 1px solid #ddd; padding: 10px; }
            .flexible-table thead th { cursor: pointer; }
            .flexible-table-caption { font-size: 16px; padding: 10px; }
            .flexible-table-filter { margin-bottom: 10px; }
            .flexible-table-filter input { width: 100%; max-width: 300px; border: 1px solid #ddd; border-radius: 4px; }
            .flexible-table-pagination { margin-top: 10px; text-align: center; }
            .flexible-table-pagination button { margin: 0 5px; padding: 8px 12px; border: 1px solid #ddd; border-radius: 4px; cursor: pointer; }
            .flexible-table-pagination button.active { font-weight: bold; }
            .flexible-table-pagination button:disabled { opacity: 0.5; cursor: not-allowed; }
            @media (max-width: 768px) {
                .flexible-table-stack .flexible-table { display: block; }
                .flexible-table-stack thead { display: none; }
                .flexible-table-stack tbody, .flexible-table-stack tr { display: block; }
                .flexible-table-stack td { display: block; text-align: left; position: relative; padding-left: 50%; }
                .flexible-table-stack td:before {
                    content: attr(data-label); position: absolute; left: 10px; font-weight: bold;
                }
                .flexible-table-scroll { overflow-x: auto; }
                .flexible-table-scroll thead th { position: sticky; top: 0; z-index: 10; }
            }
        </style>

        <div class="flexible-table-container <?php echo esc_attr( $responsive_class ); ?>">
            <?php if ( $enable_filtering === 'yes' ) : ?>
                <div class="flexible-table-filter">
                    <input type="text" class="flexible-table-filter-input" data-table-id="<?php echo esc_attr( $table_id ); ?>" placeholder="<?php esc_attr_e( 'Search table...', 'elementor-table-widget' ); ?>">
                </div>
            <?php endif; ?>

            <table id="<?php echo esc_attr( $table_id ); ?>" class="flexible-table">
                <?php if ( ! empty( $table_caption ) ) : ?>
                    <caption class="flexible-table-caption"><?php echo esc_html( $table_caption ); ?></caption>
                <?php endif; ?>

                <?php if ( $show_header === 'yes' ) : ?>
                    <thead>
                        <tr>
                            <?php foreach ( $columns as $index => $column ) : ?>
                                <?php
                                $style = '';
                                if ( ! empty( $column['column_width']['size'] ) ) {
                                    $style .= 'width:' . esc_attr( $column['column_width']['size'] . $column['column_width']['unit'] ) . ';';
                                }
                                if ( ! empty( $column['column_alignment'] ) ) {
                                    $style .= 'text-align:' . esc_attr( $column['column_alignment'] ) . ';';
                                }
                                ?>
                                <th style="<?php echo $style; ?>" data-label="<?php echo esc_attr( $column['column_name'] ); ?>">
                                    <?php echo esc_html( $column['column_name'] ); ?>
                                </th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                <?php endif; ?>

                <tbody>
                    <?php foreach ( $rows as $row ) : ?>
                        <tr>
                            <?php
                            $cells = explode( "\n", $row['row_cells'] );
                            $cell_index = 0;
                            foreach ( $columns as $column ) :
                                $cell_content = isset( $cells[ $cell_index ] ) ? $cells[ $cell_index ] : '';
                                $style = ! empty( $column['column_alignment'] ) ? 'text-align:' . esc_attr( $column['column_alignment'] ) . ';' : '';
                                ?>
                                <td style="<?php echo $style; ?>" data-label="<?php echo esc_attr( $column['column_name'] ); ?>">
                                    <?php echo wp_kses_post( $cell_content ); ?>
                                </td>
                                <?php $cell_index++; ?>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <?php if ( $enable_pagination === 'yes' ) : ?>
                <div class="flexible-table-pagination" data-table-id="<?php echo esc_attr( $table_id ); ?>"></div>
            <?php endif; ?>
        </div>

        <?php if ( $enable_sorting === 'yes' || $enable_filtering === 'yes' || $enable_pagination === 'yes' ) : ?>
            <script>
            jQuery(document).ready(function($) {
                var table = $('#<?php echo esc_js( $table_id ); ?>');

                <?php if ( $enable_sorting === 'yes' ) : ?>
                    table.find('th').on('click', function() {
                        var table = $(this).parents('table').eq(0);
                        var rows = table.find('tr:gt(0)').toArray().sort(comparer($(this).index()));
                        this.asc = !this.asc;
                        if (!this.asc) rows = rows.reverse();
                        for (var i = 0; i < rows.length; i++) table.append(rows[i]);
                    });

                    function comparer(index) {
                        return function(a, b) {
                            var valA = getCellValue(a, index), valB = getCellValue(b, index);
                            return $.isNumeric(valA) && $.isNumeric(valB) ? valA - valB : valA.toString().localeCompare(valB);
                        };
                    }

                    function getCellValue(row, index) {
                        return $(row).children('td').eq(index).text();
                    }
                <?php endif; ?>

                <?php if ( $enable_filtering === 'yes' ) : ?>
                    var $filterInput = $('.flexible-table-filter-input[data-table-id="<?php echo esc_js( $table_id ); ?>"]');
                    $filterInput.on('input', debounce(function() {
                        var filter = $(this).val().toLowerCase();
                        table.find('tbody tr').each(function() {
                            var row = $(this);
                            var match = row.find('td').toArray().some(function(cell) {
                                return $(cell).text().toLowerCase().indexOf(filter) > -1;
                            });
                            row.toggle(match);
                        });
                    }, 300));

                    function debounce(func, wait) {
                        var timeout;
                        return function() {
                            clearTimeout(timeout);
                            timeout = setTimeout(function() { func.apply(this, arguments); }, wait);
                        };
                    }
                <?php endif; ?>

                <?php if ( $enable_pagination === 'yes' ) : ?>
                    var rowsPerPage = <?php echo esc_js( $settings['rows_per_page'] ); ?>;
                    var $pagination = $('.flexible-table-pagination[data-table-id="<?php echo esc_js( $table_id ); ?>"]');
                    if (!table.data('paginated')) {
                        var currentPage = 1;
                        var numPages = Math.ceil(table.find('tbody tr').length / rowsPerPage);

                        function showPage(page) {
                            table.find('tbody tr').hide();
                            table.find('tbody tr').slice((page - 1) * rowsPerPage, page * rowsPerPage).show();
                        }

                        function setupPagination() {
                            $pagination.empty();
                            $('<button>').addClass('flexible-table-pagination-prev').text('«').attr('disabled', currentPage === 1).on('click', function() {
                                if (currentPage > 1) {
                                    currentPage--;
                                    showPage(currentPage);
                                    setupPagination();
                                }
                            }).appendTo($pagination);

                            for (var i = 1; i <= numPages; i++) {
                                $('<button>').addClass('flexible-table-pagination-page' + (i === currentPage ? ' active' : '')).text(i).on('click', function() {
                                    currentPage = parseInt($(this).text());
                                    showPage(currentPage);
                                    setupPagination();
                                }).appendTo($pagination);
                            }

                            $('<button>').addClass('flexible-table-pagination-next').text('»').attr('disabled', currentPage === numPages).on('click', function() {
                                if (currentPage < numPages) {
                                    currentPage++;
                                    showPage(currentPage);
                                    setupPagination();
                                }
                            }).appendTo($pagination);
                        }

                        showPage(currentPage);
                        setupPagination();
                        table.data('paginated', true);
                    }
                <?php endif; ?>
            });
            </script>
        <?php endif; ?>
        <?php
    }

    protected function content_template() {
        ?>
        <#
        var table_id = 'flexible-table-' + view.getID();
        var responsive_class = settings.responsive_table === 'stack' ? 'flexible-table-stack' : settings.responsive_table === 'scroll' ? 'flexible-table-scroll' : '';
        #>
        <div class="flexible-table-container {{ responsive_class }}">
            <# if ( settings.enable_filtering === 'yes' ) { #>
                <div class="flexible-table-filter">
                    <input type="text" class="flexible-table-filter-input" data-table-id="{{ table_id }}" placeholder="<?php esc_attr_e( 'Search table...', 'elementor-table-widget' ); ?>">
                </div>
            <# } #>
            <table id="{{ table_id }}" class="flexible-table">
                <# if ( settings.table_caption ) { #>
                    <caption class="flexible-table-caption">{{{ settings.table_caption }}}</caption>
                <# } #>
                <# if ( settings.show_header === 'yes' ) { #>
                    <thead>
                        <tr>
                            <# _.each( settings.table_columns, function( column, index ) { #>
                                <#
                                var style = '';
                                if ( column.column_width.size ) {
                                    style += 'width:' + column.column_width.size + column.column_width.unit + ';';
                                }
                                if ( column.column_alignment ) {
                                    style += 'text-align:' + column.column_alignment + ';';
                                }
                                #>
                                <th style="{{ style }}" data-label="{{ column.column_name }}">{{{ column.column_name }}}</th>
                            <# }); #>
                        </tr>
                    </thead>
                <# } #>
                <tbody>
                    <# _.each( settings.table_rows, function( row ) { #>
                        <tr>
                            <#
                            var cells = row.row_cells.split('\n');
                            var cell_index = 0;
                            _.each( settings.table_columns, function( column ) {
                                var cell_content = cells[cell_index] || '';
                                var style = column.column_alignment ? 'text-align:' + column.column_alignment + ';' : '';
                                #>
                                <td style="{{ style }}" data-label="{{ column.column_name }}">{{{ cell_content }}}</td>
                                <# cell_index++;
                            }); #>
                        </tr>
                    <# }); #>
                </tbody>
            </table>
            <# if ( settings.enable_pagination === 'yes' ) { #>
                <div class="flexible-table-pagination" data-table-id="{{ table_id }}"></div>
            <# } #>
        </div>
        <?php
    }
}


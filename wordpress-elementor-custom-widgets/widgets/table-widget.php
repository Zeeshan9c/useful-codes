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
        return [ 'table', 'grid', 'data', 'responsive' ];
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
                        'name' => 'column_min_width',
                        'label' => __( 'Min-Width', 'elementor-table-widget' ),
                        'type' => \Elementor\Controls_Manager::SLIDER,
                        'size_units' => [ 'px' ],
                        'range' => [
                            'px' => [ 'min' => 50, 'max' => 500 ],
                        ],
                        'default' => [ 'unit' => 'px', 'size' => 100 ],
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
                        'type' => \Elementor\Controls_Manager::WYSIWYG,
                        'description' => __( 'Enter each cell value in a new paragraph (press Enter). Simple HTML (e.g., bold, italic) is supported within cells.', 'elementor-table-widget' ),
                        'label_block' => true,
                    ],
                ],
                'default' => [
                    [ 'row_cells' => '<p>Cell 1</p><p>Cell 2</p>' ],
                    [ 'row_cells' => '<p>Cell 3</p><p>Cell 4</p>' ],
                ],
                'title_field' => __( 'Row', 'elementor-table-widget' ),
                'prevent_empty' => true,
                'max_items' => 50, // Limit rows for performance
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
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $columns = $settings['table_columns'];
        $rows = $settings['table_rows'];
        $show_header = $settings['show_header'];
        $table_caption = $settings['table_caption'];
        $responsive = $settings['responsive_table'];
        $table_id = 'flexible-table-' . $this->get_id();
        $responsive_class = $responsive === 'stack' ? 'flexible-table-stack' : ($responsive === 'scroll' ? 'flexible-table-scroll' : '');

        ?>
        <style>
            .flexible-table-container { max-width: 100%; overflow-x: auto; margin-bottom: 20px; }
            .flexible-table { border-collapse: collapse; width: 100%; max-height: 500px; overflow-y: auto; }
            .flexible-table th, .flexible-table td { border: 1px solid #ddd; padding: 10px; }
            .flexible-table-caption { font-size: 16px; padding: 10px; }
            <?php
            // Dynamically generate min-width CSS for each column
            foreach ( $columns as $index => $column ) {
                if ( ! empty( $column['column_min_width']['size'] ) ) {
                    echo sprintf(
                        '.flexible-table th:nth-child(%d), .flexible-table td:nth-child(%d) { min-width: %dpx; }',
                        $index + 1,
                        $index + 1,
                        esc_attr( $column['column_min_width']['size'] )
                    );
                }
            }
            ?>
            @media (max-width: 768px) {
                .flexible-table-stack .flexible-table { display: block; }
                .flexible-table-stack thead { display: none; }
                .flexible-table-stack tbody, .flexible-table-stack tr { display: block; }
                .flexible-table-stack td { 
                    display: block; 
                    text-align: left; 
                    position: relative; 
                    padding-left: 50%; 
                    border-bottom: none; 
                    border-top: none;
                    min-width: 0 !important; /* Override min-width for stacking */
                }
                .flexible-table-stack td:before {
                    content: attr(data-label); 
                    position: absolute; 
                    left: 10px; 
                    font-weight: bold;
                    width: 45%;
                    padding-right: 10px;
                }
                .flexible-table-stack tr {
                    margin-bottom: 10px;
                    border: 1px solid #ddd;
                    border-radius: 4px;
                }
                .flexible-table-scroll { overflow-x: auto; }
                .flexible-table-scroll thead th { 
                    position: sticky; 
                    top: 0; 
                    z-index: 10; 
                    background-color: inherit; 
                }
            }
        </style>

        <div class="flexible-table-container <?php echo esc_attr( $responsive_class ); ?>">
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
                                if ( ! empty( $column['column_min_width']['size'] ) ) {
                                    $style .= 'min-width:' . esc_attr( $column['column_min_width']['size'] ) . 'px;';
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
                            // Split WYSIWYG content by <p> tags or <br> tags
                            $content = $row['row_cells'];
                            // Replace <br> tags with a delimiter to handle line breaks within paragraphs
                            $content = str_replace(['<br>', '<br />'], '||', $content);
                            // Split by </p> to separate paragraphs
                            $cells = array_filter(array_map('trim', explode('</p>', $content)));
                            $cell_index = 0;
                            foreach ( $columns as $column ) :
                                $cell_content = isset($cells[$cell_index]) ? trim($cells[$cell_index]) : '';
                                // Remove opening <p> tag and any trailing whitespace
                                $cell_content = preg_replace('/^<p>/', '', $cell_content);
                                // Split by || to handle <br> within cells
                                $cell_content = str_replace('||', '<br>', $cell_content);
                                // Ensure content is safe for output
                                $cell_content = wp_kses_post($cell_content);
                                $style = ! empty($column['column_alignment']) ? 'text-align:' . esc_attr($column['column_alignment']) . ';' : '';
                                ?>
                                <td style="<?php echo $style; ?>" data-label="<?php echo esc_attr($column['column_name']); ?>">
                                    <?php echo $cell_content; ?>
                                </td>
                                <?php $cell_index++; ?>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php
    }

    protected function content_template() {
        ?>
        <#
        var table_id = 'flexible-table-' + view.getID();
        var responsive_class = settings.responsive_table === 'stack' ? 'flexible-table-stack' : settings.responsive_table === 'scroll' ? 'flexible-table-scroll' : '';
        #>
        <div class="flexible-table-container {{ responsive_class }}">
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
                                if ( column.column_min_width.size ) {
                                    style += 'min-width:' + column.column_min_width.size + 'px;';
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
                            // Split WYSIWYG content by <p> tags or <br> tags
                            var content = row.row_cells;
                            // Replace <br> tags with a delimiter
                            content = content.replace(/<br\s*\/?>/gi, '||');
                            // Split by </p> to separate paragraphs
                            var cells = content.split('</p>').map(function(cell) { return cell.trim(); }).filter(function(cell) { return cell !== ''; });
                            var cell_index = 0;
                            _.each( settings.table_columns, function( column ) {
                                var cell_content = cells[cell_index] || '';
                                // Remove opening <p> tag
                                cell_content = cell_content.replace(/^<p>/, '');
                                // Replace delimiter with <br>
                                cell_content = cell_content.replace(/\|\|/g, '<br>');
                                var style = column.column_alignment ? 'text-align:' + column.column_alignment + ';' : '';
                                #>
                                <td style="{{ style }}" data-label="{{ column.column_name }}">{{{ cell_content }}}</td>
                                <# cell_index++;
                            }); #>
                        </tr>
                    <# }); #>
                </tbody>
            </table>
        </div>
        <?php
    }
}
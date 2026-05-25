(function () {
    var addFilter = wp.hooks.addFilter;
    var createHOC = wp.compose.createHigherOrderComponent;
    var InspectorControls = wp.blockEditor.InspectorControls;
    var PanelBody = wp.components.PanelBody;
    var ToggleControl = wp.components.ToggleControl;
    var TextControl = wp.components.TextControl;
    var SelectControl = wp.components.SelectControl;
    var Notice = wp.components.Notice;
    var el = wp.element.createElement;
    var Fragment = wp.element.Fragment;

    // === Columns Stack Reverse Mobile ===
    addFilter(
        'blocks.registerBlockType',
        'impression-homes/columns-stack-reverse-attr',
        function (settings, name) {
            if (name !== 'core/columns') return settings;
            return Object.assign({}, settings, {
                attributes: Object.assign({}, settings.attributes, {
                    stackReverseMobile: {
                        type: 'boolean',
                        default: false,
                    },
                }),
            });
        }
    );

    var withStackReverseControl = createHOC(function (BlockEdit) {
        return function (props) {
            if (props.name !== 'core/columns') {
                return el(BlockEdit, props);
            }

            return el(
                Fragment,
                null,
                el(BlockEdit, props),
                el(
                    InspectorControls,
                    null,
                    el(
                        PanelBody,
                        { title: 'Mobile Settings', initialOpen: true },
                        el(ToggleControl, {
                            label: 'Stack reverse on mobile',
                            checked: !!props.attributes.stackReverseMobile,
                            onChange: function (value) {
                                props.setAttributes({ stackReverseMobile: value });
                            },
                        })
                    )
                )
            );
        };
    }, 'withStackReverseControl');

    addFilter(
        'editor.BlockEdit',
        'impression-homes/columns-stack-reverse-control',
        withStackReverseControl
    );

    addFilter(
        'blocks.getSaveContent.extraProps',
        'impression-homes/columns-stack-reverse-class',
        function (extraProps, blockType, attrs) {
            if (blockType.name === 'core/columns' && attrs.stackReverseMobile) {
                extraProps.className =
                    (extraProps.className || '') + ' stack-reverse-mobile';
            }
            return extraProps;
        }
    );

    // === Group Section Attribute ===
    addFilter(
        'blocks.registerBlockType',
        'impression-homes/group-section-attr',
        function (settings, name) {
            if (name !== 'core/group') return settings;
            return Object.assign({}, settings, {
                attributes: Object.assign({}, settings.attributes, {
                    sectionAttr: {
                        type: 'string',
                        default: '',
                    },
                }),
            });
        }
    );

    var withGroupSectionAttrControl = createHOC(function (BlockEdit) {
        return function (props) {
            if (props.name !== 'core/group') {
                return el(BlockEdit, props);
            }

            return el(
                Fragment,
                null,
                el(BlockEdit, props),
                el(
                    InspectorControls,
                    null,
                    el(
                        PanelBody,
                        { title: 'Group Settings', initialOpen: true },
                        el(TextControl, {
                            label: 'Section Attribute',
                            value: props.attributes.sectionAttr || '',
                            onChange: function (value) {
                                props.setAttributes({ sectionAttr: value });
                            },
                        })
                    )
                )
            );
        };
    }, 'withGroupSectionAttrControl');

    addFilter(
        'editor.BlockEdit',
        'impression-homes/group-section-attr-control',
        withGroupSectionAttrControl
    );

    addFilter(
        'blocks.getSaveContent.extraProps',
        'impression-homes/group-section-attr-save',
        function (extraProps, blockType, attrs) {
            if (blockType.name === 'core/group' && attrs.sectionAttr) {
                extraProps['data-section-attr'] = attrs.sectionAttr;
            }
            return extraProps;
        }
    );

    // === Group Anchor / Link ===
    // Registers two new attributes: linkHref and linkTarget.
    // These sit alongside tagName (which core/group already owns) so we
    // never touch or re-register tagName ourselves.
    addFilter(
        'blocks.registerBlockType',
        'impression-homes/group-anchor-attr',
        function (settings, name) {
            if (name !== 'core/group') return settings;
            return Object.assign({}, settings, {
                attributes: Object.assign({}, settings.attributes, {
                    linkHref: {
                        type: 'string',
                        default: '',
                    },
                    linkTarget: {
                        type: 'string',
                        default: '_self',
                    },
                }),
            });
        }
    );

    var HTML_ELEMENT_OPTIONS = [
        { label: 'Default (<div>)', value: 'div' },
        { label: '<a> Anchor / Link', value: 'a' },
    ];

    var withGroupAnchorControl = createHOC(function (BlockEdit) {
        return function (props) {
            if (props.name !== 'core/group') {
                return el(BlockEdit, props);
            }

            var tagName = props.attributes.tagName || 'div';
            var linkHref = props.attributes.linkHref || '';
            var linkTarget = props.attributes.linkTarget || '_self';
            var isAnchor = tagName === 'a';

            return el(
                Fragment,
                null,
                el(BlockEdit, props),
                el(
                    InspectorControls,
                    null,
                    el(
                        PanelBody,
                        { title: 'HTML Element', initialOpen: false },
                        el(SelectControl, {
                            label: 'HTML Element',
                            value: tagName,
                            options: HTML_ELEMENT_OPTIONS,
                            onChange: function (value) {
                                if (value !== 'a') {
                                    // Clear link attrs when switching away from <a>
                                    props.setAttributes({
                                        tagName: value,
                                        linkHref: '',
                                        linkTarget: '_self',
                                    });
                                } else {
                                    props.setAttributes({ tagName: value });
                                }
                            },
                            help: 'Choose the HTML wrapper element. Use <a> to make the whole group a link.',
                        }),

                        // URL field — only visible when <a> is selected
                        isAnchor && el(TextControl, {
                            label: 'Link URL',
                            value: linkHref,
                            placeholder: 'https://example.com',
                            type: 'url',
                            onChange: function (value) {
                                props.setAttributes({ linkHref: value });
                            },
                            help: 'The URL this group will navigate to.',
                        }),

                        // Open in new tab toggle — only visible when <a> is selected
                        isAnchor && el(ToggleControl, {
                            label: 'Open in new tab',
                            checked: linkTarget === '_blank',
                            onChange: function (checked) {
                                props.setAttributes({
                                    linkTarget: checked ? '_blank' : '_self',
                                });
                            },
                        }),

                        // Warning when no URL entered
                        isAnchor && !linkHref && el(
                            Notice,
                            { status: 'warning', isDismissible: false },
                            'Add a URL above so the anchor works on the front end.'
                        )
                    )
                )
            );
        };
    }, 'withGroupAnchorControl');

    addFilter(
        'editor.BlockEdit',
        'impression-homes/group-anchor-control',
        withGroupAnchorControl
    );

    // No getSaveContent filter needed here — href/target/rel are injected
    // server-side via the PHP render_block_core/group filter, which avoids
    // block validation errors.

})();
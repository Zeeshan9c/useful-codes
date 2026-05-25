import { __ } from '@wordpress/i18n';
import { useBlockProps } from '@wordpress/block-editor';
import { RichText } from '@wordpress/block-editor';

/**
 * Edit component — rendered inside the block editor.
 *
 * Currently a single editable heading.
 * Add InspectorControls and more attributes here as the project grows.
 */
export default function Edit({ attributes, setAttributes }) {
	const blockProps = useBlockProps({
		className: 'card-block',
	});

	return (
		<div {...blockProps}>
			<RichText
				tagName="h3"
				className="card-block__heading"
				value={attributes.heading}
				onChange={(heading) => setAttributes({ heading })}
				placeholder={__('Card heading…', 'block-child-textdomain')}
				allowedFormats={[]}
			/>
		</div>
	);
}
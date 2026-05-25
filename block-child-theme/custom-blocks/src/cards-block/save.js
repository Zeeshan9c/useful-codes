import { useBlockProps, RichText } from '@wordpress/block-editor';

/**
 * Save component — static HTML stored in the post content.
 */
export default function save({ attributes }) {
	const blockProps = useBlockProps.save({
		className: 'card-block',
	});

	return (
		<div {...blockProps}>
			<RichText.Content
				tagName="h3"
				className="card-block__heading"
				value={attributes.heading}
			/>
		</div>
	);
}
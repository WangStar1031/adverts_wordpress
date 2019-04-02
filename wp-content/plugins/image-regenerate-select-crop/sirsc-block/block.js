(function(wp) {

	/**
	 * Returns a new element of given type. Element is an abstraction layer atop React.
	 * @see https://github.com/WordPress/gutenberg/tree/master/element#element
	 */
	var el = wp.element.createElement;

	/**
	 * Retrieves the translation of text.
	 * @see https://github.com/WordPress/gutenberg/tree/master/i18n#api
	 */
	var __ = wp.i18n.__;

	/**
	 * Generates the plugin additional elements.
	 */
	function sirscFeaturedImageButtons(OriginalComponent) {
		return function(props) {
			var thid = props.featuredImageId;

			// Hook up the actions of the elements.
			setTimeout(function() {
				sirsc_hookup_block_buttons(thid);
			}, 500);

			// Return the buttons as expected.
			return (
				el(
					wp.element.Fragment,
					{},
					el(
						'div',
						{className: 'sirsc_button-regenerate-wrap'},
						el(
							'div',
							{className: 'sirsc-image-generate-functionality'},
							el(
								'div',
								{id: 'sirsc_recordsArray_' + thid},
								el(
									'input',
									{id: 'post_idthumb' + thid, type: 'hidden', name: 'post_id', value: thid},
								),
								el(
									'div',
									{className: 'sirsc_button-regenerate'},
									el(
										'div',
										{id: 'sirsc_inline_regenerate_sizes' + thid},
										el(
											'div',
											{className: 'button-primary button-large sirsc-block-action-details', 'data-sirsc-id': thid},
											el(
												'div',
												{className: 'dashicons dashicons-format-gallery', title: SIRSC_settings.button_options}
											),
											SIRSC_settings.button_details,
										),
										el(
											'div',
											{className: 'button-primary button-large sirsc-block-action-regenerate', 'data-sirsc-id': thid},
											el(
												'div',
												{className: 'dashicons dashicons-update', title: SIRSC_settings.button_regenerate}
											),
											SIRSC_settings.button_regenerate,
										),
										el(
											'div',
											{id: 'sirsc_recordsArray_' + thid + '_result', className: 'result'},
											el(
												'span',
												{className: 'spinner inline off'}
											),
										),
									),
								),
								el(
									'div',
									{className: 'sirsc_clearAll'},
								),
								el(
									'br',
									{},
								),
							)
						)
					),
					el(
						OriginalComponent,
						props
					),
				)
			);
		}
	}

	// Add the custom hook for the Image Regenerate & Select Crop buttons.
	wp.hooks.addFilter('editor.PostFeaturedImage', 'image-regenerate-select-crop/sirsc-block', sirscFeaturedImageButtons);

}) (
	window.wp
);

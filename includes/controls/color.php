<?php
namespace Wroter;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Control_Color extends Control_Base {

	public function get_type() {
		return 'color';
	}

	public function enqueue() {
		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		wp_register_script( 'iris', admin_url( '/js/iris.min.js' ), [ 'jquery-ui-draggable', 'jquery-ui-slider', 'jquery-touch-punch' ], '1.0.7', 1 );
		wp_register_script( 'wp-color-picker', admin_url( '/js/color-picker.min.js' ), [ 'iris' ], false, true );

		wp_localize_script(
			'wp-color-picker',
			'wpColorPickerL10n',
			[
				'clear' => __( 'Clear', 'wroter' ),
				'defaultString' => __( 'Default', 'wroter' ),
				'pick' => __( 'Select Color', 'wroter' ),
				'current' => __( 'Current Color', 'wroter' ),
			]
		);

		wp_register_script(
			'wp-color-picker-alpha',
			WROTER_ASSETS_URL . 'lib/wp-color-picker/wp-color-picker-alpha' . $suffix . '.js',
			[
				'wp-color-picker',
			],
			'1.1',
			true
		);

		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker-alpha' );
	}

	public function content_template() {
		?>
		<# var defaultValue = '', dataAlpha = '';
			if ( data.default ) {
				if ( '#' !== data.default.substring( 0, 1 ) ) {
					defaultValue = '#' + data.default;
				} else {
					defaultValue = data.default;
				}
				defaultValue = ' data-default-color=' + defaultValue; // Quotes added automatically.
			}
			if ( data.alpha ) {
				dataAlpha = ' data-alpha="true"';
			} #>
		<div class="wroter-control-field">
			<label class="wroter-control-title">
				<# if ( data.label ) { #>
					{{{ data.label }}}
				<# } #>
				<# if ( data.description ) { #>
					<span class="wroter-control-description">{{{ data.description }}}</span>
				<# } #>
			</label>
			<div class="wroter-control-input-wrapper">
				<input data-setting="{{ name }}" class="color-picker-hex" type="text" maxlength="7" placeholder="<?php esc_attr_e( 'Hex Value', 'wroter' ); ?>" {{ defaultValue }}{{ dataAlpha }} />
			</div>
		</div>
		<?php
	}

	protected function get_default_settings() {
		return [
			'alpha' => true,
		];
	}
}

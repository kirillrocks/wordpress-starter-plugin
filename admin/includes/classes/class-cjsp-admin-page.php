<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * Created by CODEJA.
 * User: kirillrocks
 * Date: 24-Jan-17
 * Time: 21:25
 */
class CJSP_Admin_Page {
	public function addAdminPages() {
        // CREATE MAIN ADMIN PAGE
		$admin_page = $this->add_main_page(); // RENDERS AND RETURN MENU SLUG FOR DEFAULT ADMIN PAGE

        // CREATE SUB PAGES
		$this->add_sub_page( $admin_page, 'Settings', 'Settings', $admin_page ); // DEFAULT SETTINGS PAGE
		$this->add_sub_page( $admin_page, 'Logs', 'Logs', 'cjsp-logs', 'renderLogs' ); // DEFAULT LOG PAGE
	}

	public function configure() {
		// GENERAL SECTION
		$general_section = $this->add_section( 'general', 'General Section', 'cjsp-admin-page' );

        // CREATE FIELD
        $this->add_field('post_name', 'Post Name', 'cjsp-admin-page', $general_section);

		// REGISTER SETTINGS
		register_setting( 'cjsp-settings', 'cjsp' );
	}

	/**
     * Wrapper method for add_menu_page function
     *
	 * @param string $page_title
	 * @param string $menu_title
	 * @param string $menu_slug
	 * @param string $render
	 * @param string $capability
	 *
	 * @return string
	 */
	private function add_main_page( $page_title = CJSP_PLUGIN_NAME, $menu_title = CJSP_PLUGIN_NAME, $menu_slug = 'cjsp-admin-page', $render = 'renderMainPage', $capability = 'manage_options' ) {
		add_menu_page( CJSP_PLUGIN_NAME, CJSP_PLUGIN_NAME, 'manage_options', 'cjsp-admin-page', array(
			$this,
			$render
		) );

		return $menu_slug;
	}

	/**
     * Wrapper method for add_submenu_page function
     *
	 * @param $page
	 * @param $title
	 * @param $menu_title
	 * @param $slug
	 * @param string $capability
	 * @param string $render
	 */
	private function add_sub_page( $page, $title, $menu_title, $slug, $render = 'renderSubPage', $capability = 'manage_options' ) {
		add_submenu_page( $page, $title, $menu_title, $capability, $slug, array(
			$this,
			$render
		) );
	}

	/**
     * Wrapper method for add_settings_section function
     *
	 * @param $name
	 * @param $title
	 * @param $page
	 *
	 * @return mixed
	 */
	private function add_section( $name, $title, $page ) {
		add_settings_section(
			'cjsp-' . $name,
			$title,
			array( $this, 'renderSection' ),
			$page
		);

		return $name;
    }

    /**
     * Wrapper method for add_settings_field function
     *
     * @param $name
     * @param $title
     * @param $page
     * @param string $section
     * @param string $type
     * @param array $select_data
     * @param bool $description
     * @param string $class
     */
	private function add_field( $name, $title, $page, $section = 'default', $type = 'text', $select_data = array( ), $description = false,  $class = 'regular-text' ) {
		// GENERAL SECTION # FIELD
		add_settings_field(
			'cjsp-' . $section . '-' . $name,
			$title,
			array( $this, 'renderField' ),
			$page,
			$section,
			$args = array(
				'name'  => $name,
				'title' => $title,
				'type'  => $type,
				'class' => $class,
                'description' => $description,
                'data' => $select_data,
			)
		);
	}

	private function renderSettings() {
		?>
		<h2>General Settings <span class="cjbl-small-header"><?php echo CJBL_PLUGIN_REAL_NAME ?></span></h2>
		<?php
	}

	private function renderSection() {

	}

    /**
     * Renders the correct field with the data from $this->add_field()
     *
     * @param $args
     */
	private function renderField( $args ) {
        if ( $args['type'] == 'textarea' ) : ?>
            <textarea id="cjsp-<?php echo $args['section'] ?>-<?php echo $args['name'] ?>" name="cjsp[<?php echo $args['name'] ?>]" class="<?php echo $args['class'] ?> code ">
            <?php echo CJSP::get_option( $args['name'] ) ?>
            </textarea>
        <?php elseif ( $args['type'] == 'select' ) : ?>
            <select id="cjsp-<?php echo $args['section'] ?>-<?php echo $args['name'] ?>" name="cjsp[<?php echo $args['name'] ?>]" class="<?php echo $args['class'] ?> code ">
                <option></option>

                <?php foreach( $args['data'] as $key => $value ) : ?>
                <option value="<?php echo $key ?>" <?php CJSP_Helper::is_selected( $key, CJSP::get_option( $args['name'] ) ) ?>><?php echo $value ?></option>
                <?php endforeach; ?>

            </select>
        <?php else : ?>
            <input id="cjsp-<?php echo $args['section'] ?>-<?php echo $args['name'] ?>" name="cjsp[<?php echo $args['name'] ?>]" class="<?php echo $args['class'] ?> code " type="<?php echo $args['type'] ?>"
                   value="<?php echo CJSP::get_option( $args['name'] ) ?>"/>
        <?php endif; ?>

        <?php if ( $args['description'] ) : ?>
        <p class="description"><?php echo $args['description'] ?></p>
        <?php endif;
	}

	private function renderMainPage() {

    }

    private function renderSubPage() {

    }

	private function renderLogs() {
		$logs = CJSP::get_logs();
		?>
		<div class="wrap" id="cjsp-logs">
			<h2>Logs <span class="cjsp-small-header"><?php echo CJSP_PLUGIN_NAME ?></span></h2>
			<table class="widefat fixed">
				<thead>
				<tr>
					<th id="cjsp-time" class="manage-column" scope="col">Time</th>
					<th id="cjsp-action" class="manage-column" scope="col">Action</th>
					<th id="cjsp-description" class="manage-column" scope="col">Description</th>
					<th id="cjsp-file-line" class="manage-column" scope="col">File (line)</th>
				</tr>
				</thead>
				<tbody>
				<?php
				$i = 0;
				foreach ( $logs as $value ) :
					?>
					<tr class="<?php echo $i % 2 ?: 'alternate';
					$i ++ ?>">
						<td><?php echo date( 'd/m/Y h:i:s', $value['time'] ) ?></td>
						<td><span><?php echo $value['action'] ?></span></td>
						<td><?php echo $value['description'] ?></td>
						<td><?php echo $value['file'] ?></td>
					</tr>
					<?php if ( $i >= 100 ) {
					break;
				} endforeach; ?>
				</tbody>
			</table>
		</div>
		<?php
	}

	public static function load(  ) {
	    $page = new self();

		add_action('admin_menu', $page->addAdminPage());
		add_action('admin_init', $page->configure());
	}
}

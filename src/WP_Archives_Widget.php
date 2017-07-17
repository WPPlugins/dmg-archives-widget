<?php
Namespace DMG\WP_Archives_Widget;

/*
	Archive list widget class.

    Copyright (C) 2016  Dan Gifford

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */


Use DMG\WP_Widget_Base\WP_Widget_Base;


class WP_Archives_Widget extends WP_Widget_Base
{
    public function __construct()
    {
        // Instantiate the parent object
        parent::__construct( 
            'dmg_archives_widget',
            __('DMG Archives List'), 
            [
                'classname' => 'widget_archives_list', 
                'description' => __( "Displays links to archive pages in a list pr dropdown.")
            ] 
        );
    }



    public function widget( $args, $instance )
    {
        $count          = ! empty( $instance['count'] ) ? '1' : '0';
        $dropdown       = ! empty( $instance['dropdown'] ) ? '1' : '0';
        $list_class     = ! empty( $instance['list_class'] ) ? $instance['list_class'] : '';

        echo $args['before_widget'];
        echo $this->getTitle( $args, $instance, $this->id_base . '_title' );

        if ( $dropdown ) {
?>
        <select name="archive-dropdown" onchange='document.location.href=this.options[this.selectedIndex].value;'>
            <option value=""><?php esc_attr_e( 'Select Month' ); ?></option>

            <?php
            /**
             * Filter the arguments for the Archives widget drop-down.
             *
             * @since 2.8.0
             *
             * @see wp_get_archives()
             *
             * @param array $args An array of Archives widget drop-down arguments.
             */
            wp_get_archives( apply_filters( 'widget_archives_dropdown_args', array(
                'type'            => 'monthly',
                'format'          => 'option',
                'show_post_count' => $count
            ) ) );
?>
        </select>
<?php
        } else {
?>
        <ul class="<?=$list_class?>">
<?php
        /**
         * Filter the arguments for the Archives widget.
         *
         * @since 2.8.0
         *
         * @see wp_get_archives()
         *
         * @param array $args An array of Archives option arguments.
         */
        wp_get_archives( apply_filters( 'widget_archives_args', array(
            'type'            => 'monthly',
            'show_post_count' => $count
        ) ) );
?>
        </ul>
<?php
        }

        echo $args['after_widget'];
    }



    public function update( $new_instance, $old_instance )
    {
        $instance = $old_instance;

        $instance['title']          = strip_tags($new_instance['title']);
        $instance['count']          = !empty($new_instance['count']) ? 1 : 0;
        $instance['dropdown']       = !empty($new_instance['dropdown']) ? 1 : 0;
        $instance['list_class']     = strip_tags($new_instance['list_class']);
        $instance['title_url']      = esc_url($new_instance['title_url']);
        $instance['show_title']     = $this->sanitizeBoolean($new_instance['show_title']);

        $this->deleteCacheOptions();

        return $instance;
    }



    public function form( $instance )
    {
        $instance = wp_parse_args( (array) $instance, ['title' => '', 'count' => false, 'dropdown' => false, 'list_class' => '', 'show_title' => 1,'title_url' => ''] );

        $count          = isset( $instance['count'])            ? (bool) $instance['count'] :false;
        $dropdown       = isset( $instance['dropdown'] )        ? (bool) $instance['dropdown'] : false;

        $this->textControl( 'title', 'Title:', $this->sanitizeTitle($instance['title']) );

        $this->openAdvancedSection();

            $this->textControl( 'title_url', 'URL for the title (make the title a link):', esc_url( $instance['title_url'] ) );

            $this->booleanControl( 'show_title', 'Show the Title', $this->sanitizeBoolean( $instance['show_title'] ) );

           $this->textControl( 'list_class', 'CSS class(es) applied to list wrapper:', $this->sanitizeCSSClasses( $instance['list_class'] ) );

            $this->booleanControl( 'dropdown', 'Display as dropdown', $this->sanitizeBoolean( $instance['dropdown'] ) );

            $this->booleanControl( 'count', 'Show post counts', $this->sanitizeBoolean( $instance['count'] ) );

        $this->closeAdvancedSection();
    }
}
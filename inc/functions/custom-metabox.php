<?php

    // add the Stiles extra metabox tab to woocommerce
    if( ! function_exists( 'stiles_add_wc_extra_metaboxes_tab' ) ) 
    {
        function stiles_add_wc_extra_metaboxes_tab ( $tabs ) 
        {
            $tabs[ 'stiles_product_data_layout_tab' ] = array(
                'label'    => __( 'Stiles Media', smw_slug ),
                'target'   => 'stiles_product_data_layout',
                'class'    => 'sm_product_layout_opt',
                'priority' => 85,
            );
            
            $tabs[ 'stiles_product_data_badge_tab' ] = array(
                'label'    => __( 'Product Badge', smw_slug ),
                'target'   => 'stiles_product_badge',
                'class'    => '',
                'priority' => 80,
            );

            return $tabs;
        }
        add_filter( 'woocommerce_product_data_tabs', 'stiles_add_wc_extra_metaboxes_tab', 10, 1 );
    }

    // add layout metabox to general tab
    if ( ! function_exists( 'stiles_add_layout_metabox_to_general_tab' ) ) 
    {
        function stiles_add_layout_metabox_to_general_tab() 
        {
            global $post;

            // Single product layout field
            echo '<div id="stiles_product_data_layout" class="panel woocommerce_options_panel hidden">';

                // Product Layout Field
                echo '<div class="options_group_general">';
                    $value = get_post_meta( $post->ID, '_selectproduct_layout', true );
                    if( empty( $value ) ) $value = '0';
                    $option_arg = [
                        'id'      => '_selectproduct_layout',
                        'label'   => esc_html__( 'Select Product Layout', smw_slug ),
                        'options' =>  esc_html__('Select Product Layout', smw_slug),
                        'value'   => $value,
                    ];
                    
                    if( function_exists('smw_elementor_template') )
                    {
                        $option_arg['options'] = smw_elementor_template();
                    }
                    
                    woocommerce_wp_select( $option_arg );
                    
                echo '</div>';

                // Custom Cart Content
                echo '<div class="options_group_general">';
                    woocommerce_wp_textarea_input(
                        array(
                            'id'          => 'stiles_cart_custom_content',
                            'label'       => __( 'Custom Content for the basket page', smw_slug ),
                            'desc_tip'    => 'true',
                            'description' => __( 'If you want to show custom content on the basket page', smw_slug ),
                        )
                    );
                echo '</div>';

            echo '</div>';
        }
        
        add_action( 'woocommerce_product_data_panels', 'stiles_add_layout_metabox_to_general_tab' );
    }
    
    // add metabox to general tab
    if( ! function_exists('stiles_add_badge_metabox_to_general_tab') )
    {
        function stiles_add_badge_metabox_to_general_tab()
        {
            echo '<div id="stiles_product_badge" class="panel woocommerce_options_panel hidden">';
                woocommerce_wp_text_input( array(
                    'id'          => '_saleflash_text',
                    'label'       => __( 'Custom Product Badge Text', smw_slug ),
                    'placeholder' => __( 'New', smw_slug ),
                    'description' => __( 'Enter your prefered text for the Sales Flash. Ex: New / Free etc', smw_slug ),
                ) );
            echo '</div>';
        }
        
        add_action( 'woocommerce_product_data_panels', 'stiles_add_badge_metabox_to_general_tab' );
    }

    // Stock progress bar extra field
    if ( ! function_exists( 'stiles_total_stock_quantity_input' ) ) 
    {
        function stiles_total_stock_quantity_input() {

            echo '<div class="options_group">';
                woocommerce_wp_text_input(
                    array(
                        'id'          => 'stiles_total_stock_quantity',
                        'label'       => __( 'Initial number in stock', smw_slug ),
                        'desc_tip'    => 'true',
                        'description' => __( 'Required for the stock progress bar', smw_slug ),
                        'type'        => 'text',
                    )
                );
            echo '</div>';

        }
        add_action( 'woocommerce_product_options_inventory_product_data', 'stiles_total_stock_quantity_input' );
    }

    // Stock progress bar value store
    if ( ! function_exists( 'stiles_save_total_stock_quantity' ) ) 
    {
        function stiles_save_total_stock_quantity( $post_id ) 
        {
            $stock_quantity = ( isset( $_POST['stiles_total_stock_quantity'] ) && $_POST['stiles_total_stock_quantity'] ? wc_clean( $_POST['stiles_total_stock_quantity'] ) : '' );
            update_post_meta( $post_id, 'stiles_total_stock_quantity', $stock_quantity );
        }

        add_action( 'woocommerce_process_product_meta_simple', 'stiles_save_total_stock_quantity' );
        add_action( 'woocommerce_process_product_meta_variable', 'stiles_save_total_stock_quantity' );
        add_action( 'woocommerce_process_product_meta_grouped', 'stiles_save_total_stock_quantity' );
        add_action( 'woocommerce_process_product_meta_external', 'stiles_save_total_stock_quantity' );
    }

    // Custom Meta Data Update
    if( ! function_exists( 'stiles_save_metaboxes_of_general_tab' ) )
    {
        function stiles_save_metaboxes_of_general_tab( $post_id )
        {
            // Single Product Layout
            $selectproduct_layout = wp_kses_post( stripslashes( $_POST['_selectproduct_layout'] ) );
            update_post_meta( $post_id, '_selectproduct_layout', $selectproduct_layout );

            // Cat Page Custom Content
            $selectproduct_cart_content = wp_kses_post( stripslashes( $_POST['stiles_cart_custom_content'] ) );
            update_post_meta( $post_id, 'stiles_cart_custom_content', $selectproduct_cart_content );
            
            $saleflash_text = wp_kses_post( stripslashes( $_POST['_saleflash_text'] ) );
            update_post_meta( $post_id, '_saleflash_text', $saleflash_text);
        }
        
        add_action( 'woocommerce_process_product_meta', 'stiles_save_metaboxes_of_general_tab');
    }

    /*
    * Product Category Meta Field
    */
    function stiles_product_cat_custom_fields_init() 
    {
        add_action('product_cat_add_form_fields', 'stiles_taxonomy_add_new_meta_field', 15, 1 );
        add_action('product_cat_edit_form_fields', 'stiles_taxonomy_edit_meta_field', 15, 1 );
        add_action('edited_product_cat', 'stiles_save_taxonomy_custom_meta', 15, 1 );
        add_action('create_product_cat', 'stiles_save_taxonomy_custom_meta', 15, 1 );
    }

    //Product Category Create page
    function stiles_taxonomy_add_new_meta_field() 
    {
        ?>
        <div class="form-field term-group">
            <label for="stiles_select_category_layout"><?php esc_html_e('Category Layout', smw_slug); ?></label>
            <select class="postform" id="equipment-group" name="stiles_select_category_layout">
                <?php if( function_exists('smw_elementor_template') ) foreach ( smw_elementor_template() as $catlayout_key => $catlayout ) : ?>
                   <option value="<?php echo esc_attr( $catlayout_key ); ?>" class=""><?php echo esc_html__( $catlayout, smw_slug ); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <?php
    }

    //Product Cat Edit page
    function stiles_taxonomy_edit_meta_field( $term ) 
    {
        //getting term ID
        $term_id = $term->term_id;

        // retrieve the existing value(s) for this meta field.
        $category_layout = get_term_meta( $term_id, 'stiles_select_category_layout', true);

        ?>
            <tr class="form-field">
                <th scope="row" valign="top"><label for="stiles_select_category_layout"><?php esc_html_e( 'Category Layout', smw_slug ); ?></label></th>
                <td><select class="postform" id="stiles_select_category_layout" name="stiles_select_category_layout">
                    <?php if( function_exists('smw_elementor_template') ) foreach ( smw_elementor_template() as $catlayout_key => $catlayout ) : ?>
                        <option value="<?php echo esc_attr( $catlayout_key ); ?>" <?php selected( $category_layout, $catlayout_key ); ?>><?php echo esc_html__( $catlayout, smw_slug ); ?></option>
                    <?php endforeach; ?>
                </select></td>
            </tr>
        <?php
    }

    // Save extra taxonomy fields callback function.
    function stiles_save_taxonomy_custom_meta( $term_id ) 
    {
        $stiles_category_layout = filter_input( INPUT_POST, 'stiles_select_category_layout' );
        update_term_meta( $term_id, 'stiles_select_category_layout', $stiles_category_layout );
    }
    
    stiles_product_cat_custom_fields_init();

?>
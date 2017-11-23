<?php
/*
 * @package Inwave Athlete
 * @version 1.0.0
 * @created Mar 31, 2015
 * @author Inwavethemes
 * @email inwavethemes@gmail.com
 * @website http://inwavethemes.com
 * @support Ticket https://inwave.ticksy.com/
 * @copyright Copyright (c) 2015 Inwavethemes. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 *
 */

/**
 * Description of iw_contact
 *
 * @Developer duongca
 */
if (!class_exists('Inwave_Contact')) {

    class Inwave_Contact
    {

        private $params;

        function __construct()
        {
            $this->initParams();
            add_action('vc_before_init', array($this, 'heading_init'));
            add_shortcode('inwave_contact', array($this, 'inwave_contact_shortcode'));
            add_action('wp_ajax_nopriv_sendMessageContact', array($this, 'sendMessageContact'));
            add_action('wp_ajax_sendMessageContact', array($this, 'sendMessageContact'));
        }

        function initParams()
        {
            global $iw_shortcodes;
            $this->params = array(
                'name' => 'Contact Form',
                'description' => __('Show contact form', 'inwavethemes'),
                'base' => 'inwave_contact',
                'icon' => 'iw-default',
                'category' => 'Custom',
                'params' => array(
                    array(
                        'type' => 'textfield',
                        "holder" => "div",
                        "heading" => __("Receiver Email", "inwavethemes"),
                        "value" => "",
                        "param_name" => "receiver_email",
                        "description" => __('If not specified, Admin E-mail Address in General setting will be used', "inwavethemes")
                    ),
                    array(
                        'type' => 'textfield',
                        "heading" => __("Button text", "inwavethemes"),
                        "value" => "",
                        "param_name" => "button_text"
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => __("Show name", "inwavethemes"),
                        "param_name" => "show_name",
                        "description" => __("Show name field", 'inwavethemes'),
                        "value" => array(
                            'Yes' => 'yes',
                            'No' => 'no',
                        ),
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => __("Show email", "inwavethemes"),
                        "param_name" => "show_email",
                        "description" => __("Show email field", 'inwavethemes'),
                        "value" => array(
                            'Yes' => 'yes',
                            'No' => 'no',
                        ),
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => __("Show mobile", "inwavethemes"),
                        "param_name" => "show_mobile",
                        "description" => __("Show mobile field", 'inwavethemes'),
                        "value" => array(
                            'Yes' => 'yes',
                            'No' => 'no',
                        ),
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => __("Show website", "inwavethemes"),
                        "param_name" => "show_website",
                        "description" => __("Show website field", 'inwavethemes'),
                        "value" => array(
                            'Yes' => 'yes',
                            'No' => 'no',
                        ),
                    ),

                    array(
                        "type" => "dropdown",
                        "heading" => __("Show message", "inwavethemes"),
                        "param_name" => "show_message",
                        "description" => __("Show message field", 'inwavethemes'),
                        "value" => array(
                            'Yes' => 'yes',
                            'No' => 'no',
                        ),
                    ),
                    array(
                        "type" => "dropdown",
                        "group" => "Style",
                        "class" => "",
                        "heading" => "Style",
                        "param_name" => "style",
                        "value" => array(
                            "Default" => "",
                            "Widget" => "widget"
                        )
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Extra Class", "inwavethemes"),
                        "param_name" => "class",
                        "description" => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', "inwavethemes")
                    )
                )
            );
            $iw_shortcodes['inwave_contact'] = $this->params;
        }

        function heading_init()
        {
            if (function_exists('vc_map')) {
                // Add banner addon
                vc_map($this->params);
            }
        }

        // Shortcode handler function for list Icon
        function inwave_contact_shortcode($atts, $content = null)
        {
            extract(shortcode_atts(array(
                'receiver_email' => '',
                'button_text' => '',
                'show_name' => 'yes',
                'show_email' => 'yes',
                'show_mobile' => 'yes',
                'show_website' => 'yes',
                'show_message' => 'yes',
                'style' => '',
                'class' => ''
            ), $atts));
            ob_start();
            $class .= ' '.$style;
            ?>
            <div class="iw-contact <?php echo $class; ?>">
            <div class="row">
                <div class="ajax-overlay">
                    <span class="ajax-loading"><i class="fa fa-spinner fa-spin fa-2x"></i></span>
                </div>
                <div class="headding-bottom"></div>
                <form method="post" name="contact-form">
                    <?php if ($show_name == 'yes'): ?>
                        <div class="form-group col-md-4 col-md-6 col-xs-12">
                            <input type="text" placeholder="<?php echo __('Your Name', 'inwavethemes'); ?>"
                                   required="required" class="control" name="name">
                        </div>
                    <?php
                    endif;
                    if ($show_email == 'yes'):
                        ?>
                        <div class="form-group col-md-4 col-sm-6 col-xs-12">
                            <input type="email" placeholder="<?php echo __('Your Email', 'inwavethemes'); ?>"
                                   required="required" class="control" name="email">
                        </div>
                    <?php
                    endif;
                    if ($show_mobile == 'yes'):
                        ?>
                        <div class="form-group col-md-4 col-sm-6 col-xs-12">
                            <input type="text" placeholder="<?php echo __('Your Mobile', 'inwavethemes'); ?>"
                                   required="required" class="control" name="mobile">
                        </div>
                    <?php
                    endif;
                    if ($show_website == 'yes'):
                        ?>
                        <div class="form-group col-md-4 col-sm-12 col-xs-12">
                            <input type="text" placeholder="<?php echo __('Your Website', 'inwavethemes'); ?>"
                                   class="control" name="website">
                        </div>
                    <?php
                    endif;
                    if ($show_message == 'yes'):
                        ?>
                        <div class="form-group col-xs-12">
                            <textarea placeholder="<?php echo __('Write message', 'inwavethemes'); ?>" rows="8"
                                      class="control" required="required" id="message" name="message"></textarea>
                        </div>
                    <?php endif; ?>
                    <div class="form-group form-submit">
                        <input name="action" type="hidden" value="sendMessageContact">
                        <input name="mailto" type="hidden" value="<?php echo $receiver_email; ?>">

                        <div class="form-group col-xs-6 ">
                            <button class="btn-submit theme-bg" name="submit"
                                    type="submit"><?php echo $button_text? $button_text: __('SEND MESSAGE', 'inwavethemes'); ?></button>
                        </div>
                        <?php if ($style != 'widget'): ?>
                        <div class="form-group col-xs-6">
                            <button class="btn-submit btn-cancel" name="submit"
                                    type="submit"><?php echo __('CANCEL', 'inwavethemes'); ?></button>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="form-group col-md-12 form-message">

                    </div>
                </form>
            </div>
            </div>
            <?php
            $html = ob_get_contents();
            ob_end_clean();
            return $html;
        }

        //Ajax iwcSendMailTakeCourse
        function sendMessageContact()
        {
            $result = array();
            $result['success'] = false;
            $mailto = $_POST['mailto'];
            if(!$mailto){
                $mailto = get_option('admin_email');
            }
            $email = isset($_POST['email'])? $_POST['email'] : '';
            $name = isset($_POST['name'])? $_POST['name'] : '';
            $mobile = isset($_POST['mobile'])? $_POST['mobile'] : '';
            $website = isset($_POST['website'])? $_POST['website'] : '';
            $message = isset($_POST['message'])? $_POST['message'] : '';
            $title = __('Email from Contact Form', 'inwavethemes') . ' ['. $email.']';

            $html =  __('This email was sent from contact form', 'inwavethemes') . "\n";

            if ($name) {
                $html .=  __('Name', 'inwavethemes') . ': ' . $name . "\n";
            }
            
			if(!is_email($email)){
				$result['message'] = __('Please enter a valid email!', 'inwavethemes');
				echo json_encode($result);
				exit();
			}
			$html .=  __('Email', 'inwavethemes') . ': ' . $email . "\n";
				
            
            if ($mobile) {
				if(!preg_match( '/^[+]?[0-9() -]*$/', $mobile )){
					$result['message'] = __('Please enter a valid mobile number!', 'inwavethemes');
					echo json_encode($result);
					exit();
				}
                $html .= __('Mobile', 'inwavethemes') . ': ' . $mobile . "\n";
            }
            if ($website) {
                $html .= __('Website', 'inwavethemes') . ': ' . $website . "\n";
            }
            if ($message) {
                $html .= __('Message', 'inwavethemes') . ': ' . $message . "\n";
            }

            // To send HTML mail, the Content-type header must be set
            $headers = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/plain; charset=utf-8' . "\r\n";

            if (wp_mail($mailto, $title, $html, $headers)) {
                $result['success'] = true;
                $result['message'] = __('Your message was sent, we will contact you soon', 'inwavethemes');
            } else {
                $result['message'] = __('Can\'t send message, please try again', 'inwavethemes');
            }
            echo json_encode($result);
            exit();
        }

    }

}

new Inwave_Contact();
if (class_exists('WPBakeryShortCode')) {

    class WPBakeryShortCode_Inwave_Contact extends WPBakeryShortCode
    {

    }

}

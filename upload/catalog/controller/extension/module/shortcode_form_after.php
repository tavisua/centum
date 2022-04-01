<?php
class ControllerExtensionModuleShortcodeFormAfter extends Controller{

    public function index(&$route, &$args, &$output){
        $this->load->model('setting/setting');
        $status = $this->model_setting_setting->getSettingValue('shortcode_form_status');
        if(!$status){
            return $this->registry->get('response')->getOutput();
        }
        $form_mask = $this->model_setting_setting->getSettingValue('shortcode_form_mask');
        $output = $this->registry->get('response')->getOutput();
        $output = str_replace($form_mask, $this->htmlForm(), $output);
        $this->registry->get('response')->setOutput($output);
        return $output;
    }

    private function htmlForm(){
        $this->load->language('extension/module/feedback_form');
        $url = $this->url->link('extension/module/shortcode_feedback_form', 'user_token=' . $this->session->data['user_token'], true);
        $html = '<div class="table-responsive">
            <form action="' . $url . '" method="post" enctype="multipart/form-data" id="feedback-form" class="form-horizontal">
                <input type="hidden" name="redirect_to" value="' . $this->registry->get('request')->server['REQUEST_URI'] . '">
               <table class="table table-bordered">
               <tbody>';
        $name = isset($this->session->data['params']['name']) ? $this->session->data['params']['name'] : '';
        $html .= '<tr><td class="text-left"><input class="form-control" value="' . $name .'" type="text" name="name" placeholder="' . $this->language->get('placeholder_name') . '"></td></tr>';
        if(isset($this->session->data['error']['empty_name'])){
            $html .= '<tr><td class="text-left text-danger">' . $this->session->data['error']['empty_name'] . '</td></tr>';
        }
        $phone = isset($this->session->data['params']['phone']) ? $this->session->data['params']['phone'] : '';
        $html .= '<tr><td class="text-left"><input class="form-control" type="tel" value="' . $phone . '" name="phone" placeholder="' . $this->language->get('placeholder_phone') . '"></td></tr>';
        if(isset($this->session->data['error']['phone_error'])){
            $html .= '<tr><td class="text-left text-danger">' . $this->session->data['error']['phone_error'] . '</td></tr>';
        }
        $email = isset($this->session->data['params']['email']) ? $this->session->data['params']['email'] : '';
        $html .= '<tr><td class="text-left"><input class="form-control" value="' . $email .'" type="email" name="email" placeholder="' . $this->language->get('placeholder_email') . '"></td></tr>';
        if(isset($this->session->data['error']['email_error'])){
            $html .= '<tr><td class="text-left text-danger">' . $this->session->data['error']['email_error'] . '</td></tr>';
        }
        $html .= '<tr><td class="text-left"><input type="submit" value="' . $this->language->get('entry_submit') . '"></td></tr>
               </tbody>
                </table>            
            </form>
            </div>';
        if(isset($this->session->data['success'])) {
            $html .= '<div class="alert alert-success alert-dismissible" ><i class="fa fa-check-circle" ></i > ' . $this->session->data['success'] . '</div >';
        }
        unset($this->session->data['error']);
        unset($this->session->data['success']);
        unset($this->session->data['params']);
        return $html;
    }
}


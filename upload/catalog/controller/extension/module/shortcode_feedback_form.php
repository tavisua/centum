<?php
class ControllerExtensionModuleShortcodeFeedbackForm extends Controller{
    private $error = [];

    public function index(){

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->load->model('extension/shortcode_form/feedback');
            $this->model_extension_shortcode_form_feedback->saveFeedback($this->request->post);
            $this->session->data['success'] = $this->language->get('text_success');
        }
        $this->session->data['error'] = $this->error;
        $this->session->data['params'] = $this->request->post;
        $this->response->redirect($this->request->post['redirect_to']);
    }

    private function validate(){
        $this->load->language('extension/module/feedback_form');
        if(strlen($this->request->post['name']) < 3){
            $this->error['empty_name'] = $this->language->get('empty_name');
        }
        if(!filter_var($this->request->post['email'], FILTER_VALIDATE_EMAIL)){
            $this->error['email_error'] = $this->language->get('email_error');
        }
        $phone = preg_replace("/[^0-9]/", '', $this->request->post['phone']);
        if(strlen($phone) < 7){
            $this->error['phone_error'] = $this->language->get('phone_error');
        }
        return !$this->error;
    }

}


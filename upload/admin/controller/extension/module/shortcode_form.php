<?php

class Controllerextensionmoduleshortcodeform extends Controller{
    private $error = [];

    public function index(){

        $this->load->model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

            $this->model_setting_setting->editSetting('shortcode_form', $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));

        }

        $this->load->language('extension/module/shortcode_form');
        $this->document->setTitle($this->language->get('heading_title'));

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_extension'),
            'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['user_token'] . '&type'),
        );
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['user_token'], true)
        );
        $data['action'] = $this->url->link('extension/module/shortcode_form', 'user_token=' . $this->session->data['user_token'], true);

        $data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);


        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $data['shortcode_form_mask'] = $this->model_setting_setting->getSettingValue('shortcode_form_mask');
        $data['shortcode_form_status'] = $this->model_setting_setting->getSettingValue('shortcode_form_status') == 1;

        if (isset($this->error['error_mask'])) {
            $data['error_mask'] = $this->error['error_mask'];
        } else {
            $data['error_mask'] = '';
        }
        $this->load->model('extension/shortcode_form/feedback');
        $data['feedback_list'] = $this->model_extension_shortcode_form_feedback->feedbackList();
        $this->response->setOutput($this->load->view('extension/module/shortcode_form', $data));
    }

    protected function validate() {
        if (!$this->user->hasPermission('modify', 'extension/module/shortcode_form')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (strlen($this->request->post['shortcode_form_mask']) > 0 && ((substr($this->request->post['shortcode_form_mask'], 0, 3) != '{# ') || (substr($this->request->post['shortcode_form_mask'], strlen($this->request->post['shortcode_form_mask']) - 3) != ' #}'))) {
            $this->error['error_mask'] = $this->language->get('error_mask');
        }

        return !$this->error;
    }

    public function install(){
        $this->load->model('setting/event');
        $this->model_setting_event->addEvent('shortcode_form', 'catalog/controller/information/information/after',
            'extension/module/shortcode_form_after', $status = 1, $sort_order = 0);
        $this->load->model("extension/shortcode_form/shortcode_form");
        $this->model_extension_shortcode_form_shortcode_form->createFeedbackTable();
    }

    public function uninstall(){
        $this->load->model('setting/event');
        $this->model_setting_event->deleteEventByCode('shortcode_form');

        $this->load->model("extension/shortcode_form/shortcode_form");
        $this->model_extension_shortcode_form_shortcode_form->deleteFeedbackTable();
    }
}

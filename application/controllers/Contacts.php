<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Contacts extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('email');
    }

    public function index()
    {
        $head = array();
        $data = array();
        if (isset($_POST['message'])) {
            $result = $this->sendEmail();
            if ($result) {
                $this->session->set_flashdata('resultSend', 'Email is sened!');
            } else {
                $this->session->set_flashdata('resultSend', 'Email send error!');
            }
            redirect('contacts');
        }
        $head['title'] = 'Title information?';
        $head['description'] = 'Description info';
        $head['keywords'] = 'key,words,for,seo';
        $this->render('contacts', $head, $data);
    }

    private function sendEmail()
    {
        $myEmail = $this->Admin_model->getValueStore('contactsEmailTo');
        if (filter_var($myEmail, FILTER_VALIDATE_EMAIL) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $this->load->library('email');

            $this->email->from($_POST['email'], $_POST['name']);
            $this->email->to($myEmail);

            $this->email->subject($_POST['subject']);
            $this->email->message($_POST['message']);

            $this->email->send();
            return true;
        }
        return false;
    }

}

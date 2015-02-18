<?php
class Build_pdf extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('pdf/xml_parser');
        $this->load->library('pdf/risk_register_pdf');

        // Load MongoDB library instead of native db driver if required
        $this->config->item('use_mongodb', 'ion_auth') ?
                        $this->load->library('mongo_db') :
                        $this->load->database();

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');
        $this->load->helper('language');

        $this->user_group = $this->config->item('user_group', 'ion_auth');
        $this->account_status_list = $this->config->item('account_status', 'ion_auth');
    }

    function index() {

        $pdf = new Risk_register_pdf('L');

        $style_xml = simplexml_load_file(base_url().'resources/pdf/xml/docx_style/risk_register_style.xml');
        $arr = json_decode(json_encode($style_xml), TRUE);
        $style_array = $arr['document'];
        
        $xml = simplexml_load_file(base_url().'resources/pdf/xml/Generated_XML (10).xml');
        $arr = json_decode(json_encode($xml), TRUE);

        $pdf->load_data($arr, $style_array);
        $pdf->AddPage();
        $pdf->AliasNbPages();
        $pdf->generate_pdf();
        $file_path = '././assets/receipt/';
        
        $file_name = uniqid(date("d-m-yy")).'.pdf';
        $pdf->Output($file_path.$file_name, 'F');
        
        echo "Your generated pdf is : ".$file_path.$file_name;
       
    }

}
?>

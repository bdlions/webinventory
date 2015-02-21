<?php

require('pdf.php');
include 'style/paragraph.php';
include 'style/table.php';
include 'style/header.php';
include 'style/footer.php';
include 'style/column.php';
include 'color_converter.php';

class Sale_pdf extends PDF {

    var $data;
    var $report_request_id;
    var $firm_name;
    var $risk_register;
    var $report_date;
    var $header_height = 15;
    var $footer_height = 15;
    var $risk_register_rows = array();
    var $page_first_row = true;
    var $header;
    var $footer;
    var $table;
    var $risk_register_para;
    var $firm_para;
    var $date_para;
    var $colorConverter;
    var $report_request;

    function __construct($orientation = 'P', $unit = 'mm', $size = 'A4') {
        parent::__construct($orientation, $unit, $size);

        $this->header = new Header();
        $this->footer = new Footer();
        $this->table = new Table();

        $this->risk_register_para = new Paragraph();
        $this->firm_para = new Paragraph();
        $this->date_para = new Paragraph();
        $this->colorConverter = new ColorConverter();
    }

    public function load_data($data, $styles) {
        $this->data = $data;
        
        if (is_array($data)) {
            if (key($data[RISK_REGISTER]) == REPORT_REQUEST) {
                $this->risk_register = $data[RISK_REGISTER];
                $this->report_request = $this->risk_register[REPORT_REQUEST];
                foreach ($this->risk_register[REPORT_REQUEST] as $key => $value) {
                    if ($key == REPORT_REQUEST_ID) {
                        $this->report_request_id = $value;
                    } else if ($key == RISK_REGISTER) {
                        $this->processRiskRegister($value);
                    }
                }
            }
            if (key($data) == RISK_REGISTER) {
                $this->processRiskRegister($data[RISK_REGISTER]);
            } else if (key($data) == RISK_REGISTER_ROW) {
                $this->risk_register_rows = $data;
            }
            
            foreach ($data[RISK_REGISTER][REPORT_REQUEST][RISK_REGISTER_ROWS][RISK_REGISTER_ROW] as $key => $value) {
                if (is_array($value) && sizeof($value) > 0) {
                    array_push($this->risk_register_rows, $value);
                }
            }
        }

        $this->header = new Header($styles[HEADER]);
        $this->table = new Table($styles[TABLE]);
        $this->footer = new Footer($styles[FOOTER]);
        
        foreach ($styles[PARAGRAPHS] as $paragraphs) {
            foreach ($paragraphs as $paragraph) {
                if ($paragraph['id'] == 'risk_register') {
                    $this->risk_register_para = new Paragraph($paragraph);
                } else if ($paragraph['id'] == 'firm') {
                    $this->firm_para = new Paragraph($paragraph);
                } else if ($paragraph['id'] == 'date') {
                    $this->date_para = new Paragraph($paragraph);
                }
            }
        }
    }

    function processRiskRegister($riskRegister) {
        foreach ($riskRegister as $key => $value) {
            if ($key == REPORT_DATE) {
                $this->report_date = $value;
            }
            if (is_array($value) && sizeof($value) > 0) {
                if ($key == RISK_REGISTER_ROWS) {
                    $this->risk_register_rows = $value;
                }
            }
        }
    }

    function generate_pdf() {


        $this->SetFont($this->risk_register_para->font_family, $this->risk_register_para->font_weight, $this->risk_register_para->font_size);
        $this->colorConverter->convertHex2RGB($this->risk_register_para->font_color);
        $this->SetTextColor($this->colorConverter->r, $this->colorConverter->g, $this->colorConverter->b);
        $this->Cell(0, 60, $this->report_request[REPORT_REQUEST_ID], 0, 1);

        $style = array('width' => 0.4, 'color' => array(79, 129, 189));
        $this->Line(10, 50, 285, 50, $style);

        $this->SetXY($this->GetX(), 55);

        $this->SetFont($this->firm_para->font_family, $this->firm_para->font_weight, $this->firm_para->font_size);
        $this->colorConverter->convertHex2RGB($this->firm_para->font_color);
        $this->SetTextColor($this->colorConverter->r, $this->colorConverter->g, $this->colorConverter->b);
        $this->Cell(0, DEFAULT_CELL_HEIGHT, "Customer name: " . $this->firm_name, 0, 1);

        $this->SetXY($this->GetX() + $this->LineWidth - 70, 55);
        
        //$this->SetXY($this->GetX() + $this->LineWidth - 70, 34);
        $this->SetFont($this->date_para->font_family, $this->date_para->font_weight, $this->date_para->font_size);
        $this->colorConverter->convertHex2RGB($this->date_para->font_color);
        $this->SetTextColor($this->colorConverter->r, $this->colorConverter->g, $this->colorConverter->b);
        $this->Cell(0, DEFAULT_CELL_HEIGHT, "Date: " . $this->report_date, 0, 1);

        $this->SetAutoPageBreak(false);
        //$this->SetFont('Times', '', 12);
        //$this->SetTextColor(0,0,0);
        //$this->SetDrawColor(190, 190, 190);
        
        $this->SetXY($this->GetX(), $this->GetY() + 5);
        $row_count = 1;
        $col_data = array();
        foreach ($this->risk_register_rows as $value) {

            $sra_riks_id = $this->getCellValue($value, SRA_RISK_ID);
            $date = $this->getCellValue($value, DATE);
            $source_register = $this->getCellValue($value, SOURCE_REGISTER);
            $practice_area = $this->getCellValue($value, PRACTICE_AREA);
            $trigger_event = $this->getCellValue($value, TRIGGER_EVENT);
            $compliance_officer = $this->getCellValue($value, COMPLIANCE_OFFICER);
            $action_taken = $this->getCellValue($value, ACTION_TAKEN);
            $comments = $this->getCellValue($value, COMMENTS);

            
            $col_data = array();
            array_push($col_data, 
                array(
                    'id' => SRA_RISK_ID,
                    'cell_width' => 25, 
                    'cell_value' => $sra_riks_id, 
                    'cell_style' => $this->getColumnStyleById(SRA_RISK_ID)
                ), 
                array(
                    'id' => DATE, 
                    'cell_width' => 60, 
                    'cell_value' => $date, 
                    'cell_style' => $this->getColumnStyleById(DATE)
                ), 
                array(
                    'id' => SOURCE_REGISTER, 
                    'cell_width' => 50, 
                    'cell_value' => $source_register, 
                    'cell_style' => $this->getColumnStyleById(SOURCE_REGISTER)
                ), 
                array(
                    'id' => PRACTICE_AREA, 
                    'cell_width' => 60, 
                    'cell_value' => $practice_area, 
                    'cell_style' => $this->getColumnStyleById(PRACTICE_AREA)
                ), 
                array(
                    'id' => TRIGGER_EVENT, 
                    'cell_width' => 80, 
                    'cell_value' => $trigger_event, 
                    'cell_style' => $this->getColumnStyleById(TRIGGER_EVENT)
                )
//                array(
//                    'id' => COMPLIANCE_OFFICER, 
//                    'cell_width' => 35, 
//                    'cell_value' => $compliance_officer, 
//                    'cell_style' => $this->getColumnStyleById(COMPLIANCE_OFFICER)
//                ), 
//                array(
//                        'id' => ACTION_TAKEN, 
//                    'cell_width' => 50, 
//                    'cell_value' => $action_taken,
//                    'cell_style' => $this->getColumnStyleById(ACTION_TAKEN)
//                ), array(
//                    'id' => COMMENTS, 
//                    'cell_width' => 40, 
//                    'cell_value' => $comments, 
//                    'cell_style' => $this->getColumnStyleById(COMMENTS)
//                )
            );

            //the height that we need to add new row
            $row_height = $this->getEssentialRowHeight($col_data);
            //Issue a page break first if needed
            if ($this->isPageBreakNeeded($row_height, $this->footer_height) && $this->page_first_row != true) {
                $this->addPageBreak($row_height, $this->header_height, $this->footer_height);
                $this->page_first_row = true;
            }

            if ($this->page_first_row == true) {
                $this->addTableHeader($this->table->header, $this->table, $col_data);
                $row_height = $this->getEssentialRowHeight($col_data);

                if ($this->isPageBreakNeeded($row_height, $this->footer_height)) {
                    $is_splitting_possible = $this->splitRow($col_data, $this->footer_height);
                    $this->addRow($is_splitting_possible[0], $row_count, $this->table);

                    while ($is_splitting_possible [1]) {
                        $this->addPageBreak($row_height, $this->header_height, $this->footer_height);
                        //$this->addTableHeader($this->table->header,  $this->table, $col_data);
                        $is_splitting_possible = $this->splitRow($is_splitting_possible [1], $this->footer_height);
                        $this->addRow($is_splitting_possible[0], $row_count, $this->table);
                    }
                } else {
                    $this->addRow($col_data, $row_count, $this->table);
                }

                $this->page_first_row = false;
            } else {
                //drawing data and set next line
                $this->addRow($col_data, $row_count, $this->table);
            }
            $row_count++;
        }
        
        $this->SetY(-20);
        $this->SetFont($this->date_para->font_family, $this->date_para->font_weight, $this->date_para->font_size);
        $this->colorConverter->convertHex2RGB($this->date_para->font_color);
        $this->SetTextColor($this->colorConverter->r, $this->colorConverter->g, $this->colorConverter->b);
        //$this->Cell(0, DEFAULT_CELL_HEIGHT, "Signature: " . $this->report_date, 0, 1);
        $this->Cell(0, DEFAULT_CELL_HEIGHT, "Signature: " . $this->report_date, 0, 1);
    }

    function getColumnStyleById($id) {
        foreach ($this->table->cols as $cols) {
            foreach ($cols as $col){
                if ($col['id'] == $id) {
                    return $col;
                }
            }
        }
        return false;
    }

    // Page header
    function Header() {
        // Move to the right
        $this->Cell(80);
        // Logo
        //image(filename, x, y, width)
        $this->Image(base_url() . 'resources/pdf/images/' . $this->header->src, $this->header->x, $this->header->y, $this->header->width, $this->header->height);
        $this->Ln();
    }

    // Page footer
    function Footer() {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Logo
        //image(filename, x, y, width)

//        $this->Image(base_url() . 'resources/pdf/images/' . $this->footer->src, $this->footer->x, $this->GetY(), $this->footer->width);
        // Arial italic 8
        $this->SetFont('Times', '', 12);
        // Page number
        $this->Cell(530, 10, 'Page ' . $this->PageNo() . ' of {nb}', 0, 0, 'C');
    }

}

?>

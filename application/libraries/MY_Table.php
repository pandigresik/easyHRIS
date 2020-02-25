<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class MY_Table extends CI_Table
{
    public $extra_columns = array();
    public $extra_header = array();
    public $key_record = array();
    public $hiddenField = [];
    public $withNumber = true;
    private $startNumber = 1;

    public function __construct(array $config = array())
    {
        parent::__construct($config);        
    }

    // --------------------------------------------------------------------

    /**
     * Generate the table.
     *
     * @param mixed $table_data
     *
     * @return string
     */
    public function generate($table_data = null)
    {
        // The table data can optionally be passed to this function
        // either as a database result object or an array
        if (!empty($table_data)) {
            if ($table_data instanceof CI_DB_result) {
                $this->_set_from_db_result($table_data);
            } elseif (is_array($table_data)) {
                $this->_set_from_array($table_data);
            }
        }

        // Is there anything to display? No? Smite them!
        if (empty($this->heading) && empty($this->rows)) {
            return 'Undefined table data';
        }

        // Compile and validate the template date
        $this->_compile_template();

        // Validate a possibly existing custom cell manipulation function
        if (isset($this->function) && !is_callable($this->function)) {
            $this->function = null;
        }

        // Build the table!

        $out = $this->template['table_open'].$this->newline;

        // Add any caption here
        if ($this->caption) {
            $out .= '<caption>'.$this->caption.'</caption>'.$this->newline;
        }

        // Is there a table heading to display?
        if (!empty($this->heading)) {
            if(!empty($this->extra_columns)){
                $this->extra_header = empty($this->extra_header) ? [['data' => 'Aksi', 'rowspan' => count($this->heading)]] : $this->extra_header;                
            }
            
            if(!empty($this->extra_header)){
                foreach($this->extra_header as $_extra_header){
                    array_push($this->heading[0],$_extra_header);
                }
            }
            if ($this->withNumber) {
                array_unshift($this->heading[0], ['data' => 'No', 'rowspan' => count($this->heading)]);
            }
            $out .= $this->template['thead_open'].$this->newline;
            foreach ($this->heading as $headings) {
                $out .= $this->template['heading_row_start'].$this->newline;
                foreach ($headings as $heading) {
                    $temp = $this->template['heading_cell_start'];
                    foreach ($heading as $key => $val) {
                        if ($key !== 'data') {
                            $temp = str_replace('<th', '<th '.$key.'="'.$val.'"', $temp);
                        }
                    }

                    $out .= $temp.(isset($heading['data']) ? $heading['data'] : '').$this->template['heading_cell_end'];
                }
                $out .= $this->template['heading_row_end'].$this->newline;
            }
            $out .= $this->template['thead_close'].$this->newline;
        }

        // Build the table rows
        if (!empty($this->rows)) {
            $out .= $this->template['tbody_open'].$this->newline;

            $i = 1;
            foreach ($this->rows as $row) {
                if (!is_array($row)) {
                    break;
                }

                // We use modulus to alternate the row colors
                $name = fmod($i++, 2) ? '' : 'alt_';

                if (!empty($this->key_record)) {
                    $tmp_key = array();
                    foreach ($this->key_record as $_v) {
                        $tmp_key[$_v] = $row[$_v]['data'];
                    }
                    $out .= substr($this->template['row_'.$name.'start'], 0, strlen($this->template['row_'.$name.'start']) - 1).' data-key=\''.json_encode($tmp_key).'\'>'.$this->newline;
                } else {
                    $out .= $this->template['row_'.$name.'start'].$this->newline;
                }

                if (!empty($this->extra_columns)) {
                    $row = array_merge($row, $this->extra_columns);
                }
                if ($this->withNumber) {
                    array_unshift($row, ['data' => $this->startNumber]);
                    ++$this->startNumber;
                }

                foreach ($row as $indexCell => $cell) {
                    $temp = $this->template['cell_'.$name.'start'];
                    if (!empty($this->hiddenField)) {
                        if (in_array($indexCell, $this->hiddenField)) {
                            if (!empty($indexCell)) {
                                continue;
                            }
                            //die();
                        }
                    }

                    foreach ($cell as $key => $val) {
                        if ($key !== 'data') {
                            $temp = str_replace('<td', '<td '.$key.'="'.$val.'"', $temp);
                        }
                    }

                    $cell = isset($cell['data']) ? $cell['data'] : '';
                    $out .= $temp;

                    if ($cell === '' or $cell === null) {
                        $out .= $this->empty_cells;
                    } elseif (isset($this->function)) {
                        $out .= call_user_func($this->function, $indexCell, $cell);
                    } else {
                        $out .= $cell;
                    }

                    $out .= $this->template['cell_'.$name.'end'];
                }

                $out .= $this->template['row_'.$name.'end'].$this->newline;
            }

            $out .= $this->template['tbody_close'].$this->newline;
        }

        $out .= $this->template['table_close'];

        // Clear table class properties before generating the table
        $this->clear();

        return $out;
    }

    public function setStartNumber($number)
    {
        $this->startNumber = $number;
    }

    private function is_multi_array($arr)
    {
        rsort($arr);

        return isset($arr[0]) && is_array($arr[0]);
    }

    /**
     * Set the value of withNumber.
     *
     * @return self
     */
    public function setWithNumber($withNumber)
    {
        $this->withNumber = $withNumber;
    }

    /**
     * Get the value of hiddenField.
     */
    public function getHiddenField()
    {
        return $this->hiddenField;
    }

    /**
     * Set the value of hiddenField.
     *
     * @return self
     */
    public function setHiddenField($hiddenField)
    {
        $this->hiddenField = $hiddenField;
    }
}

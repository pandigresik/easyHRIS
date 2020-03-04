<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Crud extends MX_Controller
{
	private $sm;	
	private $primaryKey;
	const SKIP_COLUMN = ['id','deleted_at','created_at','updated_at','created_by','updated_by'];
	public function __construct() {
		parent::__construct();
		$this->load->helper('inflector');
		$dbConfig = $this->db;
		$connectionParams = array(
			'dbname' => $dbConfig->database,
			'user' => $dbConfig->username,
			'password' => $dbConfig->password,
			'host' => '127.0.0.1',
			'driver' => 'pdo_mysql',
		);
		\Doctrine\DBAL\Types\Type::addType('uuid', 'Ramsey\Uuid\Doctrine\UuidType');		
		$conn = \Doctrine\DBAL\DriverManager::getConnection($connectionParams);
		$this->sm = $conn->getSchemaManager();
		$this->sm->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
	}
	
    public function index()
    {
		$data = array(
			'table_name' => $this->input->post('table_name'),
			'module' => $this->input->post('module'),
			'controller' => $this->input->post('controller'),
			'model' => $this->input->post('model'),
			'form_element' => $this->input->post('form_element'),
			'field_table' => array()
		);
		$listTables = [];
		foreach($this->sm->listTables() as $table){			
			array_push($listTables,$table->getName());
		}
		$data['tables'] = $listTables;//$this->db->list_tables();
		if(empty($data['form_element'])){
			if(!empty($data['table_name'])){				
				$data['module'] = $this->setModuleName(singular($data['table_name']));
				$data['controller'] = $this->setControllerName($data['table_name']);
				$data['model'] = $this->setModelName(singular($data['table_name'])).'_model';
				$data['field_table'] = [];//$this->db->field_data($data['table_name']);				
				$columns = $this->sm->listTableColumns($data['table_name']);			
				foreach($columns as $column){
					array_push($data['field_table'],$column);					
				}				
			}
		}else{
			/** generate code */
			$hasilGenerate = $this->generate($data);
			echo 'File yang telah digenerate adalah <div>'.implode('</div><div>',$hasilGenerate).'</div>';
			return;
		}
        $this->load->view('crud_generator', $data);
    }

	private function generate($data){
		$result = [];
		$module = APPPATH.'modules'.DIRECTORY_SEPARATOR.$data['module'];
		$controller = $module.DIRECTORY_SEPARATOR.'controllers'.DIRECTORY_SEPARATOR.$data['controller'].'.php';
		$sekarang = date('Y-m-d H:i:s');
		$modelStorage = APPPATH.'models';
		$model = $modelStorage.DIRECTORY_SEPARATOR.$data['model'].'.php';
		$this->createModule($module);
		$dataController = ['controller' => $data['controller'], 'model' => $data['model'],'alias' => strtolower($data['model']), 'title' => 'Data '.$data['controller'], 'created_at' => $sekarang];
		$contentController = $this->load->view('generator/template/controller',$dataController,TRUE);
		$result[] = $this->createFile($controller,$contentController);
		$dataModel = ['created_at' => $sekarang,'namaModel' => $data['model']];
		//$detailInfo = $this->detailTableInfo($data['table_name']);
        //$form = $this->generateColumnField($detailInfo);
		$dataModel = array_merge($dataModel,$this->setDataModelTemplate($data));
		$contentModel = $this->load->view('generator/template/model',$dataModel,TRUE);	
		$result[] = $this->createFile($model,$contentModel);

		return $result;
	}

	private function setDataModelTemplate($data){
		$_formElement = [];
		$_inform = $data['form_element']['inform'];
		$_alias = $data['form_element']['alias'];
		$_required = $data['form_element']['required'];
		$_options = $data['form_element']['options'];
		foreach($_inform as $_f){
			$_label = !empty($_alias[$_f]) ? $_alias[$_f] : $_f;
			$_type = $_options[$_f];
			$_tmp = <<<ARR
			'{$_f}' => [
				'id' => '{$_f}',
				'label' => '{$_label}',
				'placeholder' => 'Isikan {$_label}',
				'type' => '{$_type}',
				'value' => '',	
ARR;
			if(isset($_required[$_f])){
			$_tmp .= <<<ARR

				'required' => 'required'	
ARR;
			}	
			$_tmp .= <<<ARR

			]	
ARR;
			array_push($_formElement,$_tmp);
		}
		$_tmp = <<<ARR

		'submit' => [
            'id' => 'submit',
            'type' => 'submit',
            'label' => 'Simpan'
        ]
ARR;
		array_push($_formElement,$_tmp);

		$fields = $this->db->field_data($data['table_name']);
		$primaryKey = $fields[0]->name;
		return [
			'heading' => '\''.implode('\',\'',$data['form_element']['heading']).'\'',
			'headerTable' => $this->generateHeaderTable($data['form_element']['heading'],$_alias),
			'formElement' => implode(',',$_formElement),
			'namaTable' => $data['table_name'],
			'primaryKey' => $primaryKey
		];
	}

	private function createModule($module){
		$controllerModule = $module.DIRECTORY_SEPARATOR.'controllers';
		
		$this->createFolder($module);				
		$this->createFolder($controllerModule);
	}

	private function createFolder($namaFolder){
		if(!is_dir($namaFolder)){
			mkdir($namaFolder,0755,true);					
		}
	}

	private function createFile($namaFile,$content){
        $file = fopen($namaFile, "w");
        fputs($file, $content);
		fclose($file);
		return $namaFile;
	}

	private function setControllerName($nama){
		return ucfirst(strtolower($nama));
	}

	private function setModelName($nama){
		return ucfirst(strtolower($nama));
	}

	private function setModuleName($nama){
		return strtolower($nama);
	}

	private function generateHeaderTable($heading,$_alias){
		$result = [];
		foreach($heading as $h){
		$label = isset($_alias[$h]) ? $_alias[$h] : $h;	
		$template = <<<TTT
['data' => '{$label}']
TTT;
			array_push($result,$template);
		}
		$str = implode(',',$result);
		return <<<AAA
				[{$str}]
AAA;
	}

	private function detailTableInfo($table){
        $dataColumn = [];        
        $info = $this->sm->listTableDetails($table);        
        $i = 0;
        foreach($info->getcolumns() as $column){
            $tmp = $column->toArray();
            if(!$i){
                $this->setPrimaryKey($tmp['name']);
                $i++;
            }
            
            $tmp['type'] = $tmp['type']->getName();
            if(in_array($tmp['name'],self::SKIP_COLUMN)) continue;
            $dataColumn[$tmp['name']] = $tmp;
        }

        foreach($info->getForeignKeys() as $fk){
            $names = $fk->getLocalColumns();
            foreach($names as $name){
                $dataColumn[$name]['fk'] = ['table' => $fk->getForeignTableName(), 'column' => $fk->getForeignColumns()[0]];
            }
        }
        return $dataColumn;
	}
	
	private function generateColumnField($fields){
        $result = [];        
        if(!empty($fields)){
            foreach($fields as $field){
                if(in_array($field['name'],self::SKIP_COLUMN)) continue;
                array_push($result,$this->prepareGenerateColumnField($field));
            }
		}
		$_tmp = <<<ARR

		'submit' => [
            'id' => 'submit',
            'type' => 'submit',
            'label' => 'Simpan'
        ]
ARR;
		array_push($result,$_tmp);
        return $result;
    }
    private function prepareGenerateColumnField($field){
        $name = $field['name'];
        $type = 'text';
        $additionalAttr = '';
        $choices = '';
        $attr = '';
        $rules = [];
        if($field['notnull']){
            array_push($rules,'required');
        }
        if($field['length']){
			//array_push($rules,'max:'.$field['length'].'');
			//maxLength
        }
        
        if(in_array($field['type'],['date','datetime','time'])){
            switch($field['type']){
                case 'date':
                $attr =<<<STR
                'attr' => ['class_append' => 'date'],
STR;
                    break;
                case 'datetime':
                $attr =<<<STR
                'attr' => ['class_append' => 'date-time'],
STR;
                    break;
                case 'time':
                $attr =<<<STR
                    'attr' => ['class_append' => 'time'],
STR;
                        break;
            }
        }

        if(isset($field['fk'])){
            $type = 'select';
            $model = '\App\Models\\'.ucfirst(\Str::camel(\Str::singular($field['fk']['table'])));
            $columnId = $field['fk']['column'];
            $columnDisplay = $this->displayNameFk($field['fk']['table']);
            $choices = <<<STR
                'choices' => {$model}::all()->pluck('{$columnDisplay}','{$columnId}')->toArray(),
STR;
            $attr = <<<STR
                'attr' => ['class_append' => 'select2-allowclear'],
STR;
        }
        if(!empty($choices) || !empty($attr)){
            $additionalAttr .= join(PHP_EOL,[$choices,$attr]);
        }
        
        $ruleStr = !empty($rules) ? join('|',$rules) : '';
        return <<<STR
('{$name}', '{$type}',[
                'label' => __form('form.{$name}'),
                'rules' => '{$ruleStr}',{$additionalAttr}                 
            ])
STR;

    }

	/**
	 * Get the value of primaryKey
	 */ 
	public function getPrimaryKey()
	{
		return $this->primaryKey;
	}

	/**
	 * Set the value of primaryKey
	 *
	 * @return  self
	 */ 
	public function setPrimaryKey($primaryKey)
	{
		$this->primaryKey = $primaryKey;

		return $this;
	}
}

/* End of file model_generator.php */
/* Location: ./application/controllers/model_generator.php */
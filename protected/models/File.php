<?php

/**
 * This is the model class for table "file".
 *
 * The followings are the available columns in table 'file':
 * @property integer $id
 * @property string $name
 * @property string $uploaded_time
 */
class File extends CActiveRecord
{
    var $path = "upload/";
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return File the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'file';
	}

        public function behaviors(){
	return array(
		'CTimestampBehavior' => array(
			'class' => 'zii.behaviors.CTimestampBehavior',
			'createAttribute' => 'uploaded_time',
		)
	);
}
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('name', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, uploaded_time', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'projects' => array(self::HAS_MANY, 'Project', 'file_id','order'=>'name'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'uploaded_time' => 'Uploaded Time',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('uploaded_time',$this->uploaded_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
               
        public function getData(){
            $file = $this->path.$this->name;
            if(!file_exists($file)) {
                die("Datei nicht gefunden!");
                return false;
            }
            $handle = fopen ($file,"r");
            $result = array();
            $table = 0;
            $last = 0;
            $firsttable = false;
            while ( ($data = fgetcsv ($handle, 1000, ",")) !== FALSE ) {
                for($i = count($data)-1; $i >= 0; $i--){
                    if($data[$i] == ""){
                        unset($data[$i]);
                    } else {
                        break;
                    }
                }
                //$data = array_filter($data);
                $colCount = count($data);
//                echo $last . "->" . $colCount . " | ".($colCount-$last)."<br /><br />";
                if($colCount>1) $firsttable = true;
                if($firsttable){
//                    echo $colCount-$last."<br />";
//                    print_r($data);
                    if(($colCount-$last) > 1 || ($colCount-$last) < -1 || !isset($data[0]) || $data[0] == "") {
                        $table++;
//                        echo "New Table <br />";
                    }
                    if($colCount > 1)$result[$table][] = $data;
                }
                $last = count($data);
            }
            fclose ($handle);
            return $result;
            
        }

        public function getLines(){
            $file = $this->path.$this->name;
            if(!file_exists($file)) {
                die("Datei nicht gefunden!");
                return false;
            }
            $lines = file($file);
            echo count($lines);
            
        }        
}
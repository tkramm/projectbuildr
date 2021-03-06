<?php

/**
 * This is the model class for table "pcategory_project".
 *
 * The followings are the available columns in table 'pcategory_project':
 * @property integer $id
 * @property integer $category_id
 * @property integer $project_id
 * @property integer $pcategory_id
 *
 * The followings are the available model relations:
 * @property Project $project
 * @property Pcategory $pcategory
 */
class PcategoryProject extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PcategoryProject the static model class
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
		return 'pcategory_project';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('category_id, project_id, pcategory_id', 'required'),
			array('category_id, project_id, pcategory_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, category_id, project_id, pcategory_id', 'safe', 'on'=>'search'),
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
			'project' => array(self::BELONGS_TO, 'Project', 'project_id'),
			'pcategory' => array(self::BELONGS_TO, 'Pcategory', 'pcategory_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'category_id' => 'Category',
			'project_id' => 'Project',
			'pcategory_id' => 'Pcategory',
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
		$criteria->compare('category_id',$this->category_id);
		$criteria->compare('project_id',$this->project_id);
		$criteria->compare('pcategory_id',$this->pcategory_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
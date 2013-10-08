<?php

/**
 * This is the model class for table "related_part".
 *
 * The followings are the available columns in table 'related_part':
 * @property integer $id
 * @property integer $related_id
 * @property integer $part_id
 *
 * The followings are the available model relations:
 * @property Part $part
 * @property Part $related
 */
class RelatedPart extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RelatedPart the static model class
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
		return 'related_part';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('related_id, part_id', 'required'),
			array('related_id, part_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, related_id, part_id', 'safe', 'on'=>'search'),
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
			'part' => array(self::BELONGS_TO, 'Part', 'part_id'),
			'related' => array(self::BELONGS_TO, 'Part', 'related_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'related_id' => 'Related',
			'part_id' => 'Part',
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
		$criteria->compare('related_id',$this->related_id);
		$criteria->compare('part_id',$this->part_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
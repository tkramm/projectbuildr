<?php

/**
 * This is the model class for table "part_supplier".
 *
 * The followings are the available columns in table 'part_supplier':
 * @property integer $id
 * @property string $part_number
 * @property string $url
 * @property integer $supplier_id
 * @property integer $part_id
 *
 * The followings are the available model relations:
 * @property Supplier $supplier
 * @property Part $part
 * @property Price[] $prices
 */
class PartSupplier extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PartSupplier the static model class
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
		return 'part_supplier';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('part_number, supplier_id, part_id', 'required'),
			array('supplier_id, part_id', 'numerical', 'integerOnly'=>true),
			array('part_number, url', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, part_number, url, supplier_id, part_id', 'safe', 'on'=>'search'),
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
			'supplier' => array(self::BELONGS_TO, 'Supplier', 'supplier_id'),
			'part' => array(self::BELONGS_TO, 'Part', 'part_id'),
			'prices' => array(self::HAS_MANY, 'Price', 'part_supplier_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'part_number' => 'Part Number',
			'url' => 'Url',
			'supplier_id' => 'Supplier',
			'part_id' => 'Part',
		);
	}

//        protected function beforeDelete()
//
//        {
//            if(!empty($this->prices)) foreach ($this->prices as $price) $price->delete();
//            parent::beforeDelete();
//        }        
        
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
		$criteria->compare('part_number',$this->part_number,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('supplier_id',$this->supplier_id);
		$criteria->compare('part_id',$this->part_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
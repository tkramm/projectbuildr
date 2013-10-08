<?php

/**
 * This is the model class for table "item".
 *
 * The followings are the available columns in table 'item':
 * @property integer $id
 * @property integer $quantity
 * @property integer $quantity_warning
 * @property string $created
 * @property string $updated
 * @property integer $article_id
 * @property integer $location_id
 *
 * The followings are the available model relations:
 * @property Bom[] $boms
 * @property Article $article
 * @property Location $location
 */
class Item extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Item the static model class
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
		return 'item';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('quantity, quantity_warning, part_id, user_id, location_id', 'required'),
			array('quantity, quantity_warning, part_id, user_id, location_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, quantity, quantity_warning, created, updated, part_id, location_id', 'safe', 'on'=>'search'),
		);
	}

        public function behaviors(){
            return array(
                'CTimestampBehavior' => array(
                    'class' => 'zii.behaviors.CTimestampBehavior',
                    'createAttribute' => 'created',
                    'updateAttribute' => 'updated',
                )
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
			'location' => array(self::BELONGS_TO, 'Location', 'location_id'),
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'quantity' => 'Quantity',
			'quantity_warning' => 'Quantity Warning',
			'created' => 'Created',
			'updated' => 'Updated',
			'part_id' => 'Part',
			'location_id' => 'Location',
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
		$criteria->compare('quantity',$this->quantity);
		$criteria->compare('quantity_warning',$this->quantity_warning);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('updated',$this->updated,true);
		$criteria->compare('article_id',$this->part_id);
		$criteria->compare('location_id',$this->location_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function updateQuantity($q=null){
            if(is_null($q)) return;
            $this->quantity = $q;
            $this->save();
        }

        public function updateQuantityWarning($q=null){
            if(is_null($q)) return;
            $this->quantity_warning = $q;
            $this->save();
        }
        
        public function getValue(){
            return $this->part->BestPrice * $this->quantity;
        }

        public function getBulkValue(){
            return $this->part->BestBulkPrice * $this->quantity;
        }
}
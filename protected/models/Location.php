<?php

/**
 * This is the model class for table "location".
 *
 * The followings are the available columns in table 'location':
 * @property integer $id
 * @property string $location
 * @property string $assortment
 * @property string $box
 * @property integer $user_id
 *
 * The followings are the available model relations:
 * @property Item[] $items
 * @property User $user
 */
class Location extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Location the static model class
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
		return 'location';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('location, assortment, box, user_id', 'required'),
			array('user_id', 'numerical', 'integerOnly'=>true),
			array('location, assortment, box', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, location, assortment, box, user_id', 'safe', 'on'=>'search'),
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
			'items' => array(self::HAS_MANY, 'Item', 'location_id'),
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
			'location' => 'Location',
			'assortment' => 'Assortment',
			'box' => 'Box',
			'user_id' => 'User',
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
		$criteria->compare('location',$this->location,true);
		$criteria->compare('assortment',$this->assortment,true);
		$criteria->compare('box',$this->box,true);
		$criteria->compare('user_id',$this->user_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public static function getUserLocations(){
            $result = array();
            $user = User::getUser();
            $locations = $user->locations;
            foreach($locations as $location){
                $result[$location->location][$location->assortment][$location->box] = $location->id;
            }
            return $result;
        }
        
        public static function getLocations(){
            $result = array();
            $user = User::getUser();
            $locations = $user->locations;
            foreach($locations as $location){
                $result[$location->location] = $location->location;
            }
            return $result;
        }
        public static function getAssortments($loc){
            $result = array();
            
            $userLocations = Location::getUserLocations();
            foreach($userLocations[$loc] as $assortment=>$boxes){
                $result[$assortment] = $assortment;
            }
            return $result;
        }
        public static function getBoxes($loc,$ass){
            $result = array();
            
            $userLocations = Location::getUserLocations();
            foreach($userLocations[$loc][$ass] as $box=>$location_id){
                $result[$location_id] = $box;
            }
            return $result;
        }
        
        public static function createNALocation($userID = null){
            if(is_null($userID))    return null;
            $model = new Location();
            $model->location = 'N/A';
            $model->assortment = 'N/A';
            $model->box = '1';
            $model->user_id = $userID;
            if($model->save()) return $model->id;
            return null;
        }
}
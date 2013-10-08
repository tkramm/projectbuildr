<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $salt
 * @property string $email
 *
 * The followings are the available model relations:
 * @property ImageUser[] $imageUsers
 * @property Permission[] $permissions
 * @property Project[] $projects
 * @property Warehouse[] $warehouses
 */
class User extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
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
		return 'user';
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
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username, password, salt, email', 'required'),
			array('username, email', 'length', 'max'=>255),
			array('password', 'length', 'min'=>6, 'max'=>64),
			array('username', 'unique'),
			array('salt', 'length', 'max'=>10),
			array('email', 'email','checkMX'=>'true','message'=>'Please enter a valid email address.'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, username, password, salt, email', 'safe', 'on'=>'search'),
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
			'imageUsers' => array(self::HAS_MANY, 'ImageUser', 'user_id'),
			'permissions' => array(self::HAS_MANY, 'Permission', 'user_id'),
			'comments' => array(self::HAS_MANY, 'Comment', 'part_id','order'=>'created DESC'),
			'projects' => array(self::HAS_MANY, 'Project', 'created_user_id'),
			'createdParts' => array(self::HAS_MANY, 'Part', 'created_user_id'),
			'locations' => array(self::HAS_MANY, 'Location', 'user_id','order'=>'location,assortment,box'),
			'items' => array(self::HAS_MANY, 'Item', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'username' => 'Username',
			'password' => 'Password',
			'salt' => 'Salt',
			'email' => 'Email',
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
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('salt',$this->salt,true);
		$criteria->compare('email',$this->email,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public static function getUser(){
            $user = User::model()->findByPk(Yii::app()->User->id);
            return $user;
        }
        
        public static function getCurrentUser(){
            $user = User::model()->findByAttributes(array('username'=>Yii::app()->user->name));
            return $user;
        }
        
        public function getItem($part_id){
            $item = Item::model()->findByAttributes(array('user_id'=>$this->id,'part_id'=>$part_id));
            return $item;
        }
}
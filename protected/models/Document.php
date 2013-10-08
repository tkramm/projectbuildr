<?php

/**
 * This is the model class for table "document".
 *
 * The followings are the available columns in table 'document':
 * @property integer $id
 * @property string $name
 * @property string $path
 * @property string $filename
 * @property string $uploaded
 * @property integer $user_id
 * @property integer $downloads
 *
 * The followings are the available model relations:
 * @property User $user
 */
class Document extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Document the static model class
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
		return 'document';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, path, filename, user_id, downloads', 'required'),
			array('user_id, downloads', 'numerical', 'integerOnly'=>true),
			array('name, path, filename', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, path, filename, uploaded, user_id, downloads', 'safe', 'on'=>'search'),
		);
	}

        public function behaviors(){
            return array(
                'CTimestampBehavior' => array(
                    'class' => 'zii.behaviors.CTimestampBehavior',
                    'createAttribute' => 'uploaded',
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
			'name' => 'Name',
			'path' => 'Path',
			'filename' => 'Filename',
			'uploaded' => 'Uploaded',
			'user_id' => 'User',
			'downloads' => 'Downloads',
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
		$criteria->compare('path',$this->path,true);
		$criteria->compare('filename',$this->filename,true);
		$criteria->compare('uploaded',$this->uploaded,true);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('downloads',$this->downloads);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
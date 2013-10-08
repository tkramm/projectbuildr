<?php

/**
 * This is the model class for table "image".
 *
 * The followings are the available columns in table 'image':
 * @property integer $id
 * @property string $path
 * @property string $filename
 * @property string $uploaded
 *
 * The followings are the available model relations:
 * @property ArticleImage[] $articleImages
 * @property ImageProject[] $imageProjects
 * @property ImageSupplier[] $imageSuppliers
 * @property ImageUser[] $imageUsers
 */
class Image extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Image the static model class
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
		return 'image';
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
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('path, filename', 'required'),
			array('path, filename', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, path, filename, uploaded', 'safe', 'on'=>'search'),
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
			'articleImages' => array(self::HAS_MANY, 'ArticleImage', 'image_id'),
			'imageProjects' => array(self::HAS_MANY, 'ImageProject', 'image_id'),
			'imageSuppliers' => array(self::HAS_MANY, 'ImageSupplier', 'image_id'),
			'imageUsers' => array(self::HAS_MANY, 'ImageUser', 'image_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'path' => 'Path',
			'filename' => 'Filename',
			'uploaded' => 'Uploaded',
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
		$criteria->compare('path',$this->path,true);
		$criteria->compare('filename',$this->filename,true);
		$criteria->compare('uploaded',$this->uploaded,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
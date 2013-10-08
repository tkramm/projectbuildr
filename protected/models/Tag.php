<?php

/**
 * This is the model class for table "tag".
 *
 * The followings are the available columns in table 'tag':
 * @property integer $id
 * @property string $name
 * @property integer $frequency
 *
 * The followings are the available model relations:
 * @property ArticleTag[] $articleTags
 */
class Tag extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Tag the static model class
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
		return 'tag';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, frequency', 'required'),
			array('frequency', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, frequency', 'safe', 'on'=>'search'),
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
			'parts' => array(self::MANY_MANY, 'Part', 'part_tag(part_id,tag_id)'),
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
			'frequency' => 'Frequency',
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
		$criteria->compare('frequency',$this->frequency);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public static function getNames(){
            $result = array();
            $names = Yii::app()->db->createCommand()->select('name')->from('tag')->queryAll();
            foreach($names as $name) $result[] = $name['name'];
            return $result;
        }        
        
        public static function add($name){
            $tag = Tag::model()->findByAttributes(array('name'=>$name));
            if(empty($tag)){
                $tag = new Tag();
                $tag->name = $name;
                $tag->frequency = 1;
            } else {
                $tag->frequency = $tag->frequency + 1;
            }
            $tag->save();
            if($tag->save()){
                //Log::addEntry('Tag;add;'.$tag->id.':'.implode(';', $tag->attributes), 20);
            }
            
            return $tag;
        }
}
<?php

/**
 * This is the model class for table "bom".
 *
 * The followings are the available columns in table 'bom':
 * @property integer $id
 * @property integer $quantity
 * @property string $created
 * @property string $updated
 * @property integer $project_id
 * @property integer $part_id
 * @property string $note
 *
 * The followings are the available model relations:
 * @property Part $part
 * @property Project $project
 */
class Bom extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Bom the static model class
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
		return 'bom';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('quantity, project_id, part_id', 'required'),
			array('note', 'safe','on'=>'create,update'),
			array('quantity, project_id, part_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, quantity, created, updated, project_id, part_id, note', 'safe', 'on'=>'search'),
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
			'project' => array(self::BELONGS_TO, 'Project', 'project_id'),
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
			'created' => 'Created',
			'updated' => 'Updated',
			'project_id' => 'Project',
			'part_id' => 'Part',
			'note' => 'Note',
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
		$criteria->compare('created',$this->created,true);
		$criteria->compare('updated',$this->updated,true);
		$criteria->compare('project_id',$this->project_id);
		$criteria->compare('part_id',$this->part_id);
		$criteria->compare('note',$this->note,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function getInStock(){
            $part = $this->part;
            return $part->inStock;
        } 
        
}
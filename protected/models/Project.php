<?php

/**
 * This is the model class for table "project".
 *
 * The followings are the available columns in table 'project':
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $created
 * @property string $updated
 * @property integer $created_user_id
 * @property integer $updated_user_id
 * @property integer $category_id
 * @property integer $views
 * @property integer $published
 *
 * The followings are the available model relations:
 * @property Bom[] $boms
 * @property ImageProject[] $imageProjects
 * @property User $updatedUser
 * @property Category $category
 * @property User $createdUser
 */
class Project extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Project the static model class
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
		return 'project';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, description, category_id', 'required'),
			array('created_user_id, updated_user_id, category_id, views, published', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
			array('name', 'unique', 'caseSensitive'=>false,'allowEmpty'=>false),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, description, created, updated, created_user_id, updated_user_id, category_id, views, published', 'safe', 'on'=>'search'),
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
			'bom' => array(self::HAS_MANY, 'Bom', 'project_id'),
			'images' => array(self::MANY_MANY, 'Image', 'image_project(image_id,project_id)'),
			'documents' => array(self::MANY_MANY, 'Document', 'document_project(document_id,project_id)'),
			'updater' => array(self::BELONGS_TO, 'User', 'updated_user_id'),
			'category' => array(self::BELONGS_TO, 'Category', 'category_id'),
			'tags' => array(self::MANY_MANY, 'Tag', 'project_tag(project_id,tag_id)','order'=>'name'),
			'creater' => array(self::BELONGS_TO, 'User', 'created_user_id'),
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
			'description' => 'Description',
			'created' => 'Created',
			'updated' => 'Updated',
			'created_user_id' => 'Created User',
			'updated_user_id' => 'Updated User',
			'category_id' => 'Category',
			'views' => 'Views',
			'published' => 'Published',
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
		$criteria->compare('description',$this->description,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('updated',$this->updated,true);
		$criteria->compare('created_user_id',$this->created_user_id);
		$criteria->compare('updated_user_id',$this->updated_user_id);
		$criteria->compare('category_id',$this->category_id);
		$criteria->compare('views',$this->views);
		$criteria->compare('published',$this->published);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function addTag($name){
            $tag = Tag::add($name);
            $relation = ProjectTag::model()->findByAttributes(array('tag_id'=>$tag->id,'project_id'=>$this->id));
            if(empty($relation)) {
                $relation = new ProjectTag ();
                $relation->project_id = $this->id;
                $relation->tag_id = $tag->id;
                $relation->save();
            }
            return true;
        }   
        
        public static function getThumbURL($image_id){
            $image = Image::model()->findByPk($image_id);
            $thumb_path = $image->path.'thumbs/'.$image->filename;
            if(!file_exists($thumb_path)){
                ImageHelper::thumb(300,200,$image->path.'/'.$image->filename);
            }
            return $thumb_path;
        }
        
        public static function getSubcategoryProjects($cat_id){
            $result = array();
            $category = Category::model()->findByPk($cat_id);
            $descendants = $category->descendants()->findAll();
            foreach($descendants as $descendant){
                $result = array_merge($result,$descendant->projects);
            }
            return $result;
        }        
}
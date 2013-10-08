<?php

/**
 * This is the model class for table "part".
 *
 * The followings are the available columns in table 'part':
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $created
 * @property string $updated
 * @property integer $category_id
 *
 * The followings are the available model relations:
 * @property Bom[] $boms
 * @property ImagePart[] $imageParts
 * @property Item[] $items
 * @property Category $category
 * @property PartSupplier[] $partSuppliers
 * @property PartTag[] $partTags
 */
class Part extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Part the static model class
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
		return 'part';
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
			array('category_id,views,created_user_id,updated_user_id', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
			array('name', 'unique', 'caseSensitive'=>false,'allowEmpty'=>false),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, description, created, updated, category_id', 'safe', 'on'=>'search'),
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
			'boms' => array(self::HAS_MANY, 'Bom', 'part_id'),
			'images' => array(self::MANY_MANY, 'Image', 'image_part(image_id,part_id)'),
			'projects' => array(self::MANY_MANY, 'Project', 'bom(part_id,project_id)'),
			'documents' => array(self::MANY_MANY, 'Document', 'document_part(document_id,part_id)'),
			'items' => array(self::HAS_MANY, 'Item', 'part_id'),
			'attribs' => array(self::HAS_MANY, 'Attribute', 'part_id','order'=>'name ASC'),
			'comments' => array(self::HAS_MANY, 'Comment', 'part_id','order'=>'created DESC'),
			'supply' => array(self::HAS_MANY, 'PartSupplier', 'part_id'),
			'category' => array(self::BELONGS_TO, 'Category', 'category_id'),
			'creater' => array(self::BELONGS_TO, 'User', 'created_user_id'),
			'updater' => array(self::BELONGS_TO, 'User', 'updated_user_id'),
			'suppliers' => array(self::MANY_MANY, 'Supplier', 'part_supplier(part_id,supplier_id)','order'=>'name'),
			'tags' => array(self::MANY_MANY, 'Tag', 'part_tag(part_id,tag_id)','order'=>'name'),
			'alternatives' => array(self::MANY_MANY, 'Part', 'alternative_part(part_id,alternative_id)'),
			'related' => array(self::MANY_MANY, 'Part', 'related_part(part_id,related_id)'),
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
			'category_id' => 'Category',
		);
	}

        public static function getNames(){
            $result = array();
            $names = Yii::app()->db->createCommand()->select('name')->from('part')->queryAll();
            foreach($names as $name) $result[] = $name['name'];
            return $result;
        }
        
        public function getSupply($supplier_id = null){
            if(is_null($supplier_id)) return null;
            return PartSupplier::model()->findByAttributes(array('part_id'=>$this->id,'supplier_id'=>$supplier_id));
            
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
		$criteria->compare('category_id',$this->category_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public static function getSubcategoryParts($cat_id){
            $result = array();
            $category = Category::model()->findByPk($cat_id);
            $descendants = $category->descendants()->findAll();
            foreach($descendants as $descendant){
                $result = array_merge($result,$descendant->parts);
            }
            return $result;
        }
        
        public function getBestPrice(){
            $smallestUnit = $this->smallestUnit;
            $lowest = 0;
            $supplys = $this->supply;
            foreach ($supplys as $supply){
                $prices = $supply->prices;
                foreach($prices as $price){
                    if(($price->quantity == $smallestUnit) AND ($lowest == 0 OR $price->unit_price < $lowest)){
                        $lowest = $price->unit_price;
                    }
                }
            }
            return $lowest;
        }

        public function getBestBulkPrice(){
            $lowest = 0;
            $supplys = $this->supply;
            foreach ($supplys as $supply){
                $prices = $supply->prices;
                foreach($prices as $price){
                    if(($lowest == 0 OR $price->unit_price < $lowest)){
                        $lowest = $price->unit_price;
                    }
                }
            }
            return $lowest;
        }
        
        public function getSmallestUnit(){
            $smallestUnit = 99999;
            $supplys = $this->supply;
            foreach ($supplys as $supply){
                $prices = $supply->prices;
                foreach($prices as $price){
                    if(($smallestUnit > $price->quantity)){
                        $smallestUnit = $price->quantity;
                    }
                }
            }
            return $smallestUnit;
        }

        public static function getThumbURL($image_id){
            $image = Image::model()->findByPk($image_id);
            $thumb_path = $image->path.'thumbs/'.$image->filename;
            if(!file_exists($thumb_path)){
                ImageHelper::thumb(300,200,$image->path.'/'.$image->filename);
            }
            return $thumb_path;
        }

        public function addTag($name){
            $tag = Tag::add($name);
            $partTag = PartTag::model()->findByAttributes(array('tag_id'=>$tag->id,'part_id'=>$this->id));
            if(empty($partTag)) {
                $partTag = new PartTag ();
                $partTag->part_id = $this->id;
                $partTag->tag_id = $tag->id;
                $partTag->save();
            }
            return true;
        }    
        
        public function getInStock(){
            $user = User::getCurrentUser();
            if(empty($user)) return 0;
            
            $item = $user->getItem($this->id);
            if(empty($item)) return 0;
            return $item->quantity;
        } 

        public function addAttribute($name,$value){
            $attribute = new Attribute();
            $attribute->name = $name;
            $attribute->value = $value;
            $attribute->part_id = $this->id;
            if($attribute->save()){
                Log::addEntry('Part;addAttribute;'.$this->id.':'.implode(';', $attribute->attributes), 20);
            }
        }        
        
        public function addAlternative($id){
            $part = Part::model()->findByPk($id);
            if(!empty($part)){
                $relation = new AlternativePart();
                $relation->part_id = $this->id;
                $relation->alternative_id = $part->id;
                if($relation->save()){
                    Log::addEntry('Part;addAlternative;'.$id.':'.implode(';', $relation->attributes), 20);
                    return true;
                }
            }
            return false;
        }        

        public function addRelated($id){
            $part = Part::model()->findByPk($id);
            if(!empty($part)){
                $relation = new RelatedPart();
                $relation->part_id = $this->id;
                $relation->related_id = $part->id;
                $relation_reverse = new RelatedPart();
                $relation_reverse->part_id = $part->id;
                $relation_reverse->related_id = $this->id;
                if($relation->save() && $relation_reverse->save()){
                    Log::addEntry('Part;addRelated;'.$id.':'.implode(';', $relation->attributes), 20);
                    Log::addEntry('Part;addRelated;'.$id.':'.implode(';', $relation_reverse->attributes), 20);
                    return true;
                }
            }
            return false;
        }        
}
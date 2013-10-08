<?php

/**
 * This is the Nested Set  model class for table "category".
 *
 * The followings are the available columns in table 'category':
 * @property integer $id
 * @property integer $root
 * @property string $name
 * @property integer $lft
 * @property integer $rgt
 * @property integer $level
 *
 * The followings are the available model relations:
 * @property ArticleCategory[] $articleCategories
 */
class Category extends CActiveRecord
{

         /**
	 * Id of the div in which the tree will berendered.
	 */
    const ADMIN_TREE_CONTAINER_ID='category_admin_tree';


	/**
	 * Returns the static model of the specified AR class.
	 * @return Category the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

        /**
	 * @return string the class name
	 */
          public static function className()
	{
		return __CLASS__;
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'category';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE1: you should only define rules for those attributes that
		// will receive user inputs.
                // NOTE2: Remove ALL rules associated with the nested Behavior:
                //rgt,lft,root,level,id.
		return array(
			array('name', 'required'),
			array('name', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('name', 'safe', 'on'=>'search'),
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
			'articleCategories' => array(self::HAS_MANY, 'ArticleCategory', 'category_id'),
			'parts' => array(self::HAS_MANY, 'Part', 'category_id'),
			'projects' => array(self::HAS_MANY, 'Project', 'category_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'root' => 'Root',
			'name' => 'Name',
			'lft' => 'Lft',
			'rgt' => 'Rgt',
			'level' => 'Level',
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
		$criteria->compare('root',$this->root);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('lft',$this->lft);
		$criteria->compare('rgt',$this->rgt);
		$criteria->compare('level',$this->level);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

        public function behaviors()
{
    return array(
        'NestedSetBehavior'=>array(
            'class'=>'ext.nestedBehavior.NestedSetBehavior',
            'leftAttribute'=>'lft',
            'rightAttribute'=>'rgt',
            'levelAttribute'=>'level',
            'hasManyRoots'=>true
            )
    );
}

  public static  function printULTree(){
     $categories=Category::model()->findAll(array('order'=>'root,lft'));
     $level=0;

foreach($categories as $n=>$category)
{

    if($category->level==$level)
        echo CHtml::closeTag('li')."\n";
    else if($category->level>$level)
        echo CHtml::openTag('ul')."\n";
    else
    {
        echo CHtml::closeTag('li')."\n";

        for($i=$level-$category->level;$i;$i--)
        {
            echo CHtml::closeTag('ul')."\n";
            echo CHtml::closeTag('li')."\n";
        }
    }

    echo CHtml::openTag('li',array('id'=>'node_'.$category->id,'rel'=>$category->name));
      echo CHtml::openTag('a',array('href'=>'#'));
    echo CHtml::encode($category->name);
      echo CHtml::closeTag('a');

    $level=$category->level;
}

for($i=$level;$i;$i--)
{
    echo CHtml::closeTag('li')."\n";
    echo CHtml::closeTag('ul')."\n";
}

}

public static  function printULTree_noAnchors(){
    $categories=Category::model()->findAll(array('order'=>'lft'));
    $level=0;

foreach($categories as $n=>$category)
{
    if($category->level == $level)
        echo CHtml::closeTag('li')."\n";
    else if ($category->level > $level)
        echo CHtml::openTag('ul')."\n";
    else         //if $category->level<$level
    {
        echo CHtml::closeTag('li')."\n";

        for ($i = $level - $category->level; $i; $i--) {
                    echo CHtml::closeTag('ul') . "\n";
                    echo CHtml::closeTag('li') . "\n";
                }
    }

    echo CHtml::openTag('li');
    echo CHtml::encode($category->name);
    $level=$category->level;
}

for ($i = $level; $i; $i--) {
            echo CHtml::closeTag('li') . "\n";
            echo CHtml::closeTag('ul') . "\n";
        }

}


public static  function printMenuTree(){
     $categories=Category::model()->findAll(array('order'=>'root,lft'));
     $level=0;

    foreach($categories as $n=>$category)
    {

        if($category->level==$level)
            echo CHtml::closeTag('li')."\n";
        else if($category->level>$level)
            echo CHtml::openTag('ul')."\n";
        else
        {
            echo CHtml::closeTag('li')."\n";

            for($i=$level-$category->level;$i;$i--)
            {
                echo CHtml::closeTag('ul')."\n";
                echo CHtml::closeTag('li')."\n";
            }
        }

        echo CHtml::openTag('li',array('id'=>'node_'.$category->id,'rel'=>$category->name));
        echo CHtml::openTag('a',array('href'=>CHtml::normalizeUrl(array('site/viewCategory','id'=>$category->id))));
        echo CHtml::encode($category->name);
        echo CHtml::closeTag('a');

        $level=$category->level;
    }

    for($i=$level;$i;$i--)
    {
        echo CHtml::closeTag('li')."\n";
        echo CHtml::closeTag('ul')."\n";
    }

}


    public static  function getOptions($root=1){
        $categories=Category::model()->findAllByAttributes(array('root'=>$root),array('order'=>'root,lft'));
        $result = array();

        foreach($categories as $n=>$category)
        {
            if($category->id != $root)
                $result[$category->id] = str_repeat('&nbsp;&nbsp;&nbsp;', $category->level) . '-' . $category->name;
            else
                $result[$category->id] = str_repeat('&nbsp;&nbsp;&nbsp;', $category->level) . $category->name;
        }
        return $result;

    }
    
    
    public function getPath(){
        $node=$this;
        $result = array();
        for($i = $this->level; $i > 0; $i--){
            $result[$node->id] = $node->name;
            $node = $node->getParent();
        }
        return array_reverse($result,$preserve_keys=true);
//        return $result;

    }

}
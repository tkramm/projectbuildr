<?php

class PartController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create',
                                                    'uploadImage',
                                                    'uploadDocument',
                                                    'RemoveImage',
                                                    'RemoveDocument',
                                                    'RemoveFromStock',
                                                    'selectSupplier',
                                                    'SearchSupplier',
                                                    'addSupplier',
                                                    'addPrice',
                                                    'addAttribute',
                                                    'addSupplierRelation',
                                                    'addCategory',
                                                    'addAlternative',
                                                    'addRelated',
                                                    'removeAlternative',
                                                    'removeRelated',
                                                    'update',
                                                    'duplicate',
                                                    'UpdateCategory',
                                                    'updateItemQuantity',
                                                    'updateItemQuantityWarning',
                                                    'updateLocation',
                                                    'addTag',
                                                    'supplier',
                                                    'removeTag',
                                                    'removeAttribute',
                                                    'removeSupplierRelation',
                                                    'ajaxAddComment',
                                                    'DynamicAssortments',
                                                    'DynamicBoxes'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin','tkramm'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
            $model = $this->loadModel($id);
            $this->pageTitle = Yii::app()->name . ' / Part / ' . $model->name;
            
		$this->render('view',array(
			'model'=>$model,
		));
            $model->disableBehavior('CTimestampBehavior');
            $model->views = $model->views+1;
            $model->save();
	}

	public function actionCreate()
	{
            $model=new Part;

            $this->pageTitle = Yii::app()->name . ' / Part / Create';

            $name = Yii::app()->getRequest()->getParam('name');
            if(!empty($name)) $model->name = $name;

            if(isset($_POST['Part']))
            {
                    $user = User::getCurrentUser();
                    $model->attributes=$_POST['Part'];
                    if($model->isNewRecord) $model->created_user_id = $user->id;
                    $model->updated_user_id = $user->id;
                    if(empty($model->category_id)) $model->category_id = 1;
                    if($model->save()){
                        Log::addEntry('Part;create;'.$model->id.':'.implode(';', $model->attributes), 10);
                        $this->redirect(array('update','id'=>$model->id));
                    }
            }

            $this->render('create',array(
                    'model'=>$model,
            ));
	}


        public function actionUpdate($id)
	{
            $model=$this->loadModel($id);
            $old = $model;
            $this->pageTitle = Yii::app()->name . ' / Part / ' . $model->name . ' / Update';

            if(isset($_POST['Part']))
            {
                    $model->attributes=$_POST['Part'];
                    $model->updated_user_id = Yii::app()->user->id;
                    if($model->save()){
                        Log::addEntry('Part;update;'.$model->id.':'.implode(';', $old->attributes).':'.implode(';', $model->attributes), 10);
                        $this->redirect(array('update','id'=>$model->id));
                    }
            }

            $this->render('update',array(
                    'model'=>$model,
            ));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Part');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Part('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Part']))
			$model->attributes=$_GET['Part'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Part the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Part::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Part $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='part-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
        public function actionSupplier(){
            $id = Yii::app()->getRequest()->getParam('id');
            $query = Yii::app()->getRequest()->getParam('query');
            $model = $this->loadModel($id);
            $suppliers = array();
            if(!empty($query)) $suppliers = Supplier::model()->findAll("name COLLATE latin1_general_ci LIKE '%".$query."%'");
            
            echo $this->renderPartial('_supplierList',array('model'=>$model,'suppliers'=>$suppliers));
        }

        public function actionAddSupplier($id){
            //$id = Yii::app()->getRequest()->getParam('id');
            $model = $this->loadModel($id);
            $supplier = new Supplier();
            $supplier->name = $_POST['name'];
            $supplier->description = $_POST['description'];
            $supplier->url = $_POST['url'];
            if($supplier->save()){
                $this->redirect(array('part/addSupplierRelation','id'=>$id,'supplier_id'=>$supplier->id));
            } else {
                $this->redirect(array('part/actionSearchSupplier','id'=>$id,'query'=>$supplier->name));
            }
        }

        public function actionAddPrice($id){
            //$id = Yii::app()->getRequest()->getParam('id');
            $model = $this->loadModel($id);
            $price = new Price();
            $price->part_supplier_id = Yii::app()->getRequest()->getParam('supply_id');
            $price->quantity = Yii::app()->getRequest()->getParam('quantity');
            $unit_price = str_replace(',', '.', Yii::app()->getRequest()->getParam('price'));
            $price->unit_price = $unit_price;
            $price->save();
            $this->redirect(array('part/update','id'=>$id));
        }

        public function actionAddSupplierRelation($id,$supplier_id){
            $model = $this->loadModel($id);
            $supplier = Supplier::model()->findByPk($supplier_id);
            //print_r($_POST);

            $relation = new PartSupplier();
            $relation->part_id = $id;
            $relation->supplier_id = $supplier_id;
            if(isset($_POST['part_number'])) $relation->part_number = $_POST['part_number'];
            if(isset($_POST['url'])) $relation->url = $_POST['url'];
            if($relation->save()){
                echo $this->redirect(array('part/update','id'=>$model->id));
            } else {
                //print_r($relation->getErrors());
                echo $this->render('_supplierRelation',array('model'=>$model,'supplier'=>$supplier,'relation'=>$relation),true,true);
            }
        }
        public function actionAddCategory(){
            $id = Yii::app()->getRequest()->getParam('id');
            $name = Yii::app()->getRequest()->getParam('name');
            if(!empty($name)){
                $model = $this->loadModel($id);
                $new_cat = new Category();
                $new_cat->name = $name;
                $parent_node = Category::model()->findByPk($model->category_id);
                if($new_cat->appendTo($parent_node)){
                    Log::addEntry('Part;addCategory;'.$model->id.':'.implode(';', $new_cat->attributes), 10);
                    $model->category_id = $new_cat->id;
                    $model->save();

                    $widget = $this->renderPartial('widgets/_category',array('model'=>$model,'edit'=>true),true);
                    $this->renderPartial('widgets/_widget',array('content'=>$widget));

                }
            }
            //echo $this->redirect(array('part/update','id'=>$model->id));
        }

        public function actionSearchSupplier(){
            $id = Yii::app()->getRequest()->getParam('id');
            $query = Yii::app()->getRequest()->getParam('query');
            $model = $this->loadModel($id);
            $suppliers = Supplier::model()->findAllByAttributes(array('name'=>$query));
            $supplier = new Supplier();
            $supplier->name = $query;
            
            $this->render('_supplierAdd',array('model'=>$model,'supplier'=>$supplier,'suppliers'=>$suppliers));
        }

        public function actionRemoveFromStock($id){
            $model = $this->loadModel($id);
            $item = Item::model()->findByAttributes(array('part_id'=>$model->id,'user_id'=>Yii::app()->user->id));
            $item->delete();
            $this->redirect(array('part/view','id'=>$id));
        }
        
        public function actionRemoveImage($id,$image_id){
            $model = $this->loadModel($id);
            $image = Image::model()->findByPk($image_id);
            $imagePart = ImagePart::model()->findByAttributes(array('image_id'=>$image_id,'part_id'=>$model->id));
            $imagePart->delete();
            $thumbURL = Part::getThumbURL($image->id);
            if(file_exists($thumbURL)) unlink($thumbURL);
            if(file_exists($image->path.$image->filename)) unlink($image->path.$image->filename);
            $image->delete();
            $this->redirect(array('part/update','id'=>$id));
        }
        
        public function actionRemoveDocument($id,$document_id){
            $model = $this->loadModel($id);
            $document = Document::model()->findByPk($document_id);
            $documentPart = DocumentPart::model()->findByAttributes(array('document_id'=>$document_id,'part_id'=>$model->id));
            $documentPart->delete();
            if(file_exists($document->path.$document->filename)) unlink($document->path.$document->filename);
            $document->delete();
            $this->redirect(array('part/update','id'=>$id));
        }
        
        public function actionremoveSupplierRelation($id,$supplier_id){
            PartSupplier::model()->deleteAllByAttributes(array('part_id'=>$id,'supplier_id'=>$supplier_id));
            $this->redirect(array('part/update','id'=>$id));
        }
        
        public function actionRemoveAlternative(){
            $id = Yii::app()->getRequest()->getParam('id');
            $alternative_id = Yii::app()->getRequest()->getParam('alternative_id');
            AlternativePart::model()->deleteAllByAttributes(array('part_id'=>$id,'alternative_id'=>$alternative_id));
            echo $this->renderPartial('widgets/_alternativeList',array('model'=>$this->loadModel($id)),true,true);
        }

        public function actionRemoveRelated(){
            $id = Yii::app()->getRequest()->getParam('id');
            $related_id = Yii::app()->getRequest()->getParam('related_id');
            RelatedPart::model()->deleteAllByAttributes(array('part_id'=>$id,'$related_id'=>$related_id));
            RelatedPart::model()->deleteAllByAttributes(array('$related_id'=>$id,'part_id'=>$related_id));
            echo $this->renderPartial('widgets/_relatedList',array('model'=>$this->loadModel($id)),true,true);
        }

        public function actionRemoveTag($id,$tag_id){
            $model = $this->loadModel($id);
            $tag = Tag::model()->findByPk($tag_id);
            $partTag = PartTag::model()->findByAttributes(array('tag_id'=>$tag_id,'part_id'=>$model->id));
            $partTag->delete();
            if($tag->frequency > 1){
                $tag->frequency = $tag->frequency - 1;
                $tag->save();
            } else {
                $tag->delete();
            }
            $this->redirect(array('part/update','id'=>$id));
        }
        
        public function actionRemoveAttribute($id,$attribute_id){
            Attribute::model()->findByPk($attribute_id)->delete();
            $this->redirect(array('part/update','id'=>$id));
        }
        
        public function actionAddTag($id){
            $name = Yii::app()->getRequest()->getParam('newTag');
            $model = $this->loadModel($id);
            $model->addTag($name);
            $this->redirect(array('part/update','id'=>$id));
        }
        
        public function actionAddAttribute($id){
            $name = Yii::app()->getRequest()->getParam('name');
            $value = Yii::app()->getRequest()->getParam('value');
            $model = $this->loadModel($id);
            $model->addAttribute($name,$value);
            $this->redirect(array('part/update','id'=>$id));
        }

        public function actionAddAlternative($id){
            $alternative_id = Yii::app()->getRequest()->getParam('alternative_id');
            $model = $this->loadModel($id);
            if($model->id != $alternative_id){
               $model->addAlternative($alternative_id); 
            }
            echo $this->renderPartial('widgets/_alternativeList',array('model'=>$model),true,true);
        }

        public function actionAddRelated($id){
            $related_id = Yii::app()->getRequest()->getParam('related_id');
            $model = $this->loadModel($id);
            if($model->id != $related_id){
               $model->addRelated($related_id); 
            }
            echo $this->renderPartial('widgets/_relatedList',array('model'=>$model),true,true);
        }

        public function actionUpdateItemQuantity($id){
            $q = Yii::app()->getRequest()->getParam('quantity');
            $user = User::getUser();
            $model = $this->loadModel($id);
            $item = $user->getItem($model->id);
            $item->updateQuantity($q);
            //$this->redirect(array('part/view','id'=>$id));
        }
        public function actionUpdateItemQuantityWarning($id){
            $q = Yii::app()->getRequest()->getParam('quantity_warning');
            $user = User::getUser();
            $model = $this->loadModel($id);
            $item = $user->getItem($model->id);
            $item->updateQuantityWarning($q);
            //$this->redirect(array('part/view','id'=>$id));
        }

        public function actionUpdateCategory(){
            $id = Yii::app()->getRequest()->getParam('id');
            $category_id = Yii::app()->getRequest()->getParam('category_id');
            $model = $this->loadModel($id);
            $old = $model;
            $model->category_id = $category_id;
            if($model->save()){
                Log::addEntry('Part;updateCategory;'.$model->id.':'.implode(';', $old->attributes).':'.implode(';', $model->attributes), 15);
                
            }
            $widget = $this->renderPartial('widgets/_category',array('model'=>$model,'edit'=>true),true);
            $this->renderPartial('widgets/_widget',array('content'=>$widget));
        }

        public function actionUpdateLocation()
        {
            $id = Yii::app()->getRequest()->getParam('part_id');
            $location_id = Yii::app()->getRequest()->getParam('box');
            $user = User::getUser();
            $item = $user->getItem($id);
            if(empty($item)){
                $item = new Item;
                $item->part_id = $id;
                $item->user_id = $user->id;
                $item->quantity = 0;
                $item->quantity_warning = 0;
            }
            $item->location_id = $location_id;
            $item->save();
            $this->redirect(array('part/view','id'=>$id));
        }        

        public function actionDynamicAssortments()
        {
//            $data = Location::getAssortments('WS');
            $data = Location::getAssortments($_POST['location']);
            $data = array_merge(array('please select'),$data);
            foreach($data as $value=>$name)
            {
                echo CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);
            }
        }        
        public function actionDynamicBoxes()
        {
            $data = Location::getBoxes($_POST['location'],$_POST['assortment']);
            foreach($data as $value=>$name)
            {
                echo CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);
            }
        }     
        
        public function actionUploadImage($id)
        {
            $model = $this->loadModel($id);

            Yii::import("ext.EAjaxUpload.qqFileUploader");

            $folder='upload/parts/';// folder for uploaded files
            $allowedExtensions = array("jpg","jpeg","png","gif");//array("jpg","jpeg","gif","exe","mov" and etc...
            $sizeLimit = 2 * 1024 * 1024;// maximum file size in bytes
            $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
            $result = $uploader->handleUpload($folder);
            $fileSize=filesize($folder.$result['filename']);//GETTING FILE SIZE
            $fileName=$result['filename'];//GETTING FILE NAME
            
            $image = new Image();
            $image->path = $folder;
            $image->filename = $fileName;
            $image->save();
            $connection = new ImagePart();
            $connection->image_id = $image->id;
            $connection->part_id = $model->id;
            $connection->save();
            
            $html = $this->renderPartial('widgets/_imageList',array('model'=>$model,'edit'=>true),true,true);
            $result = array_merge($result,array('html'=>$html));
            $return = json_encode($result);

            echo $return;
        }

        public function actionUploadDocument($id)
        {
            $model = $this->loadModel($id);

            Yii::import("ext.EAjaxUpload.qqFileUploader");

            $folder='upload/parts/documents/';// folder for uploaded files
            $allowedExtensions = array("pdf","zip","stl");//array("jpg","jpeg","gif","exe","mov" and etc...
            $sizeLimit = 30 * 1024 * 1024;// maximum file size in bytes
            $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
            $result = $uploader->handleUpload($folder);
            $fileSize=filesize($folder.$result['filename']);//GETTING FILE SIZE
            $fileName=$result['filename'];//GETTING FILE NAME
            
            $document = new Document();
            $document->name = $result['oldFilename'];
            $document->path = $folder;
            $document->filename = $fileName;
            $document->user_id = Yii::app()->user->id;
            $document->downloads = 0;
            if(!$document->save()){
                print_r($document->getErrors());
            } else {
                $connection = new DocumentPart();
                $connection->document_id = $document->id;
                $connection->part_id = $model->id;
                $connection->save();
            }
            $html = $this->renderPartial('widgets/_documentList',array('model'=>$model,'edit'=>true),true,true);
            $result = array_merge($result,array('html'=>$html));
            $return = json_encode($result);

            echo $return;
        }    
        
        public function actionDuplicate($id)
	{
            $old=$this->loadModel($id);
            $model = new Part();
            $model->name = $old->name . ' Duplicate';
            $model->description = $old->description;
            $model->category_id = $old->category_id;
            $model->created_user_id = Yii::app()->user->id;
            $model->updated_user_id = Yii::app()->user->id;
            $model->views = 0;
            if($model->save()){
                Log::addEntry('Part;duplicate;'.$model->id.':'.implode(';', $model->attributes), 10);
                
                foreach ($old->attribs as $attribute) $model->addAttribute($attribute->name, $attribute->value);
                foreach ($old->tags as $tag) $model->addTag($tag->name);
            }
            $this->pageTitle = Yii::app()->name . ' / Part / ' . $model->name . ' / Update';
            $this->redirect(array('update','id'=>$model->id));
	}       
       
	public function actionAjaxAddComment()
	{
            $id = Yii::app()->getRequest()->getParam('id');
            $text = Yii::app()->getRequest()->getParam('text');
            
            if(!empty($text)){
                $user = User::getUser();
                $comment = new Comment();
                $comment->user_id = $user->id;
                $comment->part_id = $id;
                $comment->text = $text;
                if(!$comment->save()) print_r($comment->getErrors());
                Log::addEntry('Part;addComment;'.$id.':'.implode(';', $comment->attributes), 10);
            }
            
            $model=$this->loadModel($id);
            echo $this->renderPartial('_comments',array('model'=>$model));
        }
}

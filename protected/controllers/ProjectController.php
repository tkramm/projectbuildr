<?php

class ProjectController extends Controller
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
				'actions'=>array('index',
                                                'getRow',
                                                'view'
                                                ),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array(   'create',
                                                    'addBom',
                                                    'deleteBomItem',
                                                    'addCategory',
                                                    'updateCategory',
                                                    'update',
                                                    'addTag',
                                                    'removeTag',
                                                    'uploadImage',
                                                    'removeImage',
                                                    'uploadDocument',
                                                    'removeDocument',
                                                    ),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
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
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
            $model=new Project;

            $this->pageTitle = Yii::app()->name . ' / Project / Create';
            if(isset($_POST['Project']))
            {
            print_r($_POST['Project']);
                    $model->attributes=$_POST['Project'];
                    $model->created_user_id = Yii::app()->user->id;
                    $model->updated_user_id = Yii::app()->user->id;
                    if(empty($model->category_id)) $model->category_id = 2;
                    if($model->save()){
                        //Log::addEntry('Project;create;'.$model->id.':'.implode(';', $model->attributes), 10);
                        $this->redirect(array('update','id'=>$model->id));
                    } else {
                        print_r($model->getErrors());
                    }
            }

            $this->render('create',array(
                    'model'=>$model,
            ));
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
  //                  Log::addEntry('Project;addCategory;'.$model->id.':'.implode(';', $new_cat->attributes), 10);
                    $model->category_id = $new_cat->id;
                    $model->save();

                    $widget = $this->renderPartial('widgets/_category',array('model'=>$model,'edit'=>true),true);
                    $this->renderPartial('widgets/_widget',array('content'=>$widget));

                }
            }
            //echo $this->redirect(array('part/update','id'=>$model->id));
        }

        public function actionUpdateCategory(){
            $id = Yii::app()->getRequest()->getParam('id');
            $category_id = Yii::app()->getRequest()->getParam('category_id');
            $model = $this->loadModel($id);
            $old = $model;
            $model->category_id = $category_id;
            if($model->save()){
//                Log::addEntry('Project;updateCategory;'.$model->id.':'.implode(';', $old->attributes).':'.implode(';', $model->attributes), 15);
                
            }
            $widget = $this->renderPartial('widgets/_category',array('model'=>$model,'edit'=>true),true);
            $this->renderPartial('widgets/_widget',array('content'=>$widget));
        }

        
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Project']))
		{
			$model->attributes=$_POST['Project'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
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
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Project');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Project('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Project']))
			$model->attributes=$_GET['Project'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Project::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='project-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
        public function actionAddTag($id){
            $name = Yii::app()->getRequest()->getParam('newTag');
            $model = $this->loadModel($id);
            $model->addTag($name);
            $this->redirect(array('project/update','id'=>$id));
        }
        
        public function actionRemoveTag($id,$tag_id){
            $model = $this->loadModel($id);
            $tag = Tag::model()->findByPk($tag_id);
            $projectTag = ProjectTag::model()->findByAttributes(array('tag_id'=>$tag_id,'project_id'=>$model->id));
            $projectTag->delete();
            if($tag->frequency > 1){
                $tag->frequency = $tag->frequency - 1;
                $tag->save();
            } else {
                $tag->delete();
            }
            $this->redirect(array('project/update','id'=>$id));
        }
        
        public function actionUploadDocument($id)
        {
            $model = $this->loadModel($id);

            Yii::import("ext.EAjaxUpload.qqFileUploader");

            $folder='upload/projects/documents/';// folder for uploaded files
            $allowedExtensions = array("pdf","zip","stl","scad");//array("jpg","jpeg","gif","exe","mov" and etc...
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
                $connection = new DocumentProject();
                $connection->document_id = $document->id;
                $connection->project_id = $model->id;
                $connection->save();
            }
            $html = $this->renderPartial('widgets/_documentList',array('model'=>$model,'edit'=>true),true,true);
            $result = array_merge($result,array('html'=>$html));
            $return = json_encode($result);

            echo $return;
        }  
        
        public function actionRemoveDocument($id,$document_id){
            $model = $this->loadModel($id);
            $document = Document::model()->findByPk($document_id);
            $documentPart = DocumentProject::model()->findByAttributes(array('document_id'=>$document_id,'project_id'=>$model->id));
            $documentPart->delete();
            if(file_exists($document->path.$document->filename)) unlink($document->path.$document->filename);
            $document->delete();
            $this->redirect(array('project/update','id'=>$id));
        }    
        
        
        public function actionUploadImage($id)
        {
            $model = $this->loadModel($id);

            Yii::import("ext.EAjaxUpload.qqFileUploader");

            $folder='upload/projects/';// folder for uploaded files
            $allowedExtensions = array("jpg","jpeg","png","gif");//array("jpg","jpeg","gif","exe","mov" and etc...
            $sizeLimit = 4 * 1024 * 1024;// maximum file size in bytes
            $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
            $result = $uploader->handleUpload($folder);
            $fileSize=filesize($folder.$result['filename']);//GETTING FILE SIZE
            $fileName=$result['filename'];//GETTING FILE NAME
            
            $image = new Image();
            $image->path = $folder;
            $image->filename = $fileName;
            $image->save();
            $connection = new ImageProject();
            $connection->image_id = $image->id;
            $connection->project_id = $model->id;
            $connection->save();
            
            $html = $this->renderPartial('widgets/_imageList',array('model'=>$model,'edit'=>true),true,true);
            $result = array_merge($result,array('html'=>$html));
            $return = json_encode($result);

            echo $return;
        }        
        public function actionRemoveImage($id,$image_id){
            $model = $this->loadModel($id);
            $image = Image::model()->findByPk($image_id);
            $thumbURL = Project::getThumbURL($image->id);
            if(file_exists($thumbURL)) unlink($thumbURL);
            if(file_exists($image->path.$image->filename)) unlink($image->path.$image->filename);
            $image->delete();
            $imageProject = ImageProject::model()->findByAttributes(array('image_id'=>$image_id,'project_id'=>$model->id));
            $imageProject->delete();
            $this->redirect(array('project/update','id'=>$id));
        }
        

        public function actionAddBom(){
            $id = Yii::app()->getRequest()->getParam('id');
            $qty = Yii::app()->getRequest()->getParam('qty');
            $part_id = Yii::app()->getRequest()->getParam('part_id');
            $note = Yii::app()->getRequest()->getParam('note');
            $item = new Bom();
            $item->project_id = $id;
            $item->part_id = $part_id;
            $item->quantity = $qty;
            $item->note = $note;
            if($item->save()){
                echo $item->id;
            } else {
                print_r($item->getErrors());
            }
        }

        public function actionGetRow(){
            $id = Yii::app()->getRequest()->getParam('id');
            $edit = Yii::app()->getRequest()->getParam('edit');
            $item = Bom::model()->findByPk($id);
            $this->renderPartial('widgets/_bomRow',array('item'=>$item,'edit'=>$edit));
        }        
        
        public function actionDeleteBomItem(){
            $id = Yii::app()->getRequest()->getParam('id');
            Bom::model()->findByPk($id)->delete();
        }        
}

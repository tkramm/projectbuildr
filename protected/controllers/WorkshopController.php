<?php

class WorkshopController extends Controller
{
        var $upload_path = "upload/";

        public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array(''),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index','Locations','LocationDetail','Order'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
        
        public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
            $this->pageTitle = Yii::app()->name . ' / myWorkshop';

            $this->render('index');
	}

	public function actionLocationDetail(){
            if(Yii::app()->getRequest()->getIsAjaxRequest()){
                $location = Yii::app()->getRequest()->getParam('location');
                $assortment = Yii::app()->getRequest()->getParam('assortment');
                $user = User::getUser();
                $locations = Location::model()->findAllByAttributes(array('location'=>$location,'assortment'=>$assortment,'user_id'=>$user->id));
                
                $this->renderPartial('locationDetail',array('locations'=>$locations,'location'=>$location,'assortment'=>$assortment,));
                
            }

        }
        
	public function actionLocations()
	{
            $this->pageTitle = Yii::app()->name . ' / myWorkshop / Locations';

            $new_loaction = Yii::app()->getRequest()->getParam('new_location');
            $user = User::getUser();

            if(!empty($new_loaction)){
                for($i = 1;$i<=$new_loaction['boxes'];$i++){
                    $loc = new Location();
                    $loc->location = $new_loaction['location'];
                    $loc->assortment = $new_loaction['assortment'];
                    $loc->box = str_pad($i, strlen($new_loaction['boxes']) ,'0', STR_PAD_LEFT);
                    $loc->user_id = $user->id;
                    $loc->save();
                }
            }
            $locations = $user->locations;
            $list = array();
            foreach ($locations as $location) {
                $list[$location->location][$location->assortment][$location->box] = $location;
            }
            $this->render('locations',array('list'=>$list));
	}
        
	public function actionOrder()
	{
            $this->pageTitle = Yii::app()->name . ' / myWorkshop / Bestellen';
            $user = User::getUser();
            $items = Item::model()->findAll('user_id = '.$user->id.' && quantity < quantity_warning && quantity_warning != 0');
            $suppliers = array();
            foreach ($items as $itemIndex => $item) {
                foreach ($item->part->suppliers as $supplier) {
                    $suppliers[$supplier->id][] = $itemIndex;
                }                
            }
            $this->render('order',array('items'=>$items,'suppliers'=>$suppliers));
            
	}


}

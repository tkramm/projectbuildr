<?php

class SiteController extends Controller
{
        var $upload_path = "upload/";
	/**
	 * Declares class-based actions.
	 */
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
            $action = Yii::app()->getRequest()->getParam('action');
            $this->render('index');
	}
	
        public function actionSearch(){
            $query = Yii::app()->getRequest()->getParam('query');
            $stock = Yii::app()->getRequest()->getParam('stock');
            $parts = array();
            $user_parts = false;
            
            $search['query'] = $query;
            $search['stock'] = $stock;
            $criteria = new CDbCriteria();

            if(!empty($query))
            {
                $criteria->compare('name', $query, true, 'AND');
//                $criteria->compare('tag.name', $query, true, 'OR');
            }
            if(!empty($stock))
            {
                $criteria->compare('user_id', Yii::app()->user->id, false, 'AND');
            }
            
            if(!empty($query) || !empty($stock)) $parts = Part::model()->with(array('items'))->findAll($criteria);
//            if($user_parts){
//                $parts = Part::model()->with('items')->findAll('user_id = '.Yii::app()->user->id.' AND name LIKE "%'.$query.'%"');
//            } else {
//                $parts = Part::model()->with('items')->findAll('name LIKE "%'.$query.'%"');
//            }

            $this->render('search',array('parts'=>$parts,'search'=>$search));
            
        }
        
	public function actionStats()
	{
            $value = 0;
            $bulkvalue=0;
            
            $counts = array();
            $counts['Parts in Database'] = Part::model()->count();
            $counts['Parts created in last 24h'] = Part::model()->count("created >= '" . date('Y-m-d H:i:s', (time()-86400))."'");
            $counts['Parts edited in last 24h'] = Part::model()->count("updated >= '" . date('Y-m-d H:i:s', (time()-86400))."'");
            $counts['    '] = '&nbsp;';
            $counts['Parts in Users Stocks'] = Item::model()->count();
            if(!Yii::app()->user->isGuest) {
                $user = User::getCurrentUser();
                $counts['Parts in your Stock'] = Item::model()->count('user_id = '.$user->id);
            }
            if(!Yii::app()->user->isGuest) {
                foreach ($user->items as $item) {
                    $value += $item->Value;
                    $bulkvalue += $item->BulkValue;
                }
                $query = "SELECT SUM(quantity) AS total FROM item WHERE user_id = ".$user->id; 
                $list= Yii::app()->db->createCommand($query)->queryAll(); // execute a query SQL
                $counts['Total Items in your Stock'] = $list[0]['total'];
                $counts['Value of all your Items'] = round($value,2);
                $counts['Bulk Value of all you Items'] = round($bulkvalue,2);
            }
            $counts['  '] = '&nbsp;';
            $counts['Tags'] = Tag::model()->count();
            $counts[' '] = '&nbsp;';
            $counts['Registered Users'] = User::model()->count();
            $counts['Users registered in last 24h'] = User::model()->count("created >= '" . date('Y-m-d H:i:s', (time()-86400))."'");
            $counts['  '] = '&nbsp;';
            $this->render('stats',array('counts'=>$counts));
 	}
	
        public function actionTag($name)
	{
            $tag = Tag::model()->findByAttributes(array('name'=>$name));
            $parts = $tag->parts;
            $this->render('tag',array('name'=>$name,'parts'=>$parts));
	}
        
        public function actionGetRecent()
	{
            $offset = Yii::app()->getRequest()->getParam('offset');
            $this->renderPartial('_recent',array('offset'=>$offset));
	}
        
        public function actionImprint()
	{
            $this->render('imprint');
	}

        public function search($query){
            $parts = Part::model()->findAll('name LIKE "%'.$query.'%"');
            $this->render('searchResults',array('parts'=>$parts,'query'=>$query));
        }
	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('error', $error);
	    }
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$headers="From: {$model->email}\r\nReply-To: {$model->email}";
				mail(Yii::app()->params['adminEmail'],$model->subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
            if(!Yii::app()->user->isGuest) $this->redirect(array('site/index'));
		$login=new LoginForm;
                
                $register=new User;
		$this->performAjaxValidation($register);
                // if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($login);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$login->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($login->validate() && $login->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
                
                if(isset($_POST['User']))
		{
			$register->attributes=$_POST['User'];
                        $register->salt = $this->generateSalt();
                        if($register->validate()){
                            $register->password = $this->generatePassHash($register->password,$register->salt);
                            if($register->save()){
                                Location::createNALocation($register->id);
                                $this->redirect(array('site/registerSuccess'));
                            }
                        }
                        $register->password = '';
                        $register->salt = '';
		}
		// display the login form
		$this->render('login',array('login'=>$login,'register'=>$register));
	}

	/**
	 * Displays the login page
	 */
	public function actionRegisterSuccess()
	{

		$this->render('registerSuccess',array(
		));	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
        
    public function actionUpload()
    {
            Yii::import("ext.EAjaxUpload.qqFileUploader");

            $folder='upload/';// folder for uploaded files
            $allowedExtensions = array("orc","csv","sql");//array("jpg","jpeg","gif","exe","mov" and etc...
            $sizeLimit = 10 * 1024 * 1024;// maximum file size in bytes
            $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
            $result = $uploader->handleUpload($folder);
            $return = htmlspecialchars(json_encode($result), ENT_NOQUOTES);

            $fileSize=filesize($folder.$result['filename']);//GETTING FILE SIZE
            $fileName=$result['filename'];//GETTING FILE NAME

            echo $return;// it's array
    }        
    
    private function deleteFile($filename = NULL){
        if(is_null($filename)) break;
        unlink($this->upload_path . $filename);
    }

    private function generateSalt() {
            srand((double)microtime()*1000000);
            $rand64="./0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
            $salt = '';
            for ($index = 0; $index < 4; $index++) {
                    $random=rand();
                    $salt.=substr($rand64,$random%64,1).substr($rand64,($random/64)%64,1);
            }
            $salt=substr($salt,0,8);
            return($salt);
    }

    private function generatePassHash($pass,$salt) {
            return hash("sha256",$pass.$salt);
    }    
    
    protected function performAjaxValidation($model)
    {
            if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
            {
                    echo CActiveForm::validate($model);
                    Yii::app()->end();
            }
    }    
}

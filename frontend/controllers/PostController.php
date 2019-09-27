<?php
namespace  frontend\controllers;
use common\models\CatModel;
use common\models\PostExtendModel;
use common\tools\imageConvert;
use frontend\controllers\base\BaseController;
use frontend\models\PostForm;
use Ycn\Qiniu\UploadService;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

class PostController extends BaseController{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index', 'create','upload','ueditor'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['create','upload','ueditor'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    '*'=>['get','post'],
                ],
            ],
        ];
    }

    /*文章列表*/
    public  function actionIndex(){
        return $this->render('index');
    }
    public function  actionCreate(){
        $model=new PostForm();
        //定义场景
        $model->setScenario(PostForm::SCENARIOS_CREATE);
        if($model->load(Yii::$app->request->post())&&$model->validate()){
            $file = UploadedFile::getInstance($model, 'label_img');

            if($file) {
                //实例化上传对象
                $up = UploadService::getInstance(Yii::$app->params['qiniu']['ak'], Yii::$app->params['qiniu']['sk'], Yii::$app->params['qiniu']['bucket']);
                //图片上传临时路径
                $filePath = $file->tempName;
                //调用upload上传原图图片到七牛
                $response = $up->upload($filePath);
                //var_dump($response); return;
                $model->label_img = $response['filename'];

                //利用扩展生成缩略图
                $im = null;
                //取图片类型
                $ext=$file->getExtension();
                $imagetype = strtolower($ext);
                if ($imagetype == 'gif')
                    $im = imagecreatefromgif($filePath);
                else if ($imagetype == 'jpg')
                    $im = imagecreatefromjpeg($filePath);
                else if ($imagetype == 'png')
                    $im = imagecreatefrompng($filePath);
                $newName='/upload/image/image_thumb/'.time().'_thumb_'.'.'.$ext;
                $thumb_path=Yii::$app->basePath.'/web'.$newName;
                //生成缩略图
                imageConvert::resizeImage($im,500,250,$thumb_path,$ext);
                //调用upload上传缩略图片到七牛
                $response = $up->upload($thumb_path);
                $model->label_img_small = $response['filename'];
                //$model->label_img_small = $newName;
                //echo $model->label_img_small;die();
            }

            if(!$model->create()){
                Yii::$app->session->setFlash('warning',$model->_lastError);
            }else{
                return $this->redirect(['post/view','id'=>$model->id]);
            }
        }
        $cat=CatModel::getAllcats();
        return $this->render('create',['model'=>$model,'cat'=>$cat]);
    }
    public function  actionEdit($id){
        $model=new PostForm();
        $res=$model->getViewById($id);
        $model->setAttributes($res);
        //定义场景
        $model->setScenario(PostForm::SCENARIOS_UPDATE);
        if($model->load(Yii::$app->request->post())&&$model->validate()){
            $file = UploadedFile::getInstance($model, 'label_img');

            if($file) {
                //实例化上传对象
                $up = UploadService::getInstance(Yii::$app->params['qiniu']['ak'], Yii::$app->params['qiniu']['sk'], Yii::$app->params['qiniu']['bucket']);
                //图片上传临时路径
                $filePath = $file->tempName;
                //调用upload上传原图图片到七牛
                $response = $up->upload($filePath);
                //var_dump($response); return;
                $model->label_img = $response['filename'];

                //利用扩展生成缩略图
                $im = null;
                //取图片类型
                $ext=$file->getExtension();
                $imagetype = strtolower($ext);
                if ($imagetype == 'gif')
                    $im = imagecreatefromgif($filePath);
                else if ($imagetype == 'jpg')
                    $im = imagecreatefromjpeg($filePath);
                else if ($imagetype == 'png')
                    $im = imagecreatefrompng($filePath);
                $newName='/upload/image/image_thumb/'.time().'_thumb_'.'.'.$ext;
                $thumb_path=Yii::$app->basePath.'/web'.$newName;
                //生成缩略图
                imageConvert::resizeImage($im,500,250,$thumb_path,$ext);
                //调用upload上传缩略图片到七牛
                $response = $up->upload($thumb_path);
                $model->label_img_small = $response['filename'];
                //$model->label_img_small = $newName;
                //echo $model->label_img_small;die();
            }

            if(!$model->create()){
                Yii::$app->session->setFlash('warning',$model->_lastError);
            }else{
                return $this->redirect(['post/view','id'=>$model->id]);
            }
        }
        $cat=CatModel::getAllcats();
        return $this->render('update',['model'=>$model,'cat'=>$cat]);
    }
    public function actionView($id){
        //die("shit");
        $model= new PostExtendModel();
        $model->upCounter(['post_id'=>$id],'browser',1);
        $model=new PostForm();
        $data=$model->getViewById($id);
        return $this->render('view',['data'=>$data]);
    }
    public function actions()
    {
        return [
            'upload' => [
                'class' => 'kucha\ueditor\UEditorAction',
            ]
        ];
    }
}
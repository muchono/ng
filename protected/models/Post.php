<?php

/**
 * This is the model class for table "post".
 *
 * The followings are the available columns in table 'post':
 * @property string $id
 * @property string $title
 * @property string $image
 * @property string $content
 * @property string $author_name
 * @property string $author_image
 * @property string $author_content
 * @property string $meta_description Meta Description
 * @property string $meta_keywords Meta Keywords
 * @property string $url_anckor URL Anckor
 * @property string $date Date Created
 * @property bool $sent Post is sent
 * @property string $active
 */


class Post extends ManyManyActiveRecord
{
    const IMG_DIR = 'img/post/';
    const IMG_AUTHOR_DIR = 'img/post_author/';
    protected $_images = array(
        'post'  => array('w' => 684, 'h' => 0/*378*/),
        'email' => array('w' => 609, 'h' => 0/*325*/),
        'thumb' => array('w' => 301, 'h' => 0/*166*/),
    );
    
    public function getFresh()
    {
        $criteria = new CDbCriteria;
        $criteria->scopes='active';
        $criteria->order = 'date DESC';
        $criteria->limit = 3;
        
        return $this->findAll($criteria);
    }
    
    public function getRss()
    {
        $criteria = new CDbCriteria;
        $criteria->scopes='active';
        $criteria->order = 'date DESC';
        $criteria->limit = 30;
        
        return $this->findAll($criteria);
    }    
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Post the static model class
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
		return 'post';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('meta_description, meta_keywords, url_anckor, title, content, image, categories', 'required'),
			array('title, image, author_name, author_image', 'length', 'max'=>255),
            array('active', 'length', 'max'=>1),
			array('meta_description, meta_keywords, url_anckor, content, author_content, show_author', 'safe'),
            array('image', 'file', 'allowEmpty'=>true, 'on'=>'update'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, image, content, author_name, author_image, author_content, active', 'safe', 'on'=>'search'),
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
            'categories' => array(self::MANY_MANY, 'PostCategory', 'post_to_category(post_id, category_id)'), 
            'post_to_category' => array(self::HAS_MANY, 'PostToCategory', 'post_id'),
		);
	}
    
    public function findByFilter($filter=array(), &$pager = null)
    {
        $criteria = new CDbCriteria();
        $criteria->scopes='active';
        
        $criteria->order = 'id DESC';
        
        if (!empty($filter['search'])){
            $criteria->condition = "title LIKE :search OR content LIKE :search";
            $criteria->params = array(':search' => '%'.$filter['search'].'%');
        }
        
        if (!empty($filter['cid'])) {
            $criteria->with = array( 
                'post_to_category' => array(
                    'select' =>false,
                    'joinType'=>'INNER JOIN',
                    'condition'=>'category_id = :cid',
                    'params'=> array(':cid' => $filter['cid']),
                )
            ); 
            $criteria->together = true;             
        }
        $count=$this->count($criteria);
        
        $pager=new CPagination($count);
        $pager->pageSize=5;
        $pager->applyLimit($criteria);
        
        return $this->findAll($criteria);        
    }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Title',
			'image' => 'Image',
			'content' => 'Content',
			'author_name' => 'Author Name',
			'author_image' => 'Author Image',
			'author_content' => 'Author Content',
			'show_author' => 'Show Author',
            'categories'=>'Categories',
            'active' => 'Active',
            'meta_description'=>'Meta Description',
            'meta_keywords'=>'Meta Keywords',
            'url_anckor'=>'URL ID',
		);
	}

    /**
     * delete
     */
    public function delete()
    {
        Yii::app()->db->createCommand()
                  ->delete('post_to_category', 'post_id=:id', array(':id'=>$this->id));
        
        $this->deleteImages();
        parent::delete();
    }
    
    /*
     * Resize ans save all post images
     * @param string $image path to source image
     */
    public function saveImages($image)
    {
        $this->deleteImages();
        $thumb=Yii::app()->phpThumb->create($image);
        foreach($this->_images as $k=>$v) {
            $thumb->resize($v['w'],$v['h']);
            $thumb->save($this->getImageName($k));
        }
    }
    
    public function scopes()
    {
        return array(
            'active'=>array(
                'condition'=>'active=1',
            ),
        );
    }    
    
    /**
     * before save
     */
    public function beforeSave()
    {
        if ($this->isNewRecord){
            $this->date =  new CDbExpression('NOW()');
        }
        
        return parent::beforeSave();
    }
    
    public function deleteImages()
    {
        foreach($this->_images as $k=>$v) {
            if (is_file($this->getImageName($k))) {
                unlink($this->getImageName($k));
            }
        }
    }
    
    public function getBrief()
    {
        return substr(strip_tags($this->content), 0, 360).' ...';
    }
    
    public function getRSSDescription()
    {
        return self::wordTruncate(strip_tags($this->content), 1/*words number*/);
    }    
    
    public function findByHref($href, $params = array())
    {
		$criteria=new CDbCriteria;
        if (empty($params['all'])) $criteria->scopes='active';
    	$criteria->compare('url_anckor',trim($href));
        return $this->find($criteria);
    }
    
    public function findPopular()
    {
		$criteria=new CDbCriteria;
        $criteria->scopes='active';
    	$criteria->order='views DESC';
        $criteria->limit = 5;/*visible on page*/
        return $this->findAll($criteria);
    }
    
    public static function wordTruncate($text, $count) {
        $text = str_replace("  ", " ", $text);
        $trimed = '';
        $string = explode(" ", $text);
        if (count($string) > $count) {
            for ($wordCounter = 0; $wordCounter <= $count; $wordCounter++ ){
                $trimed .= $string[$wordCounter]." ";
            }
        } else {
            $trimed = $text;
        }
        return trim($trimed);
    }
    
    public function getImageName($type = 'post')
    {
        return static::IMG_DIR.$this->id.'_'.$type.'.'.pathinfo($this->image, PATHINFO_EXTENSION);
    }
    
    /**
     * Get Categories list
     * @return string categories list
     */
    public function getCategoriesList()
    {
        $tmp = array();
        foreach ($this->categories as $c) {
            $tmp[] = $c->title;
        }
        return join(', ', $tmp);
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
        $sort=new CSort;        
        

		$criteria->compare('id',$this->id,true);
		$criteria->compare('title',$this->title,true);
        $criteria->compare('active',$this->active,true);
        
        if ($this->categories) {
            $criteria->with = array( 
                'categories' => array(
                    'select' =>false,
                    'joinType'=>'INNER JOIN',
                    'condition'=>'category_id = :cid',
                    'params'=> array(':cid' => $this->categories),
                )
            ); 
            $criteria->together = true;            
        }
        
        $sort->defaultOrder= array(
            'id'=>CSort::SORT_DESC,
        ); 
        
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'sort'=>$sort,            
		));
	}
}
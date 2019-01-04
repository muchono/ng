<?php

/**
 * This is the model class for table "product".
 *
 * The followings are the available columns in table 'product':
 * @property string $id
 * @property string $title
 * @property string $url
 * @property string $image
 * @property string $age
 * @property double $price
 * @property string $link
 * @property string $anchor
 * @property string $status
 * @property integer $traffic
 * @property string $alexa_rank
 * @property string $da_rank
 * @property string $orders
 * @property string $traffic_update_date
 * @property string $domain_zone
 * @property string $stat_update_date
 * @property string $about
 */
class Product extends ManyManyActiveRecord
{
    const IMG_DIR = 'img/product/';
    const UNAVAILABLE_STATUS = 2;
    const PAGE_SIZE = 15;
    const DAYS_TO_STAT_UPDATE = 5;
    public static $links = array(
        1 => 'Dofollow',
        2 => 'Nofollow',
        3 => 'Redirect',
    );
    
    public static $anchors = array(
        1 => 'any',
        2 => 'Business',
        3 => 'Branded or naked Link URL',
    );  
    
    /**
     * statuses values
     */
    public static $statuses = array(
        0 => 'Disabled',
        1 => 'Active',
        2 => 'Temporary Unavailable',
    );
    
    public static $domain_zone_filter = array('edu', 'gov');


    public $traffic_update_months = 0;
    public $isInCart;
    protected $oldAttributes;
    
    
    public function isAnchorAvailable()
    {
        return $this->anchor != 3 /* not business */;
    }
    
    public function afterFind(){
        $this->oldAttributes = $this->attributes;
        $this->traffic = static::intToTraffic($this->traffic);
        
        return parent::afterFind();
    }
    
    public function getSimilarWebLink()
    {
        return 'http://www.similarweb.com/website/'.parse_url($this->url, PHP_URL_HOST).'#';
    }

    
    public function getSQLCommandByFilter($filter = array(), $count = false)
    {
        $command = Yii::app()->db->createCommand();
        
        if ($count) {
            $command->select('COUNT(*)');
        } else {
            $command->select('m.id');
        }
        
        $command->from($this->tableName().' m')
                ->where('status != 0');
        
        if (!empty($filter['category'])) {
            if (!in_array('all', $filter['category'])) {
                $command->join('product_to_category p2c', 'm.id = p2c.product_id');
                //supposed to be available only one category
                $command->andWhere(array('in', 'p2c.category_id', $filter['category']));
                if (!empty($filter['not_in_category'])) {
                    $command->andWhere(array('not in', 'p2c.category_id', $filter['not_in_category']));
                }
            }
        }

        if (!empty($filter['link'])) {
            $command->andWhere(array('in', 'link', $filter['link']));
        }        
        
        if (!empty($filter['anchor'])) {
            $a = $filter['anchor'];
            $a[] = 1;//add any
            $command->andWhere(array('in', 'anchor', $a));
            //!!!$criteria->order = (empty($criteria->order)? '' : ',') . 'anchor DESC';
        }
        
        if (!empty($filter['traffic'])) {
            $traffic = static::parseFilterTraffic($filter['traffic']);
            if ($traffic) {
                $command->andWhere('traffic > '.$traffic);
            }
        }
        
        if (!empty($filter['google_pr'])) {
            $google_pr = static::parseFilterGooglePR($filter['google_pr']);
            if ($google_pr) {
                $command->andWhere('google_pr > ' . $google_pr);
            }
        }
        
        if (!empty($filter['price'])) {
            $price = static::parseFilterPrice($filter['price']);
            if ($price) {
                $command->andWhere('price < '.$price);
            }
        }

        if (!empty($filter['domain_zone'])) {
            $command->andWhere(array('in', 'domain_zone', $filter['domain_zone']));
        }
        
        if (!empty($filter['sort_by'])) {
            $sort_params = explode('_', $filter['sort_by']);

            if (!empty($sort_params[1]) && in_array($sort_params[1], array('da', 'price', 'pr', 'traffic'))) {
                $order = '';
                switch($sort_params[1]){
                    case 'price': $order = 'price'; break;
                    case 'pr':    $order = 'google_pr'; break;
                    case 'traffic': $order = 'traffic'; break;
                    case 'da': $order = 'da_rank'; break;
                }
                if (!empty($sort_params[2]) && $sort_params[2] == 'down') $order .= ' DESC';
                $command->order($order);
            }
        } else {
            $command->order('traffic');
        }
        
        return $command;
    }
    
    /**
     * Get products by page filter
     * @param array $filter list of filter data
     * @return Product[]
     */
    public function findByFilter($filter=array(), &$pager = null)
    {
        $count = 0;
        $command = null;

        if (!empty($filter['category'])) {
            foreach(array_unique($filter['category']) as $c){
                ProductCategory::addView($c);
            }
        }
        
        if (!empty($filter['category'])
                && !in_array(ProductCategory::GENERAL_CATEGORY_ID, $filter['category'])) {
            //get all by category and append all general to the end
            if (!empty($filter['sort_by']) && $filter['sort_by'] == 'sort_relevance') {
                
                $filter['sort_by'] = 'sort_traffic_down';
                $sql = 'SELECT * FROM (' . $this->getSQLCommandByFilter($filter)->text . ') a ';
                
                $filter['category'] = array(ProductCategory::GENERAL_CATEGORY_ID);
                
                $sql.= ' UNION SELECT * FROM (' . $this->getSQLCommandByFilter($filter)->text . ') b';
                
                $command = Yii::app()->db->createCommand($sql);
                
                //$filter['not_in_category'] = $filter['category'];

                $count = Yii::app()->db->createCommand()
                        ->select('COUNT(*)')
                        ->from('('.$command->text.') as any_alias')
                        ->queryScalar();
            }
            //get all by category with general
            else {
                $filter['category'][] = ProductCategory::GENERAL_CATEGORY_ID;
                $command = $this->getSQLCommandByFilter($filter);
                $count = $this->getSQLCommandByFilter($filter, true)->queryScalar();
            }
        //get all by category
        } else {
            $command = $this->getSQLCommandByFilter($filter);
            $count = $this->getSQLCommandByFilter($filter, true)->queryScalar();
        }

        $dataProvider=new CSqlDataProvider($command->text, array(
            'totalItemCount'=>$count,
            'params' => $command->params,
            'pagination'=>array(
                'pageSize'=>self::PAGE_SIZE,
                'currentPage' => (!empty($filter['pager_current_page']) ? $filter['pager_current_page']-1 : 0),
            ),
        ));
        
        $pager = $dataProvider->pagination;
        $products = array();
        foreach($dataProvider->getData() as $d) {
            $tmp = Product::model()->findByPk($d['id']);
            $tmp->isInCart = $tmp->isInCart();
            $products[] = $tmp;
        }
        
        return $products;
    }
    
    /**
     * Parse google_pr value from filter string
     * @param string $v
     * @return integer
     */
    static public function parseFilterGooglePR($v)
    {
        $matches = array();
        preg_match('/PR(\d+) >/', trim($v), $matches);
        return isset($matches[1]) ? (int) $matches[1] : 0;
    }
    
    /**
     * Parse price value from filter string
     * @param string $v
     * @return integer
     */
    static public function parseFilterPrice($v)
    {
        $matches = array();
        preg_match('/.*\$(\d+)/', trim($v), $matches);
        return isset($matches[1]) ? (int) $matches[1] : 0;
    }
    
    /**
     * Parse traffic value from filter string
     * @param string $v
     * @return integer
     */
    static public function parseFilterTraffic($v)
    {
        return static::trafficToInt(str_replace(' >', '', $v));
    }
    
    /*
     * Convert traffic value(like 10M, 500K) to integer value
     * @param string $v traffic
     */
    static public function trafficToInt($v)
    {
        $r = $v;
        preg_match('/(\d+(\.\d+)?)([K,M]?)/', trim($v), $matches);
        if (!empty($matches[1])) {
            $r = (float) $matches[1];
            $k = 0;
            if (!empty($matches[3])) {
                switch($matches[3]) {
                    case 'K': $k = 1000; break;
                    case 'M': $k = 1000000; break;
                }
                $r *= $k;
            }
        }
        return (int) $r;
    }
    
    /*
     * Convert integer to traffic value(like 10M, 500K)
     * @param int $v int value
     */
    static public function intToTraffic($v)
    {
        $r = $v;
        if ($v > 1000000) {
            $r = $v/1000000 . 'M';
        } else if ($v > 1000) {
            $r = $v/1000 . 'K';
        }

        return $r;
    }    

    /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Product the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    
    /**
     * @return string
     */
    public function getOld()
    {
        return date('Y') - $this->age;
    }

    /**
     * @return string
     */
    public function getLinkName()
    {
        return self::$links[$this->link];
    }

    /**
     * Get Domain
     * @return Domain or false
     */
    public function getDomain($url) 
    {
        $pieces = parse_url($url);
        $domain = isset($pieces['host']) ? $pieces['host'] : '';
        if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)) {
          return $regs['domain'];
        }
        return false;
    }


  
     /**
     * @return string
     */
    public function getAnchorName()
    {
        return self::$anchors[$this->anchor];
    }    
    
    public function getStatusName()
    {
        return self::$statuses[$this->status];
    }
    /**
     * before save
     */
    public function beforeSave()
    {
        $this->url = trim($this->url);

            $alexa_rank = $this->loadAlexaRank();
            //$google_pr = $this->loadGooglePR();
            
            if ($alexa_rank) {
                $this->alexa_rank = $alexa_rank;
            }
            /*
            if ($google_pr) {
                $this->google_pr = $google_pr;
            }*/
            
        
        if ($this->isNewRecord){
            $this->traffic_update_date = date('Y-m-d H:i:s');
        } else {
            if(isset($this->oldAttributes['traffic']) && $this->traffic != $this->oldAttributes['traffic']){
                $this->traffic_update_date = date('Y-m-d H:i:s');
            }
            if(isset($this->oldAttributes['status']) 
                    && $this->status != $this->oldAttributes['status']
                    && !$this->status){
                $cart = new Cart();
                $criteria = new CDbCriteria;
                $criteria->addCondition('product_id = ' . $this->id);                
                $cart->deleteAll($criteria);
            }           
        }
        
        $domain = $this->getDomain($this->url);
        $parts = explode('.', $domain);
        unset($parts[0]);
        $this->domain_zone =  $parts[1];
        
        $this->traffic = static::trafficToInt($this->traffic);
        
        return parent::beforeSave();
    }
    
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'product';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('price, age, link, anchor, status, google_pr, alexa_rank, orders', 'numerical'),
			array('age', 'numerical', 'min'=>1),
			array('da_rank, title, traffic, url, image', 'length', 'max'=>255),
			array('age', 'length', 'max'=>4,'min'=>4),
			array('link, anchor, status, google_pr', 'length', 'max'=>2),
			array('alexa_rank, orders', 'length', 'max'=>11),
            array('about', 'safe'),
            array('url', 'url'),
            array('title, url, price, image, categories, age, link, anchor, traffic','required'),
            array('image', 'file', 'allowEmpty'=>true, 'on'=>'update'),
            
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, url, image, age, price, link, anchor, status, traffic, google_pr, alexa_rank, orders', 'safe', 'on'=>'search'),
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
            'categories' => array(self::MANY_MANY, 'ProductCategory', 'product_to_category(product_id, category_id)'),
            'product_to_category' => array(self::HAS_MANY, 'ProductToCategory', 'product_id'),
            'cart' => array(self::HAS_MANY, 'ProductToCategory', 'product_id'),
		);
	}
    /**
     * delete
     */
    
    public function delete()
    {
        ProductToCategory::model()->deleteAllByAttributes(array('product_id' => $this->id));
        parent::delete();
    }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Title',
			'url' => 'Url',
			'image' => 'Image',
			'age' => 'Age',
			'price' => 'Price',
			'link' => 'Link',
			'anchor' => 'Anchor',
			'status' => 'Status',
			'traffic' => 'Traffic',
			'google_pr' => 'Google Pr',
			'alexa_rank' => 'Alexa Rank',
			'da_rank' => 'DA',
			'orders' => 'Orders',
            'categories'=>'Categories',
            'traffic_update_date'=>'Traffic Update Date',
            'stat_update_date'=>'Ranks Last Update Date',
		);
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
     * Get GooglePR
     * @return int google pr
     */
    public function loadGooglePR()
    {
        Yii::import('application.lib.GooglePR');
        $stat = new GooglePR();
        
        return $stat->getRank($this->url);
    }
    
    /*
     * Check if the product is in cart.
     */
    public function isInCart()
    {
        return Cart::model()->exists('user_id='.Yii::app()->user->profile->id.' AND product_id='.$this->id);
    }
    
    /**
     * Get Alexa Rank
     * @return int Alexa Rank
     */
    public function loadAlexaRank()
    {
        Yii::import('application.lib.AlexaRanking');
        $stat = new AlexaRanking();
        
        return $stat->getRank($this->url);
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
		$criteria->compare('price',$this->price);
		$criteria->compare('orders',$this->orders,true);
		$criteria->compare('status',$this->status,true);
        
        if ($this->categories) {
            $criteria->with = array( 
                'product_to_category' => array(
                    'select' =>false,
                    'joinType'=>'INNER JOIN',
                    'condition'=>'category_id = :cid',
                    'params'=> array(':cid' => $this->categories),
                )
            ); 
            $criteria->together = true;            
        }
        
        $sort->defaultOrder= array(
            'title'=>CSort::SORT_ASC,
        );        
        
        
        
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'sort'=>$sort,
            'pagination'=>array(
                'pageSize'=>30,
            ),
		));
	}
    
    public function updateStats()
    {
        $time = strtotime($this->stat_update_date);
        if (empty($this->stat_update_date) || (time() - $time > self::DAYS_TO_STAT_UPDATE * 24 * 3600)) {
            Yii::setPathOfAlias('SEOstats',Yii::getPathOfAlias('application.extensions.SEOstats'));

            Yii::import('application.extensions.SEOstats.Services.3rdparty.GTB_PageRank', true);
            $seostats = new \SEOstats\SEOstats;
            $seostats->setUrl($this->url);
            //$pagerank = \SEOstats\Services\Google::getPageRank();

            //$this->google_pr = (int) $pagerank;
            $ar = $this->loadAlexaRank();
            $this->alexa_rank = $ar ? $ar : $this->alexa_rank;
            
            $da = round(\SEOstats\Services\Mozscape::getDomainAuthority(), 2);
            $this->da_rank = $da ? $da : $this->da_rank;
            $this->stat_update_date = new CDbExpression('NOW()');
            $this->update();
        }
    }
    
    static public function updateStatsForGroup()
    {
        $criteria = new CDbCriteria();
        $criteria->condition='status != 0 AND DATE_ADD(stat_update_date, INTERVAL 5 DAY) < NOW() OR stat_update_date IS NULL';
        $criteria->order='stat_update_date';
        $criteria->limit=10;//per one update
        
        $products = self::model()->findAll($criteria);
        
        foreach ($products as $p) {
            if (self::statUpdateChance()) {
                $p->updateStats();
            }
        }
    }
    
    static public function statUpdateChance()
    {
        $sleep_sec = rand(2, 10);
        sleep($sleep_sec);
        $run = rand(0, 1);
        
        return $run;
    }
}
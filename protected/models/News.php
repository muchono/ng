<?php

/**
 * This is the model class for table "news".
 *
 * The followings are the available columns in table 'news':
 * @property string $id
 * @property string $date_added
 * @property string $title
 * @property string $content
 * @property integer $active
 */
class News extends CActiveRecord
{
    const IMG_DIR = 'img/news/';
    
    protected function afterFind()
    {
        if (!empty($this->date_added)) {
            $this->date_added = $this->convertDate($this->date_added, 'dmy');
        }
        
        parent::afterFind();
    }
    
    protected function beforeSave()
    {
        $curr = self::findByPk($this->id);

        if ((!empty($this->img) && !empty($curr->img))
                || (isset($this->img) && ($this->img == '') && !empty($curr->img))) {
            $dir = self::IMG_DIR . $curr->img;
            if (file_exists($dir)) unlink($dir);
        }
        
        if (!empty($this->date_added)) {
            $this->date_added = $this->convertDate($this->date_added, 'ymd');
        }
        return parent::beforeSave();
    }
    
    public function convertDate($date, $fkey = 'dmy')
    {
        $format = 'd-m-Y H:i';
        switch ($fkey) {
            case 'ymd':
                $format = 'Y-m-d H:i';
                break;
        }
        return date($format, strtotime($date));
    }
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return News the static model class
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
		return 'news';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('active', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>500),
			array('date_added, content', 'safe'),
            array('title, active, date_added, content', 'required'),
            array('img', 'file', 'types'=>'jpeg, jpg, gif, png', 'allowEmpty'=>true),            
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, date_added, title, content, active', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'img' => 'Изображение',
			'date_added' => 'Дата',
			'title' => 'Заголовок',
			'content' => 'Текст',
			'active' => 'Активная',
		);
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
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('date_added',$this->date_added,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('active',$this->active);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'sort' => array(
                'defaultOrder' => 'date_added DESC'
            ),
		));
	}
}
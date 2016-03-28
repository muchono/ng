<?php

/**
 * This is the model class for table "pages_content".
 *
 * The followings are the available columns in table 'pages_content':
 * @property string $id
 * @property string $name
 * @property string $content
 * @property string $href
 * @property integer $static
 */
class PagesContent extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PagesContent the static model class
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
		return 'pages_content';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('static', 'numerical', 'integerOnly'=>true),
			array('name, href, submenu', 'length', 'max'=>255),
			array('content', 'safe'),
            array('name, href, content', 'required'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, content, href, static', 'safe', 'on'=>'search'),
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
			'name' => 'Title',
			'content' => 'Content',
			'href' => 'Identifier',
			'static' => 'Static',
		);
	}

    public function getContent($href)
    {
        return $this->findByAttributes(array('href' => $href))->content;
    }
    
    public function searchByStr($search_str)
    {
            $criteria=new CDbCriteria;
            $criteria->select='*';  // only select the 'title' column
            $criteria->condition='content LIKE :search';
            $criteria->limit=15;
            $criteria->params=array(':search'=>'%'.$search_str.'%');
            $contents=PagesContent::model()->findAll($criteria);
           
            foreach ($contents as $c) {
                $pos = stripos($c->content, $search_str);
                $str = mb_substr(strip_tags($c->content), ($pos < 200 ? 0 : $pos - 200), 200, 'UTF-8');
                $obj = new stdClass;
                $obj->href = $c->href;
                $obj->name = $c->name;
                $obj->text = $str;

                $results[] = $obj;
            }
            return $results;
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('href',$this->href,true);
		$criteria->compare('static',$this->static);
        $criteria->order = 'name';
        

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>100,
            ),
		));
	}
}
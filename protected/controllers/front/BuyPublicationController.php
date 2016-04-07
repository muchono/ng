<?php

Yii::setPathOfAlias('Zend',Yii::getPathOfAlias('application.vendors.Zend'));

class BuyPublicationController extends Controller
{
    const PDF_INVOICE_DIR = 'content/pdf/';
    protected $_payments = array('PayPal', 'Webmoney', 'TwocheckoutPayment', 'Bitcoin');
    
    public $defaultAction = 'ChooseResource';
    public function filters()
    {
        return array(
            'accessControl',
        );
    }
    
    static public function invoicePDFDir()
    {
        return Yii::app()->getBasePath().'/../'. self::PDF_INVOICE_DIR;
    }
    
    public function generatePDFInvoice(Order $order)
    {
        if (!is_dir(self::invoicePDFDir())) {
            throw new Exception('PDF Invoice direactory not found');
        }
        
        $html = $this->renderPartial('_invoice_pdf', array('order'=>$order), true);
        include(Yii::app()->getBasePath()."/extensions/mpdf60/mpdf.php");
        $mpdf=new mPDF('utf-8','A4','','',20,15,48,25,10,10);
        $mpdf->useOnlyCoreFonts = true;
        $mpdf->SetProtection(array('print'));
        $mpdf->SetTitle("Netgeron Invoice");
        $mpdf->SetAuthor("Netgeron");
        $mpdf->SetWatermarkText("Paid");
        $mpdf->showWatermarkText = true;
        $mpdf->watermark_font = 'DejaVuSansCondensed';
        $mpdf->watermarkTextAlpha = 0.1;
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->WriteHTML($html);
        
        $fname = self::invoicePDFDir().$order->id.'.pdf';
        $mpdf->Output($fname,'F');
        
        return $fname;
    }
    
    public function actionInvoice()
    {
        if (!empty($_GET['order'])) {
            $order = Order::model()->findByPk($_GET['order'], 'user_id='.Yii::app()->user->profile->id);
            if (!empty($order) && file_exists(self::invoicePDFDir().$order->id.'.pdf')){
                header('Content-type: application/pdf');
                header('Content-Disposition: inline; filename="Netgeron_Invoice_' . $order->id. '.pdf"');
                header('Content-Transfer-Encoding: binary');
                
                readfile(self::invoicePDFDir().$order->id.'.pdf');
            } else {
                echo 'Order not found!';
            }
        }
        Yii::app()->end();
    }
    
    public function accessRules()
    {
        return array(
            array('allow',
                'actions'=>array('PaymentPreResult'),
                'users'=>array('*'),
            ),            
            array('allow',
                'users'=>array('@'),
                'expression'=>'Yii::app()->user->profile->id != 0',
            ),
            array('deny',
                'users'=>array('*'),
            ),
        );
    }
    
	public function actionIndex()
	{
		$this->render('index');
	}
    
    
    public function actionPaymentCheck()
    {
        $r = array('result'=>0);
        if (!empty($_POST['payment']) && in_array($_POST['payment'], array_keys(Yii::app()->params->payments))) {
            Yii::import('application.extensions.'.$_POST['payment'].'.'.$_POST['payment']);
            $payment = new $_POST['payment']();
            $payment->setParams(Yii::app()->params->payments[$_POST['payment']]);
            $payments = $payment->getPayments(Yii::app()->user->profile->id);
            $cart_info = Cart::getByUser(Yii::app()->user->profile->id);
            $to_pay = $payment->exchange($cart_info['total']);
            $r['to_pay'] = $to_pay;
            if ($to_pay <= $payments['total_not_used']) {
                $r['result'] = 1;
            } else {
                $r['message'] = "Received sum: ".($payments['total_not_used'] ? $payments['total_not_used'] : 0) . ' BTC';
            }
        }
        exit(json_encode($r));
    }
    
    public function actionPaymentPreResult()
    {
        if (!empty($_GET['payment']) && in_array($_GET['payment'], array_keys(Yii::app()->params->payments))) {
            Yii::import('application.extensions.'.$_GET['payment'].'.'.$_GET['payment']);
            $payment = new $_GET['payment']();
            $payment->setParams(Yii::app()->params->payments[$_GET['payment']]);
            $payment->result($_REQUEST);            
        }
    }
    
    public function actionPaymentResult()
    {
        $payed = false;
        if (!empty($_GET['payment']) && in_array($_GET['payment'], array_keys(Yii::app()->params->payments))) {
            Yii::import('application.extensions.'.$_GET['payment'].'.'.$_GET['payment']);
            $payment = new $_GET['payment']();
            $payment->setParams(Yii::app()->params->payments[$_GET['payment']]);
            $payed = $payment->finish($_REQUEST);
            if ($payed) {
                $order_params = Cart::getByUser(Yii::app()->user->profile->id);
                $order_params['payment_method'] = $_GET['payment'];
                $order_params['payment_status'] = 1;
                $order_params['id'] = Order::genID();
                $order_params['transaction_id'] = $payment->getID();
                $order = new Order();
                $order->createByCart($order_params);
        
                $pdf_path = $this->generatePDFInvoice($order);

                $html = $this->renderPartial('_order_email_html', array('order'=>$order, 'user' => Yii::app()->user->profile), true);
                $text = $this->renderPartial('_order_email_text', array('order'=>$order, 'user' => Yii::app()->user->profile), true);
                $attachment = array(
                    array(
                        'name' => 'NetgeronOrder-'.$order->id.'.pdf',
                        'mime' => 'application/pdf',
                        'path' => $pdf_path,
                    ),
                );
                Yii::app()->mail->send($html, $text, 'Invoice Payment Confirmation', Yii::app()->params['emailNotif']['from_email'], Yii::app()->user->profile->email, $attachment);
                Yii::app()->mail->send($html, $text, 'Invoice Payment Confirmation - COPY', Yii::app()->user->profile->email, Yii::app()->params['emailNotif']['payed_transaction_email'], $attachment);

                $this->redirect(array('buyPublication/ResultPage', 'o' => $order_params['id']));
            }
        }
        
        $this->redirect(array('buyPublication/ResultPage'));        
    }
    
	public function actionChooseResource()
	{

        $filter = array();
        $selected_category = 'All Resources';
        if (!empty($_POST)) {
            $filter = $_POST;
            $products = Product::model()->findByFilter($filter, $pager);
            $this->renderPartial('_products', array('products'=>$products, 'pager'=>$pager, 'set_pages_num'=>true, 'filter'=>$filter));
            Yii::app()->end();
        } else {
            if (!empty($_GET['cid'])) {
                $pc = ProductCategory::model()->findByPk((int) $_GET['cid']);
                if (!empty($pc)) {
                    $selected_category = $pc->title;   
                    $filter['category'][] = $pc->id;
                    $filter['sort_by'] = 'sort_relevance';
                }
            } else {
                $filter['sort_by'] = 'sort_traffic_down';
            }
        }
        
        $this->page = 'choose-resource';
        
        $products = Product::model()->findByFilter($filter, $pager);
		$this->render('ChooseResource',array(
            'products'=>$products,
            'pager'=>$pager,
            'filter'=>$filter,
            'selected_category'=>$selected_category,
        ));
	}
    
    public function actionChoosePayment()
    {
        $this->page = 'choose-payment';
        
        $cart_info = Cart::getByUser(Yii::app()->user->profile->id);
        if (!$cart_info['count']) {
            $this->redirect($this->createUrl('BuyPublication/ChooseResource'));
        }
        //check items information
        foreach($cart_info['items'] as $citem) {
            $citem->scenario = 'SubmitDetails';
            if (!$citem->validate()) {
                $this->redirect($this->createUrl('BuyPublication/SubmitDetails'));
            }
        }
        
        $user_billing = Yii::app()->user->profile->billing;
        if (empty($user_billing)) {
            $user_billing = new UserBilling;
            $user_billing->user_id = Yii::app()->user->profile->id;
            $user_billing->payment = 'PayPal';
        }
        
        $this->performAjaxValidation($user_billing);
        if (!empty($_POST['UserBilling'])) {
            $user_billing->attributes = $_POST['UserBilling'];
            if ($user_billing->validate()) {
                $user_billing->save();
                Yii::app()->user->setProfile();
                
                //run payment
                $items = array();
                foreach ($cart_info['items'] as $c) {
                    $tmp = array('name' => $c->product->title, 'price'=>$c->product->price);
                    $items[] = $tmp;
                }
                
                Yii::import('application.extensions.'.$user_billing->payment.'.'.$user_billing->payment);
                
                $payment = new $user_billing->payment();
                $payment->setParams(Yii::app()->params->payments[$user_billing->payment]);
                $payment->setItems($items);
                $payment->perform();
            }
        } else {
            $user_billing->agreed = 0;
        }
        
        $currencies = array();
        $payments = array();
        foreach ($this->_payments as $key => $value) {
            Yii::import('application.extensions.'.$value.'.'.$value);
            $payments[$value] = new $value();
            $payments[$value]->setParams(Yii::app()->params->payments[$value]);
            $payments[$value]->registerClientScripts();
        }
        

    	$this->render('ChoosePayment',array(
            'cart_info' => $cart_info,
            'user_billing' => $user_billing,
            'payments' => $payments,
        ));
    }
    
    
    public function actionResultPage()
    {
        if (!empty($_GET['o']) && $_GET['o']) {
            $order = Order::model()->findByPk($_GET['o'], 'user_id=' . Yii::app()->user->profile->id);
            if (!empty($order)) {
                if (!empty($_POST['Order']['notif_frequency'])) {
                    $order->notif_frequency = (int) $_POST['Order']['notif_frequency'];
                    $order->update();
                    $this->redirect($this->createUrl('BuyPublication/LiveReport'));
                }
                $this->page = 'choose-payment succesful';
                $this->render('PaymentSuccess',array('order'=>$order));
            }
        } else {
            $this->page = 'choose-payment not-succesful';
            $this->render('PaymentFail',array());
        }
    }
    
    public function actionLiveReport()
    {
        $this->page = 'live-report';
        $report_data = Order::model()->getReportData(Yii::app()->user->profile->id);
		$this->render('LiveReport',array(
            'report_data' =>$report_data,
        ));
    }
    
    public function actionSubmitDetails()
    {
        
        $cart_items = array();
        $time_interval = 1;
        
        if (!empty($_POST['time_interval'])) {
            $time_interval = $_POST['time_interval'];
        }
        //save form data
        if (!empty($_POST['Cart'])) {
            $valid = true;
            foreach ($_POST['Cart'] as $key => $value) {
                $citem = Cart::model()->findByPk($key, 'user_id=:uid', array(':uid'=>Yii::app()->user->profile->id));
                if (!empty($citem)) {
                    $citem->url = $value['url'];
                    $citem->anchor = !empty($value['anchor']) ? $value['anchor'] : '';
                    $citem->comment = $value['comment'];
                    
                    $citem->time_interval = $_POST['time_interval'];
                    
                    $citem->save();
                    
                    if ($_POST['action'] == 'accept') {
                        $citem->scenario = 'SubmitDetails';
                        if (!$citem->validate()) {
                            $valid = false;
                        }
                    }
                }
                $cart_items[] = $citem;
            }
            if ($_POST['action'] == 'accept' && $valid) {
                $this->redirect($this->createUrl('ChoosePayment'));
            }
        }
        
        
        //$this->performAjaxValidation($cart_items);
        
        //change position or delete
        if (!empty($_POST['newpos4item']) || !empty($_POST['delete'])) {
            $cart_item = Cart::model()->findByPk($_POST['item_id'], 'user_id=:uid', array(':uid'=>Yii::app()->user->profile->id));
            if (!empty($cart_item)) {
                if (!empty($_POST['newpos4item'])) $cart_item->changePos($_POST['newpos']);
                if (!empty($_POST['delete'])) {
                    $cart_item->changePos(1000000);
                    $cart_item->delete();
                }
            }
            
            $cart_info = Cart::getByUser(Yii::app()->user->profile->id);
            if (!empty($cart_info['items'])) {
                $time_interval = $cart_info['items'][0]->time_interval;
            }            
            $this->renderPartial('_cart_items', array('cart_info'=>$cart_info, 'time_interval'=>$time_interval));
            Yii::app()->end();
        }
        
        
        $cart_info = Cart::getByUser(Yii::app()->user->profile->id);
        
        if (!empty($cart_items)) {
            $cart_info['items'] = $cart_items;
        }
        
        if (!empty($cart_info['items'])) {
            $time_interval = $cart_info['items'][0]->time_interval;
        }
        
        if ($cart_info['count'] == 1) {
            $this->page = 'details one';
        } else {
            $this->page = 'details more';
        }
		$this->render('SubmitDetails',array(
            'cart_info' => $cart_info,
            'time_interval'=>$time_interval,
        ));        
    }

	protected function performAjaxValidation($user_billing)
	{
		if(isset($_GET['ajax']) && $_GET['ajax']==='choose-pyment-form')
		{
			echo CActiveForm::validate($user_billing);
			Yii::app()->end();
		}
	}
}

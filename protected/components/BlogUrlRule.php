<?php

class BlogUrlRule extends CBaseUrlRule
{
    public function createUrl($manager,$route,$params,$ampersand)
    {
        return false;  // не применяем данное правило
    }
    
    public function parseUrl($manager,$request,$pathInfo,$rawPathInfo)
    {
        if (preg_match('/[0-9A-Za-z-]+/', $pathInfo, $matches))
        {
            $post = Post::model()->findByHref($pathInfo, (empty($_GET['all']) ? array(): array('all' => 1)));
            if ($post) {
                $_GET['href'] = $pathInfo;
                return 'blog/post';
            }
        }        
        
        return false;  // не применяем данное правило
    }
}
?>
